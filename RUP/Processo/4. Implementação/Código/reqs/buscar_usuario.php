<<?php

session_start();

require_once ('classes/db.class.php');

$membro_email 	= $_POST['usuario_email'];
$sessao_id 		= $_SESSION['id'];

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$sql = "SELECT email, nome FROM usuarios WHERE email LIKE '%$membro_email%' AND usuario_id != $sessao_id LIMIT 5;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	echo 'erro ao consultar os usuários';
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
			"<li onclick='seleciona_pesquisa_usuario(\"$email\");'>
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