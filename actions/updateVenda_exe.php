<?php
    session_start();

    // Validar se o usuário pode estar na página, se não tiver autorização, voltar para index.php
    require("../validacaoAcessoVendedor.php");
    
    // Imports
    include("../common/functions.php");
    include("../database/conectaBD.php");
    

    // Se não for uma requisição POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // Redirecionar ou exibir uma mensagem de erro
        redirect("../page_gerVendas.php");
        exit; // Encerrar o script
    }

    // Definindo header da resposta http
    header("Content-Type: application/json");

    // Coletando dados do formulário
    $pagamentoConfirmado = $_POST["pagamento"];
    $idVenda = $_POST["idVenda"];

    // Query para UPDATE de dados
    $updateQuery = "UPDATE compra_venda SET data_hora_confirmacao_pagamento = NULL WHERE id = $idVenda";
    if($pagamentoConfirmado == "true"){
        $updateQuery = "UPDATE compra_venda SET data_hora_confirmacao_pagamento = NOW() WHERE id = $idVenda";
    }

    // BEGIN TRANSACTION de atualização de novos valores
    mysqli_begin_transaction($conn);

    try{
        // Executar UPDATE de anúncio [camiseta]
        mysqli_query($conn, $updateQuery);

        mysqli_commit($conn); // Termina transaction

        echo json_encode( array( "success" => true, "message" => "Venda atualizada com sucesso!"));

    } catch (Exception $e){
        mysqli_rollback($conn);
        cLog($e);
        echo json_encode(
            array(
                "error" => true,
                "message" => "Houve um erro ao atualizar dados do anúncio. Tente novamente mais tarde."
            )
        );
    }


?>