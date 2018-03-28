/* ===================================================================== */
/* ======================== FUNÇÕES AUXILIARES ========================= */
/* ===================================================================== */

/** Redireciona o usuário para consultar mais informações acerca do evento clicado na tabela.
*/
function redirect_page() {
	window.location.href = 'evento.php';
}

/** Verifica se existem checkboxes selecionados na tabela.
*/
function verify_checkbox_status(element) {
	if(element.checked) {
		change_add_btn_function();
	}
	else {
		giveback_add_btn_function();
	}
}

/**
*/
function limpar_formulario() {
	document.getElementById('janela-criar-evento').reset();
}

/** Formata o tipo e a mensagem do alerta.
 * tipo Texto que define o tipo do alerta: warning, danger, success, ...
 * mensagem Texto que define a mensagem que será exibida.
*/
function formatar_texto_alerta(tipo, mensagem) {
  var alerta =
    "<div class='alert alert-" + tipo + "' role='alert'>" +
      "<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>" +
        "<span aria-hidden='true'> &times; </span>" +
      "</button>" +
      "<div> " + mensagem + " </div>" +
    "</div>";

  return alerta.toString();
}

/* ===================================================================== */
/* ============================== EVENTOS ============================== */
/* ===================================================================== */

/** Marca/desmarca todas os checkboxes do corpo da tabela caso o checkbox do cabeçalho seja marcado/desmarcado.
*/
function toggle_all_checkboxes(element) {
	checkboxes = document.getElementsByName('item');

	for(var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].checked = element.checked;
	}
}

/** Muda a função do botão de adicionar evento para poder excluir os eventos marcados.
*/
function change_add_btn_function() {
	$('#btn-excluir-evento').fadeIn();
	$('#btn-criar-evento').hide();
}

/** Devolve a função do botão de adicionar evento.
*/
function giveback_add_btn_function() {
	$('#btn-excluir-evento').hide();
	$('#btn-criar-evento').fadeIn();
}

/**
*/
function atualizar_lista_eventos() {
	// body...
}

/**
*/
function adicionar_novo_evento() {
	$.ajax({
		url: './reqs/adicionar_evento.php',
		type: 'POST',
		data: {titulo: $('#titulo').val()}
	})
	.done(function(alerta) {
		if(alerta.length != 0) {
			$('#alerta_mensagem').html(
				formatar_texto_alerta('danger', alerta)
			);
		} else {
			//atualizar_lista_eventos();
		}
	});
}

/* ===================================================================== */
/* ======================== OUTRAS REQUISIÇÕES ========================= */
/* ===================================================================== */

/**
*/
function buscar_grupo_infos() {
	$.ajax({
		url: './reqs/buscar_grupo_infos.php',
		type: 'POST',
		data: {grupo_id: $('#info_grupo_id').val()}
	})
	.done(function(titulo) {
		$('.info_grupo_titulo').html(titulo);
	});
}

/**
*/
function trigger_esconder_modal() {
	$('#janela-criar-evento').on('hidden.bs.modal', function(e) {
	  limpar_formulario();
	})
}

/* ===================================================================== */
/* ============================== OUTROS =============================== */
/* ===================================================================== */


$(document).ready(function() {
	$('#btn-excluir-evento').hide();
	buscar_grupo_infos();
	$('[data-toggle="tooltip"]').tooltip();
	trigger_esconder_modal();
});