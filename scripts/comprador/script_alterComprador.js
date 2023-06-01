/**
 * Função executada quando o formulário #alterCompradorForm está pronto.
 * Realiza a inicialização e atribuição de eventos aos elementos do formulário.
 *
 * Ações realizadas:
 * - Oculta o campo estadoFaturamentoSelect e estadoEntregaSelect.
 * - Atribui um evento de mudança ao checkbox mostrarSenha.
 * - Atribui um evento de mudança ao checkbox enderecoEntregaIdentico
 * - Atribui um evento blur ao campo cep para consulta de endereço.
 * - Formata os campos do formulário.
 * - Limita o tamanho dos campos do formulário.
 */
$("#cadCompradorForm").ready(function() { 
    $("#estadoFaturamentoSelect").hide();
    $("#estadoEntregaSelect").hide();
    $("#mostrarSenha").change(() => mostrarSenha());
    $("#checkboxEnderecoEntrega").change(() => mostrarCamposEnderecoEntrega());
    $("#cepFaturamento").blur(function() {
        // Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');  
        //Verifica se campo cep possui valor informado.
        if(cep !== ""){
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                $("#ruaFaturamento").val("...");
                $("#bairroFaturamento").val("...");
                $("#displayCidadeFaturamento").val("...");
                $("#displayEstadoFaturamentoSelect").val("...");
                //Consulta o webservice viacep.com.br/
                $("#salvar").prop("disabled", true);
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#ruaFaturamento").val(dados.logradouro);
                        $("#bairroFaturamento").val(dados.bairro);
                        $("#displayCidadeFaturamento").val(dados.localidade);
                        $("#cidadeFaturamento").val(dados.localidade);
                        $("#displayEstadoFaturamentoSelect").val(dados.uf);
                        $("#estadoFaturamentoSelect").val(dados.uf);
                        $("#salvar").prop("disabled", false);
                    } else {
                        //CEP pesquisado não foi encontrado.
                        $("#ruaFaturamento").val('');
                        $("#bairroFaturamento").val('');
                        $("#displayCidadeFaturamento").val('');
                        $("#cidadeFaturamento").val('');
                        $("#displayEstadoFaturamentoSelect").val('');
                        $("#estadoFaturamentoSelect").val('');
                        exibirPopUpErro($("#cepFaturamento"),"CEP não encontrado.");
                        $("#cepFaturamento").focus();
                        $("#salvar").prop("disabled", false);
                    }
                });
            }
            else {
                // cep é inválido
                exibirPopUpErro($("#cepFaturamento"),"CEP inválido.");
                $("#cepFaturamento").focus();
            }
        }
    });
    $("#cepEntrega").blur(function() {
        // Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');  
        //Verifica se campo cep possui valor informado.
        if(cep !== ""){
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                $("#ruaEntrega").val("...");
                $("#bairroEntrega").val("...");
                $("#displayCidadeEntrega").val("...");
                $("#displayEstadoEntregaSelect").val("...");
                //Consulta o webservice viacep.com.br/
                $("#salvar").prop("disabled", true);
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#ruaEntrega").val(dados.logradouro);
                        $("#bairroEntrega").val(dados.bairro);
                        $("#displayCidadeEntrega").val(dados.localidade);
                        $("#cidadeEntrega").val(dados.localidade);
                        $("#displayEstadoEntregaSelect").val(dados.uf);
                        $("#estadoEntregaSelect").val(dados.uf);
                        $("#salvar").prop("disabled", false);
                    } else {
                        //CEP pesquisado não foi encontrado.
                        $("#ruaEntrega").val('');
                        $("#bairroEntrega").val('');
                        $("#displayCidadeEntrega").val('');
                        $("#cidadeEntrega").val('');
                        $("#displayEstadoEntregaSelect").val('');
                        $("#estadoEntregaSelect").val('');
                        exibirPopUpErro($("#cepEntrega"),"CEP não encontrado.");
                        $("#cepEntrega").focus();
                        $("#salvar").prop("disabled", false);
                    }
                });
            }
            else {
                // cep é inválido
                exibirPopUpErro($("#cepEntrega"),"CEP inválido.");
                $("#cepEntrega").focus();
            }
        }
    });
    formatarCampos();
    limitarCampos();
})



