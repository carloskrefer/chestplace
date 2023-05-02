<?php 
    include("./database/conectaBD.php");
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
    <?php require './common/header.php'; ?>
    <div class="w3-main w3-container">
        <div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
            <p class="w3-large">
                <div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                    <div class="w3-container w3-theme">
                        <h2>Cadastro de Vendedor</h2>
                    </div>
                    <form id="cadForm"class="w3-container" action="./actions/cadVendedor_exe.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario();">
                        <div>
                            <td>
                                <input class="w3-input w3-border w3-light-grey" name="nome" type="text" placeholder="Nome" required></div>
                            </td>
                        <div>
                        <div>
                            <td>
                                <input class="w3-input w3-border w3-light-grey" name="nomeEstabelecimento" type="text" placeholder="Nome do estabelecimento" required></div>
                            </td>
                        <div>
                            <td>
                                <input class="w3-input w3-border w3-light-grey" name="email" type="text" placeholder="Email" required></div>
                            </td>
                        <div>
                            <td>
                                <input class="w3-input w3-border w3-light-grey" name="cpf" type="text" placeholder="CPF" required></div>
                            </td>
                        <div>
                            <td>
                            <input class="w3-input w3-border w3-light-grey" name="cnpj" type="text" placeholder="CNPJ" required></div>
                            </td>
                        <div>
                            <td>
                                <input class="w3-input w3-border w3-light-grey" name="senha" type="text" placeholder="Senha" required></div>
                            </td>
    
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

