<?php
    session_start();

    include("../common/functions.php");
    include("../database/conectaBD.php");

    // Dados do usuario
    $nome = $_POST["nome"];
    $emailLogin = $_POST["emailLogin"];
    $senha = $_POST["senha"];

    // Dados do vendedor
    $nomeEstabelecimento = $_POST["nomeEstabelecimento"];
    $cnpj                = (strlen($_POST["cpfCnpj"]) == 18) ? $_POST["cpfCnpj"] : NULL;
    $cpf                 = (strlen($_POST["cpfCnpj"]) == 14) ? $_POST["cpfCnpj"] : NULL;
    $emailContato        = $_POST["emailContato"];
    $telefoneContato     = $_POST["telefoneContato"];

    // Dados de endereço
    $cep         = $_POST["cep"];
    $rua         = $_POST["rua"];
    $numero      = $_POST["numero"];
    $bairro      = $_POST["bairro"];
    $complemento = $_POST["complemento"];
    $cidade      = $_POST["cidade"];
    $estado      = $_POST["estadoSelect"];

    // Query para inserir endereço no BD
    $insertQueryEndereco = "INSERT INTO endereco (rua, cep, complemento, numero, bairro, cidade, uf) VALUES (\"$rua\",\"$cep\", \"$complemento\", \"$numero\", \"$bairro\",\"$cidade\", \"$estado\");";

    // Query para inserir usuario no BD
    $insertQueryUsuario = "INSERT INTO usuario (nome, email, senha) VALUES (\"".$nome."\",\"".$emailLogin."\",\"".$senha."\")";
    
    
    // Inicia transaction
    mysqli_begin_transaction($conn);

    // Tenta realizar INSERTs
    try{
        
        // Inserir endereço
        mysqli_query($conn, $insertQueryEndereco);

        // Inserir usuário
        $idEndereco = mysqli_insert_id($conn);
        mysqli_query($conn, $insertQueryUsuario);

        // Inserir vendedor
        $idUsuario = mysqli_insert_id($conn);
        $insertQueryVendedor = " 
        INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, id_endereco, email_contato, telefone_contato)
        VALUES (\"".$idUsuario."\",\"".$nomeEstabelecimento."\",\"".$cpf."\", ".$idEndereco.", \"".$emailContato."\",\"".$telefoneContato."\");";
        mysqli_query($conn, $insertQueryVendedor);

        // Informar que inserções foram feitas com sucesso
        alert("Usuário cadastrado com sucesso!");
        mysqli_commit($conn); // Termina transaction


    } catch(Exception $e) { // Caso haja algum erro inserindo os dados 
        
        mysqli_rollback($conn); // Desfazer transaction
        alert("Houve um erro ao cadastrar o usuário. Tente novamente mais tarde.");
    }
    
    redirect("../index.php");
    
?>

