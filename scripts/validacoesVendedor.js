function validarFormulario(){
    let valido = validarNomeEstabelecimento() &&
                 validarCpfCnpj() && 
                 validarEmailContato() &&
                 validarTelefoneContato() &&
                 validarCEP() &&
                 validarRua() && 
                 validarNumero() && 
                 validarBairro() &&
                 validarComplemento()&&
                 validarCidade();

    return valido;
}

function validarNomeEstabelecimento(){
    const nomeEstabelecimento = $("#nomeEstabelecimento").val().replace(" ", "");

    let nomePequeno = nomeEstabelecimento.length < 2;
    let nomeSoComNumeros = /^\d+$/.test(nomeEstabelecimento)

    if(nomePequeno){
        exibirPopUpErro($("#nomeEstabelecimento"), "Nome inválido! O nome do estabelecimento deve conter ao menos dois caracteres.")
        return false;
    }   
    if(nomeSoComNumeros){
        exibirPopUpErro($("#nomeEstabelecimento"), "Nome inválido!")
        return false;
    }
    
    $("#nomeEstabelecimento")[0].validity.valid = true;
    $("#nomeEstabelecimento")[0].setCustomValidity("");
    return true;
}

function validarCpfCnpj(){
    let cpfCnpj = $("#cpfCnpj");
    let cpfCnpjNumerico = cpfCnpj.val().replace(/\D/g, '');

    // Validacoes CPF
    let cpfTamanhoErrado = cpfCnpjNumerico.length !== 11;
    let cpfNumsIguais =  (/^(\d)\1+$/.test(cpfCnpjNumerico));
    let cpfInvalido = !validarCPF(cpfCnpjNumerico);

    // Validacoes CNPJ
    let cnpjTamanhoErrado = cpfCnpjNumerico.length !== 14

    if(pessoaFisica){

        if(cpfTamanhoErrado){
            exibirPopUpErro(cpfCnpj, "CPF inválido! O CPF deve conter 11 dígitos.")
            return false;
        }

        if(cpfInvalido || cpfNumsIguais){
            exibirPopUpErro(cpfCnpj, "CPF inválido! O CPF inserido é inválido. Confira os dados informados e tente novamente.")
            return false;
        }

        cpfCnpj.get(0).validity.valid = true;
        cpfCnpj.get(0).setCustomValidity("");
        return true;
    }

    if(cnpjTamanhoErrado){
        exibirPopUpErro(cpfCnpj, "CNPJ inválido! O CNPJ deve conter 14 dígitos.");
        return false;
    }

    cpfCnpj.get(0).validity.valid = true;
    cpfCnpj.get(0).setCustomValidity("");
    return true;
}

function validarEmailContato(){
    // Expressão regular para validação de email
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    // Verifica se o email corresponde à expressão regular
    let emailValido = regexEmail.test($("#emailContato").val())

    if(!emailValido){
        exibirPopUpErro($("#emailContato"), "Email inválido! Por favor, insira um email válido.")
    } else{
        $("#emailContato").get(0).validity.valid = true;
        $("#emailContato").get(0).setCustomValidity("");
    }

    return emailValido;
}

function validarTelefoneContato(){
    let telefone = $("#telefoneContato");
    let telefoneNumerico = telefone.val().replace(/\D/g, '');

    let telFixo = telefoneNumerico.length == 10;
    let telUnic400X = telefoneNumerico.length == 8;
    let telComumOu0800 = telefoneNumerico.length == 11;

    // 4004
    if(telefoneNumerico.length < 8){
        exibirPopUpErro(telefone,"Número de telefone inválido! O número deve conter pelo menos 8 dígitos.");
        return false;
    }

    // 0800/comum
    if(telefoneNumerico.length > 11){
        exibirPopUpErro(telefone,"Número de telefone inválido! O número deve conter no máximo 11 dígitos.")
        return false;
    }

    if(!telFixo && !telUnic400X && !telComumOu0800){
        exibirPopUpErro(telefone,"Número de telefone inválido! Por favor, insira um telefone em algum dos seguintes formatos: [ (11) 1 1111-1111 | (22) 2222-2222 | 3333-3333 | 4444 444 4444] ")
        return false;
    }

    telefone.get(0).validity.valid = true;
    telefone.get(0).setCustomValidity("");
    return true;
}

