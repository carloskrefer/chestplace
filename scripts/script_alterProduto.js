var idImagensOriginal= [];

window.addEventListener("load", function(event) {
    limitarCampos();

    let preco = document.getElementById("preco");
    if(preco.value == ""){
        preco.value = "0.00";
    }

});

function configurarPreco(input){

    if (input.value == ""){
        input.value = 0.00; 
    }

    // Armazena a posição atual do cursor
    input.selectionStart = input.selectionEnd = input.value.length-3;

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

}

function configurarQtde(input){
    input.value = input.value.replace(/\D+/g, '');
}

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

function apagarImagem(id){
    let imageRow = document.getElementById("tr-"+id);
    imageRow.remove();
    idImagensDeletar.push(id);
}


