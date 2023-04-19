<?include("./database/conectaBD.php")?>

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
      <p>4 items</p>
    </div>

    <?php
      for($i=0; $i< 10; $i++){
        $sum = 0;
        $sum += $i;
        // echo "<script>alert(\"".$i."\")</script>";
      }
    ?>
    <!-- Product grid -->
    <div class="w3-row w3-grayscale">
      <?php

        $queryProdutos = "SELECT ";


        $conn->


        // Utilizando a sintaxe curta
        $array = [
          0 => "bar",
          1 => "foo",
        ];
      
      ?>


      <div class="w3-col l3 s6">
        <div class="w3-container">
          <div class="w3-display-container">
            <span class="w3-tag w3-display-topleft">New</span>
            <img src="./w3images/jeans2.jpg" style="width:100%">  
            <div class="w3-display-middle w3-display-hover">
              <button class="w3-left-align w3-button w3-black w3-block"><i class="fa fa-trash"></i>&nbsp;Edit</button>
              <button class="w3-left-align w3-button w3-black w3-block"><i class="fa fa-edit"></i>&nbsp;Delete</button>
            </div>
          </div>
          <p>[PRODUCT-NAME]<br><b>$19.99</b></p>
        </div>
    </div>

    <?php
      echo "<script>alert(\"".$sum."\")</script>";
    ?>

    <div class="w3-col l3 s6">
      <div class="w3-container">
        <div class="w3-display-container">
          <img src="./w3images/jeans2.jpg" style="width:100%">  
          <div class="w3-display-middle w3-display-hover">
            <button class="w3-left-align w3-button w3-black w3-block"><i class="fa fa-trash"></i>&nbsp;Edit</button>
            <button class="w3-left-align w3-button w3-black w3-block"><i class="fa fa-edit"></i>&nbsp;Delete</button>
          </div>
        </div>
        <p>[PRODUCT-NAME]<br><b>$19.99</b></p>
      </div>
    </div>

    <div class="w3-col l3 s6">
      <div class="w3-container">
        <div class="w3-display-container">
          <img src="./w3images/jeans2.jpg" style="width:100%">  
          <div class="w3-display-middle w3-display-hover">
            <button class="w3-left-align w3-button w3-black w3-block"><i class="fa fa-trash"></i>&nbsp;Edit</button>
            <button class="w3-left-align w3-button w3-black w3-block"><i class="fa fa-edit"></i>&nbsp;Delete</button>
          </div>
        </div>
        <p>[PRODUCT-NAME]<br><b>$19.99</b></p>
      </div>
    </div>

    <div class="w3-col l3 s6">
      <div class="w3-container">
        <div class="w3-display-container">
          <img src="./w3images/jeans2.jpg" style="width:100%">  
          <div class="w3-display-middle w3-display-hover">
            <button class="w3-left-align w3-button w3-black w3-block"><i class="fa fa-trash"></i>&nbsp;Edit</button>
            <button class="w3-left-align w3-button w3-black w3-block"><i class="fa fa-edit"></i>&nbsp;Delete</button>
          </div>
        </div>
        <p>[PRODUCT-NAME]<br><b class="w3-text-red">$19.99</b></p>
      </div>
    </div>

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
