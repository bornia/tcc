<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$sessao_id = $_SESSION['id'];
$grupos_id = implode(",", $_POST['grupos']);	// Coloca os elementos do array entre vírgulas

// Obtém os ids dos grupos que se deseja excluir e as permissões do usuário em relação aos grupos
$sql = "SELECT grupo_id_ref,permissao FROM usuario_pertence_grupo WHERE usuario_id_ref = $sessao_id AND grupo_id_ref IN ($grupos_id);";
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo 'erro ao verificar as permissoes nos grupos';
	return false;
}

$grupos_permitidos_ids	= array();	// Guardará os ids dos grupos que podem ser excluídos
$grupos_proibidos		= array();	// Guardará os títulos dos grupos que NÃO podem ser excluídos

while($row_usuario_grupo = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	$grupo_id = $row_usuario_grupo['grupo_id_ref'];

	// Obtém o título do grupo através do id recuperado da tabela de relação entre usuário e grupo
	$sql = "SELECT titulo FROM grupos WHERE grupo_id = $grupo_id;";
	$res2 = mysqli_query($con, $sql);

	if(!$res2) {
		ob_clean();
		echo 'erro ao consultar o titulo do grupo';
		return false;
	}

	// Guarda o título do grupo
	$row_grupo = mysqli_fetch_array($res2, MYSQLI_ASSOC);

	// Separa os grupos que podem ser excluídos e os que não poden
	if($row_usuario_grupo['permissao'] != 3) { // Então não pode excluir o grupo
		array_push($grupos_proibidos, $row_grupo['titulo']);
	} else { // Então pode excluir o grupo
		array_push($grupos_permitidos_ids, $grupo_id);
	}
}

ob_clean();
echo json_encode(
	array(
		'permitidos_ids'	=> $grupos_permitidos_ids,
		'proibidos' 		=> $grupos_proibidos
	)
);

return true;

?>