<!DOCTYPE html>
<?php 
    session_start(); 
    $tipoPagina = "cadastroVendedor";
?>



<html>

<head>
	<title>Chestplace</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
    <link rel="stylesheet" href="../styles.css">
    <script src="../scripts/jQuery/jquery-3.6.4.min.js"></script>
    <script src="../scripts/vendedor/validacoesVendedor.js"></script>
    <script src="../scripts/formats.js"></script>
    <script src="../scripts/vendedor/script_cadVendedor.js"></script>
    <script src="../scripts/viaCep/viaCep.js"></script>


</head>

<body>
	<!-- Inclui MENU.PHP  -->
    <?php include("../database/conectaBD.php"); ?>
    <?php $tipoPagina = "cadastroVendedor"; include('../common/header.php')?>
	
    $queryVendedor = SELECT * FROM vendedor WHERE id = "id.Vendedor";
    cLog($queryVendedor)
    if [NOT] EXISTS SELECT * FROM vendedor WHERE id = "id.Vendedor";
    


    <!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="max-width:1500px; margin:auto;">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Cadastrar vendedor</h2>
                </div>
                <form id="cadVendedorForm"class="w3-container" action="../actions/cadVendedor_exe.php" method="post" enctype="multipart/form-data" onsubmit="">
                    <table class='w3-table-all'>
                        
                        <tr>
                            <td style="width:50%;">
                                <h3 style="text-align:left">Dados</h3>

                                <p>
                                    <label class="w3-text-IE"><b>Nome usuário:</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="nome" name="nome" type="text" title="Nome do estabelecimento. No mínimo dois caracteres e no máximo 255." placeholder="João Doe" required>
                                </p>
                                
                                <p>
                                    <label class="w3-text-IE"><b>Email para login</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="emailLogin" name="emailLogin" type="text" title="Email que será utilizado para realização de login." placeholder="exemplo@dominio.com" required/>
                                </p>

                                <p>
                                    
                                    <label class="w3-text-IE"><b>Mostrar senha</b></label>
                                    <input id="mostrarSenha" name="mostrarSenha" type="checkbox">
                                    <br>
                                    <label class="w3-text-IE"><b>Senha</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="senha" name="senha" type="password" title="Recomenda-se uma senha com no mínimo 8 caracteres, um caractere especial, uma letra maiúscula, uma mínuscula e um número." placeholder="Digite sua senha" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Confirmação de senha</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="confirmacaoSenha" name="confirmacaoSenha" type="password" title="Recomenda-se uma senha com no mínimo 8 caracteres, um caractere especial, uma letra maiúscula, uma mínuscula e um número." placeholder="Confirme a sua senha" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Nome do estabelecimento</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="nomeEstabelecimento" name="nomeEstabelecimento" type="text" title="Nome do estabelecimento. No mínimo dois caracteres e no máximo 255." placeholder="Loja de Exemplo SA." required>
                                </p>
                                <p>
                                <p>
                                    <label class="w3-text-IE"><b>CPF/CNPJ</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="cpfCnpj" name="cpfCnpj" data-pessoafisica="" type="text" oninput="this.value = formatarCPFCNPJ(this.value)" onblur="this.value = formatarCPFCNPJ(this.value)" title="CPF ou CNPJ da sua conta de vendedor." placeholder="XXX.XXX.XXX-XX ou YY.YYY.YYY/YYYY-YY" />
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Email para contato</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="emailContato" name="emailContato" type="text" title="Email pelo qual os clientes poderão entrar em contato com o estabelecimento" placeholder="exemplo@dominio.com" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Telefone para contato</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="telefoneContato" name="telefoneContato" type="text" oninput="this.value = formatarTelefone(this.value);" onblur="this.value = formatarTelefone(this.value);" title="Telefone pelo qual os clientes poderão entrar em contato com o estabelecimento" placeholder="(XX) X XXXX-XXXX"  required>
                                </p>
                            </td>

                            <td>
                                <p style="text-align:center">
                                    <h3>Endereço</h3>
                                </p>
                                <p>
                                    <input class="w3-input w3-border w3-light-grey" type="hidden" id="idEndereco" name="idEndereco" >
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>CEP</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="cep" name="cep" oninput="this.value = formatarCEP(this.value);" onblur="this.value = formatarCEP(this.value);" title="CEP do endereço do estabelecimento" placeholder="XXXXX-XXX" >
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Rua</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="rua" name="rua" title="Rua do endereço do estabelecimento" placeholder="Rua exemplo" >
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Número</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="numero" name="numero" title="Número do endereço do estabelecimento" placeholder="000B">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Bairro</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="bairro" name="bairro" title="Bairro do endereço do estabelecimento" placeholder="Bairro Exemplo">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Complemento</b></label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="complemento" name="complemento" title="Complemento de endereço do estabelecimento" placeholder="Sala 00C" >
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Cidade</b></label>
                                        <input disabled class="w3-input w3-border w3-light-grey" type="text" id="displayCidade" title="Cidade do endereço do estabelecimento" placeholder="Cidade Exemplo" >
                                        <input class="w3-input w3-border w3-light-grey" type="hidden" id="cidade" name="cidade">
                                    </div>
                                </p>
                                <p>
                                <!-- 
                                    Há dois campos de SELECT pois o campo ESTADO é definido pelo CEP, logo não pode ser modificado pelo usuário.
                                    Assim, um dos SELECTS de ESTADO fica DISABLED mas continua sendo exibido para o usuário enquanto o outro
                                    Fica escondido do usuário por CSS mas ainda é passado para o formulário de CADASTRO ou ALTERAÇÃO por POST

                                    Não foi usado o campo INPUT[text] porque a API do viaCEP retorna apenas a UF, não o nome do estado. Então,
                                    para evitar o uso de PHP ou JS para exibir o NOME do estado foi utilizado o campo select.
                                -->
                                    <div>
                                        <label class="w3-text-IE"><b>Estado</b></label>
                                        <select disabled class=" w3-select w3-border w3-round w3-padding" id="displayEstadoSelect" title="Estado do endereço do estabelecimento">
                                            <option value="">Selecione um estado</option>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                            </select>
                                        <select class=" w3-select w3-border w3-round w3-padding" name="estadoSelect" id="estadoSelect">
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                            </select>
                                    </div>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                            <p>
                                <input type="button" id="salvar" value="Salvar" onclick="enviarFormulario();" class="w3-btn w3-red">
                                <input type="button" value="Cancelar" class="w3-btn w3-theme" onclick="window.location.href='../index.php'">
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