function validarCEP(){
    let cep = $("#cep");
    let cepNumerico = cep.val().replace(/\D/g, '');

    $.getJSON("https://viacep.com.br/ws/"+ cepNumerico +"/json/?callback=?", function(dados) {
    
                    if (("erro" in dados)) {
                        exibirPopUpErro(cep, "CEP inválido! O CEP deve conter 8 dígitos.")
                    }
                }
            );

    if(cepNumerico.length !== 8){
        exibirPopUpErro(cep, "CEP inválido! O CEP deve conter 8 dígitos.")
        return false;
    }

    cep.get(0).validity.valid = true;
    cep.get(0).setCustomValidity("");
    return true;
}

function validarRua(){
    let rua = $("#rua").val();

    if(rua.replace(" ", "").length < 1){
        exibirPopUpErro($("#rua"), "Rua inválida! O nome da rua deve conter no mínimo um caractere.")
        return false;
    }

    if(rua.length > 255){
        exibirPopUpErro($("#rua"), "Rua inválida! O nome da rua não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    $("#rua").get(0).validity.valid = true;
    $("#rua").get(0).setCustomValidity("");
    return true;
}

function validarNumero(){
    let numero = $("#numero").val();

    if(numero.replace(" ", "").length < 1){
        exibirPopUpErro($("#numero"), "Número inválido! Caso seu endereço não possua número, insira s/n")
        return false;
    }

    if(numero.length > 255){
        exibirPopUpErro($("#numero"), "Número inválido! O número do seu endereço não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    $("#rua").get(0).validity.valid = true;
    $("#rua").get(0).setCustomValidity("");
    return true;
}

function validarBairro(){
    let bairro = $("#bairro").val();

    if(bairro.replace(" ", "").length < 1){
        exibirPopUpErro($("#bairro"), "Bairro inválido! O nome do bairro deve conter no mínimo um caractere.")
        return false;
    }

    if(bairro.length > 255){
        exibirPopUpErro($("#bairro"), "Bairro inválido! O nome do bairro não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    $("#bairro").get(0).validity.valid = true;
    $("#bairro").get(0).setCustomValidity("");
    return true;
}

function validarComplemento(){
    let complemento = $("#complemento").val();

    if(complemento.length > 255){
        exibirPopUpErro($("#complemento"), "Complemento inválido! O nome do complemento não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    $("#complemento").get(0).validity.valid = true;
    $("#complemento").get(0).setCustomValidity("");
    return true;
}

function validarCidade(){
    let cidade = $("#cidade").val();

    if(cidade.length > 255){
        exibirPopUpErro($("#cidade"), "Cidade inválida! O nome da cidade não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    $("#cidade").get(0).validity.valid = true;
    $("#cidade").get(0).setCustomValidity("");
    return true;
}

/**
 * Verifica a validade de um CPF.
 * @param {string} cpf - O CPF a ser verificado.
 * @returns {boolean} - True se o CPF for válido, false caso contrário.
 */
function validarCPF(cpf) {
    // Converte o CPF em um array de números
    const numeros = cpf.split('').map(Number);
  
    // Cálculo do primeiro dígito verificador
    let soma = 0;
    for (let i = 0; i < 9; i++) {
      soma += numeros[i] * (10 - i);
    }
    let digito1 = 11 - (soma % 11);
    if (digito1 === 10 || digito1 === 11) {
      digito1 = 0;
    }
    if (digito1 !== numeros[9]) {
      return false;
    }
  
    // Cálculo do segundo dígito verificador
    soma = 0;
    for (let i = 0; i < 10; i++) {
      soma += numeros[i] * (11 - i);
    }
    let digito2 = 11 - (soma % 11);
    if (digito2 === 10 || digito2 === 11) {
      digito2 = 0;
    }
    if (digito2 !== numeros[10]) {
      return false;
    }
  
    // CPF válido
    return true;
}




/**
 * Exibe uma mensagem de erro personalizada em um campo de formulário.
 * @param {HTMLInputElement} campoInpt - O campo de entrada em que a mensagem de erro será exibida.
 * @param {string} mensagem - A mensagem de erro a ser exibida.
 */
function exibirPopUpErro(campoInpt, mensagem){
    campoInpt = $(campoInpt)[0];
    campoInpt.setCustomValidity(mensagem);
    campoInpt.validity.valid = false;
    campoInpt.reportValidity();
}
