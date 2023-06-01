/**
 * Função chamada pelo enviarFormulario(), no 'script_cadComprador.js'.
 * 
 * @param {boolean} isFormularioDeCadastro - True se é o formulário de cadastro do comprador (form_cadComprador.php).
 *                                           False se é o formulário de alteração de cadastro do comprador (form_alterComprador.php). 
 * @returns {boolean} - True se o formulário está válido.
 *                      False se o formulário está inválido.
 */
function validarFormulario(isFormularioDeCadastro){
    let valido = false;
    valido =    validarCpf() && 
                validarTelefoneContato() &&
                validarCEP($('#cepFaturamento')) &&
                validarRua($('#ruaFaturamento')) && 
                validarNumero($('#numeroFaturamento')) && 
                validarBairro($('#bairroFaturamento')) &&
                validarComplemento($('#complementoFaturamento')) &&
                validarCidade($('#cidadeFaturamento'));
    // Se o endereço de entrega não é o mesmo que o endereço de faturamento, 
    // então significa que o usuário deverá preencher também o endereço de entrega, que deve ser validado. 
    if (!$('#checkboxEnderecoEntrega').is(':checked')) {
        valido =    valido &&
                    validarCEP($('#cepEntrega')) &&
                    validarRua($('#ruaEntrega')) && 
                    validarNumero($('#numeroEntrega')) && 
                    validarBairro($('#bairroEntrega')) &&
                    validarComplemento($('#complementoEntrega')) &&
                    validarCidade($('#cidadeEntrega'));
    }    
    novaSenhaPreenchida = $('#senha').val() != "";
    // Caso seja formulário de cadastro, verificações de emailLogin e senha adicionados (são campos que terão que ser preenchidos)
    if (isFormularioDeCadastro) {
        valido =    valido &&
                    validarEmail() &&
                    validarSenha();
    // Caso seja formulário de alteração, validar senha somente se o usuário preencheu uma nova senha (se usuário deixou ela em branco,
    // significa que ele quer manter a senha antiga - neste caso não deverá ocorrer validação dela).
    } else if (novaSenhaPreenchida) {
        valido =    valido &&
                    validarSenha();
    }
    return valido;
}



/**
 * Verifica se o CPF inserido no input '#cpf' é válido.
 * 
 * @requires JQuery
 * 
 * @returns {boolean} - **TRUE** caso seja válido | **FALSE** caso seja inválido
 */
function validarCpf(){
    let cpfNumerico = $("#cpf").val().replace(/\D/g, '');
    let cpfTamanhoErrado = cpfNumerico.length !== 11;
    let cpfInvalido = !validarDigitoVerificadorCPF(cpfNumerico);
    if (cpfTamanhoErrado) {
        exibirPopUpErro($("#cpf"), "CPF inválido! O CPF deve conter 11 dígitos.");
        return false;
    } else if (cpfInvalido) {
        exibirPopUpErro($("#cpf"), "CPF inválido! O CPF inserido é inválido. Confira os dados informados e tente novamente.");
        return false;
    } else {
        // Desfaz propriedades de erro de validação (necessário caso anteriormente foi chamado 'exibirPopUpErro()')
        $("#cpf").get(0).validity.valid = true;
        $("#cpf").get(0).setCustomValidity(""); // Remove mensagem de erro de validação
        return true;
    }
}



/**
 * Verifica se o valor do campo email passado é válido. Caso não seja, o campo 'emailInpt' será focado e notificado.
 * Para verificar se é válido, as seguintes verificações são feitas:
 * - EMAIL possui '@'                       EX: "joaogmail.com" => FALSE | "joao@gmail.com" => TRUE;
 * - EMAIL possui caracteres antes do '@'   EX: "@gmail.com"    => FALSE | "joao@gmail.com" => TRUE;
 * - EMAIL possui caracteres depois do '@'  EX: "joao@"         => FALSE | "joao@gmail.com" => TRUE;
 * - EMAIL possui '.' após nome do domínio  EX: "joao@gmail"    => FALSE | "joao@gmail.com" => TRUE;
 * 
 * @requires JQuery
 *  
 * @returns {boolean} - TRUE caso seja válido | FALSE caso seja inválido
 * 
 * @example
 * // Exemplo de uso
 * const emailValido = validarEmail();
 * console.log(emailValido); // Saída: true ou false
 * 
 */
function validarEmail(){
    emailInpt = $('#emailLogin');
    // Expressão regular para validação de email
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    // Verifica se o email corresponde à expressão regular
    let emailValido = regexEmail.test(emailInpt.val())

    if(!emailValido){
        exibirPopUpErro(emailInpt, "Email inválido! Por favor, insira um email válido.")
    } else{
        emailInpt.get(0).validity.valid = true;
        emailInpt.get(0).setCustomValidity("");
    }

    return emailValido;
}




