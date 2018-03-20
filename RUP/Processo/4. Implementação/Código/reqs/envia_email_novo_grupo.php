<?php

	/* script configurado para funcionar com o servi�o de smtp do gmail */
	/* cuidado para n�o expor seus dados de usu�rio e senha de email */
	/* o gmail implementa uma seguran�a para permitir ou n�o o acesso ao seu e-mail atrav�s de aplicativos menos seguros (como � caso), ao efetuar o teste de envio de e-mail consulte sua caixa de mensagem, caso esta configura��o esteja desabilitada voc� receber� um e-mail do google questionando se deve ou n�o habilitar tal acesso */
	
	require('../PHPMailer/PHPMailerAutoload.php');
	
	//configura��es b�sicas de endere�o e protoloco 
	$mail = new PHPMailer; //faz a inst�ncia do objeto PHPMailer
	//$mail->SMTPDebug = true; //habilita o debug se par�metro for true
	$mail->isSMTP(); //seta o tipo de protocolo
	$mail->Host = 'smtp.gmail.com'; //define o servidor smtp
	$mail->SMTPAuth = true; //habilita a autentica��o via smtp
	$mail->SMTPOptions = [ 'ssl' => [ 'verify_peer' => false ] ];
	$mail->SMTPSecure = 'tls'; //tipo de seguran�a
	$mail->Port = 587; //porta de conex�o
	
	//dados de autentica��o no servidor smtp
	$mail->Username = 'guilhermeborniamiranda@gmail.com'; //usu�rio do smtp (email cadastrado no servidor)
	$mail->Password = '4pessoas1email'; //senha ****CUIDADO PARA N�O EXPOR ESSA INFORMA��O NA INTERNET OU NO F�RUM DE D�VIDAS DO CURSO****
?>