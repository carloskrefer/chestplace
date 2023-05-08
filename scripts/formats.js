function formatarCPF(cpf) {
    // Remove todos os caracteres não numéricos
    const numeros = cpf.replace(/\D/g, '');
  
    // Aplica a formatação usando regex
    return numeros.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
}

function formatarCNPJ(cnpj){
    const numeros = cnpj.replace(/\D/g, '');
    
    return numeros.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5')
} 

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

function formatarTelefoneFixo(telefone){
    return telefone.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3");
}

function formatarTelUnic400X(telefone){
    return telefone.replace(/^(\d{4})(\d{4})$/, "$1-$2");
}

function formatarTel0800(telefone){
    return telefone.replace(/^(\d{4})(\d{3})(\d{4})$/, "$1 $2 $3");
}

function formatarTelComum(telefone){
    return telefone.replace(/^(\d{2})(\d{1})(\d{4})(\d{4})$/, "($1) $2 $3-$4");
}

function formatarCEP(cep){
    cep = cep.replace(/\D/, "");
    return cep.replace(/^(\d{5})(\d{3})$/, "$1-$2");
}