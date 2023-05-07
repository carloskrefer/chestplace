<!DOCTYPE html>
<?php
    session_start();

    include("../database/conectaBD.php");

    //Select das camisetas e imagens das camisetas do vendedor passado por _GET
    $queryProdutos = "
        SELECT *
        FROM vendedor
        INNER JOIN endereco
        ON vendedor.id_endereco = endereco.id
        WHERE id_usuario = ".$_SESSION["idVendedor"].";";

    //Resultao do Select
    $result = mysqli_query($conn, $queryProdutos);

        //Percorrendo resultado do select
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $nomeEstabelecimento = $row["nome_estabelecimento"];
                $cpf = $row["cpf"];
                $cnpj = $row["cnpj"];
                $emailContato = $row["email_contato"];
                $telefoneContato = $row["telefone_contato"];
                $cep = $row["cep"];
                $uf = $row["uf"];
                $cidade = $row["cidade"];
                $rua = $row["rua"];
                $numero = $row["numero"];
                $complemento = $row["complemento"];
                $bairro = $row["bairro"];
            }   
        }
?>



<html>

<head>
	<title>Chestplace</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
    <link rel="stylesheet" href="../styles.css">
    <script src="../scripts/jQuery/jquery-3.6.4.min.js"></script>
    <script src="../scripts/formFunctions.js"></script>
    <script src="../scripts/validacoes.js"></script>
    <script src="../scripts/script_alterVendedor.js"></script>
    <script src="../scripts/viaCep/viaCep.js"></script>


</head>

