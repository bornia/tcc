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

$usuarios_ids 			= array();
$participantes_atuais 	= array();

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	array_push($usuarios_ids, $row['usuario_id_ref']);
}

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

	$participante_id = mysqli_fetch_array($res, MYSQLI_ASSOC)['usuario_id'];
	array_push($participantes_atuais, $participante_id);

	// VERIFICA SE HÁ UM PARTICIPANTE MEMBRO E SE HOUVER, O ADICIONA AO GASTO


	$validado = TRUE;

	foreach ($usuarios_ids as $usuario_id) {
		if($participante_id == $usuario_id) {
			$validado = FALSE;
		}
	}

	if($validado) {
		$sql = "INSERT INTO gasto_pertence_evento(usuario_id_ref, evento_id_ref, gasto_id_ref) VALUES ($participante_id, $evento_id, $gasto_id);";

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
}

// VERIFICA SE HÁ DIFERENÇA ENTRE A LISTA DE PARTICIPANTES ANTIGA E A EDITADA (SEM INCLUIR NOVOS PARTICIPANTES). SE HOUVER DIFERENÇA, DELETA OS PARTICIPANTES.

$participantes_deletados = array_diff($usuarios_ids, $participantes_atuais);

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
}

$sql = "UPDATE gastos SET descricao = '$gasto_descricao', categoria = '$gasto_categoria', data_pagamento = '$gasto_data_pagamento', valor = $gasto_valor WHERE gasto_id = $gasto_id;";

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