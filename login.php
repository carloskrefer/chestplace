<html>
    <!-------------------------------------------------------------------------------
    Desenvolvimento Web
    PUCPR
    Profa. Cristina V. P. B. Souza
    Agosto/2022
---------------------------------------------------------------------------------->
<!-- Login.php --> 
	<head>
    <meta charset="UTF-8">
      <title>Clínica Médica ABC</title>
	  <link rel="icon" type="image/png" href="imagens/favicon.png" />
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
<body>

<?php
    session_start(); // informa ao PHP que iremos trabalhar com sessão
    require './database/conectaBD.php'; 

    // Cria conexão
    $conn = new mysqli($servername, $username, $password, $database);
    // Verifica conexão 
    if ($conn->connect_error) {
        die("<strong> Falha de conexão: </strong>" . $conn->connect_error);
    }
    echo "<script>console.log('Não ocorreu falha de conexão com o banco de dados.')</script>";
    $usuario = $conn->real_escape_string($_POST['Login']); // prepara a string recebida para ser utilizada em comando SQL
    $senha   = $conn->real_escape_string($_POST['Senha']); // prepara a string recebida para ser utilizada em comando SQL
    
    // Faz Select na Base de Dados
    $sql = "SELECT id, nome FROM Usuario WHERE email = '$usuario' AND senha = '$senha'"; // Professora utilizou md5('$senha') mas pra mim não funcionou.
    if ($result = $conn->query($sql)) {
        echo "<script>console.log('Query foi realizada.')</script>";
        if ($result->num_rows == 1) {         // Deu match: login e senha combinaram
            echo "<script>console.log('Query localizou resultado!')</script>";
            $row = $result->fetch_assoc();
            $_SESSION ['login']       = $usuario;           // Ativa as variáveis de sessão
            $_SESSION ['ID_Usuario']  = $row['id'];
            $_SESSION ['nome']        = $row['nome'];
            unset($_SESSION ['nao_autenticado']);
            unset($_SESSION ['mensagem_header'] ); 
            unset($_SESSION ['mensagem'] ); 
            header('location: /chestplace/index.php'); // Redireciona para a página de funcionalidades.
            exit();
            
        }else{
            echo "<script>console.log('Query falhou para usuário $usuario e senha $senha.')</script>";
            $_SESSION ['nao_autenticado'] = true;         // Ativa ERRO nas variáveis de sessão
            $_SESSION ['mensagem_header'] = "Login";
            $_SESSION ['mensagem']        = "ERRO: Login ou Senha inválidos.";
            unset($_SESSION ['login']);
            unset($_SESSION ['ID_Usuario'] ); 
            unset($_SESSION ['nome'] );
            header('location: /chestplace/index.php'); // Redireciona para página inicial
            exit();
        }
    }
    else {
        echo "<script>console.log('Erro ao acessar o banco de dados.')</script>";
        echo "Erro ao acessar o BD: " . $conn ->error;
    }
    $conn->close();  //Encerra conexao com o BD

?>
    
	</body>
</html>