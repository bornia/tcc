<?php

/* script configurado para funcionar com o serviço de smtp do gmail */
/* cuidado para não expor seus dados de usuário e senha de email */
/* o gmail implementa uma segurança para permitir ou não o acesso ao seu e-mail através de aplicativos menos seguros (como é caso), ao efetuar o teste de envio de e-mail consulte sua caixa de mensagem, caso esta configuração esteja desabilitada você receberá um e-mail do google questionando se deve ou não habilitar tal acesso */

require('../PHPMailer/PHPMailerAutoload.php');

//configurações básicas de endereço e protoloco 
$mail = new PHPMailer; //faz a instância do objeto PHPMailer
//$mail->SMTPDebug = true; //habilita o debug se parâmetro for true
$mail->isSMTP(); //seta o tipo de protocolo
$mail->Host = 'smtp.gmail.com'; //define o servidor smtp
$mail->SMTPAuth = true; //habilita a autenticação via smtp
$mail->SMTPOptions = [ 'ssl' => [ 'verify_peer' => false ] ];
$mail->SMTPSecure = 'tls'; //tipo de segurança
$mail->Port = 587; //porta de conexão

//dados de autenticação no servidor smtp
$mail->Username = 'guilhermeborniamiranda@gmail.com'; //usuário do smtp (email cadastrado no servidor)
$mail->Password = '4pessoas1email'; //senha ****CUIDADO PARA NÃO EXPOR ESSA INFORMAÇÃO NA INTERNET OU NO FÓRUM DE DÚVIDAS DO CURSO****

// Propriedades do e-mail
$subject = "OurBills: um novo grupo está te chamando!";
$altBody = "Caso não seja suportado o HTML, aqui vai a mensagem em texto.";

// Envia notificação por e-mail
foreach ($_POST['membros_emails'] as $key => $email) {
	//dados de envio de e-mail
	$mail->addAddress($email); //e-mails que receberam a mesagem
	
	//configuração da mensagem
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
		    <p> Você foi adicionado no grupo TÍTULO com PERMISSÃO para apenas visualizar os seus dados. </p>
		    <a href='#' Entrar no Grupo </a>
		  </body>
		</html>
		";
	$mail->AltBody = utf8_decode($altBody); //texto alternativo caso o html não seja suportado
	
	//envio e testes
	if(!$mail->send()) { //Neste momento duas ações são feitas, primeiro o send() (envio da mensagem) que retorna true ou false, se retornar false (não enviado) juntamente com o operador de negação "!" entra no bloco if.
		echo 'A mensagem não pode ser enviada ';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'A mensagem foi enviada com sucesso!';
	}
}

?>