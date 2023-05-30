<!DOCTYPE html>
<?php 
    session_start();

    // Imports
    include("../database/conectaBD.php");

    // Verifica se está logado e se de fato é vendedor. Se não, redireciona para index.php.
    include("../common/functions.php");
    require("../validacaoAcessoVendedor.php");

    // Verifica se a venda acessada é realmente do vendedor logado
    $selectIdVendedor = "SELECT c.id_vendedor FROM camiseta c INNER JOIN compra_venda cv ON cv.id_camiseta = c.id WHERE cv.id = ". $_GET["idVenda"];
    $vendedor = mysqli_fetch_assoc(mysqli_query($conn, $selectIdVendedor));
    if($_SESSION["idVendedor"] != $vendedor["id_vendedor"]){
        redirect("../page_gerVendas.php");
    }

    // Utilizado para definir os botões do header
    $tipoPagina = "formUpdateVenda";

    $selectDadosVenda = "SELECT c.titulo, c.descricao, c.preco, cv.id, cv.id_camiseta, cv.data_hora_confirmacao_pagamento, cv.data_hora_recebimento, cv.quantidade, u.nome FROM compra_venda cv INNER JOIN camiseta c ON cv.id_camiseta = c.id INNER JOIN usuario u on cv.id_comprador = u.id WHERE cv.id = ".$_GET["idVenda"];
    $resultDadosVenda = mysqli_query($conn, $selectDadosVenda);

    while($dados = mysqli_fetch_assoc($resultDadosVenda)){
        $idCamiseta       = $dados["id_camiseta"];
        $tituloProduto    = $dados["titulo"];
        $descricaoProduto = $dados["descricao"];
        $precoProduto     = $dados["preco"];
        $idVenda          = $dados["id"];
        $dhPagamento      = $dados["data_hora_confirmacao_pagamento"];
        $dhRecebimento    = $dados["data_hora_recebimento"];
        $quantidade       = $dados["quantidade"];
        $nomeComprador    = $dados["nome"];
    }

    if(is_null($dhPagamento)){
        $opcoes = "<button id=\"cPagamento\" class=\"w3-large w3-right w3-button w3-green w3-round\"><i class=\"fa-solid fa-check\"></i> Confirmar pagamento</button>";
    } else
    if(is_null($dhRecebimento)){
        $opcoes = "<button id=\"rPagamento\" class=\"w3-large w3-right w3-button w3-red w3-round\"><i class=\"fa-solid fa-xmark\"></i> Revogar confirmação de pagamento</button>";
    }
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
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
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
    <script src="./scripts/jQuery/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</head>
    <body style="padding-bottom:35vh;">
        <!-- Import dos elementos visuais -->
        <?php include("../common/header.php")?>
        <?php include("../common/modalConfirmacao.php")?>

        <!-- !PAGE CONTENT! -->
        <div class="w3-main w3-content" style="max-width:80%; margin-bottom: 10vh;">
        
            <!-- Push down content on small screens -->
            <div class="w3-hide-large" style="margin-top:83px; width:100vw"></div>
            <input type="text" class="w3-hide" name="idVenda" id="idVenda" value="<?= $idVenda?>">

            <!-- Product grid -->
            <div class="w3-row w3-margin-top" style="height:90vh;" >
                <div class="w3-card " style="height: 60vh;">
                    <br>
                    <div class="w3-left w3-container w3-padding-left" style="width:50%; height:100%;">
                        <div class=" w3-padding w3-round w3-center" style="display:flex; align-items:center;">
                            <button id="prev-img" class="w3-button w3-xlarge w3-round" style="cursor:pointer;background-color:#f4dc55"><i class="fa-solid fa-caret-left"></i></button>
                            <?php
                                $selectImagens = "SELECT * FROM imagem WHERE id_produto = $idCamiseta";
                                $resultImagens = mysqli_query($conn, $selectImagens);

                                $first = true;
                                $idImg = 0;
                                while($imagem = mysqli_fetch_assoc($resultImagens)){
                                    $hide = $first ? "" : "w3-hide";
                                    echo "<img id=\"img-$idImg\"class=\"$hide\" src=\"data:imagem/jpeg;base64,".base64_encode($imagem["imagem"])."\" style=\"width: 300px; aspect-ratio: 1; object-fit:cover; margin:auto;\">";
                                    $first = false;
                                    $idImg++;
                                }
                            ?>
                            <button id="next-img" class="w3-button w3-xlarge w3-round" style="cursor:pointer;background-color:#f4dc55"><i class="fa-solid fa-caret-right"></i></button>
                            <!-- <img style="width: 400px; aspect-ratio: 1; object-fit:cover; margin:auto;" src="../imagens/camisetas/camiseta1.jpg" alt="s">
                            <img style="width: 400px; aspect-ratio: 1; object-fit:cover; margin:auto;" src="../imagens/camisetas/camiseta1.jpg" alt="s">
                            <img style="width: 400px; aspect-ratio: 1; object-fit:cover; margin:auto;" src="../imagens/camisetas/camiseta1.jpg" alt="s">
                            <img style="width: 400px; aspect-ratio: 1; object-fit:cover; margin:auto;" src="../imagens/camisetas/camiseta1.jpg" alt="s"> -->
                        </div>
                    </div>
                    <div class="w3-container w3-container w3-right w3-padding-left" style="width:50%; height:100%;">
                        <h3 style="text-transform: capitalize;"><b><?= $tituloProduto?></b></h3>
                        <p class="w3-light-grey w3-padding w3-large"style="max-height:75%; overflow-y:scroll;"><?= $descricaoProduto?></p>
                    </div>
                </div>
                
                <!-- INFO CONTAINER-->
                <div class=" w3-margin-top w3-card w3-container" style="height:65vh">
                    <h3 style="display:flex; align-items:center; justify-content:space-evenly; width: 15%; "><i class="fa-solid fa-circle-info"></i> <b>Informações</b></h3>
                    <div class=" w3-padding w3-margin"style="display:flex; flex-direction:column; align-items:center;">
                        <section class="step-wizard">
                            <ul class="step-wizard-list">
                                <li class="step-wizard-item ">
                                    <span class="progress-count">1</span>
                                    <span class="progress-label">Pedido recebido</span>
                                </li>
                                <li class="step-wizard-item <?= is_null($dhPagamento) ? "current-item" : ""?>">
                                    <span class="progress-count ">2</span>
                                    <span class="progress-label">Pagamento recebido</span>
                                </li>
                                <li class="step-wizard-item">
                                    <span class="progress-count">3</span>
                                    <span class="progress-label">Pedido enviado</span>
                                </li>
                                <li class="step-wizard-item <?= !is_null($dhPagamento) && is_null($dhRecebimento) ? "current-item" : ""?>">
                                    <span class="progress-count">4</span>
                                    <span class="progress-label">Pedido entregue</span>
                                </li>
                            </ul>
                        </section>
                        <?= $opcoes?>
                        <!-- <button class="w3-large w3-right w3-button w3-green w3-round" style="width:20vw;"><i class="fa-solid fa-check"></i> Confirmar pagamento</button> -->
                    </div>
                    
                    <div class=" w3-card w3-container w3-padding" style="display:flex; align-items:center; justify-content:center; margin:8vh 5vh">
                        <div class="w3-left" style="width:50%; min-height:10vh">
                            <h3>Comprador</h3>
                            <p><?= $nomeComprador?></p>
                        </div>    
                        <div class="w3-right" style="width:50%; min-height:10vh">
                            <table class="w3-table-all w3-center" style="width:65%; margin:auto;">
                                <tr class="w3-text-white" style=" background-color: #333">
                                    <!-- <th class="w3-center">
                                        TAMANHO
                                    </th> -->
                                    <th class="w3-center">
                                        QUANTIDADE
                                    </th>
                                    <th class="w3-center">
                                        TOTAL
                                    </th>
                                </tr>
                                <tr>
                                    <!-- <td class="w3-center w3-text-black">P</td> -->
                                    <td class="w3-center w3-text-black"><?= $quantidade?></td>
                                    <td class="w3-center w3-text-black"><?= number_format((float)$precoProduto * (float)$quantidade,2,",",".")?></td>
                                </tr>
                            </table>
                        </div>    
                    </div>
                
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
        <script src="../scripts/vendedor/venda/script_updateVenda.js"></script>
    </body>
</html>
