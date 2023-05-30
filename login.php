<!-- 
    Objetivo: verificar login do usuário e setar atributos na session de login.
 -->
 <html>
<head>
    <meta charset="UTF-8">
    <title>Chestplace (Erro)</title>
</head>
<body>
<?php
    session_start(); 
    require './database/conectaBD.php'; 
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("<strong> Falha de conexão: </strong>" . $conn->connect_error);
    }
    $usuario     = $_POST['Login']; 
    $senhaHash   = md5($_POST['Senha']);
    $sqlVerificarLogin = "SELECT id, nome FROM Usuario WHERE email = '$usuario' AND senha = '$senhaHash'"; 
    $resultSetVerificarLogin = $conn->query($sqlVerificarLogin);
    $bancoAcessadoComSucesso = ($resultSetVerificarLogin != false);
    if ($bancoAcessadoComSucesso) {
        $loginSenhaCombinam = ($resultSetVerificarLogin->num_rows == 1);
        if ($loginSenhaCombinam) {      
            $row = $resultSetVerificarLogin->fetch_assoc();         
            $_SESSION ['id_usuario']   = $row['id'];        
            $_SESSION ['nome_usuario'] = $row['nome'];      
            unset($_SESSION ['erro_autenticacao']);
            $id = $row['id'];
            $sqlTipoUsuario = 
                "SELECT             
                    (SELECT id_usuario FROM comprador     WHERE id_usuario = $id) as Comprador,
                    (SELECT id_usuario FROM vendedor      WHERE id_usuario = $id) as Vendedor,
                    (SELECT id_usuario FROM administrador WHERE id_usuario = $id) as Administrador
                FROM DUAL"; // DUAL é chamada de "dummy table", p/ quando o "FROM" é obrigatório apesar de desnecessário.
            $resultSetTipoUsuario = $conn->query($sqlTipoUsuario);
            $bancoAcessadoComSucesso = ($resultSetTipoUsuario != false);
            if ($bancoAcessadoComSucesso) {
                $rowTipoUsuario = $resultSetTipoUsuario->fetch_assoc();
                $isComprador     = $rowTipoUsuario['Comprador']     <> null;
                $isVendedor      = $rowTipoUsuario['Vendedor']      <> null;
                $isAdministrador = $rowTipoUsuario['Administrador'] <> null;
                if ($isComprador) {
                    header('location: /chestplace/index.php'); 
                    $_SESSION ['tipo_usuario'] = "comprador";    
                } else if ($isVendedor) {
                    header('location: /chestplace/page_gerProdutos.php'); 
                    $_SESSION ['tipo_usuario'] = "vendedor";
                } else if ($isAdministrador) {
                    // TODO: redirecionar para página do administrador
                    header('location: /chestplace/index.php');
                    $_SESSION ['tipo_usuario'] = "administrador";
                } 
            }                       
        } else { // Se login e senha não combinam
            $_SESSION ['login_senha_invalidos'] = true;
            unset($_SESSION ['id_usuario']);
            unset($_SESSION ['nome_usuario'] );
            unset($_SESSION ['tipo_usuario']);
            header('location: /chestplace/index.php'); // Redireciona para página inicial
        }
    } 
    if (!$bancoAcessadoComSucesso) {
        echo "Erro ao acessar o BD: " . $conn ->error;
    }
    $conn->close();
?>
</body>
</html>