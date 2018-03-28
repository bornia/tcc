<<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$titulo = $_POST['titulo'];

$sql = "INSERT INTO eventos(titulo) VALUES ('$titulo');";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo 'Houve um erro ao tentar criar o novo evento. Por gentileza, contate o suporte.';
	return false;
}

?>