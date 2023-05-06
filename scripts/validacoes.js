function validarFormulario(){
    let valido = validarTitulo() &&
                 validarDescricao() && 
                 validarDataPubli() &&
                 validarMarca() &&
                 validarConservacao() &&
                 validarTamanhoCheckbox() && 
                 validarQuantidade() &&
                 validarImagem();

    return valido;
}

function validarTitulo(){
    const titulo = document.getElementById("titulo");

    titulo.value = titulo.value.trim();

    if(titulo.value.length > 2){
        const regex = /^(?=.*[a-zA-Z]).+$/;
        
        if(titulo.value.match(regex)){
            titulo.validity.valid = true;
            return true;
        } else {
            exibirPopUpErro(titulo,"Titúlo inválido! Título deve conter ao menos uma letra.");
        }
    } else {
        exibirPopUpErro(titulo, "Titúlo inválido! Título deve conter ao 3 caracteres.")
    }
    return false;
}

function validarDescricao(){
    const descricao = document.getElementById("descricao");

    if(descricao.value.length > 0 && descricao.value.length < 2001){
        descricao.validity.valid = true;
        return true;
    }

    exibirPopUpErro(descricao,"Descrição inválida! Descrição deve entre 1 e 2000 caracteres.")

    return false;

}

function validarDataPubli(){
    const dataAtual = new Date();
    const dataPubli = document.getElementById("dataPublicacao");
    const data = dataPubli.value;
    const dataLimite =  new Date("9999-12-31T23:59");

    if(data == ""){ // data de publicação vazia
        alert("Campo obrigatório! Insira uma data de publicação válida.");
        exibirPopUpErro(dataPubli, "Campo obrigatório! Insira uma data de publicação válida.");
        return false;
    } 

    try{
        const dataDate = new Date(data).getTime()

        if(dataDate < dataAtual-300000){ // data de publicação anterior a agora

            alert("Data inválida! A data não deve ser anterior à data atual.")
            exibirPopUpErro(dataPubli, "Data inválida! A data não deve ser anterior à data atual.")
            return false;
        } else if(new Date(data) > dataLimite){ // data de publicação posterior a agora
            alert("Data inválida! A data não deve ser posterior a 9999-12-31 23:59");
            exibirPopUpErro(dataPubli, "Data inválida! A data não deve ser posterior a 9999-12-31 23:59")
            return false;
        }

        dataPubli.validity.valid = true;
        return true;

        } catch(exception){
            alert("Data inválida! Preencha todos os campos de data e hora. ");
            exibirPopUpErro(dataPubli, "Data inválida! Preencha todos os campos de data e hora. ");
            return false;
    }
}

function validarMarca(){
    const marca = document.getElementById("marca");

    if(marca.value == ""){
        exibirPopUpErro(marca, "Campo obrigatório! Por favor, insira uma marca válida.");
        return false;
    }
    return true;
}

function validarConservacao(){
    const conservacao = document.getElementById("conservacao");

    if(conservacao.value == ""){
        exibirPopUpErro(conservacao, "Campo obrigatório! Por favor, insira um estado de conservação válido.");
        return false;
    }
    return true;
}

function validarTamanhoCheckbox(){
    var checkboxes = document.getElementsByClassName("tamanho");
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
        exibirPopUpErro(checkboxes[0],'Selecione pelo menos uma opção de tamanho!')
    }

    return checked;
}

function validarQuantidade(){
    const quantidades = document.getElementsByClassName("quantidade");

    for(let i = 0; i < quantidades.length ; i++){
        if((quantidades[i].value <= 0 || quantidades[i].value > 2147483647) && !quantidades[i].disabled){
            
            exibirPopUpErro(quantidades[i],"Quantidade de camisetas inválido! Máximo de 2147483647, mínimo de 1." )
            return false;
        } 
        quantidades[i].validity.valid = true;
    }
    return true;

}

function validarImagem(){
    const inputImage = document.getElementById("Imagem");
    let tamanhoOk    = verificarTamanhoMaximo(Array.from(inputImage.files));
  
    if (inputImage.validity.valueMissing) {
        exibirPopUpErro(inputImage,"Campo obrigatório! Selecione pelo menos uma imagem.");
        return false;
    } 
    
    if (inputImage.validity.badInput) {
        exibirPopUpErro(inputImage,"Arquivo inválido! A extensão desse arquivo não é suportado, por favor, envie arquivos '.jpg', '.png' ou '.gif'.");
        return false;    
    } 
    
    if (!tamanhoOk){
        exibirPopUpErro(inputImage, "Arquivo inválido! O tamanho desse arquivo excede o limite de 64 KB");
        return false;
    }

    return true;

    // href=\"../actions/delImagem_exe.php?idImagem=".$rowImagens["id"]."&idCamiseta=".$idCamiseta."\"
}

function validarQuantidadeImagensDeletadas(arrayOriginal, arrayDeletadas){
    let inputImage = document.getElementById("Imagem");
    if((arrayOriginal.length == arrayDeletadas.length) && inputImage.files.length == 0){
        exibirPopUpErro(inputImage, "Campo obrigatório! Selecione pelo menos uma imagem.");
        return false;
    }
    return true;
}

/**
 * Exibe uma mensagem de erro personalizada em um campo de formulário.
 * @param {HTMLInputElement} campoInpt - O campo de entrada em que a mensagem de erro será exibida.
 * @param {string} mensagem - A mensagem de erro a ser exibida.
 */
function exibirPopUpErro(campoInpt, mensagem){
    campoInpt.setCustomValidity(mensagem);
    campoInpt.validity.valid = false;
    campoInpt.reportValidity();
    campoInpt.focus();
}

/**
 * Verifica se todos os arquivos em um array têm um tamanho válido.
 * @param {Array} arquivos - Um array de objetos do tipo `File` que representam os arquivos a serem verificados.
 * @returns {boolean} Retorna `true` se todos os arquivos no array têm um tamanho válido (menor ou igual a 64 KB) ou `false` caso contrário.
 */
function verificarTamanhoMaximo(arquivos) {
    var tamanhoMaximo = 65536; // tamanho máximo em bytes (64 KB)
    let tamanhoOk = true;

    
    arquivos.forEach(function(arquivo) {
        if (arquivo.size > tamanhoMaximo) {
            tamanhoOk = false;
        }
    });
    
    return tamanhoOk;
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
    .catch(error =>{throw new Error("Erro na requisição: " + error);
});
}

