<!DOCTYPE html>
<?php
    session_start();

    // Validar se o usuário pode estar na página, se não tiver autorização, voltar para index.php
    require("../validacaoAcessoVendedor.php");

    // Imports
    include("../database/conectaBD.php");
    include("../common/functions.php");
    

    $tipoPagina = "alterarProduto";

    $idCamiseta = $_GET["id"];

    // Select dos dados da camiseta camiseta com id passado por GET
    $queryProdutos = "SELECT * FROM camiseta WHERE id = ".$idCamiseta.";";

    cLog($queryProdutos);

    //Resultao do Select
    $result = mysqli_query($conn, $queryProdutos);

    //Percorrendo resultado do select
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // Se um vendedor tentar alterar uma camiseta que não é dele
            if($row["id_vendedor"] !== $_SESSION["idVendedor"]){ redirect("../page_gerProdutos.php"); }
            $titulo = $row["titulo"];
            $preco = $row["preco"];
            $descricao = $row["descricao"];
            $data_hora_publicacao = $row["data_hora_publicacao"];
            $marca = $row["id_marca"];
            $conservacao = $row["conservacao"];
        }
    } else {
        // Se tentar acessar uma camiseta que não está cadastrada
        redirect("../page_gerProdutos.php");
    }

?>

<html>

<head>
	<title>Chestplace</title>
    <link rel="icon" type="image/png" href="imagens/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
    <link rel="stylesheet" href="../styles.css">
    <script src="../scripts/jQuery/jquery-3.6.4.min.js"></script>
    <script src="../scripts/formats.js"></script>
    <script src="../scripts/vendedor/produto/checkboxConfig.js"></script>
    <script>
        /**
         * -----------INIT VARIAVEIS-----------
         */
        // Deleção de imagens
        var idImagensDeletar = [];
        var idImagensOriginal= [];
    </script>

</head>

