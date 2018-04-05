<<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$usuario_id 	= $_POST['usuario_id'];
$grupo_id 		= $_POST['grupo_id'];
$evento_id		= $_POST['evento_id'];
$evento_titulo	= $_POST['evento_titulo'];

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

$sql = "UPDATE eventos SET titulo = '$evento_titulo', ultima_att = CURRENT_TIMESTAMP WHERE evento_id = $evento_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<strong>Houve um erro ao tentar atualizar os dados do evento</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>.';
	return false;
}

ob_clean();
return true;

?>