<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupos = implode(",", $_POST['grupos']);
$sessao_id = $_SESSION['id'];

$sql = "DELETE FROM usuario_pertence_grupo WHERE grupo_id_ref IN ($grupos);";

// Executa a query
$res = mysqli_query($con, $sql);

$sql = "DELETE FROM grupos WHERE grupo_id IN ($grupos);";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	echo 'erro ao deletar os grupos';
	return false;
}

return true;

?>