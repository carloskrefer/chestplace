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
    $id_usuario = $_SESSION['id_usuario'];
    $nome = $_POST["nome"];
    
    // Se usuário informou uma nova senha (é opcional)
    $usuarioInformouNovaSenha = ($_POST["senha"] != null);
    if ($usuarioInformouNovaSenha) {
        $senhaHash = md5($_POST["senha"]); // Calcula o código hash da senha (32 caracteres hexadecimais)
    }

    // Dados do comprador
    $cpf                 = $_POST["cpf"];
    $telefoneContato     = $_POST["telefoneContato"];

    // Dados de endereço
    $cepFaturamento         = $_POST["cepFaturamento"];
    $ruaFaturamento         = $_POST["ruaFaturamento"];
    $numeroFaturamento      = $_POST["numeroFaturamento"];
    $bairroFaturamento      = $_POST["bairroFaturamento"];
    $complementoFaturamento = ($_POST["complementoFaturamento"] != null) ? ("\"" . $_POST["complementoFaturamento"] . "\"") : "NULL";
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
        $complementoEntrega = ($_POST["complementoEntrega"] != null) ? ("\"" . $_POST["complementoEntrega"] . "\"") : "NULL";
        $cidadeEntrega      = $_POST["cidadeEntrega"];
        $estadoEntrega      = $_POST["estadoEntregaSelect"];  
    }   
    
    // Query para obter os IDs dos endereços, para usar no update
    $selectQueryIDsEnderecos = 
       "SELECT id_endereco_faturamento, id_endereco_entrega
        FROM comprador 
        WHERE id_usuario = $id_usuario;"; 
    $resultSetQueryIDsEnderecos = $conn->query($selectQueryIDsEnderecos);
    $row = $resultSetQueryIDsEnderecos->fetch_assoc();
    $id_endereco_faturamento = $row['id_endereco_faturamento'];
    $id_endereco_entrega     = $row['id_endereco_entrega'];

    // Query para atualizar endereço de faturamento no BD
    $updateQueryEnderecoFaturamento = 
       "UPDATE endereco 
        SET 
            rua         = \"" . $ruaFaturamento         . "\",
            cep         = \"" . $cepFaturamento         . "\",
            complemento =   " . $complementoFaturamento . "  ,
            numero      = \"" . $numeroFaturamento      . "\",
            bairro      = \"" . $bairroFaturamento      . "\",
            cidade      = \"" . $cidadeFaturamento      . "\",
            uf          = \"" . $estadoFaturamento      . "\"
        WHERE id = $id_endereco_faturamento;";
    
    // Query para atualizar endereço de entrega no BD  
    if (!$isEnderecoEntregaIgualFaturamento) {
        $updateQueryEnderecoEntrega = 
           "UPDATE endereco 
            SET 
                rua         = \"" . $ruaEntrega         . "\",
                cep         = \"" . $cepEntrega         . "\",
                complemento =   " . $complementoEntrega . "  ,
                numero      = \"" . $numeroEntrega      . "\",
                bairro      = \"" . $bairroEntrega      . "\",
                cidade      = \"" . $cidadeEntrega      . "\",
                uf          = \"" . $estadoEntrega      . "\"
            WHERE id = $id_endereco_entrega;"; 

    } else {
        $updateQueryEnderecoEntrega = 
           "UPDATE endereco 
            SET 
                rua         = \"" . $ruaFaturamento         . "\",
                cep         = \"" . $cepFaturamento         . "\",
                complemento =   " . $complementoFaturamento . "  ,
                numero      = \"" . $numeroFaturamento      . "\",
                bairro      = \"" . $bairroFaturamento      . "\",
                cidade      = \"" . $cidadeFaturamento      . "\",
                uf          = \"" . $estadoFaturamento      . "\"
            WHERE id = $id_endereco_entrega;"; 
    }

    // Query para atualizar a tabela usuario no BD
    $updateQueryUsuario = "UPDATE usuario SET nome = \"".$nome."\"";
    if ($usuarioInformouNovaSenha) {
        $updateQueryUsuario = $updateQueryUsuario . ", senha = \"".$senhaHash."\"";
    }
    $updateQueryUsuario = $updateQueryUsuario . " WHERE id = $id_usuario;";

    // Query para atualizar a tabela comprador no BD
    $updateQueryComprador = 
       "UPDATE comprador 
        SET 
            cpf              = \"" . $cpf               . "\",
            telefone_contato = \"" . $telefoneContato   . "\"
        WHERE id_usuario = $id_usuario;"; 

    // Inicia transaction
    mysqli_begin_transaction($conn);

    // Tenta realizar INSERTs
    try{    
        // Atualizar endereço de faturamento na tabela Endereco
        mysqli_query($conn, $updateQueryEnderecoFaturamento);

        // Atualizar endereço de entrega na tabela Endereco
        mysqli_query($conn, $updateQueryEnderecoEntrega);

        // Atualizar a tabela Usuario
        mysqli_query($conn, $updateQueryUsuario);

        // Atualizar a tabela Comprador
        mysqli_query($conn, $updateQueryComprador);

        // Informar que inserções foram feitas com sucesso
        alert("Usuário cadastrado com sucesso!");
        mysqli_commit($conn); // Termina transaction

        $_SESSION['nome_usuario'] = $nome; // Atualiza nome do usuário na session (usada no index.php e form_visualizaProduto.php)

    } catch(Exception $e) { // Caso haja algum erro inserindo os dados 
        mysqli_rollback($conn); // Desfazer transaction
        alert("Houve um erro ao cadastrar o usuário. Tente novamente mais tarde.");
    }
    redirect("../page_gerComprador.php");
?>

