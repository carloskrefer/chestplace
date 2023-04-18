<html>
    <head>
        <meta charset="UTF-8">
        <title>IE - Instituição de Ensino</title>
        <link rel="icon" type="image/png" href="imagens/favicon.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="css/customize.css">
    </head>
    <body>
        <?php
            session_start();

            require 'database/conectaBD.php'

            $conn = new mysqli(servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("<strong> Falha de conexão: </strong>" . $conn->connect_error);
            }

            $nome    = $conn->real_escape_string($_POST['nome']);    // prepara a string recebida para ser utilizada em comando SQL
            $email   = $conn->real_escape_string($_POST['email']);
            $senha   = $conn->real_escape_string($_POST['senha']);   // prepara a string recebida para ser utilizada em comando SQL
            $cpf     = $conn->real_escape_string($_POST['cpf']);
            $cnpj    = $conn->real_escape_string($_POST['cnpj']);
            $nome_estabelecimento = $conn->real_escape_string($_POST['nomeEstabelecimento']);

            $md5Senha = md5($senha);

            $tipoUsu = 1;
            $id_usuario = 0;

            $sql_insert_usuario = "INSERT INTO usuario (Nome, Celular, DataNasc, ID_Genero, Login, Senha, ID_TipoUsu, Foto) VALUES ('$nome','$celular','$dt_nasc', '$genero','$login','$md5Senha', $tipoUsu, NULL)";
            $sql_pega_id_usuario = "SELECT id FROM usuario WHERE email = '$email';"

            if ($result = $conn->query($sql_insert_usuario)) {
                $msg = "Registro cadastrado com sucesso! Você já pode realizar login.";
            } else {
                $msg = "Erro executando INSERT: " . $conn-> error . " Tente novo cadastro.";
            }

            if ($result = $conn->query($sql_pega_id_usuario)) {
                if ($result->num_rows > 0) {
                    // Apresenta cada linha da tabela
                    while ($row = $result->fetch_assoc()) {
                        $id_usuario = $row["id"];
                    }
                }
            }

            
            $sql_insert_vendedor = "INSERT INTO vendedor (id, nome_estabelecimento, cpf, cnpj) VALUES ('$id_usuario', '$nome_estabelecimento', '$cpf', '$cnpj');"

            if ($result = $conn->query($sql_insert_vendedor)) {
                $msg = "Registro cadastrado com sucesso! Você já pode realizar login.";
            } else {
                $msg = "Erro executando INSERT: " . $conn-> error . " Tente novo cadastro.";
            }

            $_SESSION['nao_autenticado'] = true;
            $_SESSION['mensagem_header'] = "Cadastro";
            $_SESSION['mensagem']        = $msg;
            $conn->close();  //Encerra conexao com o BD

            header('location: login.php');

        ?>

    </body> 
    
</html>
