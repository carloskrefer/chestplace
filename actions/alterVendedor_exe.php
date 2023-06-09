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

    
    try{
        // Desativar conta do vendedor se necessário
        if(isset($_POST["desativar"])){
            $queryDesativar = "UPDATE usuario SET inativo = NOW() WHERE id = ".$_SESSION["idVendedor"];
            mysqli_query($conn, $queryDesativar);

            $queryAllCamisetas = "SELECT c.id, cv.data_hora_compra FROM camiseta c LEFT JOIN compra_venda cv ON c.id = cv.id_camiseta WHERE c.id_vendedor = ".$_SESSION["idVendedor"];
            $resultAllCamisetas =  mysqli_query($conn, $queryAllCamisetas);

            while($camiseta = mysqli_fetch_assoc($resultAllCamisetas)){
                if(!isset($camiseta["data_hora_compra"])){
                    mysqli_query($conn, "DELETE FROM estoque WHERE id_camiseta = ".$camiseta["id"]);
                    mysqli_query($conn, "DELETE FROM imagem  WHERE id_produto = ".$camiseta["id"]);
                    $deleteQuery = "DELETE FROM camiseta WHERE id = " . $camiseta["id"];
                } else {
                    $deleteQuery = "UPDATE camiseta SET inativo = NOW() WHERE id = ".$camiseta["id"];
                }
                
                mysqli_query($conn, $deleteQuery);
            }

            echo json_encode(array( "ok" => true, "message" => "Conta desativada com sucesso!"));
            mysqli_commit($conn);
            session_destroy();
        } else {
            // Alterar dados do vendedor
            mysqli_query($conn, $alterVendQuery);
    
            // Alterar dados do endereço
            mysqli_query($conn, $alterEndQuery);

        }
        

        mysqli_commit($conn);
        redirect("../page_gerProdutos.php");

    } catch (Exception $e){
        http_response_code(500);
        mysqli_rollback($conn);
        echo json_encode(array( "ok" => false, "message" => "Houve um erro ao alterar os dados do vendedor!".$e));
    }

?>