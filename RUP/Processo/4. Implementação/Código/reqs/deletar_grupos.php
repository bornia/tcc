<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupos = implode(",", $_POST['grupos']);
$sessao_id = $_SESSION['id'];
/*
// Verificar se o usuário tem permissão para excluir o grupo
$sql = "SELECT grupos_membros_id, permissao FROM usuario_pertence_grupo WHERE usuario_id_ref = $sessao_id AND grupo_id_ref IN ($grupos);";

// Executa a query
$res = mysqli_query($con, $sql);

$grupos_permitidos = array();
while ($data = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	if($data['permissao'] == 3) {

	}
}
*/

$sql = "DELETE FROM usuario_pertence_grupo WHERE grupo_id_ref IN ($grupos);";

// Executa a query
$res = mysqli_query($con, $sql);

$sql = "DELETE FROM grupos WHERE grupo_id IN ($grupos);";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	echo 'erro ao deletar os grupos';
	return false;
}

return true;

?>