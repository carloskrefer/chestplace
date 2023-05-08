$("#altVendedorForm").ready(function(){
    
    $("#estadoSelect").hide();

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
    
                // consultarCEP(cep)
                // .then(endereco =>{
                //     $("#cep").val(cep);
                //     $("#rua").val(endereco.logradouro);
                //     $("#cidade").val(endereco.localidade);
                //     $("#estadoSelect").val(endereco.uf);
                //     $("#bairro").val(endereco.bairro)
                // })
                // .catch(error => console.log(error))
            }
            else {
                // cep é inválido
                exibirPopUpErro($("#cep"),"CEP inválido.");
            }
        }
    
    })

    formatarCampos();
    limitarCampos();
})

function enviarFormulario(){
    if(validarFormulario()) $("#altVendedorForm").submit();
}

function limitarCampos(){
    let limiteCpfCnpj = 18;

    if(pessoaFisica){ limiteCpfCnpj = 14; }

    $("#nomeEstabelecimento").attr("maxlength", 255)
    $("#cpfCnpj").attr("maxlength", limiteCpfCnpj)
    $("#emailContato").attr("maxlength", 255)
    $("#telefoneContato").attr("maxlength", 16)
    $("#cep").attr("maxlength", 9)
    $("#rua").attr("maxlength", 255)
    $("#numero").attr("maxlength", 10)
    $("#bairro").attr("maxlength", 255)
    $("#cidade").attr("maxlength", 255)
}

function formatarCampos(){
    $("#cpfCnpj, #telefoneContato, #cep").trigger("input");
}