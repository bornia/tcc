<?php

session_start();

// Apaga todas as variáveis da sessão
$_SESSION = array();

// Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados
foreach($_COOKIE as $key=>$ck){
   setcookie($key, $ck, time() - 3600);
}

// Destrói a sessão
session_destroy();

// Por último, redireciona a página
header('./login.php');

?>