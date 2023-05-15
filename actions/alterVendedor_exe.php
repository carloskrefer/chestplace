<?php
    session_start();

    // Imports
    include("../common/functions.php");
    include("../database/conectaBD.php");

    // Validar se o usuário pode estar na página, se não tiver autorização, voltar para index.php
    require("../validacaoAcessoVendedor.php");

    // Se não for uma requisição POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // Redirecionar ou exibir uma mensagem de erro
        redirect("../page_gerProdutos.php");
        exit; // Encerrar o script
    }


    $cpfCnpjNumerico = preg_replace("/[^0-9]/", "", $_POST["cpfCnpj"]);
    $isPessoaFisica = strlen($cpfCnpjNumerico) == 11;

    // Infos do vendedor
    $nomeEstabelecimento = $_POST["nomeEstabelecimento"];
    $cpf  = $isPessoaFisica ? $_POST["cpfCnpj"] : NULL;
    $cnpj = $isPessoaFisica ? NULL : $_POST["cpfCnpj"];
    $emailContato = $_POST["emailContato"];
    $telefoneContato = $_POST["telefoneContato"];

    // Infos do endereço
    $idEndereco = $_POST["idEndereco"];
    $cep = $_POST["cep"];
    $rua = $_POST["rua"];
    $numero = $_POST["numero"];
    $bairro = $_POST["bairro"];
    $complemento = $_POST["complemento"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estadoSelect"];


    // Alterar dados vendedor
    $alterVendQuery = "UPDATE vendedor SET
                       nome_estabelecimento = \"".$nomeEstabelecimento."\",
                       cpf                  = ". ($cpf ?  "\"$cpf\"" : "NULL" ) .",
                       cnpj                 = ". ($cnpj ? "\"$cnpj\"" : "NULL") .",
                       email_contato        = \"".$emailContato."\",
                       telefone_contato     = \"".$telefoneContato."\"
                       WHERE id_usuario     = ".$_SESSION["idVendedor"].";
    ";

    // Alterar endereço
    $alterEndQuery = "UPDATE endereco SET
                      cep         = \"".$cep."\",
                      rua         = \"".$rua."\",
                      numero      = \"".$numero."\",
                      complemento = \"".$complemento."\",
                      bairro      = \"".$bairro."\",
                      cidade      = \"".$cidade."\",
                      uf          = \"".$estado."\"
                      WHERE id    = ".$idEndereco.";
    ";

    // Transaction de alterar
    mysqli_begin_transaction($conn);

    // Se foi alterado com sucesso
    if (mysqli_query($conn, $alterVendQuery) && mysqli_query($conn, $alterEndQuery)){
        mysqli_commit($conn);
        alert("Cadastro atualizado com sucesso!");
        redirect("../page_gerProdutos.php?id=".$_SESSION["idVendedor"]);
    } else {
        mysqli_rollback($conn);
        alert("Houve um erro ao atualizar cadastro. Tente novamente mais tarde.");
    }
?>