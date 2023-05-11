function limparModal(){
        
    // Textos
    $("#titulo-modalDeNotificao").text("");
    $("#subtitulo-modalDeNotificao").text("");
    $("#texto-modalDeNotificao").text("");

    // Botões
    $("#btnPrimario-modalDeNotificao").text("");
    $("#btnSecundario-modalDeNotificao").text("Cancelar");

}

function showModalConfirmacao(icone,titulo, subtitulo, texto, corW3CSS, botaoPrimario, botaoSecundario){
    limparModal();

    // Estilo
    $("#modalDeNotificao").addClass(corW3CSS);
    $("#titulo-modalDeNotificao").append(icone);

    // Textos
    $("#titulo-modalDeNotificao").append(titulo);
    $("#subtitulo-modalDeNotificao").text(subtitulo);
    $("#texto-modalDeNotificao").text(texto);

    // Botões
    $("#btnPrimario-modalDeNotificao").text(botaoPrimario);
    $("#btnSecundario-modalDeNotificao").text("Cancelar");
    if(botaoSecundario !== undefined) $("#btnSecundario-modalDeNotificao").text(botaoSecundario);

    $("#btnSecundario-modalDeNotificao").on("click",function(){$("#modalDeNotificao").get(0).close()});

    // Mostrar
    $("#modalDeNotificao").get(0).showModal()
}
