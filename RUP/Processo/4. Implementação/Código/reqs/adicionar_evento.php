<<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$evento_titulo 	= $_POST['titulo'];
$grupo_id 		= $_POST['grupo_id'];
$usuario_id = $_POST['usuario_id'];

$sql = "SELECT permissao FROM usuario_pertence_grupo WHERE usuario_id_ref = $usuario_id AND grupo_id_ref = $grupo_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<strong>Houve um erro ao consultar a permissão do usuário</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>.';
	return false;
}

$usuario_permissao = mysqli_fetch_array($res, MYSQLI_ASSOC)['permissao'];

if($usuario_permissao == 1) {
	ob_clean();
	echo '<strong>Você tem permissão apenas para visualizar</strong> as informações do grupo, mas não edita-las. <u>Peça para o Dono lhe conceder acesso</u>.';
	return false;
}

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