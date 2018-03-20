<<?php /* ADICIONA UM NOVO GRUPO */

session_start();

require_once('classes/db.class.php');
require_once('envia_email_novo_grupo.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

// Organiza as informações do novo grupo
$user_id = $_SESSION['id'];
$grupo = array($_POST['titulo_grupo'], $_POST['descricao_grupo'], $_POST['membros'], $_POST['permissoes']);

// Consulta para ver se o usuário já criou ou se já participa de um grupo com esse nome
$sql = "SELECT titulo FROM grupos JOIN usuario_pertence_grupo ON (grupo_id = grupo_id_ref) WHERE usuario_id_ref = $user_id AND titulo = '$grupo[0]';";

// Executa a query
$res = mysqli_query($con, $sql);

// Se o grupo já existe
if(mysqli_num_rows($res) > 0) {
	echo '<u>Já existe um grupo</u>, do qual você participa, com esse título.';
	return false;
}

// Se o grupo não existe
// Insere o novo grupo
$sql = "INSERT INTO grupos(titulo, descricao) VALUES ('$grupo[0]', '$grupo[1]');";

// Executa a query
$res = mysqli_query($con, $sql);

// Insere o criador do grupo no grupo
$last_id = mysqli_insert_id($con);
$sql = "INSERT INTO usuario_pertence_grupo(grupo_id_ref, usuario_id_ref, permissao) VALUES ($last_id, $user_id, 3);";

// Executa a query
$res = mysqli_query($con, $sql);

// Propriedades do e-mail
$subject = "OurBills: um novo grupo está te chamando!";
$body = "Você foi adicionado em um novo grupo. <br/> <button type='button'> Entrar no Grupo </button>";
$altBody = "Caso não seja suportado o HTML, aqui vai a mensagem em texto.";

// Envia notificação por e-mail
foreach ($grupo[2] as $email) {
	//dados de envio de e-mail
	$mail->addAddress($email); //e-mails que receberam a mesagem
	
	//configuração da mensagem
	$mail->isHTML(true); //formato da mensagem de e-mail
	$mail->Subject = utf8_decode($subject); //assunto
	$mail->Body    = utf8_decode($body); //Se o formato da mensagem for HTML você poderá utilizar as tags do HTML no corpo do e-mail
	$mail->AltBody = utf8_decode($altBody); //texto alternativo caso o html não seja suportado
	
	//envio e testes
	if(!$mail->send()) { //Neste momento duas ações são feitas, primeiro o send() (envio da mensagem) que retorna true ou false, se retornar false (não enviado) juntamente com o operador de negação "!" entra no bloco if.
		echo 'A mensagem não pode ser enviada ';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'A mensagem foi enviada com sucesso!';
	}
}

return true;

?>