<?php
    session_start();

    include("../database/conectaBD.php");

    //Select das camisetas e imagens das camisetas do vendedor passado por _GET
    $queryProdutos = "
        SELECT nome_estabelecimento, cpf, cnpj
        FROM vendedor
        WHERE id_usuario = ".$_SESSION["idVendedor"].";";

    //Resultao do Select
    $result = mysqli_query($conn, $queryProdutos);

        //Percorrendo resultado do select
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $nomeEstabelecimento = $row["nome_estabelecimento"];
                $cpf = $row["cpf"];
                $cnpj = $row["cnpj"];
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
                    <h2>Alterar dados do vendedor</h2>
                </div>
                <form name="frmAlterVendedor" class="w3-container" action="../actions/alterVendedor_exe.php" method="post" enctype="multipart/form-data">
                    <table class='w3-table-all'>
                        <tr>
                            <td style="width:50%;">
                                <p>
                                    <input type="hidden" id="Id" name="Id" value="">
                                <p>
                                    <label class="w3-text-IE"><b>Nome do estabelecimento</b>*</label>
                                    <?php
                                        echo"<input class=\"w3-input w3-border w3-light-grey\" name=\"nomeEstabelecimento\" type=\"text\" value=\"".$nomeEstabelecimento."\" required>"
                                    ?>
                                </p>

                                <?php
                                    if(is_null($cpf)){
                                        echo"
                                            <p>
                                                <label class=\"w3-text-IE\"><b>CNPJ</b>*</label>
                                                <input class=\"w3-input w3-border w3-light-grey\" name=\"cnpj\" type=\"text\" value=\"".$cnpj."\" required>
                                            </p>
                                            ";
                                        } else {
                                            echo"
                                            <p>
                                                <label class=\"w3-text-IE\"><b>CPF</b>*</label>
                                                <input class=\"w3-input w3-border w3-light-grey\" name=\"cpf\" type=\"text\" value=\"".$cpf."\" required>
                                            </p>
                                            ";
                                    }
                                ?>
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