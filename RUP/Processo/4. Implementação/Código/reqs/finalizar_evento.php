<<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$usuario_id = $_POST['usuario_id'];
$grupo_id 	= $_POST['grupo_id'];
$eventos_id	= implode(",", $_POST['eventos_ids']);

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

if($usuario_permissao != 3) {
	ob_clean();
	echo '<strong>Apenas o Dono </strong> do grupo pode finalizar um evento. Peça para o Dono <u>lhe conceder acesso</u> ou que <u>ele mesmo finalize o(s) evento(s)</u>.';
	return false;
}

$sql = "UPDATE eventos SET status = 0 WHERE evento_id IN ($eventos_id);";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<strong>Houve um erro ao tentar finalizar o(s) evento(s) do grupo</strong>. <u>Por favor, contate o suporte urgentemente</u>.';
	return false;
}

ob_clean();
return true;

?>