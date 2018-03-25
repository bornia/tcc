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

// Propriedades do e-mail
$subject = "OurBills: um novo grupo est� te chamando!";
$altBody = "Caso n�o seja suportado o HTML, aqui vai a mensagem em texto.";

// Envia notifica��o por e-mail
foreach ($_POST['membros_emails'] as $key => $email) {
	//dados de envio de e-mail
	$mail->addAddress($email); //e-mails que receberam a mesagem
	
	//configura��o da mensagem
	$mail->isHTML(true); //formato da mensagem de e-mail
	$mail->SetFrom('guilhermeborniamiranda@gmail.com', 'OurBills');
	$mail->Subject = utf8_decode($subject); //assunto
	$mail->Body    = "
		<html>
		  <head>
		    <!-- Required meta tags -->
		    <meta charset='utf-8'>

		    <style type='text/css'>
		      body {
		        text-align: center;
		      }

		      a {
		        background-color: #28a745;
		        border-color: #28a745;
		        display: inline-block;
		        font-weight: 400;
		        text-align: center;
		        white-space: nowrap;
		        vertical-align: middle;
		        -webkit-user-select: none;
		        -moz-user-select: none;
		        -ms-user-select: none;
		        user-select: none;
		        border: 1px solid transparent;
		        padding: .375rem .75rem;
		        font-size: 1rem;
		        line-height: 1.5;
		        border-radius: .25rem;
		        transition: background-color 0.5s ease;
		        text-decoration: none;
		      }

		      a:hover {
		        background-color: green;
		      }
		    </style>
		  </head>

		  <body>
		    <p> Voc� foi adicionado no grupo T�TULO com PERMISS�O para apenas visualizar os seus dados. </p>
		    <a href='#' Entrar no Grupo </a>
		  </body>
		</html>
		";
	$mail->AltBody = utf8_decode($altBody); //texto alternativo caso o html n�o seja suportado
	
	//envio e testes
	if(!$mail->send()) { //Neste momento duas a��es s�o feitas, primeiro o send() (envio da mensagem) que retorna true ou false, se retornar false (n�o enviado) juntamente com o operador de nega��o "!" entra no bloco if.
		echo 'A mensagem n�o pode ser enviada ';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'A mensagem foi enviada com sucesso!';
	}
}

?>