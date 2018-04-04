/* ===================================================================== */
/* ======================== FUNÇÕES AUXILIARES ========================= */
/* ===================================================================== */

/** Redireciona o usuário para consultar mais informações acerca do evento clicado na tabela.
*/
function redirect_page() {
	window.location.href = 'evento.php';
}

/** Verifica se existe pelo menos um checkbox selecionado na tabela. 
*/
function verificar_todos_status_checkboxes() {
	var todos_selecionados 		= $("input[type=checkbox][name='item']:checked").length;
	var todos_nao_selecionados 	= $("input[type=checkbox][name='item']:not(:checked)").length;

	if(todos_selecionados > 0) {
		mostrar_botao_excluir_evento();
	} else {
		$('#checkbox-excluir-todos-eventos').prop('checked', false);
		mostrar_botao_adicionar_evento();
	}
}

/** Retorna a quantidade de eventos marcados para exclusão.
*/
function obtem_quantidade_eventos_marcados() {
	return $("input[type=checkbox][name='item']:checked").length;;
}

/** Limpa todos os campos do modal de adicionar um novo evento.
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

/** Verifica quantos caracteres ainda podem ser digitados baseado no limite determinado.
 * element_checked O texto do ID referente ao campo que terá seus caracteres contados.
 * element_nchar O texto do ID referente ao campo que mostrará quantos caracteres ainda podem ser digitados.
 * limite A quantidade máxima de caracteres que pode ser digitada.
*/
function check_nchar(element_checked, element_nchar, limite) {
	var campo_contador = document.getElementById(element_nchar);
	var nome_grupo = document.getElementById(element_checked).value;
	var max_tam = limite - nome_grupo.length;

	if(max_tam == -1)
	  return false;

	campo_contador.innerHTML = max_tam;
	return true;
}

/** Marca/desmarca todas os checkboxes do corpo da tabela caso o checkbox do cabeçalho seja marcado/desmarcado.
*/
function toggle_all_checkboxes(element) {
	$("input[type=checkbox][name='item']").each(function(index, item) {
		item.checked = element.checked;
	});

	if(element.checked)
		mostrar_botao_excluir_evento();
	else
		mostrar_botao_adicionar_evento();
}

/** Muda a função do botão de adicionar evento para poder excluir os eventos marcados.
*/
function mostrar_botao_excluir_evento() {
	$('#btn-criar-evento').hide();
	$('#btn-excluir-evento').fadeIn();
}

/** Devolve a função do botão de adicionar evento.
*/
function mostrar_botao_adicionar_evento() {
	$('#btn-excluir-evento').hide();
	$('#btn-criar-evento').fadeIn();
}

/** Reescreve o html do body da tabela de eventos incluindo o evento que foi adicionado ao banco de dados.
*/
function atualizar_lista_eventos() {
	$.ajax({
		url: './reqs/atualizar_lista_eventos.php',
		type: 'POST',
		data: {grupo_id: $('#info_grupo_id').val()}
	})
	.done(function(data) {
		try {
			var parsed = JSON.parse(data);
			$('#tabela-corpo-eventos').html(parsed.eventos);
		} catch(e_alerta) {
			$('#tabela-corpo-eventos').html(data);
		}
	});

	$('#checkbox-excluir-todos-eventos').prop('checked', false);
}

/** Cadastra um novo evento no banco de dados e, se der errado, emite um alerta.
*/
function adicionar_novo_evento() {
	$.ajax({
		url: './reqs/adicionar_evento.php',
		type: 'POST',
		data: {titulo: $('#titulo').val(), grupo_id: $('#info_grupo_id').val()},
	})
	.done(function(alerta) {
		if(alerta.length != 0) {
			$('#alerta_mensagem').html(
				formatar_texto_alerta('danger', alerta)
			);
		} else {
			atualizar_lista_eventos();
		}
	});
}

/** Obtém os valores de todas os eventos selecionados e faz uma requisição ao Banco de Dados para excluir esses eventos.
*/
function excluir_eventos() {
	var usuario_id 				= $('#info_usuario_id');
	var grupo_id 				= $('#info_grupo_id');
	var alerta 					= $("#alerta_mensagem");
	var eventos_selecionados 	= [];

	$("input[type=checkbox][name='item']:checked").each(function() {
		eventos_selecionados.push($(this).val());
	});

	$.ajax({
		url: './reqs/deletar_evento.php',
		type: 'POST',
		data: {eventos_ids: eventos_selecionados, grupo_id: grupo_id.val(), usuario_id: usuario_id.val()},
	})
	.done(function(mensagem) {
		if(mensagem.length != 0)
			alerta.html(formatar_texto_alerta("danger", mensagem));
		else
			atualizar_lista_eventos();
	})
	.fail(function() {console.log("error"); })
	.always(function() {
		$('#janela-excluir-evento').modal('hide');
		mostrar_botao_adicionar_evento();
	});
	
}

/* ===================================================================== */
/* ======================== OUTRAS REQUISIÇÕES ========================= */
/* ===================================================================== */

/** Busca o título do grupo no Banco e o exibe na página.
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

/** Quando o modal para adicionar um novo evento é carregado (fim de todas as transições) seta-se o foco para o input do título do evento.
*/
function trigger_exibir_modal_novo_evento() {
	$('#janela-criar-evento').on('shown.bs.modal', function() {
		document.getElementById("titulo").focus();
	})
}

/** Quando o modal para adicionar um novo evento termina de ocultar-se (fim de todas as transições) limpa-se todo os campos do modal.
*/
function trigger_esconder_modal_novo_evento() {
	$('#janela-criar-evento').on('hidden.bs.modal', function(e) {
	  limpar_formulario();
	})
}

/** Quando o modal para excluir um evento é carregado atualiza-se a semântica da mensagem conforme a quantidade de eventos marcados.
*/
function trigger_exibir_modal_excluir_evento() {
	$('#janela-excluir-evento').on('shown.bs.modal', function() {
		var quantidade_eventos_marcados = obtem_quantidade_eventos_marcados();

		if(quantidade_eventos_marcados == 1) {
			$('#legenda_quantidade_itens_marcados').html("o evento selecionado");
		} else {
			$('#legenda_quantidade_itens_marcados').html("os <strong>" + quantidade_eventos_marcados + " eventos selecionados</strong>");
		}
	})
}

/* ===================================================================== */
/* ============================== OUTROS =============================== */
/* ===================================================================== */


$(document).ready(function() {
	$('#btn-excluir-evento').hide();
	buscar_grupo_infos();
	atualizar_lista_eventos();
	$('[data-toggle="tooltip"]').tooltip();
	trigger_exibir_modal_novo_evento();
	trigger_esconder_modal_novo_evento();
	trigger_exibir_modal_excluir_evento();
});