var imgAtual = 0;


$("#cPagamento").click(function(){
    showModalConfirmacao(
        "<i class=\"w3-text-amber fa fa-solid fa-exclamation-triangle\"></i> &nbsp;",
        "Você tem certeza?",
        "Ao confirmar, o status do pedido será atualizado. ",
        "",
        "w3-boder-amber",
        "Confirmar"
    );

    $("#btnPrimario-modalDeNotificacao").off();
    $("#btnPrimario-modalDeNotificacao").on("click", function() { goToUpdateVenda(true) });

});

$("#rPagamento").click(function(){
    showModalConfirmacao(
        "<i class=\"w3-text-amber fa fa-solid fa-exclamation-triangle\"></i> &nbsp;",
        "Você tem certeza?",
        "Ao confirmar, o status do pedido retornará para \"Aguardando pagamento\" ",
        "",
        "w3-boder-amber",
        "Confirmar"
    );

    $("#btnPrimario-modalDeNotificacao").off();
    $("#btnPrimario-modalDeNotificacao").on("click", function() { goToUpdateVenda(false) });

});

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

function goToUpdateVenda(confirmacaoPagamento){
    const dados = new FormData();
    dados.append("pagamento", confirmacaoPagamento);
    dados.append("idVenda", $("#idVenda").val());
  
    fetch("../actions/updateVenda_exe.php", {
      method: "POST",
      body: dados
    })
    .then(response => {
        // Se a requisição tiver sido feita com sucesso
        if(response.ok){
            alert("Status de pedido atualizado com sucesso!");
            window.location.href="../page_gerVendas.php"; 
        } else {
           throw new Error(response.status);
        }
    }) // Caso ocorra um erro
    .catch(error => {
        alert("Erro na requisição: " + error);
        location.reload();
    });
}
