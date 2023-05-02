<?php include("../database/conectaBD.php");
session_start();>

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

<div class="w3-main w3-container">
	<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
		<p class="w3-large">
		<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
			<div class="w3-container w3-theme">
				<h2>Cadastro de Vendedor</h2>
			</div>

            <div>
                <td>
                    <input class=\"w3-input w3-border w3-light-grey\" name=Nome type=\"text\" value=Nome required></div>
                </td>
            <div>
                <td>
                    <input class=\"w3-input w3-border w3-light-grey\" name=\Email type=\"text\" value=Email required></div>
                </td>
            <div>
                <td>
                    <input class=\"w3-input w3-border w3-light-grey\" name=\CPF type=\"text\" value=CPF required></div>
                </td>
            <div>
                <td>
                <input class=\"w3-input w3-border w3-light-grey\" name=\CNPJ type=\"text\" value=CNPJ required></div>
                </td>
            <div>
                <td>
                    <input class=\"w3-input w3-border w3-light-grey\" name=\Senha type=\"text\" value=Senha required></div>
                </td>


            <p>
                <input type="submit" value="Cadastrar" class="w3-btn w3-red">

            </p>
            <h2>Já possuo Conta:</h2>
            <div class ='justify-center'>
              <button onclick="https:" >Ir para o Login</button>

