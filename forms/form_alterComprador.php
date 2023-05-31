<!DOCTYPE html>
<?php 
    session_start(); 
    require("../database/conectaBD.php");
    $tipoPagina = "cadastroComprador"; // Variável para chamar o header correto no header.php. 
    require('../common/header.php'); // Carrega o header padronizado
    require("../validacaoAcessoComprador.php");  // Verifica se quem acessa é um comprador logado

    $id_usuario = $_SESSION['id_usuario'];

    // Query para buscar todos os dados cadastrados do comprador para popular a página.
    $sql = 
        "SELECT
            u.id as id_usuario,
            nome, 
            email,
            cpf,
            telefone_contato,
            endFat.id           as enderecoFaturamentoID, 
            endFat.cep          as enderecoFaturamentoCEP,
            endFat.rua          as enderecoFaturamentoRUA,
            endFat.numero       as enderecoFaturamentoNUMERO,  
            endFat.complemento  as enderecoFaturamentoCOMPL,
            endFat.bairro       as enderecoFaturamentoBAIRRO,
            endFat.cidade       as enderecoFaturamentoCIDADE,
            endFat.uf           as enderecoFaturamentoUF,
            endEnt.id           as enderecoEntregaID,
            endEnt.cep          as enderecoEntregaCEP,
            endEnt.rua          as enderecoEntregaRUA,
            endEnt.numero       as enderecoEntregaNUMERO,
            endEnt.complemento  as enderecoEntregaCOMPL,
            endEnt.bairro       as enderecoEntregaBAIRRO,
            endEnt.cidade       as enderecoEntregaCIDADE,
            endEnt.uf           as enderecoEntregaUF
        FROM Usuario u, Comprador c, Endereco endFat, Endereco endEnt
        WHERE c.id_usuario = u.id
        AND endFat.id = c.id_endereco_faturamento
        AND endEnt.id = c.id_endereco_entrega
        AND u.id = $id_usuario;"; 
    
    $resultSetTodosDadosComprador = $conn->query($sql);

    // Estas variáveis são usadas para exibir ao usuário os valores
    // cadastrados previamente.
    // Ou seja, as propriedades 'value' das tags <input> receberão esses valores.
    $id_usuario = "";
    $nome = "";
    $email = "";
    $cpf = "";
    $telefone_contato = "";
    $enderecoFaturamentoID = "";
    $enderecoFaturamentoCEP = "";
    $enderecoFaturamentoRUA = "";
    $enderecoFaturamentoNUMERO = "";
    $enderecoFaturamentoCOMPL = "";
    $enderecoFaturamentoBAIRRO = "";
    $enderecoFaturamentoCIDADE = "";
    $enderecoFaturamentoUF = "";
    $enderecoEntregaID = "";
    $enderecoEntregaCEP = "";
    $enderecoEntregaRUA = "";
    $enderecoEntregaNUMERO = "";
    $enderecoEntregaCOMPL = "";
    $enderecoEntregaBAIRRO = "";
    $enderecoEntregaCIDADE = "";
    $enderecoEntregaUF = "";

    // Se o select foi realizado com sucesso, atribuir valores nas variáveis que serão usadas para preencher os campos.
    if (($resultSetTodosDadosComprador != false) and ($resultSetTodosDadosComprador->num_rows == 1)) {
        $row = $resultSetTodosDadosComprador->fetch_assoc();
        $id_usuario                 = $row['id_usuario'];
        $nome                       = $row['nome'];
        $email                      = $row['email'];
        $cpf                        = $row['cpf'];
        $telefone_contato           = $row['telefone_contato'];
        $enderecoFaturamentoID      = $row['enderecoFaturamentoID'];
        $enderecoFaturamentoCEP     = $row['enderecoFaturamentoCEP'];
        $enderecoFaturamentoRUA     = $row['enderecoFaturamentoRUA'];
        $enderecoFaturamentoNUMERO  = $row['enderecoFaturamentoNUMERO'];
        $enderecoFaturamentoCOMPL   = $row['enderecoFaturamentoCOMPL'];
        $enderecoFaturamentoBAIRRO  = $row['enderecoFaturamentoBAIRRO'];
        $enderecoFaturamentoCIDADE  = $row['enderecoFaturamentoCIDADE'];
        $enderecoFaturamentoUF      = $row['enderecoFaturamentoUF'];
        $enderecoEntregaID          = $row['enderecoEntregaID'];

        // Verifica se o endereço de entrega e de faturamento são iguais.
        $isEnderecosIguais = ($enderecoFaturamentoID == $enderecoEntregaID);

        // Se o endereço de entrega foi cadastrado como sendo o mesmo que o endereço
        // de faturamento, deixar o checkbox 'Utilizar endereço de faturamento para entregas' 
        // marcado. Senão, manter desmarcado. 
        // Se o checkbox está marcado, os campos do endereço de entrega deverão estar desmarcados.
        // A variável $atributoHtmlDeMarcacaoCheckbox é usada dentro da tag <input> do checkbox.
        // A variável $atributoHtmlParaDisplayCamposEndereçoEntrega é usada nas tags <td>. 
        if ($isEnderecosIguais) {
            $atributoHtmlDeMarcacaoCheckbox = "checked";
            $atributoHtmlParaDisplayCamposEndereçoEntrega = "style=\"display: none;\""; 
        } else {
            $atributoHtmlDeMarcacaoCheckbox = "";
            $atributoHtmlParaDisplayCamposEndereçoEntrega = ""; 
        }

        // Só preenche os campos do endereço de entrega se os endereços de
        // entrega e faturamento não forem iguais. 
        // Quando são iguais, o checkbox citado acima ficará marcado e o usuário nem verá o endereço
        // de entrega. Se o usuário clicar no checkbox, deverá ver tudo em branco para ele preencher.
        if (!$isEnderecosIguais) {
            $enderecoEntregaCEP     = $row['enderecoEntregaCEP'];
            $enderecoEntregaRUA     = $row['enderecoEntregaRUA'];
            $enderecoEntregaNUMERO  = $row['enderecoEntregaNUMERO'];
            $enderecoEntregaCOMPL   = $row['enderecoEntregaCOMPL'];
            $enderecoEntregaBAIRRO  = $row['enderecoEntregaBAIRRO'];
            $enderecoEntregaCIDADE  = $row['enderecoEntregaCIDADE'];
            $enderecoEntregaUF      = $row['enderecoEntregaUF'];
        }
    }
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
                    <h2>Alterar dados de cadastro</h2>
                </div>
                <form id="alterCompradorForm"class="w3-container" action="../actions/alterComprador_exe.php" method="post">
                    <!-- 
                        Utilizado w3-table, w3-border e w3-bordered ao invés de w3-table-all para que o td (table data)
                        não fique com cor escura (w3-table-all inclui o w3-striped, que deixa escuro as linhas ímpares da tabela). 
                    -->
                    <table class='w3-table w3-border w3-bordered'>          
                        <tr>
                            <td style="width:50%;">
                                <h3 style="text-align:left">Dados</h3>
                                <p>
                                    <label class="w3-text-IE"><b>Nome completo</b></label>
                                    <input class="w3-input w3-border w3-light-grey " value="<?= $nome ?>" id="nome" name="nome" type="text" title="Nome completo para emissão de nota fiscal ou boleto. No mínimo dois caracteres e no máximo 255." placeholder="João Doe">
                                </p>                             
                                <p>
                                    <label class="w3-text-IE"><b>Email</b></label>
                                    <input class="w3-input w3-border w3-light-grey " value="<?= $email ?>"  id="emailLogin" name="emailLogin" type="text" title="Email para login." placeholder="exemplo@dominio.com"/>
                                </p>
                                <p>                                    
                                    <label class="w3-text-IE"><b>Mostrar senha</b></label>
                                    <input id="mostrarSenha" name="mostrarSenha" type="checkbox">
                                    <br>
                                    <label class="w3-text-IE"><b>Criar nova senha</b></label>
                                    <input class="w3-input w3-border w3-light-grey " id="senha" name="senha" type="password" title="Recomenda-se uma senha com no mínimo 8 caracteres, um caractere especial, uma letra maiúscula, uma mínuscula e um número." placeholder="Digite sua nova senha">
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Confirmação da nova senha</b></label>
                                    <input class="w3-input w3-border w3-light-grey " id="confirmacaoSenha" name="confirmacaoSenha" type="password" title="Recomenda-se uma senha com no mínimo 8 caracteres, um caractere especial, uma letra maiúscula, uma mínuscula e um número." placeholder="Confirme a sua nova senha">
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>CPF</b></label> 
                                    <input class="w3-input w3-border w3-light-grey " value="<?= $cpf ?>"  id="cpf" name="cpf" data-pessoafisica="" type="text" oninput="this.value = formatarCPFCNPJ(this.value)" onblur="this.value = formatarCPFCNPJ(this.value)" title="CPF para emissão de nota fiscal ou boleto." placeholder="XXX.XXX.XXX-XX" />
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Telefone para contato</b></label>
                                    <input class="w3-input w3-border w3-light-grey " value="<?= $telefone_contato ?>" id="telefoneContato" name="telefoneContato" type="text" oninput="this.value = formatarTelefone(this.value);" onblur="this.value = formatarTelefone(this.value);" title="Número de telefone ou celular para contato." placeholder="(XX) X XXXX-XXXX" >
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
                                    <label class="w3-text-IE"><b>CEP</b></label>
                                    <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoFaturamentoCEP ?>" type="text" id="cepFaturamento" name="cepFaturamento" oninput="this.value = formatarCEP(this.value);" onblur="this.value = formatarCEP(this.value);" title="CEP do endereço de sua residência." placeholder="XXXXX-XXX" >
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Rua</b></label>
                                    <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoFaturamentoRUA ?>" type="text" id="ruaFaturamento" name="ruaFaturamento" title="Rua do endereço de sua residência." placeholder="Rua exemplo" >
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Número</b></label>
                                        <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoFaturamentoNUMERO ?>" type="text" id="numeroFaturamento" name="numeroFaturamento" title="Número do endereço de sua residência." placeholder="000B">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Bairro</b></label>
                                        <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoFaturamentoBAIRRO ?>" type="text" id="bairroFaturamento" name="bairroFaturamento" title="Bairro do endereço de sua residência." placeholder="Bairro Exemplo">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Complemento</b></label>
                                        <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoFaturamentoCOMPL ?>" type="text" id="complementoFaturamento" name="complementoFaturamento" title="Complemento de endereço de sua residência." placeholder="Sala 00C" >
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Cidade</b></label>
                                        <input disabled class="w3-input w3-border w3-light-grey" value="<?= $enderecoFaturamentoCIDADE ?>" type="text" id="displayCidadeFaturamento" title="Cidade do endereço de sua residência." placeholder="Cidade Exemplo" >
                                        <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoFaturamentoCIDADE ?>" type="hidden" id="cidadeFaturamento" name="cidadeFaturamento">
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
                                        <select disabled class=" w3-select w3-border w3-round w3-padding" id="displayEstadoFaturamentoSelect" title="Estado do endereço de sua residência.">
                                            <option value="">Selecione um estado</option>
                                            <option value="AC" <?php if ($enderecoFaturamentoUF == "AC") {echo "selected";} ?>>Acre</option>
                                            <option value="AL" <?php if ($enderecoFaturamentoUF == "AL") {echo "selected";} ?>>Alagoas</option>
                                            <option value="AP" <?php if ($enderecoFaturamentoUF == "AP") {echo "selected";} ?>>Amapá</option>
                                            <option value="AM" <?php if ($enderecoFaturamentoUF == "AM") {echo "selected";} ?>>Amazonas</option>
                                            <option value="BA" <?php if ($enderecoFaturamentoUF == "BA") {echo "selected";} ?>>Bahia</option>
                                            <option value="CE" <?php if ($enderecoFaturamentoUF == "CE") {echo "selected";} ?>>Ceará</option>
                                            <option value="DF" <?php if ($enderecoFaturamentoUF == "DF") {echo "selected";} ?>>Distrito Federal</option>
                                            <option value="ES" <?php if ($enderecoFaturamentoUF == "ES") {echo "selected";} ?>>Espírito Santo</option>
                                            <option value="GO" <?php if ($enderecoFaturamentoUF == "GO") {echo "selected";} ?>>Goiás</option>
                                            <option value="MA" <?php if ($enderecoFaturamentoUF == "MA") {echo "selected";} ?>>Maranhão</option>
                                            <option value="MT" <?php if ($enderecoFaturamentoUF == "MT") {echo "selected";} ?>>Mato Grosso</option>
                                            <option value="MS" <?php if ($enderecoFaturamentoUF == "MS") {echo "selected";} ?>>Mato Grosso do Sul</option>
                                            <option value="MG" <?php if ($enderecoFaturamentoUF == "MG") {echo "selected";} ?>>Minas Gerais</option>
                                            <option value="PA" <?php if ($enderecoFaturamentoUF == "PA") {echo "selected";} ?>>Pará</option>
                                            <option value="PB" <?php if ($enderecoFaturamentoUF == "PB") {echo "selected";} ?>>Paraíba</option>
                                            <option value="PR" <?php if ($enderecoFaturamentoUF == "PR") {echo "selected";} ?>>Paraná</option>
                                            <option value="PE" <?php if ($enderecoFaturamentoUF == "PE") {echo "selected";} ?>>Pernambuco</option>
                                            <option value="PI" <?php if ($enderecoFaturamentoUF == "PI") {echo "selected";} ?>>Piauí</option>
                                            <option value="RJ" <?php if ($enderecoFaturamentoUF == "RJ") {echo "selected";} ?>>Rio de Janeiro</option>
                                            <option value="RN" <?php if ($enderecoFaturamentoUF == "RN") {echo "selected";} ?>>Rio Grande do Norte</option>
                                            <option value="RS" <?php if ($enderecoFaturamentoUF == "RS") {echo "selected";} ?>>Rio Grande do Sul</option>
                                            <option value="RO" <?php if ($enderecoFaturamentoUF == "RO") {echo "selected";} ?>>Rondônia</option>
                                            <option value="RR" <?php if ($enderecoFaturamentoUF == "RR") {echo "selected";} ?>>Roraima</option>
                                            <option value="SC" <?php if ($enderecoFaturamentoUF == "SC") {echo "selected";} ?>>Santa Catarina</option>
                                            <option value="SP" <?php if ($enderecoFaturamentoUF == "SP") {echo "selected";} ?>>São Paulo</option>
                                            <option value="SE" <?php if ($enderecoFaturamentoUF == "SE") {echo "selected";} ?>>Sergipe</option>
                                            <option value="TO" <?php if ($enderecoFaturamentoUF == "TO") {echo "selected";} ?>>Tocantins</option>
                                        </select>
                                        <select class=" w3-select w3-border w3-round w3-padding" name="estadoFaturamentoSelect" id="estadoFaturamentoSelect">
                                            <option value="AC" <?php if ($enderecoFaturamentoUF == "AC") {echo "selected";} ?>>Acre</option>
                                            <option value="AL" <?php if ($enderecoFaturamentoUF == "AL") {echo "selected";} ?>>Alagoas</option>
                                            <option value="AP" <?php if ($enderecoFaturamentoUF == "AP") {echo "selected";} ?>>Amapá</option>
                                            <option value="AM" <?php if ($enderecoFaturamentoUF == "AM") {echo "selected";} ?>>Amazonas</option>
                                            <option value="BA" <?php if ($enderecoFaturamentoUF == "BA") {echo "selected";} ?>>Bahia</option>
                                            <option value="CE" <?php if ($enderecoFaturamentoUF == "CE") {echo "selected";} ?>>Ceará</option>
                                            <option value="DF" <?php if ($enderecoFaturamentoUF == "DF") {echo "selected";} ?>>Distrito Federal</option>
                                            <option value="ES" <?php if ($enderecoFaturamentoUF == "ES") {echo "selected";} ?>>Espírito Santo</option>
                                            <option value="GO" <?php if ($enderecoFaturamentoUF == "GO") {echo "selected";} ?>>Goiás</option>
                                            <option value="MA" <?php if ($enderecoFaturamentoUF == "MA") {echo "selected";} ?>>Maranhão</option>
                                            <option value="MT" <?php if ($enderecoFaturamentoUF == "MT") {echo "selected";} ?>>Mato Grosso</option>
                                            <option value="MS" <?php if ($enderecoFaturamentoUF == "MS") {echo "selected";} ?>>Mato Grosso do Sul</option>
                                            <option value="MG" <?php if ($enderecoFaturamentoUF == "MG") {echo "selected";} ?>>Minas Gerais</option>
                                            <option value="PA" <?php if ($enderecoFaturamentoUF == "PA") {echo "selected";} ?>>Pará</option>
                                            <option value="PB" <?php if ($enderecoFaturamentoUF == "PB") {echo "selected";} ?>>Paraíba</option>
                                            <option value="PR" <?php if ($enderecoFaturamentoUF == "PR") {echo "selected";} ?>>Paraná</option>
                                            <option value="PE" <?php if ($enderecoFaturamentoUF == "PE") {echo "selected";} ?>>Pernambuco</option>
                                            <option value="PI" <?php if ($enderecoFaturamentoUF == "PI") {echo "selected";} ?>>Piauí</option>
                                            <option value="RJ" <?php if ($enderecoFaturamentoUF == "RJ") {echo "selected";} ?>>Rio de Janeiro</option>
                                            <option value="RN" <?php if ($enderecoFaturamentoUF == "RN") {echo "selected";} ?>>Rio Grande do Norte</option>
                                            <option value="RS" <?php if ($enderecoFaturamentoUF == "RS") {echo "selected";} ?>>Rio Grande do Sul</option>
                                            <option value="RO" <?php if ($enderecoFaturamentoUF == "RO") {echo "selected";} ?>>Rondônia</option>
                                            <option value="RR" <?php if ($enderecoFaturamentoUF == "RR") {echo "selected";} ?>>Roraima</option>
                                            <option value="SC" <?php if ($enderecoFaturamentoUF == "SC") {echo "selected";} ?>>Santa Catarina</option>
                                            <option value="SP" <?php if ($enderecoFaturamentoUF == "SP") {echo "selected";} ?>>São Paulo</option>
                                            <option value="SE" <?php if ($enderecoFaturamentoUF == "SE") {echo "selected";} ?>>Sergipe</option>
                                            <option value="TO" <?php if ($enderecoFaturamentoUF == "TO") {echo "selected";} ?>>Tocantins</option>
                                        </select>
                                    </div>
                                </p>
                                <p>    
                                    <!-- 
                                        Quando esta checkbox estiver marcada irá deixar invisível os campos do endereço de entrega.
                                        Visibilidade controlada pela função mostrarCamposEnderecoEntrega() no 'script_cadComprador.js'.  
                                    -->                                
                                    <label class="w3-text-IE"><b>Utilizar endereço de faturamento para entregas</b></label>
                                    <input id="checkboxEnderecoEntrega" name="checkboxEnderecoEntrega" value="isChecked" type="checkbox" <?= $atributoHtmlDeMarcacaoCheckbox ?>>
                                </p>
                            </td>
                        </tr>
                        <tr>
                        <!-- 
                            A tdVaziaAuxiliar abaixo apenas existe para que a tdEnderecoEntrega inicie a partir da metade
                            da tela, para ficar alinhado com o endereço de faturamento.
                            Visibilidade controlada pela função mostrarCamposEnderecoEntrega() no 'script_cadComprador.js'. 
                            A display já inicia em 'none' se o checkbox checkboxEnderecoEntrega estiver marcado (se os endereços de entrega e faturamento forem iguais).
                        -->
                        <td style="width: 50%;" id="tdVaziaAuxiliar" <?= $atributoHtmlParaDisplayCamposEndereçoEntrega ?>></td>
                        <!--
                            A display já inicia em 'none' se o checkbox checkboxEnderecoEntrega estiver marcado (se os endereços de entrega e faturamento forem iguais).
                            Visibilidade controlada pela função mostrarCamposEnderecoEntrega() no 'script_cadComprador.js'.           
                        -->
                        <td id="tdEnderecoEntrega" <?= $atributoHtmlParaDisplayCamposEndereçoEntrega ?>>
                                <p style="text-align:center">
                                    <h3>Endereço para entrega</h3>
                                </p>
                                <p>
                                    <input class="w3-input w3-border w3-light-grey" type="hidden" id="idEnderecoEntrega" name="idEnderecoEntrega" >
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>CEP</b></label>
                                    <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoEntregaCEP ?>" type="text" id="cepEntrega" name="cepEntrega" oninput="this.value = formatarCEP(this.value);" onblur="this.value = formatarCEP(this.value);" title="CEP do endereço para entrega das compras." placeholder="XXXXX-XXX" >
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Rua</b></label>
                                    <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoEntregaRUA ?>" type="text" id="ruaEntrega" name="ruaEntrega" title="Rua do endereço para entrega das compras." placeholder="Rua exemplo" >
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Número</b></label>
                                        <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoEntregaNUMERO ?>" type="text" id="numeroEntrega" name="numeroEntrega" title="Número do endereço para entrega das compras." placeholder="000B">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Bairro</b></label>
                                        <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoEntregaBAIRRO ?>" type="text" id="bairroEntrega" name="bairroEntrega" title="Bairro do endereço para entrega das compras." placeholder="Bairro Exemplo">
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Complemento</b></label>
                                        <input class="w3-input w3-border w3-light-grey" value="<?= $enderecoEntregaCOMPL ?>" type="text" id="complementoEntrega" name="complementoEntrega" title="Complemento de endereço para entrega das compras." placeholder="Sala 00C" >
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Cidade</b></label>
                                        <input disabled class="w3-input w3-border w3-light-grey" type="text" value="<?= $enderecoEntregaCIDADE ?>" id="displayCidadeEntrega" title="Cidade do endereço para entrega das compras." placeholder="Cidade Exemplo" >
                                        <input class="w3-input w3-border w3-light-grey" type="hidden" value="<?= $enderecoEntregaCIDADE ?>" id="cidadeEntrega" name="cidadeEntrega">
                                    </div>
                                </p>                           
                                <!-- 
                                    Selection box do Estado é duplicado devido a um xunxo necessário que foi explicado no selection box do endereço de faturamento.
                                -->
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Estado</b></label>
                                        <select disabled class=" w3-select w3-border w3-round w3-padding" id="displayEstadoEntregaSelect" title="Estado do endereço para entrega das compras.">
                                            <option value="">Selecione um estado</option>
                                            <option value="AC" <?php if ($enderecoEntregaUF == "AC") {echo "selected";} ?>>Acre</option>
                                            <option value="AL" <?php if ($enderecoEntregaUF == "AL") {echo "selected";} ?>>Alagoas</option>
                                            <option value="AP" <?php if ($enderecoEntregaUF == "AP") {echo "selected";} ?>>Amapá</option>
                                            <option value="AM" <?php if ($enderecoEntregaUF == "AM") {echo "selected";} ?>>Amazonas</option>
                                            <option value="BA" <?php if ($enderecoEntregaUF == "BA") {echo "selected";} ?>>Bahia</option>
                                            <option value="CE" <?php if ($enderecoEntregaUF == "CE") {echo "selected";} ?>>Ceará</option>
                                            <option value="DF" <?php if ($enderecoEntregaUF == "DF") {echo "selected";} ?>>Distrito Federal</option>
                                            <option value="ES" <?php if ($enderecoEntregaUF == "ES") {echo "selected";} ?>>Espírito Santo</option>
                                            <option value="GO" <?php if ($enderecoEntregaUF == "GO") {echo "selected";} ?>>Goiás</option>
                                            <option value="MA" <?php if ($enderecoEntregaUF == "MA") {echo "selected";} ?>>Maranhão</option>
                                            <option value="MT" <?php if ($enderecoEntregaUF == "MT") {echo "selected";} ?>>Mato Grosso</option>
                                            <option value="MS" <?php if ($enderecoEntregaUF == "MS") {echo "selected";} ?>>Mato Grosso do Sul</option>
                                            <option value="MG" <?php if ($enderecoEntregaUF == "MG") {echo "selected";} ?>>Minas Gerais</option>
                                            <option value="PA" <?php if ($enderecoEntregaUF == "PA") {echo "selected";} ?>>Pará</option>
                                            <option value="PB" <?php if ($enderecoEntregaUF == "PB") {echo "selected";} ?>>Paraíba</option>
                                            <option value="PR" <?php if ($enderecoEntregaUF == "PR") {echo "selected";} ?>>Paraná</option>
                                            <option value="PE" <?php if ($enderecoEntregaUF == "PE") {echo "selected";} ?>>Pernambuco</option>
                                            <option value="PI" <?php if ($enderecoEntregaUF == "PI") {echo "selected";} ?>>Piauí</option>
                                            <option value="RJ" <?php if ($enderecoEntregaUF == "RJ") {echo "selected";} ?>>Rio de Janeiro</option>
                                            <option value="RN" <?php if ($enderecoEntregaUF == "RN") {echo "selected";} ?>>Rio Grande do Norte</option>
                                            <option value="RS" <?php if ($enderecoEntregaUF == "RS") {echo "selected";} ?>>Rio Grande do Sul</option>
                                            <option value="RO" <?php if ($enderecoEntregaUF == "RO") {echo "selected";} ?>>Rondônia</option>
                                            <option value="RR" <?php if ($enderecoEntregaUF == "RR") {echo "selected";} ?>>Roraima</option>
                                            <option value="SC" <?php if ($enderecoEntregaUF == "SC") {echo "selected";} ?>>Santa Catarina</option>
                                            <option value="SP" <?php if ($enderecoEntregaUF == "SP") {echo "selected";} ?>>São Paulo</option>
                                            <option value="SE" <?php if ($enderecoEntregaUF == "SE") {echo "selected";} ?>>Sergipe</option>
                                            <option value="TO" <?php if ($enderecoEntregaUF == "TO") {echo "selected";} ?>>Tocantins</option>
                                        </select>
                                        <select class=" w3-select w3-border w3-round w3-padding" name="estadoEntregaSelect" id="estadoEntregaSelect">
                                            <option value="AC" <?php if ($enderecoEntregaUF == "AC") {echo "selected";} ?>>Acre</option>
                                            <option value="AL" <?php if ($enderecoEntregaUF == "AL") {echo "selected";} ?>>Alagoas</option>
                                            <option value="AP" <?php if ($enderecoEntregaUF == "AP") {echo "selected";} ?>>Amapá</option>
                                            <option value="AM" <?php if ($enderecoEntregaUF == "AM") {echo "selected";} ?>>Amazonas</option>
                                            <option value="BA" <?php if ($enderecoEntregaUF == "BA") {echo "selected";} ?>>Bahia</option>
                                            <option value="CE" <?php if ($enderecoEntregaUF == "CE") {echo "selected";} ?>>Ceará</option>
                                            <option value="DF" <?php if ($enderecoEntregaUF == "DF") {echo "selected";} ?>>Distrito Federal</option>
                                            <option value="ES" <?php if ($enderecoEntregaUF == "ES") {echo "selected";} ?>>Espírito Santo</option>
                                            <option value="GO" <?php if ($enderecoEntregaUF == "GO") {echo "selected";} ?>>Goiás</option>
                                            <option value="MA" <?php if ($enderecoEntregaUF == "MA") {echo "selected";} ?>>Maranhão</option>
                                            <option value="MT" <?php if ($enderecoEntregaUF == "MT") {echo "selected";} ?>>Mato Grosso</option>
                                            <option value="MS" <?php if ($enderecoEntregaUF == "MS") {echo "selected";} ?>>Mato Grosso do Sul</option>
                                            <option value="MG" <?php if ($enderecoEntregaUF == "MG") {echo "selected";} ?>>Minas Gerais</option>
                                            <option value="PA" <?php if ($enderecoEntregaUF == "PA") {echo "selected";} ?>>Pará</option>
                                            <option value="PB" <?php if ($enderecoEntregaUF == "PB") {echo "selected";} ?>>Paraíba</option>
                                            <option value="PR" <?php if ($enderecoEntregaUF == "PR") {echo "selected";} ?>>Paraná</option>
                                            <option value="PE" <?php if ($enderecoEntregaUF == "PE") {echo "selected";} ?>>Pernambuco</option>
                                            <option value="PI" <?php if ($enderecoEntregaUF == "PI") {echo "selected";} ?>>Piauí</option>
                                            <option value="RJ" <?php if ($enderecoEntregaUF == "RJ") {echo "selected";} ?>>Rio de Janeiro</option>
                                            <option value="RN" <?php if ($enderecoEntregaUF == "RN") {echo "selected";} ?>>Rio Grande do Norte</option>
                                            <option value="RS" <?php if ($enderecoEntregaUF == "RS") {echo "selected";} ?>>Rio Grande do Sul</option>
                                            <option value="RO" <?php if ($enderecoEntregaUF == "RO") {echo "selected";} ?>>Rondônia</option>
                                            <option value="RR" <?php if ($enderecoEntregaUF == "RR") {echo "selected";} ?>>Roraima</option>
                                            <option value="SC" <?php if ($enderecoEntregaUF == "SC") {echo "selected";} ?>>Santa Catarina</option>
                                            <option value="SP" <?php if ($enderecoEntregaUF == "SP") {echo "selected";} ?>>São Paulo</option>
                                            <option value="SE" <?php if ($enderecoEntregaUF == "SE") {echo "selected";} ?>>Sergipe</option>
                                            <option value="TO" <?php if ($enderecoEntregaUF == "TO") {echo "selected";} ?>>Tocantins</option>
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