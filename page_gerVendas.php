<!DOCTYPE html>
<?php 
    session_start();

    // Imports
    include("./database/conectaBD.php");


    // Verifica se está logado e se de fato é vendedor. Se não, redireciona para index.php.
    require("./validacaoAcessoVendedor.php"); 

    // Utilizado para definir os botões do header
    $tipoPagina = "gerenciarVendasVendedor";

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
  <?php include("./common/header.php")?>
  <?php include("./common/modalConfirmacao.php")?>

  <!-- !PAGE CONTENT! -->
  <div class="w3-main w3-content w3-margin-bottom" style="max-width:80%">
  
    <!-- Push down content on small screens -->
    <div class="w3-hide-large" style="margin-top:83px; width:100vw"></div>


    <!-- Product grid -->
    <div class="w3-row w3-margin-top" >
    
    <table class="w3-table-all w3-center w3-card">
        <h3 class="w3-margin-top w3-margin-bottom">
            Vendas realizadas
        </h3>
        <thead>
            <tr>
                <th class="w3-center" style="width: 5%;">
                    ID
                </th>
                <th class="w3-center" style="width: 25%;">
                    PRODUTO
                </th>
                <th class="w3-center" style="width: 10%;">
                    VALOR
                </th>
                <th class="w3-center" style="width: 15%;">
                    COMPRADOR
                </th>
                <th class="w3-center" style="width: 15%;">
                    DATA DA COMPRA
                </th>
                <th class="w3-center" style="width: 15%;">
                    STATUS
                </th>
                <th class="w3-center" style="width: 15%;">
                    </i> OPÇÕES
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $indexExibicao = 0;
                $selectVendasQuery = "SELECT cv.id, c.titulo, c.preco, cv.quantidade, cv.data_hora_compra,cv.data_hora_confirmacao_pagamento, cv.data_hora_recebimento, u.nome  FROM compra_venda cv INNER JOIN camiseta c ON cv.id_camiseta = c.id  INNER JOIN usuario u ON cv.id_comprador = u.id  WHERE c.id_vendedor =  " . $_SESSION["idVendedor"];
                $resultVendas = mysqli_query($conn, $selectVendasQuery);

                while($venda = mysqli_fetch_assoc($resultVendas)){

                    if(is_null($venda["data_hora_confirmacao_pagamento"])){
                        $status = "Aguardando pagamento";
                    } else if(is_null($venda["data_hora_recebimento"])){
                        $status = "Pedido em trânsito";
                    } else {
                        $status = "Pedido entregue ao destinatário.";
                    }

                    $subtotal = number_format(floatval($venda["preco"])*floatval($venda["quantidade"]),2,",");

                    echo "
                    <tr>
                        <td class=\"w3-center\">".$venda["id"]."</td>
                        <td>".$venda["titulo"]."</td>
                        <td>
                        <div class=\"w3-left\">R$</div>
                        <div class=\"w3-right\">".$subtotal."</div>
                        </td>
                        <td class=\"w3-center\">".$venda["nome"]."</td>
                        <td class=\"w3-center\">".$venda["data_hora_compra"]."</td>
                        <td class=\"w3-center\">$status</td>
                        <td class=\"w3-center\">
                            <a href=\"./forms/form_updateVenda.php?idVenda=".$venda["id"]."\" class=\"w3-button w3-blue\">Visualizar</a>
                        </td>
                    </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
  </div>
  
  <!-- End page content -->
    <div id="teste" style="  position: fixed; bottom: 0; left: 0; width: 100%;" class="w3-black w3-center w3-padding">
      Powered by 
      <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">
        w3.css
      </a>
    </div>
  </div>
  <script src="./scripts/vendedor/produto/script_gerProdutos.js"></script>
</body>
</html>
