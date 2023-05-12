let inputImagem      = document.getElementById("Imagem");
let tablePrevImagens = document.getElementById("previewTable");
let tbodyPrevImagens = tablePrevImagens.querySelector("tbody");

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
        quantidades[i].addEventListener("input", () => { quantidades[i].value = formatarQuantidade(quantidades[i].value)})
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

    if(input.value == '') input.value= "0.00"; ;

    // Armazena a posição atual do cursor
    input.selectionStart = input.selectionEnd = input.value.length;

    // Remove todos os caracteres não numéricos (exceto um ponto ou vírgula decimal)
    input.value = input.value.replace(/[^0-9]/g, '');

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
        let imgTamanhoMB = (imagem.size/1024/1024).toFixed(1);
        let imgTamanhoKB = (imagem.size/1024).toFixed(1);
        let cellTamanho  = document.createElement("td");
        cellTamanho.classList.add("w3-center");
        if(imgTamanhoMB > 1) {
            cellTamanho.classList.add("w3-bold");
            cellTamanho.classList.add("w3-text-red");
        }
        cellTamanho.style = "vertical-align: middle;";
        cellTamanho.textContent = imgTamanhoMB < 0.1 ? imgTamanhoKB + " KB" : imgTamanhoMB + " MB";

        // Criar célula de extensão
        let extensao = imagem.name.replace(/^.*\.(.+)$/, '$1');
        let formatosValidos = ["jpg", "jpeg", "gif", "png"];
        let cellExtensaoArquivo = document.createElement("td");
        cellExtensaoArquivo.classList.add("w3-center");
        if(!formatosValidos.includes(extensao)) {
            cellExtensaoArquivo.classList.add("w3-bold");
            cellExtensaoArquivo.classList.add("w3-text-red");
        }
        cellExtensaoArquivo.style = "vertical-align: middle;";
        cellExtensaoArquivo.textContent =  extensao;

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
        row.appendChild(cellExtensaoArquivo);
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

function confirmarCancelamento(){
    showModalConfirmacao(
        "<i class=\"w3-text-amber fa fa-solid fa-exclamation-triangle\"></i> &nbsp;",
        "Você tem certeza?",
        "Ao confirmar, todos os dados não salvos serão apagados permanentemente ",
        "",
        "w3-boder-amber",
        "Sim",
        "Não"
    );

    $("#btnPrimario-modalDeNotificao").off();
    $("#btnPrimario-modalDeNotificao").on("click", function() { window.location.href="../page_gerProdutos.php" });
}

