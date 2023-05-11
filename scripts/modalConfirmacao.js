function showModalConfirmacao(icone,titulo, subtitulo, texto, corW3CSS, botaoPrimario){
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
    $("#btnSecundario-modalDeNotificao").on("click",function(){$("#modalDeNotificao").get(0).close()});

    // Mostrar
    $("#modalDeNotificao").get(0).showModal()
}