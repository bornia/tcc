<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupo_id 					= $_POST['grupo_id'];
$evento_id 					= $_POST['evento_id'];
$usuario_id 				= $_POST['usuario_id'];
$novo_gasto_descricao 		= $_POST['novo_gasto_descricao'];
$novo_gasto_categoria 		= $_POST['novo_gasto_categoria'];
$novo_gasto_data_pagamento 	= $_POST['novo_gasto_data_pagamento'];
$novo_gasto_valor 			= $_POST['novo_gasto_valor'];
$participantes 				= $_POST['participantes'];
$valores 					= $_POST['valores'];
$contador_erros				= 1;
//$participantes 				= implode(",", $_POST['participantes']);

$sql = "SELECT permissao FROM usuario_pertence_grupo WHERE usuario_id_ref = $usuario_id AND grupo_id_ref = $grupo_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<strong>Houve um erro ao consultar a permissão do usuário</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>.'));
	$contador_erros++;
	return false;
}

$usuario_permissao = mysqli_fetch_array($res, MYSQLI_ASSOC)['permissao'];

if($usuario_permissao == 1) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<strong>Você tem permissão apenas para visualizar</strong> as informações do grupo, mas não para edita-las. <u>Peça para o Dono lhe conceder acesso</u>.'));
	$contador_erros++;
	return false;
}

$sql = "INSERT INTO gastos(descricao, categoria, data_pagamento, total) VALUES ('$novo_gasto_descricao', '$novo_gasto_categoria', '$novo_gasto_data_pagamento', $novo_gasto_valor);";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar adicionar o novo gasto</u>. Por gentileza, <strong>contate o suporte</strong>.'));
	$contador_erros++;
	return false;
}

// Obtém o id do último grupo inserido no banco
$last_id = mysqli_insert_id($con);

foreach ($participantes as $key => $participante_email) {
	$sql = "SELECT usuario_id FROM usuarios WHERE email = '$participante_email';";

	// Executa a query
	$res = mysqli_query($con, $sql);

	// Se houve algum erro na execução da query
	if(!$res) {
		ob_clean();
		echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar encontrar o e-mail do participante</u>. Por gentileza, <strong>contate o suporte</strong>.'));
		$contador_erros++;
		return false;
	}

	$participante_id = mysqli_fetch_array($res, MYSQLI_ASSOC)['usuario_id'];

	$sql = "INSERT INTO gasto_pertence_evento(usuario_id_ref, evento_id_ref, gasto_id_ref, valor) VALUES ($participante_id, $evento_id, $last_id, $valores[$key]);";

	// Executa a query
	$res = mysqli_query($con, $sql);

	// Se houve algum erro na execução da query
	if(!$res) {
		ob_clean();
		echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar associar o novo gasto com o evento</u>. Por gentileza, <strong>contate o suporte</strong>.' . $sql));
		$contador_erros++;
		return false;
	}
}

ob_clean();
echo json_encode(array('erro_id' => 0, 'sucesso_mensagem' => 'O gasto foi adicionado com <strong>sucesso</strong>.'));
$contador_erros++;
return true;

?>