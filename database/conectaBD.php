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

    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $database = "chestplace";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
?>




