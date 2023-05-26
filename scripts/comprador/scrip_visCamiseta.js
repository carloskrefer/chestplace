function goToVisualizarProduto(id){
    window.location.href='./forms/form_visualizaProduto.php?id=' + id;
}
var imgAtual = 0;
$("#prev-img").click(function(){
    $("#img-"+imgAtual).addClass("w3-hide");
    imgAtual--;
    // Próxima imagem existe
    let imgExiste = $("#img-"+imgAtual).length > 0;

    if(imgExiste){
        $("#img-"+imgAtual).removeClass();
    } else {
        imgAtual = 0;
        $("#img-"+imgAtual).removeClass();
    }
});

$("#next-img").click(function(){
    $("#img-"+imgAtual).addClass("w3-hide");
    imgAtual++;
    // Próxima imagem existe
    let imgExiste = $("#img-"+imgAtual).length > 0;
    
    if(imgExiste){
        $("#img-"+imgAtual).removeClass();
    } else {
        imgAtual--
        $("#img-"+imgAtual).removeClass();
    }
});