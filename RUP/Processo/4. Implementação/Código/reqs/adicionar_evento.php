<<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$evento_titulo 	= $_POST['titulo'];
$grupo_id 		= $_POST['grupo_id'];

$sql = "INSERT INTO eventos(titulo) VALUES ('$evento_titulo');";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar criar o novo evento</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

// Obtém o id do último grupo inserido no banco
$last_id = mysqli_insert_id($con);

$sql = "INSERT INTO evento_pertence_grupo(grupo_id_ref,evento_id_ref) VALUES ($grupo_id,$last_id);";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar associar o novo evento com o grupo</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

ob_clean();
return true;

?>