/**
 * Verifica se o telefone de contato inserido no input '#telefoneContato' é válido.
 * Para verificar se é válido, as seguintes verificações são feitas:
 * - Número de telefone com menos de 8 dígitos EX: "1234567" => FALSE | "12345678" => TRUE
 * - Número de telefone com mais de 11 dígitos EX: "123456789012" => FALSE | "12345678901" => TRUE
 * - Número de telefone que não se encaixa nos padrões de telefone fixo, 400X, comum ou 0800
 *   EX: "1111111111" => FALSE | "111111111" => TRUE
 * 
 * @requires JQuery
 *  
 * @returns {boolean} - TRUE caso seja válido | FALSE caso seja inválido
 *
 * @example
 * // Exemplo de uso
 * const telefoneContatoValido = validarTelefoneContato();
 * console.log(telefoneContatoValido); // Saída: true ou false
 * 
 */
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




/**
 * Verifica se o CEP é válido.
 * Para verificar se é válido, as seguintes verificações são feitas:
 * - O CEP deve conter exatamente 8 dígitos.
 * - Realiza uma chamada à API do ViaCEP para verificar se o CEP é válido.
 * 
 * @requires JQuery
 * 
 * @param {JQuery.Object} objetoJQueryCEP- Objeto JQuery referenciando o elemento HTML do CEP a ser validado
 *  
 * @returns {boolean} - TRUE caso seja válido | FALSE caso seja inválido
 *
 * @example
 * // Exemplo de uso
 * const cepValido = validarCEP($('#cepFaturamento'));
 * console.log(cepValido); // Saída: true ou false
 */
function validarCEP(objetoJQueryCEP){
    let cep = objetoJQueryCEP;
    let cepNumerico = cep.val().replace(/\D/g, '');
    let valido = true;
    
    if(cepNumerico.length !== 8){
        exibirPopUpErro(cep, "CEP inválido! O CEP deve conter 8 dígitos.")
        valido = false;
    }

    $.getJSON("https://viacep.com.br/ws/"+ cepNumerico +"/json/?callback=?", function(dados) {
        if (("erro" in dados)) {
            exibirPopUpErro(cep, "CEP inválido! O CEP deve conter 8 dígitos.");
            valido = false;
        }
    });

    if(valido){
        cep.get(0).validity.valid = true;
        cep.get(0).setCustomValidity("");
    }

    return valido;
}




/**
 * Verifica se o nome da rua inserido no input '#rua' é válido.
 * Para verificar se é válido, as seguintes verificações são feitas:
 * - O nome da rua deve conter pelo menos um caractere.
 * - O nome da rua não deve ultrapassar o limite de 255 caracteres.
 * 
 * @requires JQuery
 * 
 * @param {JQuery.Object} objetoJQueryRua - Objeto JQuery referenciando o elemento HTML da rua a ser validado
 *  
 * @returns {boolean} - TRUE caso seja válido | FALSE caso seja inválido
 *
 * @example
 * // Exemplo de uso
 * const ruaValida = validarRua();
 * console.log(ruaValida); // Saída: true ou false
 * 
 */
