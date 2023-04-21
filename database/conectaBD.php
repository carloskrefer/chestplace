<!-------------------------------------------------------------------------------
Oficina Desenvolvimento Web
PUCPR

CONECTABD.PHP - deve ser incluído em todos os arquivos PHP que precisam de acesso à BD

Profa. Cristina V. P. B. Souza
Agosto/2022
---------------------------------------------------------------------------------->
<?php
    global $servername ;
    global $username;
    global $password;
    global $database;

    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $database = "chestplace";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("<script>console.log( \" Connected failed: ".$conn->connect_error." \" )</script> ");
    }
    echo "<script>console.log(\"Connected successfully to database\")</script>";
?>