/**
 * Envia o formulário se ele for válido.
 * Primeiro, realiza a validação do formulário usando a função "validarFormulario(false)".
 * Se o formulário for válido, o envio é realizado utilizando o método "submit()" do formulário com o ID "cadVendedorForm".
 * 
 * @requires jQuery
 * @requires validarFormulario
 */
function enviarFormulario(){
    if(validarFormulario(false)) $("#alterCompradorForm").submit();
}



/**
 * Limita o tamanho máximo dos campos de entrada.
 * Define o atributo "maxlength" nos campos correspondentes para limitar o número de caracteres.
 * 
 * @requires jQuery
 */
function limitarCampos(){
    $("#emailLogin").attr("maxlength", 255)
    $("#senha").attr("maxlength", 255)
    $("#confirmacaoSenha").attr("maxlength", 255)
    $("#cpf").attr("maxlength", 14)
    $("#telefoneContato").attr("maxlength", 16)
    $("#cepFaturamento").attr("maxlength", 9)
    $("#cepEntrega").attr("maxlength", 9)
    $("#ruaFaturamento").attr("maxlength", 255)
    $("#ruaEntrega").attr("maxlength", 255)
    $("#numeroFaturamento").attr("maxlength", 10)
    $("#numeroEntrega").attr("maxlength", 10)
    $("#bairroFaturamento").attr("maxlength", 255)
    $("#bairroEntrega").attr("maxlength", 255)
    $("#cidadeFaturamento").attr("maxlength", 255)
    $("#cidadeEntrega").attr("maxlength", 255)
}



/**
 * Formata os campos de CPF, telefone de contato e CEP.
 * Dispara o evento "input" nos campos correspondentes para acionar a formatação.
 * 
 * @requires jQuery
 */
function formatarCampos(){
    $("#cpf, #telefoneContato, #cepFaturamento, #cepEntrega").trigger("input");
}



/**
 * Mostra ou oculta a senha digitada nos campos de senha e confirmação de senha.
 * A exibição da senha é controlada pelo estado do elemento de input do tipo 'checkbox' com id 'mostrarSenha'.
 * Quando o checkbox está marcado, as senhas são exibidas como texto.
 * Quando o checkbox está desmarcado, as senhas são ocultadas e exibidas como 'password'.
 * 
 * @requires HTML
 */
function mostrarSenha(){
    let mostrarSenha = document.getElementById("mostrarSenha").checked;
    let senha = document.getElementById("senha");
    let csenha = document.getElementById("confirmacaoSenha");

    if(mostrarSenha){
        senha.type = "text";
        csenha.type = "text";
        
    } else {
        senha.type = "password";
        csenha.type = "password";
    }
}



/**
 * Mostra ou oculta os campos do endereço de entrega.
 * A exibição é controlada pelo estado do elemento de input do tipo 'checkbox' com id 'checkboxEnderecoEntrega'.
 * Quando o checkbox está marcado,    os campos do endereço de entrega ficam invisíveis.
 * Quando o checkbox está desmarcado, os campos do endereço de entrega ficam visíveis.
 * 
 * @requires HTML
 */
function mostrarCamposEnderecoEntrega(){
    let mostrarCampos = document.getElementById("checkboxEnderecoEntrega").checked;
    // td = table data (é apenas um elemento utilizado para o layout da página, faz parte de uma table)
    // A tdVaziaAuxiliar preenche o campo esquerdo da tela, logo abaixo dos dados básicos de cadastro do comprador.
    // a tdEnderecoEntrega fica logo abaixo da td com o endereço de faturamento.
    // A tdVaziaAuxiliar apenas existe para que a tdEnderecoEntrega fique alinhada verticalmente com o endereço de faturamento.
    let tdVaziaAuxiliar = document.getElementById("tdVaziaAuxiliar"); 
    let tdEnderecoEntrega = document.getElementById("tdEnderecoEntrega");
    if(mostrarCampos){
        tdVaziaAuxiliar.style.display = 'none';
        tdEnderecoEntrega.style.display = 'none';
    } else {
        tdVaziaAuxiliar.style.display = 'table-cell';
        tdEnderecoEntrega.style.display = 'table-cell';
    }
}
