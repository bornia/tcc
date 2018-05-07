<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupo_id 				= $_POST['grupo_id'];
$gasto_id 				= $_POST['gasto_id'];
$usuario_id 			= $_POST['usuario_id'];
$gasto_descricao 		= $_POST['gasto_descricao'];
$gasto_categoria 		= $_POST['gasto_categoria'];
$gasto_data_pagamento 	= $_POST['gasto_data_pagamento'];
$gasto_valor 			= $_POST['gasto_valor'];
$participantes 			= $_POST['participantes'];
//$participantes 				= implode(",", $_POST['participantes']);

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
	echo '<strong>Você tem permissão apenas para visualizar</strong> as informações do grupo, mas não para edita-las. <u>Peça para o Dono lhe conceder acesso</u>.';
	return false;
}

$sql = "UPDATE gastos SET descricao = '$gasto_descricao', categoria = '$gasto_categoria', data_pagamento = '$gasto_data_pagamento', valor = $gasto_valor WHERE gasto_id = $gasto_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar editar o gasto</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}
/* ======== PAROU AQUI =========*/
$sql = "UPDATE gasto_pertence_evento SET descricao = '$gasto_descricao', categoria = '$gasto_categoria', data_pagamento = '$gasto_data_pagamento', valor = $gasto_valor WHERE gasto_id = $gasto_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar editar o gasto</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

ob_clean();
return true;

?>