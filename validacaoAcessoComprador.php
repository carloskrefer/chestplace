<?php
    /*
        Adicionar require("./database/validacaoAcessoComprador.php"); nas páginas
        de acesso exclusivo do comprador, preferencialmente após "session_start()". 
        Será verificado se ele está logado e se ele de fato é um comprador. 
        Se não for, é redirecionado para o index.php.
    */
  if(session_id() == ''){
    session_start();
  }
  $isLogado = isset($_SESSION ['id_usuario']);
  if (isset($_SESSION ['tipo_usuario'])) {
    $isComprador = $_SESSION ['tipo_usuario'] == "comprador";
  }
  if (!$isLogado or !$isComprador) {
    header('location: /chestplace/index.php'); 
  }
?>