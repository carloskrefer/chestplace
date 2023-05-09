<?php 
    include("../database/conectaBD.php");
    session_start();
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
                                <input class="w3-input w3-border w3-light-grey" name="nome" type="text" placeholder="Nome" maxlength="255" minlength="2" pattern="[a-zA-zzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]{1,}" required>
                            </td>
                        </div>
                        <div>
                            <td>
                                <input class="w3-input w3-border w3-light-grey" name="nomeEstabelecimento" type="text" maxlength="255" minlength="2" pattern="[a-zA-z ]{1,}" placeholder="Nome do estabelecimento" required>
                            </td>
                        </div>
                        <div>
                            <td>
                                <input class="w3-input w3-border w3-light-grey" name="email" type="text" placeholder="Email"pattern="(^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$)" required>
                            </td>
                        </div>
                        <div>
                            <td>
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
