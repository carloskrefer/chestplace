/**
 * Ativa o campo input[type="text"] 'inputQtde' do respectivo checkbox que chamou essa função
 * 
 * @param {HTMLInputElement} checkbox    - O elemento HTML do checkbox.
 * @param {HTMLInputElement} idInputQtde - ID do inputQtde que será ativado pela checkbox.

 */
function checkTamanho(checkbox, idInputQtde){
    let inputQtde = document.getElementById(idInputQtde);
    
    if(checkbox.checked)
        inputQtde.disabled = false;
    else 
        inputQtde.disabled = true;
    
}
