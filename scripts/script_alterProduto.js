// Preview de imagens
let inputImagem      = document.getElementById("Imagem");
let tablePrevImagens = document.getElementById("previewTable");
let tbodyPrevImagens =tablePrevImagens.querySelector("tbody");

window.addEventListener("load", function(event) {
    limitarCampos();

    let preco = document.getElementById("preco");
    if(preco.value == ""){
        preco.value = "0.00";
    }

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

function apagarImagem(id){
    let imageRow = document.getElementById("tr-"+id);
    imageRow.remove();
    idImagensDeletar.push(id);
}




inputImagem.addEventListener("change", () => exibirPreviaImagens());

function enviarFormulario(){

    // Se, considerando as novas imagens e as atingas, ainda haverá pelo menos uma imagem no BD &&
    // Outros campos do formulário são válidos
    if(
        validarQuantidadeImagensDeletadas(idImagensOriginal, idImagensDeletar)&&
        validarFormulario()
        )
    {

        // Transforma os dados do formulário em um FORMDATA, que contém os dados do formulário e será enviado para a action
        let formulario = document.getElementById("frmAlterProduto");
        let formData = new FormData(formulario);

        // Adiciona as imagens que irão ser apagadas aos dados do formulário
        formData.append('idImagensDeletar', JSON.stringify(idImagensDeletar));

        console.log(JSON.stringify(idImagensDeletar));

        // Envia para o link da action do formulario, os dados do formulário (com os IDs das imagens para deletar).
        enviarFormularioPost(formulario.action,formData)
        .then( response => {
            // Caso seja um resposta positiva, exibir mensagem de sucesso e redirecionar para página principal
            alert("Anúncio atualizado com sucesso!");
            window.location.assign("../page_gerProdutos.php");
        })
        .catch( error => {alert("Erro ao atualizar anúncio no banco de dados. ERRO: " + error)})  // Caso haja um erro, informar erro
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
        "Ao confirmar, todas as alterações não salvas serão perdidas. ",
        "",
        "w3-boder-amber",
        "Sim",
        "Não"
    );

    $("#btnPrimario-modalDeNotificao").off();
    $("#btnPrimario-modalDeNotificao").on("click", function() { window.location.href="../page_gerProdutos.php" });
}

function confirmarAlteracao(){
    showModalConfirmacao(
        "<i class=\"w3-text-amber fa fa-solid fa-exclamation-triangle\"></i> &nbsp;",
        "Você tem certeza?",
        "Ao confirmar, todos os dados salvos anteriormente serão substituídos pelos novos dados inseridos. ",
        "",
        "w3-boder-amber",
        "Sim",
        "Não"
    );

    $("#btnPrimario-modalDeNotificao").off();
    $("#btnPrimario-modalDeNotificao").on("click", function() {  $("#modalDeNotificao").get(0).close();  enviarFormulario();});
}


/**
* Envia uma requisição POST para a URL de destino
* @param {string} action - A URL de destino para a requisição POST.
* @param {FormData|URLSearchParams|Blob|string} dados - Os dados a serem enviados no corpo da requisição.
* @returns {Promise} - Uma Promise que resolve para a resposta da requisição.
*/
function enviarFormularioPost(action, dados) {
    return fetch(action, {
            method: "POST",
            body: dados
        })        
        .then(response => {response.text()})
        .then(data => {return data})
        .catch(error =>{throw new Error("Erro na requisição: " + error);});
}
