function checkTamanho(e, idInputQtde){
    let inputQtde = document.getElementById(idInputQtde);
    
    if(e.checked){
        inputQtde.disabled = false;
    } else {
        inputQtde.disabled = true;
    }
}
