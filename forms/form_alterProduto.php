<?php
    include("../database/conectaBD.php");
    session_start();

    //Select das camisetas e imagens das camisetas do vendedor passado por _GET
    $queryProdutos = "
    SELECT * 
    FROM camiseta c 
    INNER JOIN imagem i
    ON c.id = i.id_produto
    WHERE c.id = ".$_GET["id"]."
    GROUP BY id;";

    //Resultao do Select
    $result = mysqli_query($conn, $queryProdutos);

        //Percorrendo resultado do select
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $titulo = $row["titulo"];
                $preco = $row["preco"];
                $descricao = $row["descricao"];
                $data_hora_publicacao = $row["data_hora_publicacao"];
                $marca = $row["id_marca"];
            }
        }
?>

<!DOCTYPE html>

<html>

<head>
	<title>Chestplace</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
    <link rel="stylesheet" href="../styles.css">
    <script src="../scripts/formFunctions.js"></script>

</head>

<body onload="w3_show_nav('menuMedico')">
	<!-- Inclui MENU.PHP  -->
    <?php require '../common/header.php'; ?>
    <?php require '../database/conectaBD.php'; ?>

	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Alterar dados do produto</h2>
                </div>
                <form name="frmAlterProduto" class="w3-container" action="" method="post" enctype="multipart/form-data">
                    <table class='w3-table-all'>
                        <tr>
                            <td style="width:50%;">
                                <p>
                                    <input type="hidden" id="Id" name="Id" value="">
                                <p>
                                <label class="w3-text-IE"><b>Título</b>*</label>
                                <?php
                                    echo"<input class=\"w3-input w3-border w3-light-grey\" name=\"titulo\" type=\"text\" value=\"".$titulo."\" required>"
                                ?>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Descrição</b>*</label>
                                    <?php
                                        echo"<textarea class=\"w3-input w3-border w3-light-grey \" name=\"descricao\" id=\"descricao\" cols=\"30\" rows=\"10\" placeholder=\"Insira a descrição do seu produto\" required>".$descricao."</textarea>"
                                    ?>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Preço</b>*</label>
                                    <?php
                                        echo"<input step=\"0.01\" class=\"w3-input w3-border w3-light-grey \" min=\"0\" type=\"number\" name=\"preco\" id=\"preco\" value=\"".$preco."\" required>";
                                    ?>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Data de publicação*</b></label>
                                    <?php
                                        echo"<input class=\"w3-input w3-border w3-light-grey \" name=\"dataPublicacao\" type=\"datetime-local\" placeholder=\"dd/mm/aaaa\" title=\"dd/mm/aaaa\" title=\"Formato: dd/mm/aaaa\" value=\"".$data_hora_publicacao."\">";
                                    ?>
                                    
                                </p>

                                <p><label class="w3-text-IE"><b>Marca</b>*</label>
                                    <select name="marca" id="marca" class="w3-input w3-border w3-light-grey " required>
                                        <?php
                                            //Select das camisetas e imagens das camisetas do vendedor passado por _GET
                                            $queryMarcas = "SELECT * FROM marca";

                                            //Resultao do Select
                                            $result = mysqli_query($conn, $queryMarcas);

                                            //Percorrendo resultado do select
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    if($row["id"] == $marca){
                                                        echo"<option value=".$marca." selected>".$row["nome"]."</option>";
                                                    } else{
                                                        echo"<option value=".$row["id"].">".$row["nome"]."</option>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </p>

                                <p><label class="w3-text-IE"><b>Tamanhos/Quantidade</b>*</label>
                                    <table id="tabelaTamanhos">
                                        <th class="w3-center">Disponível</th>
                                        <th class="w3-center">
                                            Tamanho
                                        </th class="w3-center">
                                        <th class="w3-center">Quantidade</th>
                                        <?php
                                            //Select das camisetas e imagens das camisetas do vendedor passado por _GET
                                            $queryTamanhos = "
                                                SELECT * FROM tamanho";

                                            //Resultao do Select
                                            $result = mysqli_query($conn, $queryTamanhos);

                                            //Percorrendo resultado do select
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    echo "
                                                        <tr>
                                                            <td class=\"w3-center\"     ><input onclick=\"checkTamanho(this,'inpt-".$row["codigo"]."')\" type=\"checkbox\" name=\"disp\" id=\"disp\" checked></td>
                                                            <td class=\"w3-left-align\" >".$row["codigo"]." - ".$row["descricao"]."</td>
                                                            <td class=\"w3-center\"     ><input id=\"inpt-".$row["codigo"]."\" type=\"number\" style=\"width:50%\" min=0 step=\"1\" required></td>
                                                        </tr>
                                                    ";
                                                }
                                            }
                                        ?>

                                    </table>
                                </p>

                            </td>
                            <td>
                            <p style="text-align:center"><label class="w3-text-IE"><b>Imagens do produto: </b></label></p>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="16777215" />
                                    <input type="file" id="Imagem" name="Imagem" accept="imagem/*" onchange="validaImagem(this);" /></label>
                            </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                            <p>
                                <input type="submit" value="Alterar" class="w3-btn w3-red">
                                <?php echo"<input type=\"button\" value=\"Cancelar\" class=\"w3-btn w3-theme\" onclick=\"window.location.href='../page_gerProdutos.php?id=".$_SESSION["idVendedor"]."'\">"?>
                            </p>
                            </td>
                        </tr>
                    </table>
                    <br>
                </form>
			</div>
			</p>
		</div>

	</div>

</body>

</html>