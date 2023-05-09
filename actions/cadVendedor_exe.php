<?php
    session_start();

    include("../common/functions.php");
    include("../database/conectaBD.php");

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $nomeEstabelecimento = $_POST["nomeEstabelecimento"];
    // $cnpj = $_POST["cnpj"];
    $cpf  = $_POST["cpf"];

    $rua = $_POST["rua"];
    $cep = $_POST["cep"];
    $complemento = $_POST["complemento"];
    $numero = $_POST["numero"];
    $bairro = $_POST["bairro"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estadoSelect"];

    $insertQueryEndereco = "INSERT INTO endereco (rua, cep, complemento, numero, bairro, cidade, uf) VALUES (\"$rua\",\" $cep\", \"$complemento\", \"$numero\", \"$bairro\",\" $cidade\", \"$estado\");";

    $selectQueryEndereco = "SELECT MAX(id) id_end FROM endereco";

    // echo $_POST["dataPublicacao"];
    $insertQueryUsuario = "INSERT INTO usuario (nome, email, senha) VALUES (\"".$nome."\",\"".$email."\",\"".$senha."\")";
    
    // echo $insertQueryUsuario;

    echo $insertQueryEndereco;

    if(mysqli_query($conn, $insertQueryEndereco)){

        $idEndereco = mysqli_query($conn, $selectQueryEndereco);

        if(mysqli_num_rows($idEndereco) > 0){
    
            if (mysqli_query($conn, $insertQueryUsuario)){
                
                cLog("usuario cadastrado");
        
                $selectIdUsuario = "SELECT MAX(id) id FROM USUARIO";
        
                $idUsuario = mysqli_query($conn, $selectIdUsuario);
        
                if (mysqli_num_rows($idUsuario) > 0) {

                    while($usuario = mysqli_fetch_assoc($idUsuario)) {

                        while($end = mysqli_fetch_assoc($idEndereco)){
                            
                            $insertQueryVendedor = " 
                            INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, id_endereco)
                            VALUES (\"".$usuario["id"]."\",\"".$nomeEstabelecimento."\",\"".$cpf."\", ".$end["id_end"].");
                            ";

                        }

                    }
                    
                }
        
                if (mysqli_query($conn, $insertQueryVendedor)){
                    alert("Vendedor cadastrado");
                }
                redirect("../index.php");
            }
            else
               alert("Erro ao cadastrar usuário!");

            

        }
        
    }

    

?>

