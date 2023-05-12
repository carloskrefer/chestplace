<?php
    session_start();
    header("Content-Type: application/json");
    include("../common/functions.php");
    include("../database/conectaBD.php");

    // Coletando dados do formulário
    $idCamiseta     = $_POST["idCamiseta"];
    $titulo         = $_POST["titulo"];
    $descricao      = $_POST["descricao"];
    $preco          = $_POST["preco"];
    $dataPublicacao = DateTime::createFromFormat('Y-m-d\TH:i', $_POST["dataPublicacao"]);
    $marca          = $_POST["marca"];
    $conservacao    = $_POST["conservacao"];
    $tamanhoSelect  = $_POST["tamanho"];
    $imagensExcluir = json_decode($_POST["idImagensDeletar"]);

    // Query para UPDATE de dados
    $updateQuery = "UPDATE camiseta SET
        titulo               = \"".$titulo."\",
        descricao            = \"".$descricao."\",
        preco                = \"".$preco."\",
        conservacao          = \"".$conservacao."\",
        data_hora_publicacao = \"".$dataPublicacao->format('Y-m-d H:i:s')."\",
        id_vendedor          = ".$_SESSION["idVendedor"].",
        id_marca             = ".$marca."
        WHERE id             = ".$idCamiseta."
    ;";

    // BEGIN TRANSACTION de atualização de novos valores
    mysqli_begin_transaction($conn);

    try{
        // Executar UPDATE de anúncio [camiseta]
        mysqli_query($conn, $updateQuery);

        // Executar DELETE de quantidade do estoque | RESET do estoque [estoque]
        mysqli_query($conn, "DELETE FROM estoque WHERE id_camiseta = ".$idCamiseta);

        // SELECT de todos os tamanhos [tamanho]
        $resTamanhos = mysqli_query($conn, "SELECT * FROM tamanho;");

        // Para cada tamanho cadastrado no BD [tamanho]
        while($rowTamanho = mysqli_fetch_assoc($resTamanhos)){

            // Se a quantidade desse tamanho foi inserida pelo usuário no formulário
            if(isset($_POST["quantidade_".$rowTamanho["codigo"]])){

                // Set da variável quantidade para o valor passado por POST com a quantidade do tamanho
                $quantidade = $_POST["quantidade_".$rowTamanho["codigo"]];

                $insertQtdeEstq = "INSERT INTO estoque(id_camiseta, id_tamanho, quantidade) VALUES (".$idCamiseta.",".$rowTamanho["id"].", ".$quantidade.");";

                // INSERT no BD do tamanho tamanho e quantidade
                mysqli_query($conn, $insertQtdeEstq);

                // INSERT no BD + debug
                // if(mysqli_query($conn, $insertQtdeEstq)){
                //     cLog("Tamanho [".$rowTamanho["codigo"]."] adicionado com sucesso!");
                // } else {
                //     echo json_encode("Erro ao adicionar tamanho [".$rowTamanho["codigo"]."]! Tente novamente.");
                // }
            }
        }

        // Adicionar Imagens no BD [imagem]
        if(isset($_FILES["imagem"])){

            // Loop através de cada arquivo enviado pelo formulário
            foreach ($_FILES["imagem"]["tmp_name"] as $key => $tmp_name) {

                // Verifica se o arquivo é uma imagem
                $file_type = $_FILES["imagem"]["type"][$key];
                if (strpos($file_type, "image/") === 0) {

                    // Lê o conteúdo do arquivo de imagem
                    $filename = $_FILES["imagem"]["name"][$key];
                    $file_size = $_FILES["imagem"]["size"][$key];
                    $file_tmp = $_FILES["imagem"]["tmp_name"][$key];
                    $handle = fopen($file_tmp, "r");
                    $content = fread($handle, $file_size);
                    fclose($handle);

                    // Escapa os caracteres especiais do conteúdo
                    $content = mysqli_real_escape_string($conn, $content);

                    // Query INSERT da imagem no BD [imagem]
                    $sql = "INSERT INTO imagem (id_produto, imagem) VALUES(\"".$idCamiseta."\",\"".$content."\")";
                    
                    cLog($filename);
        
                    // INSERT da imagem no BD [imagem]
                    mysqli_query($conn, $sql);
                    
                }
            }
        }

        // Apagar imagens no BD [imagem]
        $deleteImagensQuery = "DELETE FROM imagem WHERE id IN (" . implode(",", $imagensExcluir) . ")";
        mysqli_query($conn, $deleteImagensQuery);


        mysqli_commit($conn); // Termina transaction

    } catch (Exception $e){
        mysqli_rollback($conn);
        echo json_encode("Houve um erro ao atualizar dados do anúncio. Tente novamente mais tarde.");
        cLog($e);
    }


?>