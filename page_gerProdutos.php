<?php 
  session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
<title>Chestplace</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./styles.css">
</head>

<body class="w3-content" style="max-width:1200px">
  <!-- Top menu on small screens -->
  <header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
    <div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
  </header>


  <!-- Small screens -->
  <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
  
  <!-- !PAGE CONTENT! -->
  <div class="w3-main">
  
    <!-- Push down content on small screens -->
    <div class="w3-hide-large" style="margin-top:83px; width:100vw"></div>
    
    <!-- Top header -->
    <header class="w3-container w3-xlarge" style=" display:flex; align-items: center; justify-content: space-between; padding:0px 50px 0px 50px;">
      <h3 class="w3-wide w3-left w3-padding-16" >
        <img src="./imagens/logo_chestplace.png" style="width: 15%;">
      </h3>
      <p class="w3-right">
        </p>
        <a class="no-underline" href="./forms/form_alterVendedor.php" target="" style="display:flex; width:10vw;" >
          <spam class="w3-large" style="text-decoration: underline;">Gabriel</spam>
          <i class="fa fa-user w3-margin-right"></i>
        </a>
      <a class="no-underline" href="forms/form_cadProduto.php" title="Cadastrar novo produto">
        <i class="fa fa-solid fa-plus"></i>
      </a>
    </header>


    <div class="w3-container w3-text-grey" id="jeans">
      <p>
      <?php
        include("./database/conectaBD.php");
        $_SESSION["idVendedor"] = $_GET["id"];

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
            $dataPublicacao = new DateTime($row["data_hora_publicacao"]);
            
            echo "
              <div class=\"w3-col l3 s6\">
                <div class=\"w3-container\">
                  <div class=\"w3-display-container\">
            ";

            //Se o anuncio foi feito há menos de dois dias
            //Tag 'Novo'
            if($dataHoraAtual->diff($dataPublicacao)->days < 2){
              echo "<span class=\"w3-tag w3-display-topleft\">Novo</span>";
            }

            // echo "<img src=\"data:" . $imageType . ";base64," . $base64Image . "\" style=\"width:100%;\">";
            echo "<img src='./w3images/jeans1.jpg' style=\"width:100%;\">";

            //Coloca botões, título e preço do anúncio
            echo "
                  <div class=\"w3-display-middle w3-display-hover\">
                    <button onclick=\"goToAlterProduto(".$row["id"].")\" class=\"w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-edit\"></i>&nbsp;Editar</button>
                    <button onclick=\"goToDeletarProduto(".$row["id"].")\" class=\"w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-trash\"></i>&nbsp;Apagar</button>
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
