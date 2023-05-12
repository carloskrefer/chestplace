<?php
    session_start();

    // Imports
    include("../common/functions.php");
    include("../database/conectaBD.php");
    
    // Dados do produto passados por post 
    $titulo         = $_POST["titulo"];
    $descricao      = $_POST["descricao"];
    $preco          = $_POST["preco"];
    $dataPublicacao = DateTime::createFromFormat('Y-m-d\TH:i', $_POST["dataPublicacao"]); 
    $dataCadastro   = date('Y-m-d H:i:s');
    $marca          = $_POST["marca"];
    $conservacao    = $_POST["conservacao"];
    $tamanhoSelect  = $_POST["tamanho"];

    // Queries
    $insertCamiseta   = "INSERT INTO camiseta(titulo, descricao, preco, conservacao, data_hora_publicacao, data_hora_cadastro,id_vendedor, id_marca) VALUES(
        \"".$titulo."\",
        \"".$descricao."\",
        \"".$preco."\",
        \"".$conservacao."\",
        \"".$dataPublicacao->format('Y-m-d H:i:s')."\",
        \"".$dataCadastro."\",
          ".$_SESSION["idVendedor"].",
          ".$marca.");";

    cLog($insertCamiseta);

    
    $resTamanhos = mysqli_query($conn, "SELECT * FROM tamanho");
    
    // inicia transaction
    mysqli_begin_transaction($conn);

    try{

        // INSERT na tabela CAMISETA
        mysqli_query($conn, $insertCamiseta);
        $idCamiseta = mysqli_insert_id($conn);


        // Loop por cada arquivo enviado pelo formulário para inserir no BD
        foreach ($_FILES["imagem"]["tmp_name"] as $key => $tmp_name) {
            $file_type = $_FILES["imagem"]["type"][$key];
            if (strpos($file_type, "image/") === 0) {
                
                // Lê o conteúdo do arquivo de imagem
                $filename  = $_FILES["imagem"]["name"][$key];
                $file_size = $_FILES["imagem"]["size"][$key];
                $file_tmp  = $_FILES["imagem"]["tmp_name"][$key];
                $handle    = fopen($file_tmp, "r");
                $content   = fread($handle, $file_size);
                fclose($handle);
                
                $content = mysqli_real_escape_string($conn, $content);
                
                // INSERT de imagens na tabela IMAGENS

                // INSERT Query
                $insertImagens = "INSERT INTO imagem (id_produto, imagem) VALUES(\"".$idCamiseta."\",\"".$content."\")";

                cLog($filename);
                
                mysqli_query($conn, $insertImagens);

                cLog("Imagem cadastrada com sucesso!");
                
            }
        }

        // Loop por cada um dos tamanhos no BD
        if (mysqli_num_rows($resTamanhos) > 0) {
            while($row = mysqli_fetch_assoc($resTamanhos)){
                
                // Se o tamanho tiver sido selecionado
                if(in_array($row["codigo"], $tamanhoSelect)){

                    // Quantidade desse tamanho
                    $qtdeTamanho = $_POST["quantidade_".$row["codigo"]];

                    // Query
                    $insertTC  = "INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (".$idCamiseta.",".$row["id"].",".$qtdeTamanho.");";
                    
                    // INSERT no BD
                    mysqli_query($conn, $insertTC);

                    clog("Tamanho cadastrado no BD.");
                }
            }
        }

        alert("Cadastro realizado com sucesso");
        mysqli_commit($conn); // Termina transaction
        redirect("../page_gerProdutos.php?");  
    }
    catch(Exception $e){
        alert("Houve um erro ao cadastrar a camiseta no Banco de dados. Por favor, tente novamente mais tarde.");
        mysqli_rollback($conn); // Desfazer transaction
        cLog($e);
    }

    
?>