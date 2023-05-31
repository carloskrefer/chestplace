<!DOCTYPE html>
<?php 
  session_start();

  // Imports
  require("./database/conectaBD.php");
  // Verifica se está logado e se de fato é comprador. Se não, redireciona para index.php.
  require("./validacaoAcessoComprador.php"); 
  
  // Utilizado para definir os botões do header
  $tipoPagina = "gerComprador";                                   

?>
<html>
<head>
<title>Chestplace - COMPRADOR</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="./scripts/jQuery/jquery-3.6.4.min.js"></script>
  <style type="text/css" media="screen">a:link{ text-decoration: none; } body {font-family: "Montserrat", sans-serif;}</style>
</head>

<body>
  <!-- Import dos elementos visuais -->
  <?php require("./common/header.php")?>

  <!-- !PAGE CONTENT! -->
  <div class="w3-main w3-content" style="margin-bottom:10vh;max-width:1200px">
  
    <!-- Push down content on small screens -->
    <div class="w3-hide-large" style="margin-top:83px; width:100vw"></div>

    <!-- BOTÃO DE ALTERAR CADASTRO -->
    <a href="./forms/form_alterComprador.php" style="margin:auto;">
      <div class="w3-center w3-border w3-border-black w3-round-xlarge w3-hover-border-orange" 
        style="width: 400px; margin:auto; margin-top:20px; border-width: 16px!important;">
      <i class="fas fa-address-card" style="font-size: 150px;"></i>
      <p id="txtAltCad" style="font-size: 40px; margin:0px; font-weight: 900;">Alterar cadastro</p>
      </div>
    </a>

    <!-- BOTÃO DE ACOMPANHAR PEDIDOS -->
    <a href="" style="margin:auto;"> <!-- TODO: adicionar link da página do Felipe -->
      <div class="w3-center w3-border w3-border-black w3-round-xlarge w3-hover-border-orange" 
        style="width: 400px; margin:auto; margin-top:50px; border-width: 16px!important;">
      <i class="fa fa-tasks" style="font-size: 150px;"></i>
      <p id="txtAltCad" style="font-size: 40px; margin:0px; font-weight: 900;">Acompanhar pedidos</p>
      </div>
    </a>

    <!-- BOTÃO DE EXCLUIR CONTA -->
    <a href="" style="margin:auto;"> <!-- TODO: exibir modal de confirmação ao clicar -->
      <div class="w3-center w3-border w3-border-black w3-round-xlarge w3-hover-border-orange" 
        style="width: 400px; margin:auto; margin-top:50px; border-width: 16px!important;">
      <i class="fa fa-exclamation-triangle" style="font-size: 150px; color: orange;"></i>
      <p id="txtAltCad" style="font-size: 40px; margin:0px; font-weight: 900;">Excluir conta</p>
      </div>
    </a>
    <div id="itens-publicado" class="w3-row">
  
  <!-- End page content -->
    <div id="teste" style=" z-index:100; position: fixed; bottom: 0; left: 0; width: 100%;" class="w3-black w3-center w3-padding">
      Powered by 
      <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">
        w3.css
      </a>
    </div>
  </div>
</body>
</html>