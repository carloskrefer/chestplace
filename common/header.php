<?php

    if($tipoPagina == "gerenciarProdutosVendedor"){

        $imgLogo = "./imagens/logo_chestplace.png";
        
        $selectNomeVendedor = 
        "SELECT nome_estabelecimento 
         FROM vendedor 
         WHERE id_usuario = ".$_SESSION["idVendedor"];

        $resSelect = mysqli_query($conn, $selectNomeVendedor);
        $loja      = mysqli_fetch_assoc($resSelect);
        $nome      = $loja["nome_estabelecimento"];
 
        if(is_null($nome)) $nome = "ERRO";

        $botoes = 
        "
            <div class=\"w3-hover-opacity\" style=\"display:flex; align-items:center;\">
                <div class=\"w3-right w3-bar-item w3-btn w3-xxlarge\" style=\"display:flex; align-items:center; justify-content:space-between;;\">
                    <a class=\"no-underline w3-large\" href=\"./forms/form_alterVendedor.php\" target=\"\" style=\"color:white;\" >
                    ".$nome."
                    </a>
                </div>
                <div class=\"w3-right w3-bar-item w3-btn w3-xxlarge\" style=\"display:flex; align-items:center; justify-content:space-between;;\">
                    <a class=\"no-underline\"  href=\"./forms/form_alterVendedor.php\" target=\"\" style=\"color:white;\">
                        <i class=\"fa fa-user w3-margin-right\" style=\"color:white;\"></i>
                    </a>
                </div>
            </div>
            <div class=\"w3-hover-opacity w3-right w3-bar-item w3-btn w3-xxlarge\" style=\"display:flex; align-items:center; justify-content:space-between;;\">
                <a class=\"w3-btn w3-xxlarge no-underline\" style=\"display:flex; align-items:center; justify-content:space-between; color:white;\" href=\"./forms/form_cadProduto.php\">
                    <i class=\"fa fa-solid fa-plus\"></i>
                </a>
            </div>
            <div class=\"w3-hover-opacity w3-right w3-bar-item w3-btn w3-xxlarge\" style=\"display:flex; align-items:center; justify-content:space-between;\">
                <a class=\"w3-btn w3-xxlarge no-underline\" style=\"display:flex; align-items:center; justify-content:space-between; color:white;\" href=\"./index.php\">
                    <i class=\"fa-solid fa-right-from-bracket\"></i>
                </a>
            </div>
         ";
    }

    if($tipoPagina == "cadastroVendedor"){

        $imgLogo = "../imagens/logo_chestplace.png";

        $botoes = 
        "
        <div class=\"w3-hover-opacity w3-right w3-bar-item w3-btn w3-xxlarge\" style=\"display:flex; align-items:center; justify-content:space-between;\">
            <a class=\"w3-btn w3-xxlarge no-underline\" style=\"display:flex; align-items:center; justify-content:space-between; color:white;\" href=\"../index.php\">
                <i class=\"fa-solid fa-house\"></i>
            </a>
        </div>
         ";
    }

    if($tipoPagina == "alteracaoVendedor"){

        $imgLogo = "../imagens/logo_chestplace.png";

        $botoes = 
        "
            <div class=\"w3-hover-opacity w3-right w3-bar-item w3-btn w3-xxlarge\" style=\"display:flex; align-items:center; justify-content:space-between;\">
                <a class=\"w3-btn w3-xxlarge no-underline\" style=\"display:flex; align-items:center; justify-content:space-between; color:white;\" href=\"../page_gerProdutos.php\">
                    <i class=\"fa-solid fa-circle-chevron-left\"></i>
                </a>
            </div>
        ";
    }

    if($tipoPagina == "cadastroProduto"){

        $imgLogo = "../imagens/logo_chestplace.png";

        $botoes = 
        "
            <div class=\"w3-hover-opacity w3-right w3-bar-item w3-btn w3-xxlarge\" style=\"display:flex; align-items:center; justify-content:space-between;\">
                <a class=\"w3-btn w3-xxlarge no-underline\" style=\"display:flex; align-items:center; justify-content:space-between; color:white;\" href=\"../page_gerProdutos.php\">
                    <i class=\"fa-solid fa-circle-chevron-left\"></i>
                </a>
            </div>
        ";
    }
?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles.css">
</head>

<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge" style="display:flex; align-items:center; padding: 0px 25px 0px 25px">
  <div class="w3-bar-item w3-padding-24 w3-wide">
    <img src="<?=$imgLogo?>" style="width: 30%;">
  </div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

 <!-- Top header -->
 <header class=" w3-xlarge" style="background-color: #141414; display:flex; align-items: center; justify-content: space-between; padding:0px 50px 0px 50px;">
    
    <img src="<?=$imgLogo?>" alt="logo" style="width: 15%;">


    <div class="w3-bar w3-right" style="display:flex; align-items:center; justify-content: flex-end;width: 100%;">
        <?php echo $botoes; ?>
    </div>
</header>
