<?php session_start() ?>

<!DOCTYPE html>

<html>

<head>
	<title>Chestplace</title>
	<link rel="icon" type="image/png" href="imagens/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
    <script src="../scripts/formFunctions.js"></script>
    <script src="../scripts/validacoes.js"></script>

</head>

<body >
	<!-- Inclui MENU.PHP  -->
    <?php require "../common/header.php"; ?>
    <?php require '../database/conectaBD.php'; ?>

	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container">
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="max-width:1500px; margin:auto;">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate" style="border-left:4px solid blue;">
                <div class="w3-container w3-theme">
                    <h2>Cadastrar produto</h2>
                </div>
                <form id="cadForm"class="w3-container" action="../actions/cadProduto_exe.php" method="post" enctype="multipart/form-data" onsubmit="">
                    <table class='w3-table-all'>
                        <tr>
                            <td style="width:50%;">
                                <!-- <p>
                                    <input type="hidden" id="idProduto" name="idProduto" value="">
                                <p> -->
                                <p>
                                    <label class="w3-text-IE"><b>Título</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " id="titulo" name="titulo" type="text" title="Nome entre 10 e 100 letras." value="" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Descrição</b>*</label>
                                    <textarea class="w3-input w3-border w3-light-grey " name="descricao" id="descricao" cols="30" rows="10" placeholder="Insira a descrição do seu produto" required></textarea>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Preço</b>*</label>
                                    <input class="w3-input w3-border w3-light-grey " onkeyup="configurarPreco(this);" onblur="configurarPreco(this)" type="text" name="preco" id="preco" required>
                                </p>
                                <p>
                                    <label class="w3-text-IE"><b>Data de publicação*</b></label>
                                    <input class="w3-input w3-border w3-light-grey " id="dataPublicacao" name="dataPublicacao" type="datetime-local" title="dd/mm/aaaa hh:mm" title="Formato: dd/mm/aaaa" value="" max="9999-12-12T23:59:59" required>
                                </p>

                                <p>
                                    <label class="w3-text-IE"><b>Marca</b>*</label>
                                    <select name="marca" id="marca" class="w3-input w3-border w3-light-grey " required>
                                        <option value=""  disabled hidden selected>Escolha a marca</option>
                                        <?php
                                            //Select das camisetas e imagens das camisetas do vendedor passado por _GET
                                            $queryMarcas = "SELECT * FROM marca";

                                            //Resultao do Select
                                            $result = mysqli_query($conn, $queryMarcas);

                                            //Percorrendo resultado do select
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    if($row["id"] == $marca){
                                                        echo"<option value=".$marca.">".$row["nome"]."</option>";
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
                                        <option value=""  disabled hidden selected>Escolha o estado de conservação</option>
                                        <option value="nova">Nova</option>
                                        <option value="seminova">Seminova</option>
                                        <option value="usada">Usada</option>
                                        <option value="desgastada">Desgastada</option>
                                        <option value="muito desgastada">Muito desgastada</option>
                                    </select>
                                </p>

                                <p>
                                    <label class="w3-text-IE"><b>Tamanhos/Quantidade</b>*</label>
                                    <table id="tabelaTamanhos" style="width:100%">
                                        <th class="w3-center">Disponível</th>
                                        <th class="w3-center">Tamanho</th>
                                        <th class="w3-center">Quantidade</th>
                                        <?php
                                            //Select das camisetas e imagens das camisetas do vendedor passado por _GET
                                            $queryTamanhos = "
                                                SELECT * FROM tamanho";
    
                                            //Resultao do Select
                                            $result = mysqli_query($conn, $queryTamanhos);
    
                                            //Percorrendo resultado do select
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    echo "
                                                        <tr>
                                                            <td class=\"w3-center\"     ><input onclick=\"checkTamanho(this,'quantidade_".$row["codigo"]."')\" type=\"checkbox\" name=\"tamanho[]\" value=\"".$row["codigo"]."\" class=\"tamanho\"></td>
                                                            <td class=\"w3-left-align\" >".$row["codigo"]." - ".$row["descricao"]."</td>
                                                            <td class=\"w3-center\"     ><input name=\"quantidade_".$row["codigo"]."\" id=\"quantidade_".$row["codigo"]."\" type=\"text\" style=\"width:50%; text-align:center\" min=\"0\" pattern\"\d+\" onkeyup=\"configurarQtde(this)\" onblur=\"configurarQtde(this)\" class=\"quantidade\" required></td>
                                                        </tr>
                                                    ";
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
                                    <input type="file" id="Imagem" name="imagem[]" accept="image/*" enctype="multipart/form-data" onchange="validaImagem(this);" class="clickable" multiple required/></label>
                                </p>
                                
                                <table class="w3-table " style="margin:auto;width:75%;" id="previewTable">
                                    <thead>
                                        <tr>
                                            <th class="w3-center">Imagem</th>
                                            <th class="w3-center">Tamanho</th>
                                            <th class="w3-center">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- As prévias das imagens serão adicionadas dinamicamente aqui -->
                                    </tbody>
                                </table>
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
    
    <script>
        let inputImagem      = document.getElementById("Imagem");
        let tablePrevImagens = document.getElementById("previewTable");
        let tbodyPrevImagens =tablePrevImagens.querySelector("tbody");

        inputImagem.addEventListener("change", () => exibirPreviaImagens());

        window.addEventListener("load", function(event) {
            limitarCampos();

            let preco = document.getElementById("preco");
            if(preco.value == ""){
                preco.value = "0.00";
            }

            configurarTamanhoCheckbox();
            configurarDataHoraPubli();
        });

        function limitarCampos(){
            let titulo = document.getElementById("titulo");
            titulo.maxLength = 255;

            let descricao = document.getElementById("descricao");
            descricao.maxLength = 2000;

            let quantidades = document.getElementsByClassName("quantidade");
            for(let i = 0; i < quantidades.length ; i++){
                quantidades[i].max = 2147483647;
                quantidades[i].min = 1;
            }
        }

        function configurarMensagensValidacao(){
            let inputs = document.document.querySelectorAll("input");

            for(let i = 0; i < inputs.length; i++){
                inputs[i].addEventListener("invalid", function(event) {
                    event.preventDefault(); // Impede que a mensagem de erro padrão apareça
                    inputs[i].setCustomValidity("Por favor, preencha este campo com uma informação válida."); // Define uma mensagem de erro personalizada
                });
            }
        }

        function configurarTamanhoCheckbox(){
            // Seleciona todos os checkboxes
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            
            // Verifica se pelo menos um checkbox foi marcado
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].click();
                checkboxes[i].click();
            }
        }

        function configurarDataHoraPubli(){
            // Seleciona dataPublicacao
            const input = document.getElementById('dataPublicacao');

            // Obter a data e hora atual
            const agora = new Date();

            // Definir o valor mínimo do input
            agora.setUTCHours(agora.getUTCHours() - 3);
            input.min = agora.toISOString().slice(0,16);
            input.value = agora.toISOString().slice(0,16);

            console.log(agora.toISOString());
        }

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

            // Define a posição do cursor para a posição armazenada
            // input.setSelectionRange(cursorPos, cursorPos);
        }

        function configurarQtde(input){
            input.value = input.value.replace(/\D+/g, '');
            // alert(input.value);
        }

        function validarFormulario(){
            const formulario = document.getElementById("cadForm");
            let valido = validarTitulo() &&
                         validarDescricao() && 
                         validarDataPubli() &&
                         validarMarca() &&
                         validarConservacao() &&
                         validarTamanhoCheckbox() && 
                         validarQuantidade() &&
                         validarImagem();
            if(valido){
                formulario.submit();
            }
        }

        function exibirPreviaImagens() {
            tbodyPrevImagens.innerHTML = ""; // Limpar o tbody da tabela de pré-visualização

            // Obter os arquivos selecionados
            let imagens = inputImagem.files;

            for (let i = 0; i < imagens.length; i++) {
                let imagem = imagens[i];

                // Criar um elemento <img> com os atributos desejados
                let img = document.createElement("img");
                img.setAttribute("src", URL.createObjectURL(imagem));
                img.setAttribute("width", "90");
                img.setAttribute("height", "100");

                // Criar a linha da tabela
                let row = document.createElement("tr");
                row.id = "prevImg-"+imagem.name;

                // Criar a célula da imagem
                let cellImagem = document.createElement("td");
                cellImagem.classList.add("w3-center");
                cellImagem.style = "vertical-align: middle;";
                cellImagem.appendChild(img);
                
                // Criar célula de tamanho
                let cellTamanho = document.createElement("td");
                cellTamanho.classList.add("w3-center");
                cellTamanho.style = "vertical-align: middle;";
                cellTamanho.textContent =  (imagem.size/1024).toFixed(1) + " kB"

                // Criar a célula do botão de exclusão
                let cellExcluir = document.createElement("td");
                let btnExcluir = document.createElement("input");
                cellExcluir.classList.add("w3-center");
                cellExcluir.style = "vertical-align: middle;";
                btnExcluir.type = "button";
                btnExcluir.value = "Excluir";
                btnExcluir.classList.add("w3-btn", "w3-theme", "w3-red");
                btnExcluir.addEventListener("click", function () {
                    excluirImagem(imagem.name);
                });
                cellExcluir.appendChild(btnExcluir);

                // Adicionar as células à linha da tabela
                row.appendChild(cellImagem);
                row.appendChild(cellTamanho);
                row.appendChild(cellExcluir);

                // Adicionar a linha ao tbody da tabela de pré-visualização
                tbodyPrevImagens.appendChild(row);
            }
            }

            function excluirImagem(nomeArquivo) {
                // Criar uma nova lista de arquivos sem o arquivo a ser excluído

                let novosArquivos = new DataTransfer();
                for (let i = 0; i < inputImagem.files.length; i++) {
                    if (inputImagem.files[i].name !== nomeArquivo) {
                        novosArquivos.items.add(inputImagem.files[i]);
                    }
                }

                // Atribuir a nova lista de arquivos ao input de imagem
                inputImagem.files = novosArquivos.files;

                // Remover a linha da tabela de pré-visualização
                let deletedRow = document.getElementById("prevImg-"+nomeArquivo);
                deletedRow.remove();
            }

    </script>


</body>

</html>