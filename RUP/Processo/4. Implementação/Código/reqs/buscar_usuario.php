<<?php

session_start();

require_once ('classes/db.class.php');

$membro_email 	= $_POST['usuario_email'];
$sessao_id 		= $_SESSION['id'];

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$sql = "SELECT email FROM usuarios WHERE email = '$membro_email' AND usuario_id != $sessao_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	echo 'erro ao consultar os usuários';
	return false;
}

if(!mysqli_num_rows($res)) {
	ob_clean();
	echo false;
} else {
	ob_clean();
	echo true;
}

return true;

?>