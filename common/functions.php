<?php

    function redirect($url) {
        jsScript("window.setTimeout(function(){ window.location.href =\"".$url."\";},1)");
        die();
    }

    function alert($mensagem) {
        jsScript("alert(\"".$mensagem."\")");
    }

    function cLog($mensagem){
        jsScript("console.log(\"".$mensagem."\")");
    }

    function jsScript($script){
        echo "<script>".$script."</script>";
    }

?>