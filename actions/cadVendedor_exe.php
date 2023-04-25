<?php
    session_start();



    include("../common/functions.php");
    include("../database/conectaBD.php");

    $titulo         = $_POST["email"];
    $descricao      = $_POST["descricao"];
    $preco          = $_POST["preco"];
    $dataPublicacao = DateTime::createFromFormat('Y-m-d\TH:i', $_POST["dataPublicacao"]);
    $marca          = $_POST["marca"];
    $conservacao    = $_POST["conservacao"];

    // echo $_POST["dataPublicacao"];
    $insertQuery = "INSERT INTO camiseta(titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca) VALUES(
        \"".$titulo."\",
        \"".$descricao."\",
        \"".$preco."\",
        \"".$conservacao."\",
        \"".$dataPublicacao->format('Y-m-d H:i:s')."\",
        ".$_SESSION["idVendedor"].",
        ".$marca."
    );";
    echo $insertQuery;
    if (mysqli_query($conn, $insertQuery)){
        echo "<script>alert(\"Cadastro realizado\");</script>";
        
        $selectIdCamiseta = "SELECT id FROM camiseta ORDER BY id LIMIT 1;";
    
        $result = mysqli_query($conn, $selectIdCamiseta);

        if (mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $idCamiseta = $row["id"];
            }
        }
    
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
                
                echo "<script>console.log(\"".$filename."\");</script>";
    
                if (mysqli_query($conn, $sql)){
                    echo "<script>console.log(\"Cadastro de imagem realizado\");</script>";
                }
                else
                    echo "<script>console.log(\"Erro ao inserir imagem no banco de dados:" . mysqli_error($conn) . "\");</script>";
                
            }
        }
    }
    else
        echo "<script>alert(\"Erro ao cadastrar produto:" . mysqli_error($conn) . "\");</script>";

?>

