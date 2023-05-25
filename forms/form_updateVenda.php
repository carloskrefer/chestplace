<!DOCTYPE html>
<?php 
    session_start();

    // Imports
    include("../database/conectaBD.php");


    // Verifica se está logado e se de fato é vendedor. Se não, redireciona para index.php.
    require("../validacaoAcessoVendedor.php"); 

    // Utilizado para definir os botões do header
    $tipoPagina = "formUpdateVenda";

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
        <?php include("../common/header.php")?>
        <?php include("../common/modalConfirmacao.php")?>

        <!-- !PAGE CONTENT! -->
        <div class="w3-main w3-content w3-margin-bottom" style="max-width:80%">
        
            <!-- Push down content on small screens -->
            <div class="w3-hide-large" style="margin-top:83px; width:100vw"></div>


            <!-- Product grid -->
            <div class="w3-row w3-margin-top" style="height:90vh; margin-bottom: 10vh" >
                <h2 class="w3-bold w3-margin-top w3-margin-bottom">
                    Vendas realizadas
                </h2>
                <div style="height: 60vh;">
                    <div class="w3-left w3-container w3-pink w3-padding-left" style="width:50%; height:100%;">
                        <h3>Imagens</h3>
                        <div class="w3-red w3-center" style="display:flex; align-items:center;width: 100%;height: 500px;">
                            <img style="width: 400px;height: 400px; object-fit:cover; margin:auto;" src="../imagens/camisetas/camiseta1.jpg" alt="s">
                        </div>
                    </div>
                    <div class="w3-orange w3-container w3-right w3-padding-left" style="width:50%; height:100%;">
                        <h3>Título</h3>
                        <p>Camiseta</p>
                        <h3>Descrição</h3>
                        <p>Camiseta de sba</p>
                    </div>
                </div>
                <h3 style="display:flex; align-items:center; justify-content:space-evenly; width: 15%; "><i class="fa-solid fa-circle-info"></i> Informações</h3>
                <div class="w3-left w3-container w3-pink w3-padding-left" style="width:50%; margin-bottom:5vh;">
                    <h3>Status do pedido</h3>
                    <style>
                        .step-wizard-list{
                            background: #333;
                            box-shadow: 0 15px 25px rgba(0,0,0,0.1);
                            color: #fff;
                            list-style-type: none;
                            border-radius: 10px;
                            display: flex;
                            padding: 20px 10px;
                            position: relative;
                            z-index: 10;
                        }

                        .step-wizard-item{
                            padding: 0 20px;
                            flex-basis: 0;
                            -webkit-box-flex: 1;
                            -ms-flex-positive:1;
                            flex-grow: 1;
                            max-width: 100%;
                            display: flex;
                            flex-direction: column;
                            text-align: center;
                            min-width: 170px;
                            position: relative;
                        }
                        .step-wizard-item + .step-wizard-item:after{
                            content: "";
                            position: absolute;
                            left: 0;
                            top: 19px;
                            background: #f4dc55;
                            width: 100%;
                            height: 2px;
                            transform: translateX(-50%);
                            z-index: -10;
                        }
                        .progress-count{
                            height: 40px;
                            width:40px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border-radius: 50%;
                            font-weight: 600;
                            margin: 0 auto;
                            position: relative;
                            z-index:9;
                            color: transparent;
                        }
                        .progress-count:after{
                            content: "";
                            height: 40px;
                            width: 40px;
                            background: #f4dc55;
                            position: absolute;
                            left: 50%;
                            top: 50%;
                            transform: translate(-50%, -50%);
                            border-radius: 50%;
                            z-index: -10;
                        }
                        .progress-count:before{
                            content: "";
                            height: 10px;
                            width: 20px;
                            border-left: 3px solid #333;
                            border-bottom: 3px solid #333;
                            position: absolute;
                            left: 50%;
                            top: 50%;
                            transform: translate(-50%, -60%) rotate(-45deg);
                            transform-origin: center center;
                        }
                        .progress-label{
                            font-size: 14px;
                            font-weight: 600;
                            margin-top: 10px;
                        }
                        .current-item .progress-count:before,
                        .current-item ~ .step-wizard-item .progress-count:before{
                            display: none;
                        }
                        .current-item ~ .step-wizard-item .progress-count:after{
                            height:10px;
                            width:10px;
                        }
                        .current-item ~ .step-wizard-item .progress-label{
                            opacity: 0.5;
                        }
                        .current-item .progress-count:after{
                            background: #333;
                            border: 2px solid #f4dc55;
                        }
                        .current-item .progress-count{
                            color: #f4dc55;
                        }
                        </style>
                <section class="step-wizard">
                    <ul class="step-wizard-list">
                        <li class="step-wizard-item current-item">
                            <span class="progress-count">1</span>
                            <span class="progress-label">Pedido recebido</span>
                        </li>
                        <li class="step-wizard-item">
                            <span class="progress-count">2</span>
                            <span class="progress-label">Pagamento recebido</span>
                        </li>
                        <li class="step-wizard-item ">
                            <span class="progress-count">3</span>
                            <span class="progress-label">Pedido enviado</span>
                        </li>
                        <li class="step-wizard-item">
                            <span class="progress-count">4</span>
                            <span class="progress-label">Pedido entregue</span>
                        </li>
                    </ul>
                </section>
                <button class="w3-large w3-right w3-button w3-green w3-round"><i class="fa-solid fa-sack-dollar"></i> Confirmar pagamento</button>

                </div>
                <div class="w3-orange w3-container w3-right w3-padding-left" style="width:50%; margin-bottom:5vh;">
                    <h3>Comprador</h3>
                    <p>João das Couves</p>
                    <h3>Quantidade</h3>
                    <p>Camiseta de sba</p>
                    <h3>Valor total</h3>
                    <p>R$ 89,90</p>
                </div>
            </div>
        </div>
        
            <!-- End page content -->
            <div id="teste" style="  z-index: 10; position: fixed; bottom: 0; left: 0; width: 100%;" class="w3-black w3-center w3-padding">
                Powered by 
                <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">
                    w3.css
                </a>
            </div>
        </div>
        <script src="./scripts/vendedor/produto/script_gerProdutos.js"></script>
    </body>
</html>
