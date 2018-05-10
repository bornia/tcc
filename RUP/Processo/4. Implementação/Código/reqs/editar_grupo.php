<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupo_id 		= $_POST['grupo_id'];
$usuario_id 	= $_POST['usuario_id'];
$titulo 		= $_POST['titulo_grupo'];
$descricao 		= $_POST['descricao_grupo'];
$membros_emails = $_POST['emails_grupo'];
$permissoes 	= $_POST['permissoes_grupo'];
$contador_erros = 1;
//$membros_atuais = $_POST['membros_atuais'];

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

if($usuario_permissao != 3) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<strong>Apenas o Dono pode editar os dados do grupo</strong>. <u>Peça para o Dono lhe conceder acesso</u>.'));
	$contador_erros++;
	return false;
}

$sql = "SELECT usuario_id_ref FROM usuario_pertence_grupo WHERE grupo_id_ref = $grupo_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<strong>Houve um erro ao tentar recuperar os IDs dos memros do grupo</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>.'));
	$contador_erros++;
	return false;
}

$usuarios_ids = array();
$membros_atuais = array();

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	array_push($usuarios_ids, $row['usuario_id_ref']);
}

foreach ($membros_emails as $key => $membro_email) {
	$sql = "SELECT usuario_id FROM usuarios WHERE email = '$membro_email';";

	// Executa a query
	$res = mysqli_query($con, $sql);

	// Se houve algum erro na execução da query
	if(!$res) {
		ob_clean();
		echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar encontrar o e-mail do participante</u>. Por gentileza, <strong>contate o suporte</strong>.'));
		$contador_erros++;
		return false;
	}

	$membro_id = mysqli_fetch_array($res, MYSQLI_ASSOC)['usuario_id'];
	array_push($membros_atuais, $membro_id);

	// VERIFICA SE HÁ UM NOVO MEMBRO E SE HOUVER, O ADICIONA AO GRUPO

	$validado = TRUE;

	foreach ($usuarios_ids as $id) {
		if($membro_id == $id) {
			$validado = FALSE;
		}
	}

	if($validado) {
		$sql = "INSERT INTO usuario_pertence_grupo(grupo_id_ref, usuario_id_ref, permissao) VALUES ($grupo_id, $membro_id, $permissoes[$key]);";

		// Executa a query
		$res = mysqli_query($con, $sql);

		// Se houve algum erro na execução da query
		if(!$res) {
			ob_clean();
			echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar adicionar o novo membro ao grupo</u> no Banco de Dados. Por gentileza, <strong>contate o suporte</strong>.'));
			$contador_erros++;
			return false;
		}
	}

	// EDITA AS PERMISSÕES DOS USUÁRIOS QUE JA ESTAVAM NO GRUPO

	$sql = "UPDATE usuario_pertence_grupo SET permissao = $permissoes[$key] WHERE grupo_id_ref = $grupo_id AND usuario_id_ref = $membro_id;";

	// Executa a query
	$res = mysqli_query($con, $sql);

	// Se houve algum erro na execução da query
	if(!$res) {
		ob_clean();
		echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar editar a permissão do usuário no grupo</u>. Por gentileza, <strong>contate o suporte</strong>.' . $sql));
		$contador_erros++;
		return false;
	}
}

// VERIFICA SE HÁ DIFERENÇA ENTRE A LISTA DE MEMBROS ANTIGA E A EDITADA (SEM INCLUIR NOVOS MEMBROS). SE HOUVER DIFERENÇA, DELETA OS MEMBROS.

$membros_deletados = array_diff($usuarios_ids, $membros_atuais);

if(count($membros_deletados) > 0) {
	$membros_deletados = implode(",", $membros_deletados);
	$sql = "DELETE FROM usuario_pertence_grupo WHERE usuario_id_ref IN ($membros_deletados) AND grupo_id_ref = $grupo_id;";

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

$sql = "UPDATE grupos SET titulo = '$titulo', descricao = '$descricao', ultima_att = CURRENT_TIMESTAMP WHERE grupo_id = $grupo_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<u>Houve um erro ao tentar editar o grupo</u>. Por gentileza, <strong>contate o suporte</strong>.'));
	$contador_erros++;
	return false;
}

ob_clean();
echo json_encode(array('erro_id' => 0, 'sucesso_mensagem' => 'Grupo <u>editado com <strong>sucesso</strong></u>.'));

return true;

?>