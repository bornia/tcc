<<?php /* ADICIONA UM NOVO GRUPO */

session_start();

require_once('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

// Organiza as informações do novo grupo
$user_id 			= $_SESSION['id'];
$grupo_titulo 		= $_POST['titulo_grupo'];
$grupo_descricao 	= $_POST['descricao_grupo'];
$grupo_membros 		= $_POST['membros'];
$grupo_permissoes 	= $_POST['permissoes'];

// Consulta para ver se o usuário já criou ou se já participa de um grupo com esse nome
$sql = "SELECT titulo FROM grupos JOIN usuario_pertence_grupo ON (grupo_id = grupo_id_ref) WHERE usuario_id_ref = $user_id AND titulo = '$grupo_titulo';";

// Executa a query
$res = mysqli_query($con, $sql);

// Se o grupo já existe
if(mysqli_num_rows($res) > 0) {
	ob_clean();
	echo '<u>Já existe um grupo</u>, do qual você participa, com esse título.';
	return false;
}

// Se o grupo não existe
// Insere o novo grupo
$sql = "INSERT INTO grupos(titulo, descricao) VALUES ('$grupo_titulo', '$grupo_descricao');";

// Executa a query
$res = mysqli_query($con, $sql);

if(!$res) {
	ob_clean();
	echo 'erro ao inserir novo grupo';

	return false;
}

// Obtém o id do último grupo inserido no banco
$last_id = mysqli_insert_id($con);

// Adiciona o criador do grupo no grupo como 'dono'
$sql = "INSERT INTO usuario_pertence_grupo(grupo_id_ref, usuario_id_ref, permissao) VALUES ($last_id, $user_id, 3)";
$res = mysqli_query($con, $sql);

// Adiciona os demais membros
foreach ($grupo_membros as $key => $value) {
	$sql = "SELECT usuario_id FROM usuarios WHERE email = '$value';";
	$res = mysqli_query($con, $sql);
	$usuario_id = (mysqli_fetch_array($res, MYSQLI_ASSOC)['usuario_id']);
	$sql = "INSERT INTO usuario_pertence_grupo(grupo_id_ref, usuario_id_ref, permissao) VALUES ($last_id, $usuario_id, $grupo_permissoes[$key])";
	$res = mysqli_query($con, $sql);
}

ob_clean();
echo json_encode($grupo_membros);

return true;

?>