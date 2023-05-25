<!DOCTYPE html>
<?php
    session_start();
    include("../database/conectaBD.php");
    $idCamiseta = $_GET["id"];
    $queryProdutos = "SELECT * FROM camiseta WHERE id = ".$idCamiseta.";";
?>
<html>
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
<?php include("../common/header.php")?>
</body>
</html>