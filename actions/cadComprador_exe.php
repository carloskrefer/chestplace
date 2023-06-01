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
    $senhaHash  =   md5($_POST["senha"]); // Calcula o código hash da senha (32 caracteres hexadecimais)

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

    // Verifica se foi marcado o checkbox 'Utilizar endereço de faturamento para entregas'.
    // Se foi marcado, seu valor é 'isChecked' (ver atributo 'value' do elemento input no 'form_cadComprador.php').
    // Se não foi marcado, o atributo nem é enviado por POST (por isso foi necessário 'isset()').
    $isEnderecoEntregaIgualFaturamento = isset($_POST["checkboxEnderecoEntrega"]) and ($_POST["checkboxEnderecoEntrega"] == "isChecked");

    // Se os endereços de entrega e faturamento são diferentes, coletar os valores dos endereços de entrega.
    if (!$isEnderecoEntregaIgualFaturamento) {
        $cepEntrega         = $_POST["cepEntrega"];
        $ruaEntrega         = $_POST["ruaEntrega"];
        $numeroEntrega      = $_POST["numeroEntrega"];
        $bairroEntrega      = $_POST["bairroEntrega"];
        $complementoEntrega = $_POST["complementoEntrega"];
        $cidadeEntrega      = $_POST["cidadeEntrega"];
        $estadoEntrega      = $_POST["estadoEntregaSelect"];  

        // Verifica se, por algum motivo, o usuário resolveu marcar o checkbox mas
        // escreveu o endereço de entrega e faturamento idênticos. Se sim, são iguais, então
        // vou considerar como se tivesse marcado o checkbox.
        $isEnderecoEntregaIgualFaturamento = ($cepFaturamento         == $cepEntrega)         and
                                             ($ruaFaturamento         == $ruaEntrega)         and
                                             ($numeroFaturamento      == $numeroEntrega)      and
                                             ($bairroFaturamento      == $bairroEntrega)      and
                                             ($complementoFaturamento == $complementoEntrega) and
                                             ($cidadeFaturamento      == $cidadeEntrega)      and
                                             ($estadoFaturamento      == $estadoEntrega);
    }


    // Query para inserir endereço de faturamento no BD
    $insertQueryEnderecoFaturamento = 
       "INSERT INTO endereco (rua, cep, complemento, numero, bairro, cidade, uf) 
        VALUES (\"$ruaFaturamento\",\"$cepFaturamento\", \"$complementoFaturamento\", \"$numeroFaturamento\", \"$bairroFaturamento\",
            \"$cidadeFaturamento\", \"$estadoFaturamento\");";
    
    // Query para inserir endereço de entrega no BD.
    // Se endereço de entrega e faturamento forem diferentes, buscar dados do endereço de entrega que o usuário preencheu.
    // Se forem iguais, usar os dados do endereço de faturamento (pois os campos de entrega não foram preenchidos pelo usuário).
    // Para facilitar na tela de alteração, sempre será feito um outro insert para o endereço de faturamento, mesmo que eles sejam iguais.
    if (!$isEnderecoEntregaIgualFaturamento) {
        $insertQueryEnderecoEntrega = 
           "INSERT INTO endereco (rua, cep, complemento, numero, bairro, cidade, uf) 
            VALUES (\"$ruaEntrega\",\"$cepEntrega\", \"$complementoEntrega\", \"$numeroEntrega\", \"$bairroEntrega\",
                \"$cidadeEntrega\", \"$estadoEntrega\");";
    } else {
        $insertQueryEnderecoEntrega = 
           "INSERT INTO endereco (rua, cep, complemento, numero, bairro, cidade, uf) 
            VALUES (\"$ruaFaturamento\",\"$cepFaturamento\", \"$complementoFaturamento\", \"$numeroFaturamento\", \"$bairroFaturamento\",
                \"$cidadeFaturamento\", \"$estadoFaturamento\");";
    }

    // Query para inserir usuario no BD
    $insertQueryUsuario = "INSERT INTO usuario (nome, email, senha) VALUES (\"".$nome."\",\"".$emailLogin."\",\"".$senhaHash."\")";
    
    
    // Inicia transaction
    mysqli_begin_transaction($conn);

    // Tenta realizar INSERTs
    try{    
        // Inserir endereço de faturamento
        mysqli_query($conn, $insertQueryEnderecoFaturamento);
        // Obter ID do endereço de faturamento na tabela Endereco
        $idEnderecoFaturamento = mysqli_insert_id($conn);

        // Inserir endereço de entrega
        mysqli_query($conn, $insertQueryEnderecoEntrega);
        // Obter ID do endereço de entrega na tabela Endereco
        $idEnderecoEntrega = mysqli_insert_id($conn);

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

