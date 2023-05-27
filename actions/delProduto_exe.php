<?php
    session_start();

    // Imports
    include("../common/functions.php");
    include("../database/conectaBD.php");

    // Validar se o usuário pode estar na página, se não tiver autorização, voltar para index.php
    require("../validacaoAcessoVendedor.php");

    // Se não for uma requisição GET ou o campo do formulário não estiver presente
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // Redirecionar ou exibir uma mensagem de erro
        redirect("../page_gerProdutos.php");
        exit; // Encerrar o script
    }
        
    // Querie que verifica se o anúncio será apagado ou desativado
    $selectAllVendas = "SELECT * FROM compra_venda WHERE id_camiseta = ".$_POST["id"];
    $numeroVendasCamiseta = mysqli_num_rows(mysqli_query($conn, $selectAllVendas));

    // Queries de deleção de registros em tabelas que camiseta interfer
    $delImgQuery = "DELETE FROM imagem WHERE id_produto = " . $_POST["id"];
    $delTamQuery = "DELETE FROM estoque WHERE id_camiseta = " . $_POST["id"];
    $delQuery    = "DELETE FROM camiseta WHERE id = " . $_POST["id"];

    // alert($delImgQuery);
    // alert($delTamQuery);
    // alert($delQuery);

    mysqli_begin_transaction($conn);
    try{

        // Se aquele produto já foi vendido pelo menos uma vez
        if($numeroVendasCamiseta > 0){
            mysqli_query($conn, "UPDATE camiseta SET inativo = NOW() WHERE id = ".$_POST["id"]);
        } else {

            // DELETE das imagens da camiseta sendo deletada [imagem]
            mysqli_query($conn, $delImgQuery);

            // DELETE dos tamanhos disponíveis da camiseta no estoque [estoque]
            mysqli_query($conn, $delTamQuery);

            // DELETE dos anúncios do BD [camisetas]
            mysqli_query($conn, $delQuery);

        }

        // COMMIT da transação de deleção
        mysqli_commit($conn);

        // Define response como SUCCESS
        $response = array("ok" => true, "message" => "Anúncio apagado com sucesso");

    }catch(Exception $e){
        // Define response como ERROR
        http_response_code(500);
        $response = array("error" => true, "message" => "Erro ao apagar anúncio: " . $e->getMessage());
        
        // Desfaz queries feitas até então
        mysqli_rollback($conn);
    }

    // Define cabeçalho Content-Type e retorna resposta como JSON para ser utilizado pelo JS
    header('Content-Type: application/json');
    echo json_encode($response);
?>