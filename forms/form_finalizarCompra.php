<!DOCTYPE html>
<?php 
    session_start(); 
    $tipoPagina = "Finalizar compra";

?>
<html> 
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles.css">
</head>

<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge" style="display:flex; align-items:center; padding: 0px 25px 0px 25px">
  <div class="w3-bar-item w3-padding-24 w3-wide">
    <img src="../imagens/logo_chestplace.png" style="width: 30%;">
  </div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

 <header class=" w3-xlarge" style="background-color: #141414; display:flex; align-items: center; justify-content: space-between; padding:0px 50px 0px 50px;">
    
    <img src="../imagens/logo_chestplace.png" alt="logo" style="width: 15%;">


    <div class="w3-bar w3-right" style="display:flex; align-items:center; justify-content: flex-end;width: 100%;">
        
        <div class="w3-hover-opacity w3-right w3-bar-item w3-btn w3-xxlarge" style="display:flex; align-items:center; justify-content:space-between;">
            <a class="w3-btn w3-xxlarge no-underline" style="display:flex; align-items:center; justify-content:space-between; color:white;" href="../index.php">
                <i class="fa-solid fa-house"></i>
            </a>
        </div>
             </div>
</header>



<body>

<?php include("../database/conectaBD.php"); ?>
    <?php $tipoPagina = "FinalizarCompra"; include('../common/header.php')?>

    <div class="w3-main w3-container">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="max-width:1500px; margin:auto;">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="center:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Finalize sua compra</h2>
                </div>

                <form id="fincompra"class="w3-container" action="" method="post" enctype="multipart/form-data" onsubmit="">
                    <table class='w3-table-all'>

                        
                        
                        <tr>
                            <td style="width:50%;">
                                <h3 style="text-align:center">Dados de pagamento</h3>
                                <p>Escolha metódo de pagamento:</p>

                                <form>
                                    <input type="radio" id="Cartão de crédito" name="formapag" value="Cartão de crédito">
                                    <label for="html">Cartão de crédito</label><br>
                                    <input type="radio" disabled id="css" name="formapag" value="Boleto">
                                    <label for="css">Boleto(Em breve)</label><br>                            
                                </form>

                                <p>
                                    <label class="w3-text-IE"><b>Número do cartão</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="numerocartao" name="NumeroCartao" type="text" title="Número do cartão usado" placeholder="XXXX.XXXX.XXXX.XXXX" pattern="[0-9]+$ min=16 max=16" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>CVC</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="CVCcartao" name="CVCCrtao" type="text" title="CVC" placeholder="CVC" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Nome do Titular</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="nometitular" name="NomeTitular" type="text" title="Nome do Titular" placeholder="Nome do Titular" required>
                                </p>
				<p>
                                    <label class="w3-text-IE"><b>Validade</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="validadecartao" name="ValidadeCartao" type="text" title="Validade do Cartao" placeholder="Validade do Cartao" required>
                                </p>
                                    <br>
                                    <tr>
                                        <td colspan="2" style="text-align:center">
                                        <p>
                                            <input type="button" id="Finalizar" value="Salvar" onclick="FinalizarCompra();" class="w3-btn w3-red" >
                                            <input type="button" value="Cancelar" class="w3-btn w3-theme" onclick="window.location.href='../index.php'">
                                        </p>
						<script>
							function FinalizarCompra(){
							alert("Houve algum erro nos dados de pagamento!")
							}
						</script>
					
						
                                        </td>
                                    </tr>
</body>

</html>
