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

    $queryVerificarQtdComprasPendentesDoUsuario =
       "SELECT id
        FROM compra_venda
        WHERE id_comprador = $id_usuario
        AND data_hora_recebimento IS NULL;";

    // Tenta realizar UPDATEs
    try{   
        // Se há compras pendentes, não permitir exclusão do usuário.
        $resultSetComprasPendentes = $conn->query($queryVerificarQtdComprasPendentesDoUsuario);
        if ($resultSetComprasPendentes->num_rows > 0) {
            echo <<<END
            <script>
            alert("Não é possível excluir usuário com compras pendentes. Favor aguardar a entrega dos produtos comprados.");
            window.location.href='/chestplace/page_gerComprador.php';
            </script>
            END;
        } else {     
            $queryInativarUsuario =
            "UPDATE Usuario
                SET inativo = now()
                WHERE id = $id_usuario;";

            // Inserir endereço de faturamento
            mysqli_query($conn, $queryInativarUsuario);

            echo <<<END
            <script>
            alert("Usuário excluído com sucesso!");
            window.location.href='/chestplace/logout.php';
            </script>
            END;
        }
    } catch(Exception $e) { // Caso haja algum erro inserindo os dados 
        mysqli_rollback($conn); // Desfazer transaction

        echo <<<END
        <script>
        alert("Houve um erro ao excluir o usuário. Tente novamente mais tarde.");
        window.location.href='/chestplace/index.php';
        </script>
        END;
        
    }    
?>

