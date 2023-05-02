<?php
    session_start();
    include("../common/functions.php");
    include("../database/conectaBD.php");

    $idCamiseta     = $_POST["idCamiseta"];
    $titulo         = $_POST["titulo"];
    $descricao      = $_POST["descricao"];
    $preco          = $_POST["preco"];
    $dataPublicacao = DateTime::createFromFormat('Y-m-d\TH:i', $_POST["dataPublicacao"]);
    $marca          = $_POST["marca"];
    $conservacao    = $_POST["conservacao"];
    $tamanhoSelect  = $_POST["tamanho"];

    // echo $_POST["dataPublicacao"];
    $updateQuery = "UPDATE camiseta SET
        titulo=\"".$titulo."\",
        descricao=\"".$descricao."\",
        preco=\"".$preco."\",
        conservacao=\"".$conservacao."\",
        data_hora_publicacao=\"".$dataPublicacao->format('Y-m-d H:i:s')."\",
        id_vendedor=".$_SESSION["idVendedor"].",
        id_marca=".$marca."
        WHERE id = ".$idCamiseta."
    ;";

    echo $updateQuery;

    if (mysqli_query($conn, $updateQuery)){
        
        $resetEstoque = "DELETE FROM estoque WHERE id_camiseta = ".$idCamiseta;


        if (mysqli_query($conn, $resetEstoque)){
            cLog("Estoque resetado.");

            $selectTamanhos = $selectTamanhos   = "SELECT * FROM tamanho"; 
            $resTamanhos    = mysqli_query($conn, $selectTamanhos);

            // Percorre cada um dos tamanhos no BD
            if (mysqli_num_rows($resTamanhos) > 0) {
                while($rowTamanho = mysqli_fetch_assoc($resTamanhos)){
 
                    if(isset($_POST["quantidade_".$rowTamanho["codigo"]])){

                        $quantidade = $_POST["quantidade_".$rowTamanho["codigo"]];

                        $insertQtdeEstq = "INSERT INTO estoque(id_camiseta, id_tamanho, quantidade) VALUES (".$idCamiseta.",".$rowTamanho["id"].", ".$quantidade.");";
                        
                        if(mysqli_query($conn, $insertQtdeEstq)){
                            cLog("Tamanho [".$rowTamanho["codigo"]."] adicionado com sucesso!");
                        } else {
                            alert("Erro ao adicionar tamanho [".$rowTamanho["codigo"]."]! Tente novamente.");
                        }
                    }
                }
            }
        }


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
                    // Insere o conteúdo no banco de dados
                    $sql = "INSERT INTO imagem (id_produto, imagem) VALUES(\"".$idCamiseta."\",\"".$content."\")";
                    
                    cLog($filename);
        
                    if (mysqli_query($conn, $sql)){
                        cLog("Cadastro de imagem realizada com sucesso");
                    }
                    else{
                        cLog("Erro ao inserir imagem no banco de dados:" . mysqli_error($conn));
                    }
                    
                }
            }
        }

        alert("Cadastro atualizado com sucesso!");
        redirect("../page_gerProdutos.php?id=".$_SESSION["idVendedor"]);
    }
    else{
        alert("Erro ao atualizar dados de produto: " . mysqli_error($conn));
        redirect("../forms/alterProduto?id=".$idCamiseta);
    }
        
    // $insertImages = "INSERT INTO imagem VALUES(".$idCamiseta.")";

?>