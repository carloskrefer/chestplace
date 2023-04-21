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
    <div class="w3-hide-large" style="margin-top:83px"></div>
    
    <!-- Top header -->
    <header class="w3-container w3-xlarge">
      <h3 class="w3-wide w3-left w3-padding-16"><b>LOGO</b></h3>
      <p class="w3-right">
        <a class="no-underline" href="#" target="" >
          <spam class="w3-large" style="text-decoration: underline;">Gabriel</spam>
          <i class="fa fa-user w3-margin-right"></i>
        </a>
        <a class="no-underline" href="forms/form_cadProduto.php">
          <i class="fa fa-solid fa-plus"></i>
        </a>
      </p>
    </header>


    <div class="w3-container w3-text-grey" id="jeans">
      <p>
      <?php
        include("./database/conectaBD.php");

        $queryQtde = "
        SELECT count(*) qtde 
        FROM camiseta c 
        INNER JOIN imagem i
        ON c.id = i.id_produto
        WHERE c.id_vendedor =".$_GET["id"].";";

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
        $dataHoraAtual = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));;

        $queryProdutos = "
          SELECT * 
          FROM camiseta c 
          INNER JOIN imagem i
          ON c.id = i.id_produto
          WHERE c.id_vendedor =".$_GET["id"].";";
          
        $result = mysqli_query($conn, $queryProdutos);

        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            $dataPublicacao = new DateTime($row["data_hora_publicacao"]);
            
            echo "
              <div class=\"w3-col l3 s6\">
                <div class=\"w3-container\">
                  <div class=\"w3-display-container\">
            ";

            //Tag 'Novo'
            if($dataHoraAtual->diff($dataPublicacao)->days < 2){
              echo "<span class=\"w3-tag w3-display-topleft\">Novo</span>";
            }

            // Codifica o blob em base64
            $base64Image = base64_encode($row["imagem"]);

            // echo "<img src=\"data:" . $imageType . ";base64," . $base64Image . "\" style=\"width:100%;\">";
            echo "<img src='./w3images/jeans1.jpg' style=\"width:100%;\">";

            echo "
                  <div class=\"w3-display-middle w3-display-hover\">
                  <button class=\"w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-trash\"></i>&nbsp;Edit</button>
                  <button class=\"w3-left-align w3-button w3-black w3-block\"><i class=\"fa fa-edit\"></i>&nbsp;Delete</button>
                </div>
              </div>
              <p>".$row["titulo"]."<br><b>$".$row["preco"]."</b></p>
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

    </script>
</body>
</html>
