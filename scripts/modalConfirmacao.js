function limparModal(){
        
    // Textos
    $("#titulo-modalDeNotificacao").text("");
    $("#subtitulo-modalDeNotificacao").text("");
    $("#texto-modalDeNotificacao").text("");

    // Botões
    $("#btnPrimario-modalDeNotificacao").text("");
    $("#btnSecundario-modalDeNotificacao").text("Cancelar");

}

function showModalConfirmacao(icone,titulo, subtitulo, texto, corW3CSS, botaoPrimario, botaoSecundario){
    limparModal();

    // Estilo
    $("#modalDeNotificacao").addClass(corW3CSS);
    $("#titulo-modalDeNotificacao").append(icone);

    // Textos
    $("#titulo-modalDeNotificacao").append(titulo);
    $("#subtitulo-modalDeNotificacao").text(subtitulo);
    $("#texto-modalDeNotificacao").text(texto);

    // Botões
    $("#btnPrimario-modalDeNotificacao").text(botaoPrimario);
    $("#btnSecundario-modalDeNotificacao").text("Cancelar");
    if(botaoSecundario !== undefined) $("#btnSecundario-modalDeNotificacao").text(botaoSecundario);

    $("#btnSecundario-modalDeNotificacao").on("click",function(){$("#modalDeNotificacao").get(0).close()});

    // Mostrar
    $("#modalDeNotificacao").get(0).showModal()
}
