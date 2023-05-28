<?php
    session_start();

    // Imports
    require("../common/functions.php");
    require("../database/conectaBD.php");

    // Verifica se o acesso a esta página foi feita por meio de requisição POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect("../index.php");
    }

    // Dados do usuario
    $nome       =   $_POST["nome"];
    $emailLogin =   $_POST["emailLogin"];
    $senha      =   $_POST["senha"];

    // Dados do comprador
    $cpf                 = $_POST["cpf"];
    $telefoneContato     = $_POST["telefoneContato"];

    // Dados de endereço
    $cepFaturamento         = $_POST["cepFaturamento"];
    $ruaFaturamento         = $_POST["ruaFaturamento"];
    $numeroFaturamento      = $_POST["numeroFaturamento"];
    $bairroFaturamento      = $_POST["bairroFaturamento"];
    $complementoFaturamento = $_POST["complementoFaturamento"];
    $cidadeFaturamento      = $_POST["cidadeFaturamento"];
    $estadoFaturamento      = $_POST["estadoFaturamentoSelect"];
    // Se os endereços de entrega são diferentes dos de cobrança,
    // coletá-los. Obs: 'isChecked' é o valor que dei para a propriedade 'value' do input do tipo checkbox.
    if ($_POST["checkboxEnderecoEntrega"] == "isChecked") {
        $cepEntrega         = $_POST["cepEntrega"];
        $ruaEntrega         = $_POST["ruaEntrega"];
        $numeroEntrega      = $_POST["numeroEntrega"];
        $bairroEntrega      = $_POST["bairroEntrega"];
        $complementoEntrega = $_POST["complementoEntrega"];
        $cidadeEntrega      = $_POST["cidadeEntrega"];
        $estadoEntrega      = $_POST["estadoEntregaSelect"];  
    }


    // Query para inserir endereço de faturamento no BD
    $insertQueryEnderecoFaturamento = 
       "INSERT INTO endereco (rua, cep, complemento, numero, bairro, cidade, uf) 
        VALUES (\"$ruaFaturamento\",\"$cepFaturamento\", \"$complementoFaturamento\", \"$numeroFaturamento\", \"$bairroFaturamento\",
            \"$cidadeFaturamento\", \"$estadoFaturamento\");";
    
    // Query para inserir endereço de entrega no BD
    if ($_POST["checkboxEnderecoEntrega"] == "isChecked") {
        $insertQueryEnderecoEntrega = 
        "INSERT INTO endereco (rua, cep, complemento, numero, bairro, cidade, uf) 
            VALUES (\"$ruaEntrega\",\"$cepEntrega\", \"$complementoEntrega\", \"$numeroEntrega\", \"$bairroEntrega\",
                \"$cidadeEntrega\", \"$estadoEntrega\");";
    }

    // Query para inserir usuario no BD
    $insertQueryUsuario = "INSERT INTO usuario (nome, email, senha) VALUES (\"".$nome."\",\"".$emailLogin."\",\"".$senha."\")";
    
    
    // Inicia transaction
    mysqli_begin_transaction($conn);

    // Tenta realizar INSERTs
    try{    
        // Inserir endereço de faturamento
        mysqli_query($conn, $insertQueryEnderecoFaturamento);
        // Obter ID do endereço de faturamento na tabela Endereco
        $idEnderecoFaturamento = mysqli_insert_id($conn);

        // Se o usuário não marcou o checkbox 'Utilizar endereço de faturamento para entregas',
        // então inserir na tabela endereço o endereço de entrega preenchido.
        // Se o usuário marcou o checkbox, o idEnderecoEntrega é igual ao idEnderecoFaturamento.
        if (!$_POST["checkboxEnderecoEntrega"] == "isChecked") {
            // Inserir endereço de entrega
            mysqli_query($conn, $insertQueryEnderecoEntrega);
            // Obter ID do endereço de entrega na tabela Endereco
            $idEnderecoEntrega = mysqli_insert_id($conn);
        } else {
            $idEnderecoEntrega = $idEnderecoFaturamento;  
        }

        // Inserir na tabela Usuario
        mysqli_query($conn, $insertQueryUsuario);
        // Obter ID da inserção na tabela Usuario
        $idUsuario = mysqli_insert_id($conn);

        // Inserir na tabela Comprador
        $insertQueryVendedor = 
           "INSERT INTO comprador (id_usuario, cpf, id_endereco_faturamento, id_endereco_entrega, telefone_contato)
            VALUES (
                \"$idUsuario\",
                \"$cpf\",
                \"$idEnderecoFaturamento\",
                \"$idEnderecoEntrega\",
                \"$telefoneContato\"
            );";
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

