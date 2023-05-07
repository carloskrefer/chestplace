<?php
    session_start();
    include("../common/functions.php");
    include("../database/conectaBD.php");

    $cpfCnpjNumerico = preg_replace("/[^0-9]/", "", $_POST["cpfCnpj"]);
    $isPessoaFisica = strlen($cpfCnpjNumerico) == 11;

    // Infos do vendedor
    $nomeEstabelecimento = $_POST["nomeEstabelecimento"];
    $cpf  = $isPessoaFisica ? $_POST["cpfCnpj"] : null;
    $cnpj = $isPessoaFisica ? null : $_POST["cpfCnpj"];
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
    $alterVendQuery = "UPTDATE vendedor SET
                       nome_estabelecimento = ".$nomeEstabelecimento.",
                       cpf                  = ".$cpf.",
                       cnpj                 = ".$cnpj.",
                       email_contato        = ".$emailContato.",
                       telefone_contato     = ".$telefoneContato."
                       WHERE id_usuario     = ".$_SESSION["idVendedor"].";
    ";

    // Alterar endereço
    $alterEndQuery = "UPTDATE endereco SET
                      cep         = ".$cep.",
                      rua         = ".$rua.",
                      numero      = ".$numero.",
                      complemento = ".$complemento.",
                      bairro      = ".$bairro."
                      cidade      = ".$cidade."
                      uf          = ".$estado."
                      WHERE id    = ".$idEndreco.";
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