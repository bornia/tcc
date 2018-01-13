<?php

session_start();
  
if(empty($_SESSION)) {
  header('Location: ./login.php');
  return false;
}

return true;
?>