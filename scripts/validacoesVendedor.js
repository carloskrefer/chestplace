function validarFormulario(){
    let valido = validarNomeEstabelecimento() &&
                 validarCpfCnpj() && 
                 validarEmailContato() &&
                 validarTelefoneContato() &&
                 validarCep() &&
                 validarRua() && 
                 validarBairro() &&
                 validarComplemento();

    return valido;
}

function validarNomeEstabelecimento(){
    const nomeEstabelecimento = $("#nomeEstabelecimento").val().replace(" ", "");

    let nomePequeno = nomeEstabelecimento.length < 2;
    let nomeSoComNumeros = /^\d+$/.test(nomeEstabelecimento)

    if(nomePequeno){
        exibirPopUpErro($("nomeEstabelecimento"), "Nome inválido! O nome do estabelecimento deve conter ao menos dois caracteres.")
        return false;
    }   
    if(nomeSoComNumeros){
        exibirPopUpErro($("nomeEstabelecimento"), "Nome inválido!")
        return false;
    }
    return true;
}

function validarCpfCnpj(){
    let cpfCnpj = $("cpfCnpj");
    let cpfCnpjNumerico = cpfCnpj.val().replace(/\D/g, '');

    // Validacoes CPF
    let cpfTamanhoErrado = cpfCnpjNumerico.length !== 11;
    let cpfInvalido = validarCPF(cpfCnpj);

    // Validacoes CNPJ
    let cnpjTamanhoErrado = cpfCnpjNumerico.length !== 14

    if(pessoaFisica){

        if(cpfTamanhoErrado){
            exibirPopUpErro(cpfCnpj, "CPF inválido! O CPF deve conter 11 dígitos.")
            return false;
        }

        if(cpfInvalido){
            exibirPopUpErro(cpfCnpj, "CPF inválido! O CPF inserido é inválido. Confira os dados informados e tente novamente.")
            return false;
        }

        return true;
    }

    if(cnpjTamanhoErrado){
        exibirPopUpErro(cpfCnpj, "CNPJ inválido! O CNPJ deve conter 14 dígitos.");
        return false;
    }
}

function validarEmailContato(){
    // Expressão regular para validação de email
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    // Verifica se o email corresponde à expressão regular
    let emailValido = regexEmail.test($("#emailContato").val())

    if(!emailValido){
        exibirPopUpErro($("#emailContato"), "Email inválido! Por favor, insira um email válido.")
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
    if(telefoneNumerico > 11){
        exibirPopUpErro(telefone,"Número de telefone inválido! O número deve conter no máximo 11 dígitos.")
        return false;
    }

    if(!telFixo && !telUnic400X && !telComumOu0800){
        exibirPopUpErro(telefone,"Número de telefone inválido! Por favor, insira um telefone em algum dos seguintes formatos: [ (99) 9 9999-9999 | (99) 9999-9999 | 9999-9999 | 9999 999 9999] ")
        return false;
    }

    return true;
}

function validarCEP(){
    let cep = $("#cep");
    let cepNumerico = cep.replace(/\D/g, '');

    if(cepNumerico.length !== 8){
        exibirPopUpErro(cep, "CEP inválido! O CEP deve conter 8 dígitos.")
        return false;
    }

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

    return true;
}

function validarComplemento(){
    let complemento = $("#complemento").val();

    if(complemento.length > 255){
        exibirPopUpErro($("#complemento"), "Complemento inválido! O nome do complemento não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

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
    campoInpt.setCustomValidity(mensagem);
    campoInpt.validity.valid = false;
    campoInpt.reportValidity();
    campoInpt.focus();
}