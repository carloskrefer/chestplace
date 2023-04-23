function checkTamanho(e, idInputQtde){
    let inputQtde = document.getElementById(idInputQtde);
    console.log(e);
    console.log(inputQtde);
    console.log(idInputQtde);
    if(e.checked){
        inputQtde.disabled = false;
    } else {
        inputQtde.disabled = true;
    }
}