<body>
	<!-- Inclui MENU.PHP  -->
    <?php require '../common/header.php'; ?>
    <?php require '../database/conectaBD.php'; ?>
    <?php require '../common/modalConfirmacao.php'; ?>
    <?php echo"<script>var idVendedor = ".$_SESSION["idVendedor"].";</script>"?>

	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="max-width:1500px; margin:auto;">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Alterar dados do produto</h2>
                </div>
                <form name="frmAlterProduto" id="frmAlterProduto" class="w3-container" action="../actions/alterProduto_exe.php" method="post" enctype="multipart/form-data">
                    <table class='w3-table-all'>
                        <tr>
                            <td style="width:50%;">
                                <p>
                                    <input type="hidden" id="idCamiseta" name="idCamiseta" value="<?= $idCamiseta?>">
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Título</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" name="titulo" id="titulo" type="text" value="<?= $titulo ?>" required/>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Descrição</b>*</label>
                                    <textarea class="w3-input w3-border w3-light-grey " name="descricao" id="descricao" cols="30" rows="10" placeholder="Insira a descrição do seu produto" required> <?= $descricao ?> </textarea>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Preço</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " oninput="configurarPreco(this);" onblur="configurarPreco(this)" type="text" name="preco" id="preco" value="<?= number_format($preco,2,".","") ?>"required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Data de publicação*</b></label>
                                    <input class="w3-input w3-border w3-light-grey " name="dataPublicacao" id="dataPublicacao" type="datetime-local" placeholder="dd/mm/aaaa" title="dd/mm/aaaa" title="Formato: dd/mm/aaaa" value="<?= $data_hora_publicacao ?>">
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Marca</b>*</label>
                                    <select name="marca" id="marca" class="w3-input w3-border w3-light-grey " required>
                                        <?php
                                            // SELECT de todas marcas das camisetas cadastradas
                                            $queryMarcas = "SELECT * FROM marca";

                                            // Resultao do SELECT das marcas
                                            $result = mysqli_query($conn, $queryMarcas);

                                            // Para cada uma das marcas
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    
                                                    // Se a marca for a marca da camiseta a ser alterada, selecionar opção
                                                    $selected = ($row["id"] == $marca) ? "selected" : ""; 

                                                    echo"<option value=".$row["id"]." $selected>".$row["nome"]."</option>";

                                                }
                                            }
                                        ?>
                                    </select>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Estado de conservação</b>*</label>
                                    <select name="conservacao" id="conservacao" class="w3-input w3-border w3-light-grey " required>
                                        <option value=""  disabled hidden>Escolha o estado de conservação</option>
                                        
                                        <?php
                                            $enum = array(
                                                "Nova" => "nova",
                                                "Seminova" => "seminova",
                                                "Usada" => "usada",
                                                "Desgastada" => "desgastada",
                                                "Muito desgastada" => "muito desgastada",
                                            );

                                            // Para cada $chave e $valor do ENUM
                                            foreach ($enum as $chave => $valor) {
                                                // Se for o valor for o estado de conservação da camiseta a ser alterada, selecionar opção
                                                echo "<option value='$valor'". ($conservacao == $valor ? " selected" : "") .">$chave</option>";
                                            }
                                            


                                        ?>
                                    </select>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Tamanhos/Quantidade</b>*</label>
                                    <table class="w3-table w3-card" id="tabelaTamanhos" style="width:100%">
                                        <th class="w3-center">Disponível</th>
                                        <th class="w3-center">Tamanho</th>
                                        <th class="w3-center">Quantidade</th>
                                        <?php
                                            // SELECT de todos os tamanhos de camisetas [tamanho]
                                            $queryTamanhos = "SELECT * FROM tamanho";
                                            $resultTamanhos = mysqli_query($conn, $queryTamanhos);
                                            
                                            // Para cada tamanho que no BD [tamanho]
                                            if (mysqli_num_rows($resultTamanhos) > 0) {
                                                while($rowTamanho = mysqli_fetch_assoc($resultTamanhos)) {

                                                    // SELECT dos dados de determinado tamanho da camiseta
                                                    $queryEstoque = "SELECT * FROM estoque WHERE id_camiseta = $idCamiseta AND id_tamanho = ". $rowTamanho["id"];
                                                    $resultEstoque  = mysqli_query($conn, $queryEstoque);
                                                    $rowEstq = mysqli_fetch_assoc($resultEstoque);

                                                    // Se houver estoque para determinado tamanho, marcar checkbox,
                                                    // habilitar campo de qtde, preencher campo de qtde com qtde disponível
                                                    $checked = mysqli_num_rows($resultEstoque) > 0 ? "checked" : "";
                                                    $disabled = mysqli_num_rows($resultEstoque) > 0 ? "" : "disabled";
                                                    $quantidade = isset($rowEstq["quantidade"]) ? $rowEstq["quantidade"] : "";


                                                    echo "
                                                        <tr>
                                                            <td class=\"w3-center\"><input class=\"tamanho\" onclick=\"checkTamanho(this, 'inpt-{$rowTamanho["codigo"]}')\" type=\"checkbox\" name=\"tamanho[]\" id=\"tamanho\" class=\"tamanho\" $checked></td>
                                                            <td class=\"w3-left-align\">{$rowTamanho["codigo"]} - {$rowTamanho["descricao"]}</td>
                                                            <td class=\"w3-center\"><input class=\"quantidade\" id=\"inpt-{$rowTamanho["codigo"]}\" name=\"quantidade_{$rowTamanho["codigo"]}\" type=\"text\" style=\"width:50%; text-align:center\" min=0 step=\"1\" oninput=\"this.value = formatarQuantidade(this.value)\" onblur=\"this.value = formatarQuantidade(this.value)\" value=\"$quantidade\" $disabled required></td>
                                                        </tr>
                                                    ";

                                                }
                                            }
                                        ?>

                                    </table>
                                </p>

                            </td>
                            <td>
                                <p style="text-align:center">
                                    <label class="w3-text-IE">
                                        <b>Imagens do produto:</b>
                                    </label>
                                </p>
                                <p>
                                    <?php
                                        // SELECT de todas as imagens da camiseta
                                        $queryImagens = "SELECT * FROM imagem WHERE id_produto = ".$idCamiseta;
                                        $resultImagensFileInput = mysqli_query($conn, $queryImagens);

                                        // Se não houver nenhuma, é necessário
                                        $required = mysqli_num_rows($resultImagensFileInput) > 0 ? "" : "required";
                                        
                                        echo "<input type=\"file\" id=\"Imagem\" name=\"imagem[]\" accept=\"image/*\" enctype=\"multipart/form-data\" onchange=\"validarImagem(this);\" multiple $required/></label>";


                                        // SELECT dos IDs das imagens cadastradas no bd
                                        $queryIdImagens  = "SELECT id FROM imagem WHERE id_produto = ".$idCamiseta;
                                        $resultIdImagens = mysqli_query($conn, $queryIdImagens);

                                        // Adicionando cada uma das imagens previamente cadastradas no array 'idImagensOriginal' do JS
                                        while($idImagemArray = mysqli_fetch_assoc($resultIdImagens)){
                                            jsScript("idImagensOriginal.push({$idImagemArray["id"]})");
                                        }
                                    
                                    ?>
                                    
                                </p>
                                
                                <table class="w3-table w3-card" style="margin:auto;width:75%;" id="previewTable">
                                    <thead>
                                        <tr><th class="w3-center" colspan="3">Imagens novas</th></tr>
                                        <tr>
                                            <th class="w3-center">Imagem</th>
                                            <th class="w3-center">Tamanho</th>
                                            <th class="w3-center">Extensão</th>
                                            <th class="w3-center">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- As prévias das imagens serão adicionadas dinamicamente aqui -->
                                    </tbody>
                                </table>
                                <br><br>
                                <table class="w3-table w3-stripped w3-card w3-bordered w3-hoverable " style="margin:auto;width:75%;">
                                    <thead>
                                        <tr><th class="w3-center" colspan="2">Imagens já cadastradas</th></tr>
                                        <tr>
                                            <th class="w3-center">Imagem</th>
                                            <th class="w3-center">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                        // SELECT de todas as imagens da camiseta a ser alterada
                                        $resultImagens = mysqli_query($conn, $queryImagens);

                                        // Para cada imagem no BD
                                        if (mysqli_num_rows($resultImagens) > 0) {
                                            while($rowImagens = mysqli_fetch_assoc($resultImagens)) {

                                                // Transformar binário (BLOB) em base64 (imagem exibível)
                                                $base64 = base64_encode($rowImagens["imagem"]);

                                                // Exibir imagem na tabela, bem como o botão de 'EXCLUIR'
                                                echo "
                                                    <tr id=\"tr-".$rowImagens["id"]."\">
                                                        <td class=\"w3-center \" style=\" vertical-align: middle;\">
                                                            <img width=\"90\" height=\"100\" src=\"data:image/png;base64," . $base64 . "\" />
                                                        </td>
                                                        <td class=\"w3-center \" style=\" vertical-align: middle;\">
                                                            <input onclick=\"apagarImagem(".$rowImagens["id"].");\" type=\"button\" class=\"w3-btn w3-theme w3-red\" value=\"Excluir\">
                                                        </td>
                                                    </tr>
                                                ";
                                            }
                                        } else {
                                            echo "<tr><td colspan=2>Nenhuma imagem salva</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                            <p>
                                <input type="button" onclick="confirmarAlteracao();" value="Alterar" class="w3-btn w3-red">
                                <input type="button" value="Cancelar" class="w3-btn w3-theme" onclick="confirmarCancelamento()">
                            </p>
                            </td>
                        </tr>
                    </table>
                    <br>
                </form>
                </form>
            </div>
			</p>
		</div>

	</div>


    <script src="../scripts/vendedor/produto/script_alterProduto.js"></script>
    <script src="../scripts/vendedor/produto/validacoesProduto.js"></script>

</body>

</html>