$(document).ready(function() {

	/** Envia a requisição assíncrona */
	$('#btn-submit').click(function() {
		$.ajax({
			url: './reqs/validar_login.php',
			type: 'POST',
			data: $('#form_login').serialize()
		})
		.done(function(data) {
			switch(data) {
				case 'query': // Problema na execução da query
					$('#container_alerta_mensagem').html(
		                "<div class='alert alert-danger' role='alert'>" +
		                  "<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>" +
		                    "<span aria-hidden='true'> &times; </span>" +
		                  "</button>" +
		                  "<div>" +
		                    "Problema na <b>execução da query</b>. <u>Contate o suporte urgentemente</u>." +
		                  "</div>" +
		                "</div>"
	              	);
					break;
				case 'invalido': // Login inválido
					$('#container_alerta_mensagem').html(
		                "<div class='alert alert-danger' role='alert'>" +
		                  "<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>" +
		                    "<span aria-hidden='true'> &times; </span>" +
		                  "</button>" +
		                  "<div>" +
		                    "<b>E-mail e/ou senha inválidos</b>. <u>Verifique suas credenciais</u>." +
		                  "</div>" +
		                "</div>"
	              	);
					break;
				default: // Logado com sucesso
					location.href = "./meusgrupos.php";
			}
		});
	}); // btn-submit evento de clique
});