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

    $filtrosAceitos = ["ID", "PRODUTO", "COMPRADOR", "DCOMPRA"];
    $orderAceitos   = ["ID", "PRODUTO", "VALOR", "COMPRADOR", "DCOMPRA" , "STATUS"];


    if(!isset($_GET["pesquisarPor"]) || !in_array($_GET["pesquisarPor"],$filtrosAceitos)) $_GET["pesquisarPor"] = "";
    if(!isset($_GET["pesquisa"])) $_GET["pesquisa"] = "";
    if(!isset($_GET["orderBy"]) || !in_array($_GET["orderBy"], $orderAceitos)) $_GET["orderBy"] = "";
    if(!isset($_GET["sentido"])) $_GET["sentido"] = "";

    /**
     * 
     *         FILTROS DE PESQUISA DE VENDAS
     * 
     * Para adicionar novos métodos de pesquisa (BARRA DE PESQUISA):
     * 
     * 1- Adicionar clausula no enumFiltro
     * 
     * 2- Adicionar option no selectBox pesquisarPor
     * 
     * 3- Adicionar cláusula no array de filtrosAceitos
     * 
     * 
     *         ORDENAÇÃO
     * 
     * Para adicionar novos métodos de ordenação (orderBy):
     * 
     * 1- Adicionar cláusula no enumOrderBy
     * 
     * 2- Adicionar cláusula no array de orderAceitos
     * 
     * 3- Adicionar o evento onclick com a função ordernar() na tag de <th></th> da coluna que a tabela será ordenado:
     *     3.1 - O parâmetro do ordenar é o da cláusula ENUM(), por exemplo:
     *           ordernar por "VALOR" vai ser onclick="ordenar('VALOR').
     *           "VALOR" está na chave do enum:
     *           "VALOR" => " ORDER BY c.preco * cv.quantidade"
     * 
     * 4- Adicionar as tags com os símbolos de ordenação (ASC/DESC):
     * 
     *      <i class="fa-sharp fa-solid fa-sort-down ord" id="ORDENACAO-ASC"></i>
     *      <i class="fa-sharp fa-solid fa-sort-up ord" id="ORDENACAO-DESC"></i>
     *      
     *      ORDENACAO deve ser substituído pela chave do enum que você adicionou anteriormente:
     *      
     * 5- Caso a <th></th> correspondente ao dado a ser ordenado não esteja sendo exibida,
     *     é necessário colocá-la também. Exemplo: dataHoraEntrega não está sendo exibida, logo
     *     um <th>Data Hora Compra</th> na primeira linha da tabela.
     * 
     *     @example 
     *     EXEMPLO para ordenar por dataHoraEntrega
     * 
     *          > adicionado ao enumOrderBy: "DHENTREGA" => "CLAUSULA ORDER BY DO SELECT"
     * 
     *          > adicionado onclick ao <th>Data Hora Entrega</th>: <th onclick="ordernar("DHENTREGA")">Data Hora Entrega</th>
     *      
     *          > adicionado ícones de sentido de ordenação: 
     *              <i class="fa-sharp fa-solid fa-sort-down ord" id="DHENTREGA-ASC"></i>
     *              <i class="fa-sharp fa-solid fa-sort-up ord"   id="DHENTREGA-DESC"></i>
    */


    // Faz um array com todas as letras da pesquisa. Exemplo: "camiseta A" fica: ["c","a","m","i","s","e","t","a","A"]
    $letrasDaPesquisa = str_split(str_replace(" ","",$_GET["pesquisa"]));


    /**
     * ENUM com o tipo de filtro que será feito e a instrução WHERE do select que será feito depois
     * a instrução é iniciada com AND e depois onde a instrução sobre o que deve ser parecido com o que.
     * Exemplo:
     * 
     * pesquisarPor : "cam"
     * 
     * Produto: vai pesquisar os registros onde c.titulo (título da camiseta) é parecido com:
     * 
     * "%c%" AND c.titulo LIKE "%a%" AND c.titulo LIKE "%m%"
     * 
     * - a '%' no início e no fim simboliza procurar por aquela string em qualquer posição do texto
     *   não necessariamente no fim ou no início da string
     * 
     * - o 'impode' coloca cada um dos itens de uma array separados por uma determinada string
     *   nesse caso, "%' AND c.nome LIKE '%".
     * 
     * - o primeiro e o último %, juntamente com o primeiro LIKE, já estão na string. Assim, caso só haja uma letra, o resultado será um úncio
     *   LIKE só com a primeira letra. 
     */
    $enumFiltro = array(
        "ID" => " AND cv.id LIKE '%".implode("%' AND cv.id LIKE '%", $letrasDaPesquisa)."%'",
        "PRODUTO" => " AND c.titulo LIKE '%".implode("%' AND c.titulo LIKE '%", $letrasDaPesquisa)."%'",
        "COMPRADOR" => " AND u.nome LIKE '%".implode("%' AND u.nome LIKE '%", $letrasDaPesquisa)."%'",
        "DCOMPRA" => " AND cv.data_hora_compra LIKE '%".implode("%' AND cv.data_hora_compra LIKE '%", $letrasDaPesquisa)."%'",
        NULL => ""
    );

    /**
     * ENUM que define a ordenação da pesquisa (será passado por GET depois)
     * 
     * a cláusula será adiciona depois na query SQL
     */
    $enumOrderBy = array(
        "ID" => " ORDER BY cv.id",
        "PRODUTO" => " ORDER BY c.titulo",
        "VALOR" => " ORDER BY c.preco * cv.quantidade",
        "COMPRADOR" => " ORDER BY u.nome",
        "DCOMPRA" => " ORDER BY cv.data_hora_compra",
        "STATUS" => " ORDER BY status",
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
                <select style="cursor:pointer;width:15%" class="w3-input" name="pesquisarPor" id="pesquisarPor">
                    <option value="ID" <?= ($_GET["pesquisarPor"] == "ID") ? "selected" : "" ?>>ID</option>
                    <option value="PRODUTO" <?= ($_GET["pesquisarPor"] == "PRODUTO") ? "selected" : "" ?>>PRODUTO</option>
                    <option value="COMPRADOR" <?= ($_GET["pesquisarPor"] == "COMPRADOR") ? "selected" : "" ?>>COMPRADOR</option>
                    <option value="DCOMPRA" <?= ($_GET["pesquisarPor"] == "DCOMPRA") ? "selected" : "" ?>>DATA DA COMPRA</option>
                </select>
                <input onkeydown="if (event.key === 'Enter') { pesquisar(); }" type="text" name="pesquisa" id="pesquisa" class="w3-input w3-border w3-large w3-round-large" style="width:75%;" placeholder="Insira o termo a ser pesquisado" value="<?= ($_GET["pesquisa"] != "null" && $_GET["pesquisa"] != null) ? $_GET["pesquisa"] : ""; ?>">
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
                <th class="w3-center w3-hover-opacity" style="cursor:pointer; width: 15%;" onclick="ordenar('DCOMPRA')">
                    DATA DA COMPRA
                    <i class="fa-sharp fa-solid fa-sort-down ord" id="DCOMPRA-ASC"></i>
                    <i class="fa-sharp fa-solid fa-sort-up ord" id="DCOMPRA-DESC"></i>
                </th>
                <th class="w3-center w3-hover-opacity" style="cursor:pointer; width: 15%;" onclick="ordenar('STATUS')">
                    STATUS
                    <i class="fa-sharp fa-solid fa-sort-down ord" id="STATUS-ASC"></i>
                    <i class="fa-sharp fa-solid fa-sort-up ord" id="STATUS-DESC"></i>
                </th>
                <th class="w3-center" style="width: 15%;">
                    </i> OPÇÕES
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Se é uma clásula de pesquisa válida (é uma chave no enumFiltro), o valor passa a ser a query pega no enumFiltro(valor), caso contrário, é vazio.
                $filtro = array_key_exists($_GET["pesquisarPor"], $enumFiltro) ? $enumFiltro[$_GET["pesquisarPor"]] : "";
                // Se é uma cláusula de ordenação válida (é uma chave no enumOrderBy), valor passa a ser a query de ordenação (valor), caso contrário, vazio.
                $ordenacao = array_key_exists($_GET["orderBy"], $enumOrderBy) ? $enumOrderBy[$_GET["orderBy"]] : "";
                // (ASC/DESC) se o sentido está settado e se o valor dele é ASC ou DESC e ordenação (variavel de cima) não é vazia
                $sentido   = isset($_GET["sentido"]) && ($_GET["sentido"] == "ASC" || $_GET["sentido"] == "DESC") && $ordenacao != "" ? " ".$_GET["sentido"] : "";
                

                // Query selecionando todos os dados necessários para mostrar os dados da venda
                $selectVendasQuery = 
                "SELECT 
                    cv.id,
                    c.titulo, 
                    c.preco, 
                    cv.quantidade, 
                    cv.data_hora_compra,
                    cv.data_hora_confirmacao_pagamento, 
                    cv.data_hora_recebimento,
                    u.nome,
                    CASE
                        WHEN cv.data_hora_confirmacao_pagamento IS NULL THEN 'Aguardando pagamento'
                        WHEN cv.data_hora_recebimento IS NULL THEN 'Pedido em trânsito'
                        ELSE 'Pedido entregue ao destinatário'
                    END AS status
                FROM 
                    compra_venda cv 
                    INNER JOIN camiseta c 
                    ON cv.id_camiseta = c.id  
                    INNER JOIN usuario u 
                    ON cv.id_comprador = u.id  
                WHERE 
                    c.id_vendedor =  " . $_SESSION["idVendedor"] .
                    $filtro .
                    $ordenacao .
                    $sentido .
                    ($sentido != "" ? ", u.nome ASC;" : "")
                    ;
                // Aqui no final coloca o filtro de pesquisa, a ordenção e o sentido.


                // Resultado do select dos dados das vendas
                $resultVendas = mysqli_query($conn, $selectVendasQuery);


                if(mysqli_num_rows($resultVendas) > 0){
                    // Percorrendo todos os dados do SELECT de vendas
                    while($venda = mysqli_fetch_assoc($resultVendas)){

                        // if(is_null($venda["data_hora_confirmacao_pagamento"])){
                        //     $status = "Aguardando pagamento";
                        // } else if(is_null($venda["data_hora_recebimento"])){
                        //     $status = "Pedido em trânsito";
                        // } else {
                        //     $status = "Pedido entregue ao destinatário.";
                        // }

                        // Calcula o TOTAL quantidade * preço unitário
                        $subtotal = number_format(floatval($venda["preco"])*floatval($venda["quantidade"]),2,",",".");

                        // Printa os dados na tabela
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
                            <td class=\"w3-center\">".$venda["status"]."</td>
                            <td class=\"w3-center\">
                                <a href=\"./forms/form_updateVenda.php?idVenda=".$venda["id"]."\" class=\"w3-button w3-blue\">Visualizar</a>
                            </td>
                        </tr>
                        ";
                    }
                } else {
                    echo "<tr><td class=\"w3-center\" colspan=\"7\">Não há vendas realizadas.</td></tr>";
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
