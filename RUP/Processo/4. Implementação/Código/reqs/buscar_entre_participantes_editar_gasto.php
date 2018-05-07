<?php

session_start();

require_once ('classes/db.class.php');

$membro_email 	= $_POST['membro_email'];
$grupo_id 		= $_POST['grupo_id'];
$sessao_id 		= $_SESSION['id'];

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$sql = "SELECT email, nome FROM usuarios WHERE email LIKE '%$membro_email%' AND usuario_id IN (SELECT usuario_id_ref FROM usuario_pertence_grupo WHERE grupo_id_ref = $grupo_id) LIMIT 5;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	echo '<strong>Houve um erro ao buscar pelos membros do grupo</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>.';
	return false;
}

$usuarios = "";

if(!mysqli_num_rows($res)) {
	ob_clean();
	echo '';
}
else {
	while($data = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		$email = $data['email'];

		$usuarios .= "" .
			"<li onclick='seleciona_pesquisa_usuario_editar_gasto(\"$email\");'>
				<div> <small> " . $data['email'] . " </small> </div>
				<div class='text-muted'> <small> " . $data['nome'] . " </small> </div>
			</li>"
		. "\n\n";
	}
}

ob_clean();
echo $usuarios;

return true;

?>