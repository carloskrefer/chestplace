/**
 * Função executada quando o formulário #cadVendedorForm está pronto.
 * Realiza a inicialização e atribuição de eventos aos elementos do formulário.
 *
 * Ações realizadas:
 * - Oculta o campo estadoSelect.
 * - Atribui um evento de mudança ao checkbox mostrarSenha.
 * - Atribui um evento blur ao campo cep para consulta de endereço.
 * - Formata os campos do formulário.
 * - Limita o tamanho dos campos do formulário.
 */
$("#cadVendedorForm").ready(function(){
    
    $("#estadoSelect").hide();
    $("#mostrarSenha").change(() => mostrarSenha());

    $("#cep").blur(function(){
    
        // Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');
    
        //Verifica se campo cep possui valor informado.
        if(cep !== ""){
    
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
    
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
    
                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#displayCidade").val("...");
                $("#displayEstadoSelect").val("...");
    
                
                //Consulta o webservice viacep.com.br/
                $("#salvar").prop("disabled", true);

                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estadoSelect").val(dados.uf);
                        $("#displayCidade").val(dados.localidade);
                        $("#displayEstadoSelect").val(dados.uf);
                        $("#ibge").val(dados.ibge);
                        $("#salvar").prop("disabled", false);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        $("#rua").val('');
                        $("#bairro").val('');
                        $("#cidade").val('');
                        $("#estadoSelect").val('');
                        $("#displayCidade").val('');
                        $("#displayEstadoSelect").val('');
                        $("#ibge").val('');
                        exibirPopUpErro($("#cep"),"CEP não encontrado.");
                        $("#cep").focus();
                        $("#salvar").prop("disabled", false);
                    }
                });
            }
            else {
                // cep é inválido
                exibirPopUpErro($("#cep"),"CEP inválido.");
                $("#cep").focus();
            }
        }
    
    })

    formatarCampos();
    limitarCampos();
})




/**
 * Envia o formulário se ele for válido.
 * Primeiro, realiza a validação do formulário usando a função "validarFormulario(true)".
 * Se o formulário for válido, o envio é realizado utilizando o método "submit()" do formulário com o ID "cadVendedorForm".
 * 
 * @requires jQuery
 * @requires validarFormulario
 * 
 * @example
 * // Exemplo de uso
 * enviarFormulario();
 * 
 */
function enviarFormulario(){
    if(validarFormulario(true)) $("#cadVendedorForm").submit();
}




/**
 * Limita o tamanho máximo dos campos de entrada.
 * Define o atributo "maxlength" nos campos correspondentes para limitar o número de caracteres.
 * 
 * @requires jQuery
 * 
 * @example
 * // Exemplo de uso
 * limitarCampos();
 */
function limitarCampos(){
    let limiteCpfCnpj = 18;

    $("#emailLogin").attr("maxlength", 255)
    $("#senha").attr("maxlength", 255)
    $("#confirmacaoSenha").attr("maxlength", 255)
    $("#cpfCnpj").attr("maxlength", limiteCpfCnpj)
    $("#nomeEstabelecimento").attr("maxlength", 255)
    $("#emailContato").attr("maxlength", 255)
    $("#telefoneContato").attr("maxlength", 16)
    $("#cep").attr("maxlength", 9)
    $("#rua").attr("maxlength", 255)
    $("#numero").attr("maxlength", 10)
    $("#bairro").attr("maxlength", 255)
    $("#cidade").attr("maxlength", 255)
}




/**
 * Formata os campos de CPF/CNPJ, telefone de contato e CEP.
 * Dispara o evento "input" nos campos correspondentes para acionar a formatação.
 * 
 * @requires jQuery
 * 
 * @example
 * // Exemplo de uso
 * formatarCampos();
 */
function formatarCampos(){
    $("#cpfCnpj, #telefoneContato, #cep").trigger("input");
}




/**
 * Mostra ou oculta a senha digitada nos campos de senha e confirmação de senha.
 * A exibição da senha é controlada pelo estado do elemento de input do tipo 'checkbox' com id 'mostrarSenha'.
 * Quando o checkbox está marcado, as senhas são exibidas como texto.
 * Quando o checkbox está desmarcado, as senhas são ocultadas e exibidas como 'password'.
 * 
 * @requires HTML
 *  
 * @example
 * // Exemplo de uso
 * mostrarSenha();
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