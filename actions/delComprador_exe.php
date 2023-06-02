<?php
    session_start();
    require("../validacaoAcessoComprador.php"); // Verificar se o usuário é comprador e está logado.

    // Verifica se o usuário entrou nesta página por método POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('location: /chestplace/index.php');
        exit(); // Para que não execute o resto do programa PHP.
    }

    $id_usuario = $_SESSION['id_usuario'];

    // Imports
    require("../database/conectaBD.php");

    // Inicia transaction
    mysqli_begin_transaction($conn);

    // Tenta realizar UPDATEs
    try{    
        $queryInativarUsuario =
           "UPDATE Usuario
            SET inativo = now()
            WHERE id = $id_usuario;";

        // Inserir endereço de faturamento
        mysqli_query($conn, $queryInativarUsuario);

        echo <<<END
        <script>
        alert("Usuário excluído com sucesso!");
        </script>
        END;

        mysqli_commit($conn); // Termina transaction
    } catch(Exception $e) { // Caso haja algum erro inserindo os dados 
        mysqli_rollback($conn); // Desfazer transaction

        echo <<<END
        <script>
        alert("Houve um erro ao cadastrar o usuário. Tente novamente mais tarde.");
        </script>
        END;
    }
    header('location: /chestplace/logout.php');
?>

