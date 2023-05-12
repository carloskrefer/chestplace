/**
 * Formata um número identificador passado e, dependendo do tamanho do identificador
 * formata para CPF ou CNPJ.
 * - Caso o tamanho não seja de nenhum dos dois, o valor original é retornado
 * 
 * @param {string} cpf - O número de CPF a ser formatado.
 * @returns {string} - O CPF formatado.
 *
 * @example
 * formatarCPFCNPJ('12345678900');    // Retorna '123.456.789-00'
 * formatarCPFCNPJ('01234567891234'); // Retorna '01.234.567/8912-34'
 * formatarCPFCNPJ('01234');          // Retorna '01234'
 * 
 */
function formatarCPFCNPJ(identificador){

    // Remove todos os caracteres não numéricos
    const numeros = identificador.replace(/\D/g, '');

    if(numeros.length == 11) return formatarCPF(numeros);
    if(numeros.length == 14) return formatarCNPJ(numeros);

    return numeros;
}




/**
 * Formata um número passado para o formato XXX.XXX.XXX-XX [CPF].
 * 
 * @param {string} cpf - O número de CPF a ser formatado.
 * @returns {string}   - O CPF formatado.
 *
 * @example
 * formatarCPF('12345678900'); // Retorna '123.456.789-00'
 */
function formatarCPF(cpf) {

    // Remove todos os caracteres não numéricos
    const numeros = cpf.replace(/\D/g, '');
  
    // Aplica a formatação usando regex
    return numeros.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
}




/**
 * Formata um número passado para o formato XX.XXX.XXX/XXXX-XX [CNPJ].
 * 
 * @param {string} cnpj - O número de CNPJ a ser formatado.
 * @returns {string}    - O CNPJ formatado.
 *
 * @example
 * formatarCNPJ('12345678000190'); // Retorna '12.345.678/0001-90'
 */
function formatarCNPJ(cnpj){

    // Remove todos os caracteres não numéricos
    const numeros = cnpj.replace(/\D/g, '');
    
    // Aplica a formatação usando Regex
    return numeros.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
} 




/**
 * Formata um número passado para algum dos seguintes formatos
 * dependendo da quantidade de caracteres:
 * -> tamanho:10; (XX) XXXX-XXXX
 * -> tamanho:8;  XXXX-XXXX
 * -> tamanho:11 + telefone inicia com '0800'; 0800 123 456
 * -> tamanho:11; (XX) X XXXX-XXXX
 * 
 * - Caso não esteja em nenhum desses tamanhos, são retornados apenas os números do telefone passado
 * 
 * @param   {string} telefone - O número de telefone a ser formatado.
 * @returns {string}          - O telefone formatado.
 *
 * @example
 * formatarTelefone('0123456789');  // Retorna '(01) 2345-6789'
 * formatarTelefone('12345678');    // Retorna '1234-5678'
 * formatarTelefone('08001234567'); // Retorna '0800 123 4567'
 * formatarTelefone('01234567890'); // Retorna '(01) 2 3456-7890'
 * formatarTelefone('01234');       // Retorna '01234'
 * 
 */
function formatarTelefone(telefone){
    telefone = telefone.replace(/\D/g, "");

    if(telefone.length == 10) return formatarTelefoneFixo(telefone);
    if(telefone.length == 8) return formatarTelUnic400X(telefone);
    if(telefone.substring(0,4) == "0800"){
        let numeroFormatado = formatarTel0800(telefone);
        if(numeroFormatado.length == 13) return numeroFormatado;
        return formatarTelComum(telefone.substring(0,11));
    }

    if(telefone.length == 11) return formatarTelComum(telefone) ;
    

    return telefone;
}




/**
 * Formata um número de telefone fixo para o formato (XX) XXXX-XXXX.
 * @param {string} telefone - O número de telefone fixo a ser formatado.
 * @returns {string} - O telefone fixo formatado.
 *
 * @example
 * formatarTelefoneFixo('1123456789'); // Retorna '(11) 2345-6789'
 */
function formatarTelefoneFixo(telefone){
    return telefone.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3");
}




/**
 * Formata um número de telefone único 400x para o formato XXXX-XXXX.
 * @param {string} telefone - O número de telefone único 400x a ser formatado.
 * @returns {string} - O telefone único 400x formatado.
 *
 * @example
 * formatarTelUnic400X('12345678'); // Retorna '1234-5678'
 */
function formatarTelUnic400X(telefone){
    return telefone.replace(/^(\d{4})(\d{4})$/, "$1-$2");
}




/**
 * Formata um número de telefone 0800 para o formato XXXX XXX XXXX.
 * @param {string} telefone - O número de telefone 0800 a ser formatado.
 * @returns {string} - O telefone 0800 formatado.
 *
 * @example
 * formatarTel0800('08001234567'); // Retorna '0800 123 456'
 */
function formatarTel0800(telefone){
    return telefone.replace(/^(\d{4})(\d{3})(\d{4})$/, "$1 $2 $3");
}




/**
 * Formata um número de telefone comum para o formato (XX) X XXXX-XXXX.
 * @param {string} telefone - O número de telefone comum a ser formatado.
 * @returns {string} - O telefone comum formatado.
 *
 * @example
 * formatarTelComum('11987654321'); // Retorna '(11) 9 8765-4321'
 */
function formatarTelComum(telefone){
    return telefone.replace(/^(\d{2})(\d{1})(\d{4})(\d{4})$/, "($1) $2 $3-$4");
}




/**
 * Formata um número de CEP para o formato XXXXX-XXX.
 * @param {string} cep - O número de CEP a ser formatado.
 * @returns {string} - O CEP formatado.
 *
 * @example
 * formatarCEP('12345678'); // Retorna '12345-678'
 */
function formatarCEP(cep){
    cep = cep.replace(/\D/, "");
    return cep.replace(/^(\d{5})(\d{3})$/, "$1-$2");
}





/**
 * Formata uma determinada quantidade para que só aceite números. 
 * Retorna 0 caso a quantidade esteja vazia.
 * @param   {string} quantidade - A quantidade que será formatada.
 * @returns {string} - A quantidade formatada só com números.
 *
 * @example
 * formatarQuantidade('12e'); // Retorna '12'
 * formatarQuantidade('012'); // Retorna '12'
 * 
 */
function formatarQuantidade(quantidade){
    // Deixar somente números
    quantidade = quantidade.replace(/\D/, "");

    // Se não houver nada
    if(quantidade == '') return 0;

    // Passar para int (tirar possíveis '0' no início)
    quantidade = parseInt(quantidade);

    // Se for o valor for maior que o máximo permitido, o valor irá se alterar para o máximo.
    if(quantidade > 999999) return 999999;

    return quantidade;
}



/**
 * Configura o preço em um campo de input.
 * 
 * @param {HTMLInputElement} input - O campo de input que contém o preço.
 * 
 * @returns {void}
 *
 */
function configurarPreco(input){

    // Se não houver valor inserido, definir como '0.00'
    if (input.value == ""){ input.value = "0.00"; }

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