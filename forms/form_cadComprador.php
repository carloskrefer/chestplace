<!DOCTYPE html>
<?php 
    session_start(); 
    require("../database/conectaBD.php");
    $tipoPagina = "cadastroComprador"; // Variável para chamar o header correto no header.php. 
    require('../common/header.php'); 
?>
<html>
<head>
	<title>Chestplace</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="../styles.css">
    <script src="../scripts/jQuery/jquery-3.6.4.min.js"></script>
    <script src="../scripts/comprador/validacoesComprador.js"></script>
    <script src="../scripts/formats.js"></script>
    <script src="../scripts/comprador/script_cadComprador.js"></script>

</head>

<body>	
	<div class="w3-main w3-container">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="max-width:1500px; margin:auto;">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Cadastrar comprador</h2>
                </div>
                <form id="cadCompradorForm"class="w3-container" action="../actions/cadComprador_exe.php" method="post">
                    <!-- 
                        Utilizado w3-table, w3-border e w3-bordered ao invés de w3-table-all para que o td (table data)
                        não fique com cor escura (w3-table-all inclui o w3-striped, que deixa escuro as linhas ímpares da tabela). 
                    -->
                    <table class='w3-table w3-border w3-bordered'>          
                        <tr>
                            <td style="width:50%;">
                                <h3 style="text-align:left">Dados</h3>
                                <p>
                                    <label class="w3-text-IE"><b>Nome completo</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="nome" name="nome" type="text" title="Nome do usuário para emissão de nota fiscal e/ou boleto. No mínimo dois caracteres e no máximo 255." placeholder="João Doe" required>
                                </p>                             
                                <p>
                                    <label class="w3-text-IE"><b>Email</b>*</label>
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
                                <!-- removi name e id=nomeEstabelecimento, ver nos arquivos no que preciso excluir -->
                                <!-- name e id=cpfCnpj mudei para id=cpf, ver nos arquivos o que eu preciso mudar (buscar por cpfCnpj) -->
                                <p>
                                    <label class="w3-text-IE"><b>CPF</b>*</label> 
                                    <input class="w3-input w3-border w3-light-grey " id="cpf" name="cpf" data-pessoafisica="" type="text" oninput="this.value = formatarCPFCNPJ(this.value)" onblur="this.value = formatarCPFCNPJ(this.value)" title="CPF da sua conta de comprador." placeholder="XXX.XXX.XXX-XX" />
                                </p>
                                <!-- removi name e id=nomeEstabelecimento, ver nos arquivos no que preciso excluir -->
                                <!-- removi name e id=emailContato, ver nos arquivos no que preciso excluir -->
                                <p>
                                    <label class="w3-text-IE"><b>Telefone para contato</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="telefoneContato" name="telefoneContato" type="text" oninput="this.value = formatarTelefone(this.value);" onblur="this.value = formatarTelefone(this.value);" title="Telefone pelo qual os clientes poderão entrar em contato com o estabelecimento" placeholder="(XX) X XXXX-XXXX"  required>
                                </p>
                            </td>
                            <td>
                                <p style="text-align:center">
                                    <h3>Endereço para faturamento</h3>
                                </p>
                                <p>
                                    <input class="w3-input w3-border w3-light-grey" type="hidden" id="idEnderecoFaturamento" name="idEnderecoFaturamento" >
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>CEP</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="cepFaturamento" name="cepFaturamento" oninput="this.value = formatarCEP(this.value);" onblur="this.value = formatarCEP(this.value);" title="CEP do endereço do estabelecimento" placeholder="XXXXX-XXX" >
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Rua</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="ruaFaturamento" name="ruaFaturamento" title="Rua do endereço do estabelecimento" placeholder="Rua exemplo" >
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Número</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="numeroFaturamento" name="numeroFaturamento" title="Número do endereço do estabelecimento" placeholder="000B">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Bairro</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="bairroFaturamento" name="bairroFaturamento" title="Bairro do endereço do estabelecimento" placeholder="Bairro Exemplo">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Complemento</b></label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="complementoFaturamento" name="complementoFaturamento" title="Complemento de endereço do estabelecimento" placeholder="Sala 00C" >
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Cidade</b></label>
                                        <input disabled class="w3-input w3-border w3-light-grey" type="text" id="displayCidadeFaturamento" title="Cidade do endereço do estabelecimento" placeholder="Cidade Exemplo" >
                                        <input class="w3-input w3-border w3-light-grey" type="hidden" id="cidadeFaturamento" name="cidadeFaturamento">
                                    </div>
                                </p>                           
                                <!-- 
                                    Foi necessário fazer um xunxo e duplicar a caixa de seleção de Estado pois
                                    campos desabilitados não são enviados no post do formulário. Então, o Estado desabilitado
                                    serve apenas para visualização, enquanto que o segundo Estado (invisível) será enviado pelo post.
                                -->
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Estado</b></label>
                                        <select disabled class=" w3-select w3-border w3-round w3-padding" id="displayEstadoFaturamentoSelect" title="Estado do endereço para faturamento">
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
                                        <select class=" w3-select w3-border w3-round w3-padding" name="estadoFaturamentoSelect" id="estadoFaturamentoSelect">
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
                                <p>    
                                    <!-- 
                                        Quando esta checkbox estiver marcada irá deixar invisível os campos do endereço de entrega.
                                        Visibilidade controlada pela função mostrarCamposEnderecoEntrega() no 'script_cadComprador.js'.  
                                    -->                                
                                    <label class="w3-text-IE"><b>Utilizar endereço de faturamento para entregas</b></label>
                                    <input id="checkboxEnderecoEntrega" name="checkboxEnderecoEntrega" value="isChecked" type="checkbox" checked>
                                </p>
                            </td>
                        </tr>
                        <tr>
                        <!-- 
                            A tdVaziaAuxiliar abaixo apenas existe para que a tdEnderecoEntrega inicie a partir da metade
                            da tela, para ficar alinhado com o endereço de faturamento.
                            Visibilidade controlada pela função mostrarCamposEnderecoEntrega() no 'script_cadComprador.js'. 
                            Inicialmente display é 'none' pois porque o checkbox checkboxEnderecoEntrega por padrão está marcado.
                        -->
                        <td style="width: 50%;" id="tdVaziaAuxiliar" style="display: none;"></td>
                        <!--
                            O endereço de entrega fica invisível se o checkboxEnderecoEntrega for marcado. 
                            Visibilidade controlada pela função mostrarCamposEnderecoEntrega() no 'script_cadComprador.js'. 
                            Inicialmente display é 'none' pois porque o checkbox checkboxEnderecoEntrega por padrão está marcado.
                        -->
                        <td id="tdEnderecoEntrega" style="display: none;">
                                <p style="text-align:center">
                                    <h3>Endereço para entrega</h3>
                                </p>
                                <p>
                                    <input class="w3-input w3-border w3-light-grey" type="hidden" id="idEnderecoEntrega" name="idEnderecoEntrega" >
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>CEP</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="cepEntrega" name="cepEntrega" oninput="this.value = formatarCEP(this.value);" onblur="this.value = formatarCEP(this.value);" title="CEP do endereço do estabelecimento" placeholder="XXXXX-XXX" >
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Rua</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="ruaEntrega" name="ruaEntrega" title="Rua do endereço do estabelecimento" placeholder="Rua exemplo" >
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Número</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="numeroEntrega" name="numeroEntrega" title="Número do endereço do estabelecimento" placeholder="000B">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Bairro</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="bairroEntrega" name="bairroEntrega" title="Bairro do endereço do estabelecimento" placeholder="Bairro Exemplo">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Complemento</b></label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="complementoEntrega" name="complementoEntrega" title="Complemento de endereço do estabelecimento" placeholder="Sala 00C" >
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Cidade</b></label>
                                        <input disabled class="w3-input w3-border w3-light-grey" type="text" id="displayCidadeEntrega" title="Cidade do endereço do estabelecimento" placeholder="Cidade Exemplo" >
                                        <input class="w3-input w3-border w3-light-grey" type="hidden" id="cidadeEntrega" name="cidadeEntrega">
                                    </div>
                                </p>                           
                                <!-- 
                                    Selection box do Estado é duplicado devido a um xunxo necessário que foi explicado no selection box do endereço de faturamento.
                                -->
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Estado</b></label>
                                        <select disabled class=" w3-select w3-border w3-round w3-padding" id="displayEstadoEntregaSelect" title="Estado do endereço de entrega">
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
                                        <select class=" w3-select w3-border w3-round w3-padding" name="estadoEntregaSelect" id="estadoEntregaSelect">
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
                                <!-- 
                                    A função enviarFormulario() [script_cadComprador.js]
                                    chamará a função validarFormulario() [validacoesComprador.js] para validar o formulário antes
                                    de enviá-lo pelo POST.
                                -->
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