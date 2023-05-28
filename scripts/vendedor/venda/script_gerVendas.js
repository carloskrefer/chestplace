$(document).ready(function(){
    $(".ord").addClass("w3-hide");

    let urlParams = new URLSearchParams(window.location.search);

    let pesquisarPor = urlParams.get("orderBy");
    let sentido = urlParams.get("sentido");

    let x = `#${pesquisarPor}-${sentido}`;
    $(x).removeClass("w3-hide")
});

function pesquisar(){
    window.location.href = `./page_gerVendas.php?pesquisarPor=${$("#pesquisarPor").val()}&pesquisa=${$("#pesquisa").val()}`;
}

function ordenar(coluna){
    const urlParams  = new URLSearchParams(window.location.search);
    let sentido      = urlParams.get('sentido');
    let pesquisarPor = urlParams.get('pesquisarPor');
    let pesquisa     = urlParams.get('pesquisa'); 
    let ordernarPor  = urlParams.get('orderBy');

    if(sentido == "DESC" && sentido != null) {
        sentido = "ASC"
    } else {
        sentido = "DESC"
    }

    if(pesquisarPor != null || pesquisa != null){
        window.location.href = `./page_gerVendas.php?pesquisarPor=${pesquisarPor}&pesquisa=${pesquisa}&orderBy=${coluna}&sentido=${sentido}`;
    } else {
        window.location.href = `./page_gerVendas.php?orderBy=${coluna}&sentido=${sentido}`;
    }
}