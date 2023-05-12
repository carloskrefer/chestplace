<?php session_start(); $tipoPagina = "cadastroProduto"?>



<!DOCTYPE html>

<html>

<head>
	<title>Chestplace</title>
	<link rel="icon" type="image/png" href="imagens/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
    <script src="../scripts/jQuery/jquery-3.6.4.min.js"></script>
    <script src="../scripts/vendedor/produto/checkboxConfig.js"></script>
    <script src="../scripts/formats.js"></script>
    <script src="../scripts/vendedor/produto/validacoesProduto.js"></script>

</head>

<body >
	<!-- Inclusões necessárias  -->
    <?php require '../database/conectaBD.php'; ?>
    <?php require "../common/header.php"; ?>
    <?php require "../common/modalConfirmacao.php"; ?>

	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="max-width:1500px; margin:auto;">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Cadastrar produto</h2>
                </div>
                <form id="cadForm"class="w3-container" action="../actions/cadProduto_exe.php" method="post" enctype="multipart/form-data" onsubmit="">
                    <table class='w3-table-all'>
                        <tr>
                            <td style="width:50%;">
                                <p>
                                    <label class="w3-text-IE"><b>Título</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="titulo" name="titulo" type="text" title="Nome entre 10 e 100 letras." value="" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Descrição</b>*</label>
                                    <textarea class="w3-input w3-border w3-light-grey " name="descricao" id="descricao" cols="30" rows="10" placeholder="Insira a descrição do seu produto" required></textarea>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Preço</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " oninput="configurarPreco(this)" onkeyup="configurarPreco(this);" onblur="configurarPreco(this)" type="text" name="preco" id="preco" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Data de publicação*</b></label>
                                    <input class="w3-input w3-border w3-light-grey " id="dataPublicacao" name="dataPublicacao" type="datetime-local" title="dd/mm/aaaa hh:mm" title="Formato: dd/mm/aaaa" value="" max="9999-12-12T23:59:59" required>
                                </p>

                                <p>
                                    <label class="w3-text-IE"><b>Marca</b>*</label>
                                    <select name="marca" id="marca" class="w3-input w3-border w3-light-grey " required>
                                        <option value=""  disabled hidden selected>Escolha a marca</option>
                                        
                                        <!-- 
                                            PONTO PARA REVISÃO

                                            CONTINUAR COMO SELECT BOX OU MUDAR PARA INPUT TEXT?
                                         -->
                                        
                                        
                                        <?php

                                            // Resultao do SELECT de todas as marcas
                                            $marcas = mysqli_query($conn, "SELECT * FROM marca");

                                            // Inserindo cada uma das marcas no <select></select>
                                            if (mysqli_num_rows($marcas) > 0) {
                                                while($marca = mysqli_fetch_assoc($marcas)) {
                                                    echo"<option value=".$marca["id"].">".$marca["nome"]."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </p>

                                <p>
                                    <label class="w3-text-IE"><b>Estado de conservação</b>*</label>
                                    <select name="conservacao" id="conservacao" class="w3-input w3-border w3-light-grey " required>
                                        <option value=""  disabled hidden selected>Escolha o estado de conservação</option>
                                        <option value="nova">Nova</option>
                                        <option value="seminova">Seminova</option>
                                        <option value="usada">Usada</option>
                                        <option value="desgastada">Desgastada</option>
                                        <option value="muito desgastada">Muito desgastada</option>
                                    </select>
                                </p>

                                <p>
                                    <label class="w3-text-IE"><b>Tamanhos/Quantidade</b>*</label>
                                    <table class="w3-table w3-card" id="tabelaTamanhos" style="width:100%">
                                        <th class="w3-center">Disponível</th>
                                        <th class="w3-center">Tamanho</th>
                                        <th class="w3-center">Quantidade</th>
                                        <?php
                                            // SELECT de todos os tamanhos
                                            $result = mysqli_query($conn, "SELECT * FROM tamanho");
    
                                            // Inserindo table row com opcões de tamanho (checkbox, descricao, quantidade)
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    echo "
                                                        <tr>
                                                            <td class=\"w3-center\"     ><input onclick=\"checkTamanho(this,'quantidade_".$row["codigo"]."')\" type=\"checkbox\" name=\"tamanho[]\" value=\"".$row["codigo"]."\" class=\"tamanho\"></td>
                                                            <td class=\"w3-left-align\" >".$row["codigo"]." - ".$row["descricao"]."</td>
                                                            <td class=\"w3-center\"     ><input name=\"quantidade_".$row["codigo"]."\" id=\"quantidade_".$row["codigo"]."\" type=\"text\" style=\"width:50%; text-align:center\" min=\"0\" pattern\"\d+\" onkeyup=\"this.value = formatarQuantidade(this.value)\" onblur=\"this.value = formatarQuantidade(this.value)\" class=\"quantidade\" required></td>
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
                                    <input type="file" id="Imagem" name="imagem[]" accept="image/*" enctype="multipart/form-data" onchange="validarImagem(this);" class="clickable" multiple required/></label>
                                </p>
                                
                                <table class="w3-table " style="margin:auto;width:75%;" id="previewTable">
                                    <thead>
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
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                            <p>
                                <input type="button" value="Salvar" onclick="validarFormulario();" class="w3-btn w3-red">
                                <input type="button" value="Cancelar" class="w3-btn w3-theme" onclick="confirmarCancelamento()">
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
    
    <script src="../scripts/vendedor/produto/script_cadProduto.js"></script>


</body>

</html>