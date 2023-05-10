<!DOCTYPE html>
<?php 
  include("./database/conectaBD.php");
  
  session_start();
  
  require("./validacaoAcessoVendedor.php"); // Verifica se está logado e se de fato é vendedor. Se não, redireciona p/ index.php.
  
  $tipoPagina = "gerenciarProdutosVendedor";
  

  $_SESSION["idVendedor"] = $_SESSION ['id_usuario']; // id_usuario é setado no login.php
  $selectNomeEstabelecimento = "SELECT nome_estabelecimento FROM vendedor WHERE id_usuario = ".$_SESSION["idVendedor"];
  $resultNomeEstabelecimento = mysqli_query($conn, $selectNomeEstabelecimento);
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
</head>

<body>
  <?php include("./common/header.php")?>

  <!-- Modal de confirmação de deleção -->
  <!-- <dialog id="dialog-delete" class="w3-border w3-border-amber" style="border-width: 5px !important;">
    <h2 class="w3-center w3-xxlarge"><i class="fa fa-solid fa-exclamation-triangle"></i> Confirmação</h2>
    <div class="w3-panel">
      <h2>Você realmente quer apagar este anúncio?</h2>
      <p>Todos os dados deste anúncio serão perdidos.</p>
    </div>
    <div class="w3-section w3-right-align">
      <button class="w3-button w3-theme w3-section w3-padding w3-orange" type="submit">Apagar</button>
      <button class="w3-button w3-theme w3-section w3-padding" type="button">Cancelar</button>
    </div>
  </dialog> -->





  <script>document.getElementById("dialog-delete").showModal()</script>

  <!-- !PAGE CONTENT! -->
  <div class="w3-main w3-content" style="max-width:1200px">
  
    <!-- Push down content on small screens -->
    <div class="w3-hide-large" style="margin-top:83px; width:100vw"></div>


    <div class="w3-container w3-text-grey" id="jeans">
      <p>
      <?php
        $queryQtde = "
        SELECT count(*) qtde 
        FROM camiseta c 
        WHERE c.id_vendedor =".$_SESSION["idVendedor"].";";

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

    <!-- Product grid -->
    <div class="w3-row w3-grayscale">
      <?php

        //Coleta data e hora atual (momento da execução)
        $dataHoraAtual = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));;

        //Select das camisetas e imagens das camisetas do vendedor passado por _GET
        $queryProdutos = "
          SELECT * 
          FROM camiseta c 
          WHERE c.id_vendedor =".$_SESSION["idVendedor"]."
          GROUP BY c.id;";

        //Resultao do Select
        $result = mysqli_query($conn, $queryProdutos);

        //Percorrendo resultado do select
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            //Data de publicação convertida para DateTime do php
            $dataCadastro = new DateTime($row["data_hora_cadastro"]);
            $sql = "SELECT  id, imagem FROM imagem where id_produto =" .$row['id']." limit 1;";
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


            // echo "<img src=\"data:" . $imageType . ";base64," . $base64Image . "\" style=\"width:100%;\">";
            echo "<img src=\"data:imagem/jpeg;base64,".base64_encode($imagemcamiseta)."\" style=\"width:13vw; height: 30vh; object-fit:cover;\">";

            //Coloca botões, título e preço do anúncio
            echo "
                  <div class=\"w3-display-middle w3-display-hover\">
                    <button onclick=\"goToAlterProduto(".$row["id"].")\" class=\" w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-edit\"></i>&nbsp;Editar</button>
                    <button onclick=\"goToDeletarProduto(".$row["id"].")\" class=\" w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-trash\"></i>&nbsp;Apagar</button>
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
    <div id="teste" style="  position: fixed; bottom: 0; left: 0; width: 100%;" class="w3-black w3-center w3-padding">
      Powered by 
      <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">
        w3.css
      </a>
    </div>
  </div>
    
    <script>

      // Accordion 
      function myAccFunc() {
        var x = document.getElementById("demoAcc");
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
        } else {
          x.className = x.className.replace(" w3-show", "");
        }
      }

      // Click on the "Jeans" link on page load to open the accordion for demo purposes
      document.getElementById("myBtn").click();

      // Open and close sidebar
      function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
      }
      
      function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
      }

      function goToAlterProduto(id){
        window.location.href='./forms/form_alterProduto.php?id=' + id;
      }

      function goToDeletarProduto(id){
        window.location.href="./actions/delProduto_exe.php?id=" + id;
      }

    </script>
</body>
</html>
