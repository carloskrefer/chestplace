<!DOCTYPE html>
<?php 
    session_start();

    // Imports
    include("./database/conectaBD.php");
    include("./common/functions.php");


    // Verifica se está logado e se de fato é vendedor. Se não, redireciona para index.php.
    require("./validacaoAcessoVendedor.php"); 

    // Utilizado para definir os botões do header
    $tipoPagina = "gerenciarVendasVendedor";

    if(!isset($_GET["pesquisarPor"])) $_GET["pesquisarPor"] = "";
    if(!isset($_GET["pesquisa"])) $_GET["pesquisa"] = "";
    if(!isset($_GET["orderBy"])) $_GET["orderBy"] = "";
    if(!isset($_GET["sentido"])) $_GET["sentido"] = "";

    // Define o filto de pesquisa
    $letrasDaPesquisa = str_split(str_replace(" ","",$_GET["pesquisa"]));
    $enumFiltro = array(
        "ID" => " AND cv.id LIKE '%".implode("%' AND cv.id LIKE '%", $letrasDaPesquisa)."%'",
        "PRODUTO" => " AND c.titulo LIKE '%".implode("%' AND c.titulo LIKE '%", $letrasDaPesquisa)."%'",
        "COMPRADOR" => " AND u.nome LIKE '%".implode("%' AND u.nome LIKE '%", $letrasDaPesquisa)."%'",
        NULL => ""
    );

    // Define a ordenação da pesquisa
    $enumOrderBy = array(
        "ID" => " ORDER BY cv.id",
        "PRODUTO" => " ORDER BY c.titulo",
        "VALOR" => " ORDER BY c.preco * cv.quantidade",
        "COMPRADOR" => " ORDER BY u.nome",
        "dcompra" => " ORDER BY cv.data_hora_compra",
        NULL => ""
    );

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
        <div class="w3-card w3-padding w3-margin-bottom">
            <div class="w3-margin-bottom" style="display:flex; align-items: stretch; justify-content: space-between;">
                <select style="width:15%" class="w3-input" name="pesquisarPor" id="pesquisarPor">
                    <option value="ID" <?= ($_GET["pesquisarPor"] == "ID") ? "selected" : "" ?>>ID</option>
                    <option value="PRODUTO" <?= ($_GET["pesquisarPor"] == "PRODUTO") ? "selected" : "" ?>>PRODUTO</option>
                    <option value="COMPRADOR" <?= ($_GET["pesquisarPor"] == "COMPRADOR") ? "selected" : "" ?>>COMPRADOR</option>
                </select>
                <input type="text" name="pesquisa" id="pesquisa" class="w3-input w3-border w3-large w3-round-large" style="width:75%;" placeholder="Insira o termo a ser pesquisado" value="<?= ($_GET["pesquisa"] != "null" && $_GET["pesquisa"] != null) ? $_GET["pesquisa"] : ""; ?>">
                <button onclick="pesquisar();" class="w3-button w3-round-xxlarge w3-blue" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <thead>
            <tr>
                <th class="w3-center w3-hover-opacity" style="cursor:pointer; width: 5%;" onclick="ordenar('ID')">
                    ID
                    <i class="fa-sharp fa-solid fa-sort-down ord" id="ID-ASC"></i>
                    <i class="fa-sharp fa-solid fa-sort-up ord" id="ID-DESC"></i>
                </th>
                <th class="w3-center w3-hover-opacity" style="cursor:pointer; width: 25%;" onclick="ordenar('PRODUTO')">
                    PRODUTO
                    <i class="fa-sharp fa-solid fa-sort-down ord" id="PRODUTO-ASC"></i>
                    <i class="fa-sharp fa-solid fa-sort-up ord" id="PRODUTO-DESC"></i>
                </th>
                <th class="w3-center w3-hover-opacity" style="cursor:pointer; width: 10%;" onclick="ordenar('VALOR')">
                    VALOR
                    <i class="fa-sharp fa-solid fa-sort-down ord" id="VALOR-ASC"></i>
                    <i class="fa-sharp fa-solid fa-sort-up ord" id="VALOR-DESC"></i>
                </th>
                <th class="w3-center w3-hover-opacity" style="cursor:pointer; width: 15%;" onclick="ordenar('COMPRADOR')">
                    COMPRADOR
                    <i class="fa-sharp fa-solid fa-sort-down ord" id="COMPRADOR-ASC"></i>
                    <i class="fa-sharp fa-solid fa-sort-up ord" id="COMPRADOR-DESC"></i>
                </th>
                <th class="w3-center w3-hover-opacity" style="cursor:pointer; width: 15%;" onclick="ordenar('dcompra')">
                    DATA DA COMPRA
                    <i class="fa-sharp fa-solid fa-sort-down ord" id="dcompra-ASC"></i>
                    <i class="fa-sharp fa-solid fa-sort-up ord" id="dcompra-DESC"></i>
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
                $filtro = array_key_exists($_GET["pesquisarPor"], $enumFiltro) ? $enumFiltro[$_GET["pesquisarPor"]] : "";
                $ordenacao = array_key_exists($_GET["orderBy"], $enumOrderBy) ? $enumOrderBy[$_GET["orderBy"]] : "";
                $sentido   = isset($_GET["sentido"]) && ($_GET["sentido"] == "ASC" || $_GET["sentido"] == "DESC") ? " ".$_GET["sentido"] : "";
                
                $indexExibicao = 0;
                $selectVendasQuery = "SELECT cv.id, c.titulo, c.preco, cv.quantidade, cv.data_hora_compra,cv.data_hora_confirmacao_pagamento, cv.data_hora_recebimento, u.nome  FROM compra_venda cv INNER JOIN camiseta c ON cv.id_camiseta = c.id  INNER JOIN usuario u ON cv.id_comprador = u.id  WHERE c.id_vendedor =  " . $_SESSION["idVendedor"] . $filtro . $ordenacao . $sentido;
                $resultVendas = mysqli_query($conn, $selectVendasQuery);


                while($venda = mysqli_fetch_assoc($resultVendas)){

                    if(is_null($venda["data_hora_confirmacao_pagamento"])){
                        $status = "Aguardando pagamento";
                    } else if(is_null($venda["data_hora_recebimento"])){
                        $status = "Pedido em trânsito";
                    } else {
                        $status = "Pedido entregue ao destinatário.";
                    }

                    $subtotal = number_format(floatval($venda["preco"])*floatval($venda["quantidade"]),2,",",".");

                    echo "
                    <tr>
                        <td class=\"w3-center\">".$venda["id"]."</td>
                        <td>".$venda["titulo"]."</td>
                        <td>
                        <div class=\"w3-left\">R$</div>
                        <div class=\"w3-right\">".$subtotal."</div>
                        </td>
                        <td class=\"w3-center\">".$venda["nome"]."</td>
                        <td class=\"w3-center\">".date('d/m/Y H:i', strtotime($venda['data_hora_compra']))."</td>
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
  <script src="./scripts/vendedor/venda/script_gerVendas.js"></script>
</body>
</html>
