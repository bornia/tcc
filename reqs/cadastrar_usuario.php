<?php /* Cadastra usuários */

require_once('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

// Organiza as informações de cadastro do usuário
$user = array($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['pais_moeda']);

// Consulta para ver se o e-mail já existe
$sql = "SELECT email, senha FROM usr WHERE email = '$user[1]';";

// Executa a query
$res = mysqli_query($con, $sql);

// Verifica se a query foi executada com sucesso
if(!$res) {
	echo 'Erro ao verificar se usuário já existe.';
	return false;
}

$data = mysqli_fetch_array($res, MYSQLI_ASSOC);

// Verifica se a consulta não retornou nenhum registro, isto é, se já existe um usuário com o mesmo e-mail
if($data) {
	echo 'usuário já existe.';
	return false;
}

// Query para inserir um novo usuário
$sql = "INSERT INTO usr(nome, email, senha, pais_moeda, notificacoes) VALUES ('$user[0]', '$user[1]', '$user[2]', '$user[3]', '1,2,3,4');";

// Executa a query
$res = mysqli_query($con, $sql);


if(!$res) {
	echo 'Erro ao inserir novo usuário.';
	return false;
}

echo 'Usuário cadastrado com sucesso.';
header('Location: ../cadastrado.php?usuario_cadastrado');
return true;

?>