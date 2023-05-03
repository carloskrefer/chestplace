
<!DOCTYPE html>
<?php
    include("../database/conectaBD.php");
    include("../common/functions.php");
    session_start();

    $idCamiseta = $_GET["id"];

    //Select das camisetas e imagens das camisetas do vendedor passado por _GET
    $queryProdutos = "SELECT * FROM camiseta WHERE id = ".$idCamiseta.";";

    cLog($queryProdutos);

    //Resultao do Select
    $result = mysqli_query($conn, $queryProdutos);

        //Percorrendo resultado do select
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $titulo = $row["titulo"];
                $preco = $row["preco"];
                $descricao = $row["descricao"];
                $data_hora_publicacao = $row["data_hora_publicacao"];
                $marca = $row["id_marca"];
                $conservacao = $row["conservacao"];
            }
        }

?>

<html>

<head>
	<title>Chestplace</title>
    <link rel="icon" type="image/png" href="imagens/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
    <link rel="stylesheet" href="../styles.css">
    <script src="../scripts/formFunctions.js"></script>

</head>

<body onload="w3_show_nav('menuMedico')">
	<!-- Inclui MENU.PHP  -->
    <?php require '../common/header.php'; ?>
    <?php require '../database/conectaBD.php'; ?>

	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="max-width:1500px; margin:auto;">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Alterar dados do produto</h2>
                </div>
                <form name="frmAlterProduto" id="frmAlterProduto" class="w3-container" action="../actions/alterProduto_exe.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                    <table class='w3-table-all'>
                        <tr>
                            <td style="width:50%;">
                                <p>
                                    <input type="hidden" id="idCamiseta" name="idCamiseta" value="<?= $idCamiseta?>">
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Título</b>*</label>
                                    <?php
                                        echo"<input class=\"w3-input w3-border w3-light-grey\" name=\"titulo\" type=\"text\" value=\"".$titulo."\" required/>"
                                    ?>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Descrição</b>*</label>
                                    <?php
                                        echo"<textarea class=\"w3-input w3-border w3-light-grey \" name=\"descricao\" id=\"descricao\" cols=\"30\" rows=\"10\" placeholder=\"Insira a descrição do seu produto\" required>".$descricao."</textarea>"
                                    ?>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Preço</b>*</label>
                                    <?php
                                        echo"<input class=\"w3-input w3-border w3-light-grey \" onkeyup=\"configurarPreco(this);\" onblur=\"configurarPreco(this)\" type=\"text\" name=\"preco\" id=\"preco\" value=\"".$preco."\" required>";
                                    ?>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Data de publicação*</b></label>
                                    <?php
                                        echo"<input class=\"w3-input w3-border w3-light-grey \" name=\"dataPublicacao\" type=\"datetime-local\" placeholder=\"dd/mm/aaaa\" title=\"dd/mm/aaaa\" title=\"Formato: dd/mm/aaaa\" value=\"".$data_hora_publicacao."\">";
                                    ?>
                                    
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Marca</b>*</label>
                                    <select name="marca" id="marca" class="w3-input w3-border w3-light-grey " required>
                                        <?php
                                            //Select das camisetas e imagens das camisetas do vendedor passado por _GET
                                            $queryMarcas = "SELECT * FROM marca";

                                            //Resultao do Select
                                            $result = mysqli_query($conn, $queryMarcas);

                                            //Percorrendo resultado do select
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    if($row["id"] == $marca){
                                                        echo"<option value=".$marca." selected>".$row["nome"]."</option>";
                                                    } else{
                                                        echo"<option value=".$row["id"].">".$row["nome"]."</option>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Estado de conservação</b>*</label>
                                    <select name="conservacao" id="conservacao" class="w3-input w3-border w3-light-grey " required>
                                        <option value=""  disabled hidden>Escolha o estado de conservação</option>
                                        
                                        <?php
                                            $enum = array(
                                                "Nova" => "nova",
                                                "Seminova" => "seminova",
                                                "Usada" => "usada",
                                                "Desgastada" => "desgastada",
                                                "Muito desgastada" => "muito desgastada",
                                            );

                                            foreach ($enum as $chave => $valor) {
                                                if($conservacao == $valor){
                                                    echo "<option value\"".$valor."\" selected>".$chave."</option>";
                                                }else {
                                                    echo "<option value\"".$valor."\">".$chave."</option>";
                                                }
                                            }
                                            


                                        ?>
                                    </select>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Tamanhos/Quantidade</b>*</label>
                                    <table id="tabelaTamanhos">
                                        <th class="w3-center">Disponível</th>
                                        <th class="w3-center">
                                            Tamanho
                                        </th class="w3-center">
                                        <th class="w3-center">Quantidade</th>
                                        <?php
                                            //Select das camisetas e imagens das camisetas do vendedor passado por _GET
                                            $queryTamanhos = "SELECT * FROM tamanho";

                                            //Resultao do Select
                                            $resultTamanhos = mysqli_query($conn, $queryTamanhos);

                                            
                                            //Percorrendo resultado do select
                                            if (mysqli_num_rows($resultTamanhos) > 0) {
                                                while($rowTamanho = mysqli_fetch_assoc($resultTamanhos)) {

                                                    $queryEstoque = "SELECT * FROM estoque WHERE id_camiseta = ".$idCamiseta." AND id_tamanho = ". $rowTamanho["id"];
                                                    $resultEstoque  = mysqli_query($conn, $queryEstoque);

                                                    if (mysqli_num_rows($resultEstoque) > 0) {
                                                        
                                                        while($rowEstq = mysqli_fetch_assoc($resultEstoque)) {
                                                            echo "
                                                                <tr>
                                                                    <td class=\"w3-center\"     ><input onclick=\"checkTamanho(this,'inpt-".$rowTamanho["codigo"]."')\" type=\"checkbox\" name=\"tamanho[]\" id=\"tamanho\" class=\"tamanho\" checked></td>
                                                                    <td class=\"w3-left-align\" >".$rowTamanho["codigo"]." - ".$rowTamanho["descricao"]."</td>
                                                                    <td class=\"w3-center\"     ><input id=\"inpt-".$rowTamanho["codigo"]."\" name=\"quantidade_".$rowTamanho["codigo"]."\" type=\"number\" style=\"width:50%\" min=0 step=\"1\" value=\"".$rowEstq["quantidade"]."\"required></td>
                                                                </tr>
                                                            ";
                                                        }
                                                    } else {
                                                        echo "
                                                            <tr>
                                                                <td class=\"w3-center\"     ><input onclick=\"checkTamanho(this,'inpt-".$rowTamanho["codigo"]."')\" type=\"checkbox\" name=\"tamanho[]\" id=\"tamanho\" class=\"tamanho\"></td>
                                                                <td class=\"w3-left-align\" >".$rowTamanho["codigo"]." - ".$rowTamanho["descricao"]."</td>
                                                                <td class=\"w3-center\"     ><input id=\"inpt-".$rowTamanho["codigo"]."\" name=\"quantidade_".$rowTamanho["codigo"]."\" type=\"number\" style=\"width:50%\" min=0 step=\"1\" disabled required></td>
                                                            </tr>
                                                        ";
                                                    }


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
                                    <input type="hidden" name="MAX_FILE_SIZE" value="16777215"/>
                                    <?php
                                        //Select das camisetas e imagens das camisetas do vendedor passado por _GET
                                        $queryImagens = "SELECT * FROM imagem WHERE id_produto = ".$idCamiseta;
                        
                                        $resultImagens = mysqli_query($conn, $queryImagens);

                                        if(mysqli_num_rows($resultImagens) > 0){
                                            echo "<input type=\"file\" id=\"Imagem\" name=\"imagem[]\" accept=\"imagem/*\" enctype=\"multipart/form-data\" onchange=\"validaImagem(this);\" multiple/></label>";
                                        } else {
                                            echo "<input type=\"file\" id=\"Imagem\" name=\"imagem[]\" accept=\"imagem/*\" enctype=\"multipart/form-data\" onchange=\"validaImagem(this);\" multiple required/></label>";
                                        }
                                    
                                    ?>
                                    
                                </p>

                                <?php


                                    echo "
                                        <table>
                                            <tr>
                                                <th>Imagem</th>
                                                <th>Opções</th>
                                            </tr>
                                    ";
                                    //Percorrendo resultado do select
                                    if (mysqli_num_rows($resultImagens) > 0) {
                                        while($rowImagens = mysqli_fetch_assoc($resultImagens)) {
                                            $blob = $rowImagens["imagem"];
                                            $base64 = base64_encode($blob);
                                            echo "
                                                <tr>
                                                    <td>
                                                        <img width=\"75\" height=\"100\" src=\"data:image/png;base64," . $base64 . "\" />
                                                    </td>
                                                    <td>
                                                        <a href=\"../actions/delImagem_exe.php?idImagem=".$rowImagens["id"]."&idCamiseta=".$idCamiseta."\">Excluir</a>
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                    } else {
                                        echo "<tr><td colspan=2>Nenhuma imagem salva</td></tr>";
                                    }
                                    echo"</table>"
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                            <p>
                                <input type="submit" value="Alterar" class="w3-btn w3-red">
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

    <script>



        function configurarPreco(input){
            // Armazena a posição atual do cursor
            input.selectionStart = input.selectionEnd = input.value.length;

            // Remove todos os caracteres não numéricos (exceto um ponto ou vírgula decimal)
            input.value = input.value.replace(/[^0-9]/g, '');

            // Substitui a vírgula pelo ponto como separador decimal, se necessário
            // input.value = input.value.replace(',', '.');

            // Formata o valor com duas casas decimais, se possível
            var valor = parseFloat(input.value.replace(',', '.'));
            if (!isNaN(valor) && input.value.trim() !== '') {
                valor = valor/100;
                input.value = valor.toFixed(2);
                if(valor > 999999.99){
                    input.value = 999999.99; 

                }
            }
        }

        function validarFormulario(){
            return validarTamanhoCheckbox();
        }

        function validarTamanhoCheckbox(){
            console.log("hellop");
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var checked = false;

            for (var i = 0; i < checkboxes.length; i++) {
                if(checkboxes[i].classList[0] == "tamanho"){
                    if (checkboxes[i].checked) {
                        checked = true;
                        break;
                    }
                }
            }

            if (!checked) {
                alert('Selecione pelo menos uma opção de tamanho!');
            }

            return checked;
        }

        
    </script>

</body>

</html>