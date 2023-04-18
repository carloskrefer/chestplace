<!DOCTYPE html>
<!-------------------------------------------------------------------------------
    Desenvolvimento Web
    PUCPR
    Profa. Cristina V. P. B. Souza
    Agosto/2022
---------------------------------------------------------------------------------->
<!-- MedAtualizar.php -->

<html>

<head>
	<title>Clínica Médica ABC</title>
	<link rel="icon" type="image/png" href="imagens/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">

</head>

<body onload="w3_show_nav('menuMedico')">
	<!-- Inclui MENU.PHP  -->
    <?php require '../common/header.php'; ?>
    <?php require '../database/conectaBD.php'; ?>

	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container" style="">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Alterar dados do produto</h2>
                </div>
                <form class="w3-container" action="cadProduto_exe.php" method="post" enctype="multipart/form-data">
                    <table class='w3-table-all'>
                        <tr>
                            <td style="width:50%;">
                                <p>
                                    <input type="hidden" id="Id" name="Id" value="">
                                <p>
                                <label class="w3-text-IE"><b>Título</b>*</label>
                                <input class="w3-input w3-border w3-light-grey " name="titulo" type="text" pattern="[a-zA-Z\u00C0-\u00FF ]{10,100}$" title="Nome entre 10 e 100 letras." value="" required>
                                </p>
                                <p>
                                <label class="w3-text-IE"><b>Descrição</b>*</label>
                                <textarea class="w3-input w3-border w3-light-grey " name="descricao" id="descricao" cols="30" rows="10" placeholder="Insira a descrição do seu produto" required></textarea>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Preço</b>*</label>
                                    <input step="0.01" class="w3-input w3-border w3-light-grey " min="0" type="number" name="preco" id="preco" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Data de publicação</b></label>
                                    <input class="w3-input w3-border w3-light-grey " name="dataPublicacao" type="datetime-local" placeholder="dd/mm/aaaa" title="dd/mm/aaaa" title="Formato: dd/mm/aaaa" value="">
                                </p>

                                <p><label class="w3-text-IE"><b>Marca</b>*</label>
                                    <select name="marca" id="marca" class="w3-input w3-border w3-light-grey " required>
                                    </select>
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
                                <input type="button" value="Cancelar" class="w3-btn w3-theme" onclick="window.location.href='medListar.php'">
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