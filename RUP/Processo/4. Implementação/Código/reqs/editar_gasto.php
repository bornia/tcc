<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupo_id 				= $_POST['grupo_id'];
$evento_id 				= $_POST['evento_id'];
$gasto_id 				= $_POST['gasto_id'];
$usuario_id 			= $_POST['usuario_id'];
$gasto_descricao 		= $_POST['gasto_descricao'];
$gasto_categoria 		= $_POST['gasto_categoria'];
$gasto_data_pagamento 	= $_POST['gasto_data_pagamento'];
$gasto_valor 			= $_POST['gasto_valor'];
$participantes 			= $_POST['participantes'];
$valores 				= $_POST['valores'];
$contador_erros 		= 1;

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

// OBTEM OS IDS DOS PARTICIPANTES DA LISTA

$participantes_atuais 	= array();

foreach ($participantes as $participante_email) {
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

	array_push($participantes_atuais, mysqli_fetch_array($res, MYSQLI_ASSOC)['usuario_id']);
}

// OBTEM OS IDS DE TODOS OS PARTICIPANTES DO GASTO

$sql = "SELECT usuario_id_ref FROM gasto_pertence_evento WHERE gasto_id_ref = $gasto_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<strong>Houve um erro ao tentar recuperar os IDs dos participantes do grupo</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>.'));
	$contador_erros++;
	return false;
}

$participantes_ids 			= array();

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	array_push($participantes_ids, $row['usuario_id_ref']);
}

// VERIFICA SE HÁ DIFERENÇA ENTRE A LISTA DE PARTICIPANTES ANTIGA E A EDITADA (SEM INCLUIR NOVOS PARTICIPANTES). SE HOUVER DIFERENÇA, DELETA OS PARTICIPANTES.

$participantes_deletados = array_diff($participantes_ids, $participantes_atuais);

if(count($participantes_deletados) > 0) {
	$participantes_deletados = implode(",", $participantes_deletados);
	$sql = "DELETE FROM gasto_pertence_evento WHERE usuario_id_ref IN ($participantes_deletados) AND gasto_id_ref = $gasto_id;";

	// Executa a query
	$res = mysqli_query($con, $sql);

	// Se houve algum erro na execução da query
	if(!$res) {
		ob_clean();
		echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar deletar o(s) membro(s) do grupo</u> no Banco de Dados. Por gentileza, <strong>contate o suporte</strong>.'));
		$contador_erros++;
		return false;
	}

	// ATUALIZA OS IDS DOS USUÁRIOS QUE PARTICIPAM DO GRUPO, JÁ QUE HOUVE EXCLUSÃO

	$sql = "SELECT usuario_id_ref FROM gasto_pertence_evento WHERE gasto_id_ref = $gasto_id;";

	// Executa a query
	$res = mysqli_query($con, $sql);

	// Se houve algum erro na execução da query
	if(!$res) {
		ob_clean();
		echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<strong>Houve um erro ao tentar recuperar os IDs dos participantes do grupo</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>.'));
		$contador_erros++;
		return false;
	}

	$participantes_ids	= array();

	while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		array_push($participantes_ids, $row['usuario_id_ref']);
	}
}

// PARA

foreach ($participantes_ids as $key => $participante_id) {
	$sql = "SELECT valor FROM gasto_pertence_evento WHERE usuario_id_ref = $participante_id AND gasto_id_ref = $gasto_id;";

	// Executa a query
	$res = mysqli_query($con, $sql);

	// Se houve algum erro na execução da query
	if(!$res) {
		ob_clean();
		echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar encontrar o e-mail do participante</u>. Por gentileza, <strong>contate o suporte</strong>.'));
		$contador_erros++;
		return false;
	}

	$participante_valor = mysqli_fetch_array($res, MYSQLI_ASSOC)['valor'];

	if($participante_valor != $valores[$key]) {
		$sql = "UPDATE gasto_pertence_evento SET valor = $valores[$key] WHERE gasto_id_ref = $gasto_id AND usuario_id_ref = $participante_id;";

		// Executa a query
		$res = mysqli_query($con, $sql);

		// Se houve algum erro na execução da query
		if(!$res) {
			ob_clean();
			echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar atualizar o valor gasto do participante</u>. Por gentileza, <strong>contate o suporte</strong>.' . $sql));
			$contador_erros++;
			return false;
		}
	}
}

$participantes_adicionados = array_diff($participantes_atuais, $participantes_ids);
$values = array();

if(count($participantes_adicionados) > 0) {
	foreach ($participantes_adicionados as $key => $novo_participante_id) {
		array_push($values, "($novo_participante_id, $evento_id, $gasto_id, $valores[$key])");
	}

	$values = implode(",", $values);

	$sql = "INSERT INTO gasto_pertence_evento(usuario_id_ref, evento_id_ref, gasto_id_ref, valor) VALUES $values;";

	// Executa a query
	$res = mysqli_query($con, $sql);

	// Se houve algum erro na execução da query
	if(!$res) {
		ob_clean();
		echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar adicionar o novo participante ao gasto</u> no Banco de Dados. Por gentileza, <strong>contate o suporte</strong>.'));
		$contador_erros++;
		return false;
	}
}

$sql = "UPDATE gastos SET descricao = '$gasto_descricao', categoria = '$gasto_categoria', data_pagamento = '$gasto_data_pagamento', total = $gasto_valor WHERE gasto_id = $gasto_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar editar o gasto</u>. Por gentileza, <strong>contate o suporte</strong>.'));
	$contador_erros++;
	return false;
}

ob_clean();
echo json_encode(array('erro_id' => 0, 'sucesso_mensagem' => 'Gasto editado com <strong>sucesso</strong>.'));
return true;

?>