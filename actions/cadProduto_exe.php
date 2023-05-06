<?php
    session_start();

    // Imports
    include("../common/functions.php");
    include("../database/conectaBD.php");
    
    // Dados passados por post 
    $titulo         = $_POST["titulo"];
    $descricao      = $_POST["descricao"];
    $preco          = $_POST["preco"];
    $dataPublicacao = DateTime::createFromFormat('Y-m-d\TH:i', $_POST["dataPublicacao"]);
    $marca          = $_POST["marca"];
    $conservacao    = $_POST["conservacao"];
    $tamanhoSelect  = $_POST["tamanho"];

    // Queries
    $insertCamiseta   = "INSERT INTO camiseta(titulo, descricao, preco, conservacao, data_hora_publicacao,id_vendedor, id_marca) VALUES(
        \"".$titulo."\",
        \"".$descricao."\",
        \"".$preco."\",
        \"".$conservacao."\",
        \"".$dataPublicacao->format('Y-m-d H:i:s')."\",
        ".$_SESSION["idVendedor"].",
        ".$marca.");";

    echo $insertCamiseta;

    $selectIdCamiseta = "SELECT id FROM camiseta ORDER BY id DESC LIMIT 1;";
    $selectTamanhos   = "SELECT * FROM tamanho";

    // echo $insertCamiseta;

    if (mysqli_query($conn, $insertCamiseta)){
        
        alert("Cadastro realizado");

        // Resultados de queries
        $resIdCamiseta = mysqli_query($conn, $selectIdCamiseta);
        $resTamanhos   = mysqli_query($conn, $selectTamanhos);
        
        if (mysqli_num_rows($resIdCamiseta) > 0)
            while($row = mysqli_fetch_assoc($resIdCamiseta))
                $idCamiseta = $row["id"];
            
        
        // Loop através de cada arquivo enviado pelo formulário
        foreach ($_FILES["imagem"]["tmp_name"] as $key => $tmp_name) {
            $file_type = $_FILES["imagem"]["type"][$key];
            if (strpos($file_type, "image/") === 0) {
                
                // Lê o conteúdo do arquivo de imagem
                $filename = $_FILES["imagem"]["name"][$key];
                $file_size = $_FILES["imagem"]["size"][$key];
                $file_tmp = $_FILES["imagem"]["tmp_name"][$key];
                $handle = fopen($file_tmp, "r");
                $content = fread($handle, $file_size);
                fclose($handle);
                
                $content = mysqli_real_escape_string($conn, $content);
                
                // Queries
                $insertImagens = "INSERT INTO imagem (id_produto, imagem) VALUES(\"".$idCamiseta."\",\"".$content."\")";

                cLog($filename);
                
                if (mysqli_query($conn, $insertImagens))
                    cLog("Imagem cadastrada com sucesso!");
                else{
                    alert("Erro ao inserir imagem no banco de dados!");
                    cLog("Erro ao inserir imagem no banco de dados:" . mysqli_error($conn) . "\");");
                }
                
            }
        }
        
        // Percorre cada um dos tamanhos no BD
        if (mysqli_num_rows($resTamanhos) > 0) {
            while($row = mysqli_fetch_assoc($resTamanhos)){
                
                // Para cada tamanho selecionado
                foreach($tamanhoSelect as $tam){
                
                    // Quantidade desse tamanho
                    $qtdeTamanho = $_POST["quantidade_".$tam];

                    if($row["codigo"] == $tam){
                        // Queries
                        $insertTC  = "INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (".$idCamiseta.",".$row["id"].",".$qtdeTamanho.");";
                        if(mysqli_query($conn, $insertTC))
                            cLog("Deu certo a inserção do tamanho " . $tam);
                    }
                    
                }
            }
        }

        redirect("../page_gerProdutos.php?id=".$_SESSION["idVendedor"]);  
    }
    else
        alert("Erro ao cadastrar produto:" . mysqli_error($conn));

    echo "<a href=\"../page_gerProdutos.php?id=".$_SESSION["idVendedor"]."\">Voltar</a>" ;  
?>