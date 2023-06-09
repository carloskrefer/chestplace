// Quando o formulário de alteração estiver carregado (ready), executar função
$("#altVendedorForm").ready(function(){
    
    // Esconde o estadoSelect (displayEstadoSelect continua sendo exibido);
    $("#estadoSelect").hide();

    // Ao usuário sair do campo '#cep', executar função
    $("#cep").blur(function(){
    
        // CEP somente com números
        var cep = $(this).val().replace(/\D/g, '');
    
        // Verifica se CEP não é vazio
        if(cep !== ""){
    
            // REGEX para ver se CEP possui 8 dígitos
            var validacep = /^[0-9]{8}$/;
    
            // Se o CEP possuir 8 dígitos
            if(validacep.test(cep)) {
    
                // Preenche os campos com "..." enquanto consulta API.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#displayCidade").val("...");
                $("#displayEstadoSelect").val("...");
    
                
                // Consulta a API do viacep.com.br/

                // Desativa botão de salvar enquanto sistema consulta dados do CEP
                $("#salvar").prop("disabled", true);

                // Vai pegar o JSON retornado pela consulta do viaCEP [JSON => 'dados']
                $.getJSON(`https://viacep.com.br/ws/${cep}/json/?callback=?`, function(dados) {

                    // Se NÃO houve erro ao procurar o CEP
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
                    }

                    // Se HOUVE erro ao procurar o CEP
                    else {

                        // Deixar campos de endereço vazios
                        $("#rua").val('');
                        $("#bairro").val('');
                        $("#cidade").val('');
                        $("#estadoSelect").val('');
                        $("#displayCidade").val('');
                        $("#displayEstadoSelect").val('');
                        $("#ibge").val('');

                        // Notificar que CEP não foi encontrado e habilitar botão de salvar
                        exibirPopUpErro($("#cep"),"CEP não encontrado.");
                        $("#cep").focus();
                        $("#salvar").prop("disabled", false);
                    }
                });
            }

            // Se o CEP NÃO possuir 8 dígitos
            else {

                // Notificar que CEP é inválido e habilitar botão de salvar
                exibirPopUpErro($("#cep"),"CEP inválido.");
                $("#cep").focus();
                $("#salvar").prop("disabled", false);
            }
        }
    
    })

    formatarCampos();
    limitarCampos();
})

$("#desativarButton").click(function(){
    confirmarDesativarConta();
})

function enviarFormulario(){
    if(validarFormulario(false)) $("#altVendedorForm").submit();
}

function limitarCampos(){
    let limiteCpfCnpj = 18;

    if($("#cpfCnpj").data("pessoafisica")){ limiteCpfCnpj = 14; }

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

function confirmarCancelamento(){
    showModalConfirmacao(
        "<i class=\"w3-text-amber fa fa-solid fa-exclamation-triangle\"></i> &nbsp;",
        "Você tem certeza?",
        "Ao confirmar, todas as alterações não salvas serão perdidas. ",
        "",
        "w3-boder-amber",
        "Sim",
        "Não"
    );

    $("#btnPrimario-modalDeNotificacao").off();
    $("#btnPrimario-modalDeNotificacao").on("click", function() { window.location.href="../page_gerProdutos.php"; });
}

function confirmarDesativarConta(){
    showModalConfirmacao(
        "<i class=\"w3-text-amber fa fa-solid fa-exclamation-triangle\"></i> &nbsp;",
        "Você tem certeza?",
        "Ao confirmar, sua conta será permanentemente desativada e você perderá acesso a ela. ",
        "Você não poderá desfazer essa ação e não poderá cadastrar uma nova conta com este email.",
        "w3-boder-amber",
        "Sim",
        "Não"
    );

    $("#btnPrimario-modalDeNotificacao").off();
    $("#btnPrimario-modalDeNotificacao").on("click", function() { desativarConta(); });
}

function desativarConta(){
    const dados = new FormData($("#altVendedorForm").get(0));
    dados.append("desativar", true);
  
    fetch("../actions/alterVendedor_exe.php", {
      method: "POST",
      body: dados
    })
    .then(response => {
        console.log(response);
        // Se a requisição tiver sido feita com sucesso
        if(response.ok){
            alert("Usuário desativado com sucesso!");
            location.reload();
        } else {
           throw new Error("Houve um erro ao desativar o usuário.");
        }
    }) // Caso ocorra um erro
    .catch(error => {
        alert("Erro na requisição: " + error);
        location.reload();
    });
}