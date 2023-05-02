<!-- Top menu on small screens -->

<?php
    include("../database/conectaBD.php");
    $selectNomeVendedor = "SELECT nome_estabelecimento FROM vendedor WHERE id_usuario = " . $_SESSION["idVendedor"];

    $result = mysqli_query($conn, $selectNomeVendedor);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $nome = $row["nome_estabelecimento"];
        }
    } else{
        $nome = "ERRO!";
    }
?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>

<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <div class="w3-bar-item w3-padding-24 w3-wide">
    <img src="./imagens/logo_chestplace.png" style="width: 100%; margin-top: 10px;">
  </div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

 <!-- Top header -->
 <header class=" w3-xlarge" style="background-color: #141414; display:flex; align-items: center; justify-content: space-between; padding:0px 50px 0px 50px;">
    
    <img src="../imagens/logo_chestplace.png" style="width: 15%;">


    <p class="w3-right align-right">
        <a class="no-underline" href="#" target="" >
            <span class="w3-large" style="text-decoration: underline; color:white;""><?php echo $nome?></span>
            <i class="fa fa-user w3-margin-right" style="color:white;"></i>
        </a>
        <a class="no-underline" style="color:white;" href="#">
            <i class="fa fa-solid fa-plus"></i>
        </a>
    </p>
</header>