<body>
	<!-- Inclui MENU.PHP  -->
    <?php require '../common/header.php'; ?>
    <?php require '../database/conectaBD.php'; ?>
    <?php echo "<script>let cep = ".$cep."</script>"?>


        	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="max-width:1500px; margin:auto;">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Alterar conta</h2>
                </div>
                <form id="altVendedorForm"class="w3-container" action="../actions/cadProduto_exe.php" method="post" enctype="multipart/form-data" onsubmit="">
                    <table class='w3-table-all'>
                        
                        <tr>
                            <td style="width:50%;">
                                <p style="text-align:center">
                                    <h3>Dados</h3>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Nome do estabelecimento</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="nomeEstabelecimento" name="nomeEstabelecimento" type="text" title="Nome entre 10 e 100 letras." value="<?= $nomeEstabelecimento?>" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>CPF/CNPJ</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="cpfCnpj" name="cpfCnpj" type="text" oninput="<?= isset($cpf)? 'this.value = formatarCPF(this.value)': 'this.value = formatarCNPJ(this.value)'?>" value="<?= isset($cpf)? $cpf : $cnpj?>" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Email para contato</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="emailContato" name="emailContato" type="text" value="<?= $emailContato?>" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Telefone para contato</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="telefoneContato" name="telefoneContato" type="text" oninput="this.value = formatarCNPJ(this.value);" value="<?= $telefoneContato?>" required>
                                </p>
                            </td>

                            <td>
                                <p style="text-align:center">
                                    <h3>Endereço</h3>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>CEP</b></label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="cep" name="cep" value="<?= $cep?>">
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Rua</b></label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="rua" name="rua"" value="<?= $rua?>">
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Número</b></label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="numero" name="numero" value="<?= $numero?>">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Bairro</b></label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="bairro" name="bairro" value="<?= $bairro?>">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Complemento</b></label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="complemento" name="complemento" value="<?= $complemento?>">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Cidade</b></label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="cidade" name="cidade" value="<?= $cidade?>" disabled>
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Estado</b></label>
                                        <select class=" w3-select w3-border w3-round w3-padding" name="estadoSelect" id="estadoSelect" value="<?= $uf?>" disabled>
                                            <option value="">Selecione um estado</option>
                                            <option value="AC" <?= $uf === 'AC' ? 'selected' : '' ?>>Acre</option>
                                            <option value="AL" <?= $uf === 'AL' ? 'selected' : '' ?>>Alagoas</option>
                                            <option value="AP" <?= $uf === 'AP' ? 'selected' : '' ?>>Amapá</option>
                                            <option value="AM" <?= $uf === 'AM' ? 'selected' : '' ?>>Amazonas</option>
                                            <option value="BA" <?= $uf === 'BA' ? 'selected' : '' ?>>Bahia</option>
                                            <option value="CE" <?= $uf === 'CE' ? 'selected' : '' ?>>Ceará</option>
                                            <option value="DF" <?= $uf === 'DF' ? 'selected' : '' ?>>Distrito Federal</option>
                                            <option value="ES" <?= $uf === 'ES' ? 'selected' : '' ?>>Espírito Santo</option>
                                            <option value="GO" <?= $uf === 'GO' ? 'selected' : '' ?>>Goiás</option>
                                            <option value="MA" <?= $uf === 'MA' ? 'selected' : '' ?>>Maranhão</option>
                                            <option value="MT" <?= $uf === 'MT' ? 'selected' : '' ?>>Mato Grosso</option>
                                            <option value="MS" <?= $uf === 'MS' ? 'selected' : '' ?>>Mato Grosso do Sul</option>
                                            <option value="MG" <?= $uf === 'MG' ? 'selected' : '' ?>>Minas Gerais</option>
                                            <option value="PA" <?= $uf === 'PA' ? 'selected' : '' ?>>Pará</option>
                                            <option value="PB" <?= $uf === 'PB' ? 'selected' : '' ?>>Paraíba</option>
                                            <option value="PR" <?= $uf === 'PR' ? 'selected' : '' ?>>Paraná</option>
                                            <option value="PE" <?= $uf === 'PE' ? 'selected' : '' ?>>Pernambuco</option>
                                            <option value="PI" <?= $uf === 'PI' ? 'selected' : '' ?>>Piauí</option>
                                            <option value="RJ" <?= $uf === 'RJ' ? 'selected' : '' ?>>Rio de Janeiro</option>
                                            <option value="RN" <?= $uf === 'RN' ? 'selected' : '' ?>>Rio Grande do Norte</option>
                                            <option value="RS" <?= $uf === 'RS' ? 'selected' : '' ?>>Rio Grande do Sul</option>
                                            <option value="RO" <?= $uf === 'RO' ? 'selected' : '' ?>>Rondônia</option>
                                            <option value="RR" <?= $uf === 'RR' ? 'selected' : '' ?>>Roraima</option>
                                            <option value="SC" <?= $uf === 'SC' ? 'selected' : '' ?>>Santa Catarina</option>
                                            <option value="SP" <?= $uf === 'SP' ? 'selected' : '' ?>>São Paulo</option>
                                            <option value="SE" <?= $uf === 'SE' ? 'selected' : '' ?>>Sergipe</option>
                                            <option value="TO" <?= $uf === 'TO' ? 'selected' : '' ?>>Tocantins</option>
                                            </select>
                                    </div>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                            <p>
                                <input type="button" value="Salvar" onclick="validarFormulario();" class="w3-btn w3-red">
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

	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível
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
                                        //echo"<input class=\"w3-input w3-border w3-light-grey\" name=\"nomeEstabelecimento\" type=\"text\" value=\"".$nomeEstabelecimento."\" required>"
                                    ?>
                                </p>

                                <?php
                                    // if(is_null($cpf)){
                                    //     echo"
                                    //         <p>
                                    //             <label class=\"w3-text-IE\"><b>CNPJ</b>*</label>
                                    //             <input class=\"w3-input w3-border w3-light-grey\" name=\"cnpj\" type=\"text\" value=\"".$cnpj."\" required>
                                    //         </p>
                                    //         ";
                                    //     } else {
                                    //         echo"
                                    //         <p>
                                    //             <label class=\"w3-text-IE\"><b>CPF</b>*</label>
                                    //             <input class=\"w3-input w3-border w3-light-grey\" name=\"cpf\" type=\"text\" value=\"".$cpf."\" required>
                                    //         </p>
                                    //         ";
                                    // }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                            <p>
                                <input type="submit" value="Alterar" class="w3-btn w3-red">
                                <?php //echo"<input type=\"button\" value=\"Cancelar\" class=\"w3-btn w3-theme\" onclick=\"window.location.href='../page_gerProdutos.php?id=".$_SESSION["idVendedor"]."'\">"?>
                            </p>
                            </td>
                        </tr>
                    </table>
                    <br>
                </form>
			</div>
			</p>
		</div>

	</div> -->

</body>

</html>