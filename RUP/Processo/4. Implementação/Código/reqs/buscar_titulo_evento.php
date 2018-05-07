<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$sql = "SELECT titulo FROM eventos WHERE evento_id = ". $_POST['evento_id'] . ";";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	echo 'erro ao buscar o titulo do evento.';
	return false;
}

ob_clean();
echo (mysqli_fetch_array($res, MYSQLI_ASSOC))['titulo'];

?>