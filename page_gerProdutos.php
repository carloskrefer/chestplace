<!DOCTYPE html>
<?php 
  session_start();

  // Imports
  include("./database/conectaBD.php");
  
  
  // Verifica se está logado e se de fato é vendedor. Se não, redireciona para index.php.
  require("./validacaoAcessoVendedor.php"); 
  
  // Utilizado para definir os botões do header
  $tipoPagina = "gerenciarProdutosVendedor";

  // id_usuario é setado no login.php
  $_SESSION["idVendedor"] = $_SESSION ['id_usuario']; 

  // SELECT do nome do estabelecimento logado
  $selectNomeEstabelecimento = "SELECT nome_estabelecimento FROM vendedor WHERE id_usuario = ".$_SESSION["idVendedor"];
  $resultNomeEstabelecimento = mysqli_query($conn, $selectNomeEstabelecimento);
  
  // Settar variavel com nome do estabelecimento
  while($row = mysqli_fetch_assoc($resultNomeEstabelecimento)) { $nomeEstabelecimento = $row["nome_estabelecimento"]; }
?>
<html>
<head>
<title>Chestplace</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./styles.css">
  <script src="./scripts/jQuery/jquery-3.6.4.min.js"></script>
  
</head>

<body>
  <!-- Import dos elementos visuais -->
  <?php include("./common/header.php")?>
  <?php include("./common/modalConfirmacao.php")?>

  <!-- !PAGE CONTENT! -->
  <div class="w3-main w3-content" style="margin-bottom:10vh;max-width:1200px">
  
    <!-- Push down content on small screens -->
    <div class="w3-hide-large" style="margin-top:83px; width:100vw"></div>

    <!-- PRODUTO ATIVOS -->
    <div class="w3-container w3-text-grey w3-margin-top" style="padding-top:20px;" id="jeans">
      <h4 class="w3-text-green"><span id="showHide-publicado" style="cursor:pointer;" onclick="showHide('qtde-publicado','itens-publicado', 'showHide-publicado')"><i class="fa-solid fa-eye"></i></span> Produtos publicados </h4>
      <p id="qtde-publicado">
        <?php
          $queryQtde = "
          SELECT count(*) qtde 
          FROM camiseta c 
          WHERE c.id_vendedor =".$_SESSION["idVendedor"]."
          AND data_hora_publicacao <= NOW()
          AND inativo IS NULL;";

          $result = mysqli_query($conn, $queryQtde);

          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo $row["qtde"]." produtos";
            }
          } else {
            echo "0 results";
          }
        ?>  
      </p>
    </div>
    <div id="itens-publicado" class="w3-row">
      <?php

        //Coleta data e hora atual (momento da execução)
        $dataHoraAtual = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));;

        //Select das camisetas e imagens das camisetas do vendedor passado por _GET
        $queryProdutos = "
          SELECT * 
          FROM camiseta c 
          WHERE c.id_vendedor =".$_SESSION["idVendedor"]."
          AND data_hora_publicacao <= NOW()
          AND inativo IS NULL 
          GROUP BY c.id;";

        //Resultao do Select
        $result = mysqli_query($conn, $queryProdutos);

        //Percorrendo resultado do select
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            //Data de publicação convertida para DateTime do php
            $dataCadastro = new DateTime($row["data_hora_cadastro"]);
            $sql = "SELECT  id, imagem FROM imagem WHERE id_produto = " .$row['id']." limit 1;";
            $resultadoimg = mysqli_query($conn, $sql);
            while ($rowimg = mysqli_fetch_assoc($resultadoimg)){
            $imagemcamiseta = $rowimg['imagem'];
            }
            
            echo "
              <div class=\"w3-col l3 s6\">
                <div class=\"w3-container\">
                  <div class=\"w3-display-container\">
            ";

            //Se o anuncio foi feito há menos de dois dias
            //Tag 'Novo'
            if($dataHoraAtual->diff($dataCadastro)->days < 2){
              echo "<span class=\"w3-tag w3-display-topleft\">Novo</span>";
            }

            echo "<div style=\"position:relative; width:13vw; aspect-ratio: 13/16; display: inline-block; \">";
            // echo "<img src=\"data:" . $imageType . ";base64," . $base64Image . "\" style=\"width:100%;\">";
            echo "  <img class=\"w3-shadow w3-card\" src=\"data:imagem/jpeg;base64,".base64_encode($imagemcamiseta)."\" style=\"position:relative; z-index:1;width:100%; aspect-ratio: 13/16; object-fit:cover;\">";

            //Coloca botões, título e preço do anúncio
            echo "
                    <div class=\"w3-display-middle w3-display-hover\" style=\"position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center; z-index:4;\">
                      <button onclick=\"goToAlterProduto(".$row["id"].")\" class=\" w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-edit\"></i>&nbsp;Editar</button>
                      <button onclick=\"confirmarDelecao(".$row["id"].")\" class=\" w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-trash\"></i>&nbsp;Apagar</button>
                    </div>
                  </div>
                </div>
                <p>".$row["titulo"]."<br><b>R$ ".number_format($row["preco"], 2, ',', '.')."</b></p>
                </div>
              </div>
            ";

            
          }
        }

      ?>


      
  </div>
    <hr>

    <!-- PRODUTO AINDA NÃO DISPONÍVEIS PARA COMPRA -->
    <div class="w3-container w3-text-grey w3-margin-top" style="padding-top:20px;" id="jeans">
      <h4 class="w3-text-orange"><span id="showHide-nPublicado" style="cursor:pointer;" onclick="showHide('qtde-nPublicado','itens-nPublicado', 'showHide-nPublicado')"><i class="fa-solid fa-eye"></i></span> Produtos não publicados </h4>
      <p id="qtde-nPublicado">
        <?php
          $queryQtde = "
          SELECT count(*) qtde 
          FROM camiseta c 
          WHERE c.id_vendedor =".$_SESSION["idVendedor"]."
          AND data_hora_publicacao > NOW()
          AND inativo IS NULL;";

          $result = mysqli_query($conn, $queryQtde);

          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo $row["qtde"]." produtos";
            }
          } else {
            echo "0 results";
          }
        ?>  
      </p>
    </div>
    <div id="itens-nPublicado" class="w3-row">
      <?php

        //Coleta data e hora atual (momento da execução)
        $dataHoraAtual = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));;

        //Select das camisetas e imagens das camisetas do vendedor passado por _GET
        $queryProdutos = "
          SELECT * 
          FROM camiseta c 
          WHERE c.id_vendedor =".$_SESSION["idVendedor"]."
          AND data_hora_publicacao > NOW()
          AND inativo IS NULL 
          GROUP BY c.id;";

        //Resultao do Select
        $result = mysqli_query($conn, $queryProdutos);

        //Percorrendo resultado do select
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            //Data de publicação convertida para DateTime do php
            $dataCadastro = new DateTime($row["data_hora_cadastro"]);
            $sql = "SELECT  id, imagem FROM imagem WHERE id_produto = " .$row['id']." limit 1;";
            $resultadoimg = mysqli_query($conn, $sql);
            while ($rowimg = mysqli_fetch_assoc($resultadoimg)){
            $imagemcamiseta = $rowimg['imagem'];
            }
            
            echo "
              <div class=\"w3-col l3 s6\">
                <div class=\"w3-container\">
                  <div class=\"w3-display-container\">
            ";

            //Se o anuncio foi feito há menos de dois dias
            //Tag 'Novo'
            if($dataHoraAtual->diff($dataCadastro)->days < 2){
              echo "<span class=\"w3-tag w3-display-topleft\">Novo</span>";
            }

            echo "<div style=\"position:relative; width:13vw; aspect-ratio: 13/16; display: inline-block; \">";
            // echo "<img src=\"data:" . $imageType . ";base64," . $base64Image . "\" style=\"width:100%;\">";
            echo "  <img class=\"w3-shadow w3-card\" src=\"data:imagem/jpeg;base64,".base64_encode($imagemcamiseta)."\" style=\"position:relative; z-index:1;width:100%; aspect-ratio: 13/16; object-fit:cover;\">";

            //Coloca botões, título e preço do anúncio
            echo "
                    <div class=\"w3-display-middle w3-display-hover\" style=\"position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center; z-index:4;\">
                      <button onclick=\"goToAlterProduto(".$row["id"].")\" class=\" w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-edit\"></i>&nbsp;Editar</button>
                      <button onclick=\"confirmarDelecao(".$row["id"].")\" class=\" w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-trash\"></i>&nbsp;Apagar</button>
                    </div>
                  </div>
                </div>
                <p>".$row["titulo"]."<br><b>R$ ".number_format($row["preco"], 2, ',', '.')."</b></p>
                </div>
              </div>
            ";

            
          }
        }

      ?>


      
  </div>
    <hr>

    <!-- PRODUTO INATIVOS -->
    <div class="w3-container w3-text-grey" id="jeans">
      <h4 class="w3-text-red"><span id="showHide-inativo" style="cursor:pointer;" onclick="showHide('qtde-inativo','itens-inativo', 'showHide-inativo')"><i class="fa-solid fa-eye"></i></span> Produtos inativos </h4>
      <p id="qtde-inativo">
        <?php
          $queryQtde = "
          SELECT count(*) qtde 
          FROM camiseta c 
          WHERE c.id_vendedor =".$_SESSION["idVendedor"]."
          AND inativo IS NOT NULL;";

          $result = mysqli_query($conn, $queryQtde);

          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo $row["qtde"]." produtos";
            }
          } else {
            echo "0 results";
          }
        ?>  
      </p>
    </div>
    <div id="itens-inativo" class="w3-row w3-grayscale-max">
        <?php

          //Coleta data e hora atual (momento da execução)
          $dataHoraAtual = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));;

          //Select das camisetas e imagens das camisetas do vendedor passado por _GET
          $queryProdutos = "
            SELECT * 
            FROM camiseta c 
            WHERE c.id_vendedor =".$_SESSION["idVendedor"]."
            AND inativo IS NOT NULL
            GROUP BY c.id;";

          //Resultao do Select
          $result = mysqli_query($conn, $queryProdutos);

          //Percorrendo resultado do select
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              //Data de publicação convertida para DateTime do php
              $dataDesativado = new DateTime($row["inativo"]);
              $sql = "SELECT  id, imagem FROM imagem where id_produto =" .$row['id']." LIMIT 1;";
              $resultadoimg = mysqli_query($conn, $sql);
              while ($rowimg = mysqli_fetch_assoc($resultadoimg)){
              $imagemcamiseta = $rowimg['imagem'];
              }
              
              echo "
                <div class=\"w3-col l3 s6\">
                  <div class=\"w3-container\">
                    <div class=\"w3-display-container\">
              ";

              //Se o anuncio foi feito há menos de dois dias
              //Tag 'Novo'
              if($dataHoraAtual->diff($dataDesativado)->days < 2){
                echo "<span class=\"w3-tag w3-display-topleft\">Novo</span>";
              }

              echo "<div style=\"position:relative; width:13vw; aspect-ratio: 13/16; display: inline-block; \">";
              // echo "<img src=\"data:" . $imageType . ";base64," . $base64Image . "\" style=\"width:100%;\">";
              echo "  <img class=\"w3-shadow w3-card\" src=\"data:imagem/jpeg;base64,".base64_encode($imagemcamiseta)."\" style=\"position:relative; z-index:1;width:100%; aspect-ratio: 13/16; object-fit:cover;\">";

              //Coloca botões, título e preço do anúncio
              echo "
                      <div class=\"w3-display-middle w3-display-hover\" style=\"position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center; z-index:4;\">
                        <button onclick=\"confirmarReativacao(".$row["id"].")\" class=\" w3-left-align w3-button w3-black w3-block\"><i class=\"fa-solid fa-plus\"></i>&nbsp; Reativar anúncio</button>
                      </div>
                    </div>
                  </div>
                  <p>".$row["titulo"]."<br><b>R$ ".number_format($row["preco"], 2, ',', '.')."</b></p>
                  </div>
                </div>
              ";

              
            }
          }

        ?>


        
    </div>
  
  <!-- End page content -->
    <div id="teste" style=" z-index:100; position: fixed; bottom: 0; left: 0; width: 100%;" class="w3-black w3-center w3-padding">
      Powered by 
      <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">
        w3.css
      </a>
    </div>
  </div>
  <script src="./scripts/vendedor/produto/script_gerProdutos.js"></script>
</body>
</html>
