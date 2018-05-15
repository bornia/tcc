/* ===================================================================== */
/* ======================== FUNÇÕES AUXILIARES ========================= */
/* ===================================================================== */

/** Redireciona o usuário para consultar mais informações acerca do evento clicado na tabela.
*/
function redirect_page() {
	window.location.href = 'meusgastos.php';
}

/** Retorna a quantidade de eventos marcados para exclusão.
*/
function obtem_quantidade_eventos_marcados() {
	return $("input[type=checkbox][name='item']:checked").length;;
}

/** Limpa todos os campos do modal de adicionar um novo evento.
*/
function limpar_formulario(form_id) {
	document.getElementById(form_id).reset();
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

/** Verifica se um campo input, conforme o seu id, está vazio.
 * input_id ID do campo input que será verificado.
*/
function verifica_campo_vazio(input_id) {
	var titulo = $('#' + input_id).val();

	if(titulo.length == 0)
		return false;

	return true;
}

/** Valida o formulário de criação de eventos verificando se atende aos padrões determinados.
*/
function validar_formulario_criar_evento() {
	var validado = true;

	if(!verifica_campo_vazio('titulo')) {
		$('#alerta-janela-criar-evento').html(
			$('#alerta-janela-criar-evento').html() +
			formatar_texto_alerta('warning', '<u>Dê um <b>título</b></u> ao evento.')
		);

		$('#titulo').get(0).focus();

		validado = false;
	}

	return validado;
}

/** Valida o formulário de edição de eventos verificando se atende aos padrões determinados.
*/
function validar_formulario_editar_evento() {
	var validado = true;

	if(!verifica_campo_vazio('editar-titulo')) {
		$('#alerta-janela-editar-evento').html(
			$('#alerta-janela-editar-evento').html() +
			formatar_texto_alerta('warning', '<u>Dê um <b>título</b></u> ao evento.')
		);

		$('#editar-titulo').get(0).focus();

		validado = false;
	}

	return validado;
}

/**
*/
function exibe_quantidade_eventos_marcados(legenda_modal_id) {
	var quantidade_eventos_marcados = obtem_quantidade_eventos_marcados();

		if(quantidade_eventos_marcados == 1) {
			$('#' + legenda_modal_id).html("o evento selecionado");
		} else {
			$('#' + legenda_modal_id).html("os <strong>" + quantidade_eventos_marcados + " eventos selecionados</strong>");
		}
}

/**
*/
function atualizar_tabela_saldo() {
	$.ajax({
			url: './reqs/atualizar_saldo.php',
			type: 'POST',
			data: {
				grupo_id: $("#info_grupo_id").val()
			}
		})
		.done(function(data) {
			try {
				var parsed = JSON.parse(data);
				
				if(parseInt(parsed.erro_id) != 0) {
					$('#alerta_mensagem').html(formatar_texto_alerta('warning', parsed.erro_mensagem));
				} else {
					$('#tabela-corpo-saldo').html(parsed.tbody_saldo);
				}
			} catch(e_alerta) {
				$('#alerta_mensagem_adicionar_gasto').html(
					formatar_texto_alerta('warning', "Erro ao converter para JSON.")
				);
			}	
		})
		.fail(function() {})
		.always(function() {});
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

/** Verifica se existe pelo menos um checkbox selecionado na tabela. 
*/
function verificar_valor_checkboxes() {
	var todos_selecionados 		= $("input[type=checkbox][name='item']:checked");
	var todos_nao_selecionados 	= $("input[type=checkbox][name='item']:not(:checked)");

	if(todos_selecionados.length > 0) {
		mostrar_botao_excluir_evento();
		verificar_status_checkboxes(todos_selecionados, 1) == true ? mostrar_botao_finalizar_evento() 	: ocultar_botao_finalizar_evento();
		verificar_status_checkboxes(todos_selecionados, 0) == true ? mostrar_botao_reabrir_evento() 	: ocultar_botao_reabrir_evento();
	} else {
		$('#checkbox-excluir-todos-eventos').prop('checked', false);
		mostrar_botao_adicionar_evento();
		ocultar_botao_reabrir_evento();
		ocultar_botao_finalizar_evento();
	}

	if(todos_nao_selecionados.length == 0) {
		$('#checkbox-excluir-todos-eventos').prop('checked', true);
	}
}

/** Marca/desmarca todas os checkboxes do corpo da tabela caso o checkbox do cabeçalho seja marcado/desmarcado.
*/
function toggle_all_checkboxes(element) {
	$("input[type=checkbox][name='item']").each(function(index, item) {
		item.checked = element.checked;
	});

	var todos_selecionados = $("input[type=checkbox][name='item']:checked");

	if(element.checked) {
		mostrar_botao_excluir_evento();
		verificar_status_checkboxes(todos_selecionados, 1) == true ? mostrar_botao_finalizar_evento() 	: ocultar_botao_finalizar_evento();
		verificar_status_checkboxes(todos_selecionados, 0) == true ? mostrar_botao_reabrir_evento() 	: ocultar_botao_reabrir_evento();
	}
	else {
		mostrar_botao_adicionar_evento();
		ocultar_botao_reabrir_evento();
		ocultar_botao_finalizar_evento();
	}
}

/**
*/
function verificar_status_checkboxes(checkboxes_selecionadas, status) {
	var validado = true;

	checkboxes_selecionadas.each(function() {
		if($(this).data('evento-status') != status) {
			validado = false;
			return;
		}
	});

	return validado;
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

/**
*/
function mostrar_botao_finalizar_evento() {
	$('#btn-finalizar-evento').fadeIn();
}

/**
*/
function ocultar_botao_finalizar_evento() {
	$('#btn-finalizar-evento').fadeOut();
}

/**
*/
function mostrar_botao_reabrir_evento() {
	$('#btn-reabrir-evento').fadeIn();
}

/**
*/
function ocultar_botao_reabrir_evento() {
	$('#btn-reabrir-evento').fadeOut();
}

/** Reescreve o html do body da tabela de eventos incluindo o evento que foi adicionado ao banco de dados.
*/
function atualizar_lista_eventos() {
	$.ajax({
		url: './reqs/atualizar_lista_eventos.php',
		type: 'POST',
		data: {
			grupo_id: 			$('#info_grupo_id').val(),
			texto_pesquisado: 	$('#barra-de-pesquisa').val(),
			ordem: 				($('#ordem').val() == 'titulo' ? 'titulo' : ($('#ordem').val() == 'total' ? 'total' : 'ultima_att')),
			tipo_ordem: 		($('#btn-ordenar-asc').is(':visible') ? $('#btn-ordenar-asc').data('tipo-ordem') : $('#btn-ordenar-desc').data('tipo-ordem')),
			regs_por_pagina: 	$('#registros_por_pagina').val(),
			offset: 			$('#offset').val(),
			status: 			($('#status').val() != 2 ? "AND status = " + $('#status').val() : "")
		}
	})
	.done(function(data) {
		try {
			var parsed = JSON.parse(data);
			$('#tabela-corpo-eventos').html(parsed.eventos);
			$('#lista_paginas').html(parsed.paginas);
		} catch(e_alerta) {
			$('#tabela-corpo-eventos').html(data);
		}
	});

	$('#checkbox-excluir-todos-eventos').prop('checked', false);

	return true;
}

/** Cadastra um novo evento no banco de dados e, se der errado, emite um alerta.
*/
function adicionar_novo_evento() {
	if(validar_formulario_criar_evento()) {
		$.ajax({
			url: './reqs/adicionar_evento.php',
			type: 'POST',
			data: {
				titulo: $('#titulo').val(),
				grupo_id: $('#info_grupo_id').val(),
				usuario_id: $('#info_usuario_id').val()
			}
		})
		.done(function(alerta) {
			if(alerta.length != 0) {
				$('#alerta_mensagem').html(
					formatar_texto_alerta('danger', alerta)
				);
			} else {
				atualizar_lista_eventos();
			}
		})
		.always(function() {
			$('#janela-criar-evento').modal('hide');
		});
	}
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
		if(mensagem.length != 0) {
			alerta.html(formatar_texto_alerta("danger", mensagem));
		}
		else {
			atualizar_lista_eventos();
			mostrar_botao_adicionar_evento();
		}
	})
	.fail(function() {console.log("error"); })
	.always(function() {
		$('#janela-excluir-evento').modal('hide');
	});
}

/** Obtém os valores de todas os eventos selecionados e faz uma requisição ao Banco de Dados para finalizar esses eventos.
*/
function finalizar_eventos() {
	var usuario_id 				= $('#info_usuario_id');
	var grupo_id 				= $('#info_grupo_id');
	var alerta 					= $("#alerta_mensagem");
	var eventos_selecionados 	= [];

	$("input[type=checkbox][name='item']:checked").each(function() {
		eventos_selecionados.push($(this).val());
	});

	$.ajax({
		url: './reqs/finalizar_evento.php',
		type: 'POST',
		data: {eventos_ids: eventos_selecionados, grupo_id: grupo_id.val(), usuario_id: usuario_id.val()},
	})
	.done(function(mensagem) {
		if(mensagem.length != 0) {
			alerta.html(formatar_texto_alerta("danger", mensagem));
		}
		else {
			atualizar_lista_eventos();
			ocultar_botao_finalizar_evento();
		}
	})
	.fail(function() {console.log("error"); })
	.always(function() {
		$('#janela-finalizar-evento').modal('hide');
	});
}

/** Obtém os valores de todas os eventos selecionados e faz uma requisição ao Banco de Dados para reabrir esses eventos.
*/
function reabrir_eventos() {
	var usuario_id 				= $('#info_usuario_id');
	var grupo_id 				= $('#info_grupo_id');
	var alerta 					= $("#alerta_mensagem");
	var eventos_selecionados 	= [];

	$("input[type=checkbox][name='item']:checked").each(function() {
		eventos_selecionados.push($(this).val());
	});

	$.ajax({
		url: './reqs/reabrir_evento.php',
		type: 'POST',
		data: {eventos_ids: eventos_selecionados, grupo_id: grupo_id.val(), usuario_id: usuario_id.val()},
	})
	.done(function(mensagem) {
		if(mensagem.length != 0) {
			alerta.html(formatar_texto_alerta("danger", mensagem));
		}
		else {
			atualizar_lista_eventos();
			ocultar_botao_reabrir_evento();
		}
	})
	.fail(function() {console.log("error"); })
	.always(function() {
		$('#janela-reabrir-evento').modal('hide');
	});
}

/** Quando o botão para editar um evento é clicado, atualiza-se o id do evento no atributo do botão Editar dentro do modal.
*/
function altera_eventoId_botao_editar_evento(element) {
	$('#info-evento-id').val($('#' + element.id).data('evento_id'));
}

/**
*/
function editar_evento(element) {
	if(validar_formulario_editar_evento()) {
		var usuario_id 		= $('#info_usuario_id');
		var grupo_id 		= $('#info_grupo_id');
		var alerta 			= $("#alerta_mensagem");
		var evento_id 		= $('#info-evento-id');
		var evento_titulo	= $('#editar-titulo');

		$.ajax({
			url: './reqs/editar_evento.php',
			type: 'POST',
			data: {evento_id: evento_id.val(), grupo_id: grupo_id.val(), usuario_id: usuario_id.val(), evento_titulo: evento_titulo.val()},
		})
		.done(function(mensagem) {
			if(mensagem.length != 0)
				alerta.html(formatar_texto_alerta("danger", mensagem));
			else
				atualizar_lista_eventos();
		})
		.fail(function() { console.log("error");})
		.always(function() {
			$('#janela-editar-evento').modal('hide');
		});
	}
}

/**
*/
function apagar_texto(input_id) {
	$('#' + input_id).val("");
}

/**
*/
function mostrar_botao_ordenar_asc() {
	$('#div-btn-ordenar-desc').hide();
	$('#div-btn-ordenar-asc').fadeIn();
}

/**
*/
function mostrar_botao_ordenar_desc() {
	$('#div-btn-ordenar-asc').hide();
	$('#div-btn-ordenar-desc').fadeIn();
}

/**
*/
function paginar_eventos(element) {
	var pagina_clicada = $('#' + element.id).data('pagina_clicada');
	pagina_clicada = pagina_clicada - 1; //necessário para ajusar o parâmetro offset

	//recupera os parametros de paginacao do formulario
	var registros_por_pagina = $('#registros_por_pagina').val();
	var pagina_atual = $('#pagina_atual').val();

	var offset_atualizado = pagina_clicada * registros_por_pagina;
	//aplica o valor atualizado do offset ao campo do form
	$('#offset').val(offset_atualizado);

	atualizar_lista_eventos();
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

/* ===================================================================== */
/* ============================== TRIGGERS ============================= */
/* ===================================================================== */

/** Quando o modal para adicionar um novo evento é carregado (fim de todas as transições) seta-se o foco para o input do título do evento.
*/
function trigger_exibir_modal_novo_evento() {
	$('#janela-criar-evento').on('shown.bs.modal', function() {
		document.getElementById("titulo").focus();
		$('#nchar_titulo').html(40);
	})
}

/** Quando o modal para adicionar um novo evento termina de ocultar-se (fim de todas as transições) limpa-se todo os campos do modal.
*/
function trigger_esconder_modal_novo_evento() {
	$('#janela-criar-evento').on('hidden.bs.modal', function(e) {
	  limpar_formulario('janela-criar-evento');
	  $('#alerta-janela-criar-evento').html("");
	})
}

/** Quando o modal para excluir um evento é carregado atualiza-se a semântica da mensagem conforme a quantidade de eventos marcados.
*/
function trigger_exibir_modal_excluir_evento() {
	$('#janela-excluir-evento').on('shown.bs.modal', function() {
		exibe_quantidade_eventos_marcados('legenda_quantidade_itens_marcados_excluir');
	
		document.getElementById("modal-btn-excluir-evento").focus();
	})
}

/** Quando o modal para editar um evento é carregado (fim de todas as transições) seta-se o foco para o primeiro input do formulário.
*/
function trigger_exibir_modal_editar_evento() {
	$('#janela-editar-evento').on('shown.bs.modal', function() {
		document.getElementById("editar-titulo").focus();
		$('#nchar-editar-titulo').html(40);
	})
}

/** Quando o modal para adicionar um novo evento termina de ocultar-se (fim de todas as transições) limpa-se todo os campos do modal.
*/
function trigger_esconder_modal_editar_evento() {
	$('#janela-editar-evento').on('hidden.bs.modal', function(e) {
	  limpar_formulario('janela-editar-evento');
	  $('#alerta-janela-editar-evento').html("");
	})
}

/** Quando o modal para finalizar um evento é carregado atualiza-se a semântica da mensagem conforme a quantidade de eventos marcados.
*/
function trigger_exibir_modal_finalizar_evento() {
	$('#janela-finalizar-evento').on('shown.bs.modal', function() {
		exibe_quantidade_eventos_marcados('legenda_quantidade_itens_marcados_finalizar');
	
		document.getElementById("modal-btn-finalizar-evento").focus();
	})
}

/** Quando o modal para reabrir um evento é carregado atualiza-se a semântica da mensagem conforme a quantidade de eventos marcados.
*/
function trigger_exibir_modal_reabrir_evento() {
	$('#janela-reabrir-evento').on('shown.bs.modal', function() {
		exibe_quantidade_eventos_marcados('legenda_quantidade_itens_marcados_reabrir');
	
		document.getElementById("modal-btn-reabrir-evento").focus();
	})
}

/**
*/
function trigger_exibir_tab_saldo() {
	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
		if($(e.target).attr('id') == "saldo-tab") {
			atualizar_tabela_saldo();
		}
	})
}

/* ===================================================================== */
/* ============================== OUTROS =============================== */
/* ===================================================================== */


$(document).ready(function() {
	mostrar_botao_adicionar_evento();
	mostrar_botao_ordenar_desc();
	ocultar_botao_reabrir_evento();
	ocultar_botao_finalizar_evento();

	buscar_grupo_infos();
	atualizar_lista_eventos();
	
	trigger_exibir_modal_novo_evento();
	trigger_esconder_modal_novo_evento();

	trigger_exibir_modal_excluir_evento();

	trigger_exibir_modal_editar_evento();
	trigger_esconder_modal_editar_evento();

	trigger_exibir_modal_finalizar_evento();
	trigger_exibir_modal_reabrir_evento();

	trigger_exibir_tab_saldo();
});