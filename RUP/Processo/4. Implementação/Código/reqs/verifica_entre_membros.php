<<?php

session_start();

require_once ('classes/db.class.php');

$membro_email 	= $_POST['membro_email'];
$grupo_id 		= $_POST['grupo_id'];
$sessao_id 		= $_SESSION['id'];

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$sql = "SELECT COUNT(usuario_id) AS quantidade_membros FROM usuarios WHERE email LIKE '%$membro_email%' AND usuario_id IN (SELECT usuario_id_ref FROM usuario_pertence_grupo WHERE grupo_id_ref = $grupo_id);";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<strong>Houve um erro ao verificar se existe um membro no Banco de Dados com o e-mail digitado</strong>. <u>Por favor, contate o suporte urgentemente</u>.';
	return false;
}

if(mysqli_fetch_array($res, MYSQLI_ASSOC)['quantidade_membros'] == 0) {
	ob_clean();
	echo false;
	return false;
}

ob_clean();
echo true;

return true;

?>