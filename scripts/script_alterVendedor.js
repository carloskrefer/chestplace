$("#altVendedorForm").ready(function(){
    $("#cep").val(cep);

    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
        if (!("erro" in dados)) {
            $("#estadoSelect").val(dados.uf)
        }
    });
    
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
                $("#cidade").val("...");
                $("#estadoSelect").val("...");
    
                
                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
    
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estadoSelect").val(dados.uf);
                        $("#ibge").val(dados.ibge);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        $("#rua").val('');
                        $("#bairro").val('');
                        $("#cidade").val('');
                        $("#estadoSelect").val('');
                        $("#ibge").val('');
                        exibirPopUpErro(document.getElementById("cep"),"CEP não encontrado.");
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
                alert("CEP inválido")
            }
        }
    
    })
})

function enviarFormulario(){
    if(validarFormulario()) $("#altVendedorForm").submit();
}