function validarRua(objetoJQueryRua){
    let rua = objetoJQueryRua;

    if(rua.val().replace(" ", "").length < 1){
        exibirPopUpErro(rua, "Rua inválida! O nome da rua deve conter no mínimo um caractere.")
        return false;
    }

    if(rua.val().length > 255){
        exibirPopUpErro(rua, "Rua inválida! O nome da rua não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    rua.get(0).validity.valid = true;
    rua.get(0).setCustomValidity("");
    return true;
}




/**
 * Verifica se o número do endereço inserido é válido.
 * Para verificar se é válido, as seguintes verificações são feitas:
 * - Caso o endereço não possua número, o valor "s/n" é aceito.
 * - O número do endereço não deve ultrapassar o limite de 255 caracteres.
 * 
 * @requires JQuery
 * 
 * @param {JQuery.Object} objetoJQueryNumero - Objeto JQuery referenciando o elemento HTML do número do endereço a ser validado 
 * 
 * @returns {boolean} - TRUE caso seja válido | FALSE caso seja inválido
 *
 * @example
 * // Exemplo de uso
 * const numeroValido = validarNumero($('#numeroFaturamento'));
 * console.log(numeroValido); // Saída: true ou false
 * 
 */
function validarNumero(objetoJQueryNumero){
    let numero = objetoJQueryNumero;

    if(numero.val().replace(" ", "").length < 1){
        exibirPopUpErro(numero, "Número inválido! Caso seu endereço não possua número, insira s/n")
        return false;
    }

    if(numero.val().length > 255){
        exibirPopUpErro(numero, "Número inválido! O número do seu endereço não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    numero.get(0).validity.valid = true;
    numero.get(0).setCustomValidity("");
    return true;
}




/**
 * Verifica se o nome do bairro inserido é válido.
 * Para verificar se é válido, as seguintes verificações são feitas:
 * - O nome do bairro deve conter pelo menos um caractere.
 * - O nome do bairro não deve ultrapassar o limite de 255 caracteres.
 * 
 * @requires JQuery
 * 
 * @param {JQuery.Object} objetoJQueryBairro - Objeto JQuery referenciando o elemento HTML do bairro a ser validado 
 *  
 * @returns {boolean} - TRUE caso seja válido | FALSE caso seja inválido
 *
 * @example
 * // Exemplo de uso
 * const bairroValido = validarBairro($('#bairroFaturamento'));
 * console.log(bairroValido); // Saída: true ou false
 * 
 */
function validarBairro(objetoJQueryBairro){
    let bairro = objetoJQueryBairro;

    if(bairro.val().replace(" ", "").length < 1){
        exibirPopUpErro(bairro, "Bairro inválido! O nome do bairro deve conter no mínimo um caractere.")
        return false;
    }

    if(bairro.val().length > 255){
        exibirPopUpErro(bairro, "Bairro inválido! O nome do bairro não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    bairro.get(0).validity.valid = true;
    bairro.get(0).setCustomValidity("");
    return true;
}




/**
 * Verifica se o complemento do endereço é válido.
 * Para verificar se é válido, a seguinte verificação é feita:
 * - O complemento do endereço não deve ultrapassar o limite de 255 caracteres.
 * 
 * @requires JQuery
 *  
 * @param {JQuery.Object} objetoJQueryComplemento - Objeto JQuery referenciando o elemento HTML do complemento do endereço a ser validado 
 * 
 * @returns {boolean} - TRUE caso seja válido | FALSE caso seja inválido
 *
 * @example
 * // Exemplo de uso
 * const complementoValido = validarComplemento($('#complementoFaturamento'));
 * console.log(complementoValido); // Saída: true ou false
 */
function validarComplemento(objetoJQueryComplemento){
    let complemento = objetoJQueryComplemento;

    if(complemento.val().length > 255){
        exibirPopUpErro(complemento, "Complemento inválido! O nome do complemento não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    complemento.get(0).validity.valid = true;
    complemento.get(0).setCustomValidity("");
    return true;
}




/**
 * Verifica se o nome da cidade é válida.
 * Para verificar se é válido, a seguinte verificação é feita:
 * - O nome da cidade não deve ultrapassar o limite de 255 caracteres.
 * 
 * @requires JQuery
 * 
 * @param {JQuery.Object} objetoJQueryCidade - Objeto JQuery referenciando o elemento HTML da cidade do endereço a ser validado 
 * 
 * @returns {boolean} - TRUE caso seja válido | FALSE caso seja inválido
 *
 * @example
 * // Exemplo de uso
 * const cidadeValida = validarCidade($('#cidadeFaturamento'));
 * console.log(cidadeValida); // Saída: true ou false
 * 
 */
function validarCidade(objetoJQueryCidade){
    let cidade = objetoJQueryCidade;

    if(cidade.val().length > 255){
        exibirPopUpErro(cidade, "Cidade inválida! O nome da cidade não deve ultrapassar o limite de 255 caracteres.")
        return false;
    }

    cidade.get(0).validity.valid = true;
    cidade.get(0).setCustomValidity("");
    return true;
}




/**
 * Verifica se a senha inserida no input '#senha' é válida.
 * Para verificar se é válida, as seguintes verificações são feitas:
 * - A senha deve conter pelo menos 8 caracteres.
 * - A senha não deve ultrapassar o limite de 255 caracteres.
 * - A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula, um caractere especial e um número.
 * - As senhas digitadas nos campos '#senha' e '#confirmacaoSenha' devem ser iguais.
 * 
 * @requires JQuery
 *  
 * @returns {boolean} - TRUE caso seja válida | FALSE caso seja inválida
 *
 * @example
 * // Exemplo de uso
 * const senhaValida = validarSenha();
 * console.log(senhaValida); // Saída: true ou false
 * 
 */
function validarSenha(){
    /*
    * Senha deve conter (no mínimo)
    * 1x letra maiúscula, 
    * 1x letra minúscula,
    * 1x caracter especial [!-@-#-$-%-^-&-*-(-)---_-+-=-{-}-[-]-|-\-/-:-;-.-,->-<-?]
    */
    const regexSenha = /^(?=.*[!@#$%^&*()\-_=+{}[\]|\\:;.,<>?])(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/;

    let senhasDiferentes  = $("#senha").val() !== $("#confirmacaoSenha").val();
    let senhaMuitoPequena = $("#senha").val().length < 8;
    let senhaMuitoGrande  = $("#senha").val().length > 255;
    let senhaFraca = !regexSenha.test($("#senha").val());

    if(senhasDiferentes){
        exibirPopUpErro($("#senha"),"As senhas não são iguais.");
        return false;
    }
    if(senhaMuitoPequena){
        exibirPopUpErro($("#senha"),"A senha deve conter pelo menos 8 caracteres.");
        return false;
    }
    if(senhaMuitoGrande){
        exibirPopUpErro($("#senha"),"A senha deve conter no mínimo 255 caracteres.");
        return false;
    }
    if(senhaFraca){
        exibirPopUpErro($("#senha"),"A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula, um caractere especial e um número.");
        return false;
    }

    $("#senha").get(0).validity.valid = true;
    return true;

}




/**
 * Verifica a validade de um CPF.
 * @param {string} cpf - O CPF a ser verificado.
 * @returns {boolean} - True se o CPF for válido, false caso contrário.
 */
function validarDigitoVerificadorCPF(cpf) {
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
 * Verifica a validade de um CNPJ.
 * @param {string} cnpj - O CNPJ a ser verificado.
 * @returns {boolean} - True se o CNPJ for válido, false caso contrário.
 */
function validarDigitoVerificadorCNPJ(cnpj) {
    if (!cnpj) return false

    // Aceita receber o valor como string, número ou array com todos os dígitos
    const isString = typeof cnpj === 'string'
    const validTypes = isString || Number.isInteger(cnpj) || Array.isArray(cnpj)
  
    // Elimina valor de tipo inválido
    if (!validTypes) return false
  
    // Filtro inicial para entradas do tipo string
    if (isString) {
      // Limita ao mínimo de 14 caracteres, válido para apenas dígitos
      // Limita ao máximo de 18 caracteres, válido para CNPJ formatado
      // Se passar dos limites, retorna inválido
      if (cnpj.length < 14 || cnpj.length > 18) return false
  
      // Teste Regex para veificar se é uma string apenas dígitos válida
      const digitsOnly = /^\d{14}$/.test(cnpj)
      // Teste Regex para verificar se é uma string formatada válida
      const validFormat = /^\d{2}.\d{3}.\d{3}\/\d{4}-\d{2}$/.test(cnpj)
      // Verifica se o valor passou em ao menos 1 dos testes
      const isValid = digitsOnly || validFormat
  
      // Se o formato não é válido, retorna inválido
      if (!isValid) return false
    }
  
    // Guarda um array com todos os dígitos do valor
    const match = cnpj.toString().match(/\d/g)
    const numbers = Array.isArray(match) ? match.map(Number) : []
  
    // Valida a quantidade de dígitos
    if (numbers.length !== 14) return false
    
    // Elimina inválidos com todos os dígitos iguais
    const items = [...new Set(numbers)]
    if (items.length === 1) return false
  
    // Cálculo validador
    const calc = (x) => {
      const slice = numbers.slice(0, x)
      let factor = x - 7
      let sum = 0
  
      for (let i = x; i >= 1; i--) {
        const n = slice[x - i]
        sum += n * factor--
        if (factor < 2) factor = 9
      }
  
      const result = 11 - (sum % 11)
  
      return result > 9 ? 0 : result
    }
  
    // Separa os 2 últimos dígitos de verificadores
    const digits = numbers.slice(12)
    
    // Valida 1o. dígito verificador
    const digit0 = calc(12)
    if (digit0 !== digits[0]) return false
  
    // Valida 2o. dígito verificador
    const digit1 = calc(13)
    return digit1 === digits[1]
}




/**
 * Exibe uma mensagem de erro personalizada em um campo de formulário.
 * 
 * @requires JQuery
 * 
 * @param {HTMLInputElement} campoInpt - O campo de entrada em que a mensagem de erro será exibida.
 * @param {string} mensagem - A mensagem de erro a ser exibida.
 */
function exibirPopUpErro(campoInpt, mensagem){
    campoInpt = $(campoInpt)[0];
    campoInpt.setCustomValidity(mensagem);
    campoInpt.validity.valid = false;
    campoInpt.reportValidity();
}
