<!-- 
    Objetivo: limpar as variáveis de sessão do usuário para logout,
    redirecionando em seguida para index.php.
 -->
 <html>
<head>
    <meta charset="UTF-8">
    <title>Logout (Erro)</title>
</head>
<body>
<?php
    session_start(); 
    $_SESSION = array(); // Apaga todas variáveis da sessão
    header('location: /chestplace/index.php');
?>
</body>
</html>