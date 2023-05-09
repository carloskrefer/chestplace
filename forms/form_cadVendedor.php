<?php 
    include("../database/conectaBD.php");
    session_start();

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
            $idEndereco = $row["id_endereco"];
            $cep = $row["cep"];
            $uf = $row["uf"];
            $cidade = $row["cidade"];
            $rua = $row["rua"];
            $numero = $row["numero"];
            $complemento = $row["complemento"];
            $bairro = $row["bairro"];
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

<body>
    <?php require '../common/header.php'; ?>
    <div class="w3-main w3-container">
        <div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
            <p class="w3-large">
                <div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                    <div class="w3-container w3-theme">
                        <h2>Cadastro de Vendedor</h2>
                    </div>
                    <form id="cadForm"class="w3-container" action="../actions/cadVendedor_exe.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario();">
                        <div>
                            <td>
                                <label class="w3-text-IE"><b>Nome</b>*</label>
                                <input class="w3-input w3-border w3-light-grey" name="nome" type="text" placeholder="Nome" maxlength="255" minlength="2" pattern="[a-zA-zzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]{1,}" required>
                            </td>
                        </div>
                        <div>
                            <td>
                                <label class="w3-text-IE"><b>Nome do estabelicimento</b>*</label>
                                <input class="w3-input w3-border w3-light-grey" name="nomeEstabelecimento" type="text" maxlength="255" minlength="2" pattern="[a-zA-z ]{1,}" placeholder="Nome do estabelecimento" required>
                            </td>
                        </div>
                        <div>
                            <td>
                                <label class="w3-text-IE"><b>Email</b>*</label>
                                <input class="w3-input w3-border w3-light-grey" name="email_contato" type="text" placeholder="Email"pattern="(^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$)" required>
                            </td>
                        </div>
                        <div>
                            <td>
                                <label class="w3-text-IE"><b>CNPJ</b>*</label>
                                <input class="w3-input w3-border w3-light-grey" onkeyup="validaCpfCnpj(this);" onblur="validaCpfCnpj(this)" id="cpf" name="cpf" type="text" placeholder="CPF/CNPJ (Apenas números)"pattern="([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})" required>
                                <script>

                                    window.addEventListener("load", function(event) {
                                        let cpf = document.getElementById("cpf");
                                        if(cpf.value == ""){
                                            preco.value = "0";
                                        }
                                        alert("AAAAAAA");
                                        // configurarTamanhoCheckbox();
                                        // configurarDataHoraPubli();
                                    });

                                    function validaCpfCnpj(input){
                                        
                                        alert("AAAAAAAAAAAAAAAA");
                                        // Armazena a posição atual do cursor
                                        input.selectionStart = input.selectionEnd = input.value.length;

                                        // Remove todos os caracteres não numéricos (exceto um ponto ou barra)
                                        input.value = input.value.replace(/[^0-9\.\-]/g, '');

                                        // Formata o valor com duas casas decimais, se possível
                                        var valor = input.value.replace('.', "");

                                        if (valor.length == 11) {

                                            //999.999.999-99

                                            input.value = valor.substr(0, 3) + "." + valor.substr(3, 6) + "." + valor.substr(6, 9) + "-" + valor.substr(9,11);

                                        }if (valor.length == 14) {

                                            //99.999.999/9999-99

                                            input.value = valor.substr(0, 2) + "." + valor.substr(2, 5) + "." + valor.substr(5, 8) + "/" + valor.substr(8,12) + "-" valor.substr(12, 14);

                                        }

                                        // Define a posição do cursor para a posição armazenada
                                        // input.setSelectionRange(cursorPos, cursorPos);

                                    }

                                </script>
                            </td>
                        </div>

                        <!-- <div>
                            <td>
                            <input class="w3-input w3-border w3-light-grey" name="cnpj" type="text" placeholder="CNPJ" required>
                            </td>
                        </div> -->

                        <div>
                            <td>
                                <label class="w3-text-IE"><b>Senha</b>*</label>
                                <input class="w3-input w3-border w3-light-grey" id="senha" name="senha" type="password" placeholder="Senha" pattern="([0-9a-zA-zzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ-Z$*&@#]){8,}" required></div>
                                    <p>
                                        <input type="checkbox" onclick="Mostrar()">Mostrar senha
                                    </p>
                                    <script>
                                        function Mostrar() {
                                            var x = document.getElementById("senha");
                                            if (x.type === "password") {
                                                x.type = "text";
                                            } else {
                                                x.type = "password";
                                            }
                                        }
                                    </script>
                            </td> 
                        </div>
                    <div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                        <div>
                            <td>
                                <p style="text-align:center">
                                    <h3>Endereço</h3>
                                </p>
                                
                                <p>
                                    <input class="w3-input w3-border w3-light-grey" type="hidden" id="idEndereco" name="idEndereco" placeholder="Endereco">
                                </p>

                                <p>
                                    <label class="w3-text-IE"><b>CEP</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="cep" name="cep" oninput="this.value = formatarCEP(this.value);" onblur="this.value = formatarCEP(this.value);" placeholder= "CEP" required>
                                </p>

                                <p>
                                    <label class="w3-text-IE"><b>Rua</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey" type="text" id="rua" name="rua" placeholder="Rua">
                                </p>

                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Número</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="numero" name="numero" placeholder="Número" required>
                                    </div>
                                </p>

                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Bairro</b>*</label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="bairro" name="bairro" placeholder="Bairro" required>
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Complemento</b></label>
                                        <input class="w3-input w3-border w3-light-grey" type="text" id="complemento" name="complemento" placeholder ="Complemento" required>
                                    </div>
                                </p>
                                <p>
                                    <div>
                                        <label class="w3-text-IE"><b>Cidade</b></label>
                                        <input disabled class="w3-input w3-border w3-light-grey" type="text" id="displayCidade" placeholder="Cidade" required>
                                        <input class="w3-input w3-border w3-light-grey" type="hidden" id="cidade" name="cidade" placeholder="Cidade" required>
                                    </div>
                                </p>
                                <p>
                                    <div>

                            </td>
                        </div>

                        <div>
                            <td>
                                <label class="w3-text-IE"><b>Estado</b></label>

                                        <select class=" w3-select w3-border w3-round w3-padding" name="estadoSelect" id="estadoSelect" value="<?= $uf?>">
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
                            </td>
                        </div>
                    </div>

    
                        <p>
                            <input type="submit" value="Cadastrar" class="w3-btn w3-red">
                        </p>
                    </form>
                </div>
            </p>
        </div>
    </div>
</body>
</html>
