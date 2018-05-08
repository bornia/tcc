var contador_participantes_novo_gasto 	= 1; // Indica a ordem de inclusão dos participantes na lista do novo gasto
var contador_participantes_editar_gasto = 1; // Indica a ordem de inclusão dos participantes na lista de editar gasto

/* ===================================================================== */
/* ======================== FUNÇÕES AUXILIARES ========================= */
/* ===================================================================== */

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
      "<div class='text-justify'> " + mensagem + " </div>" +
    "</div>";

  return alerta.toString();
}

/**
*/
function seleciona_pesquisa_usuario_novo_gasto(email) {
	$('#buscar-email-participante-novo-gasto').val(email);
	$('#caixa-pesquisa-usuarios-novo-gasto').hide();
	document.getElementById("buscar-email-participante-novo-gasto").focus();
}

/**
*/
function seleciona_pesquisa_usuario_editar_gasto(email) {
	$('#buscar-email-participante-editar-gasto').val(email);
	$('#caixa-pesquisa-usuarios-editar-gasto').hide();
	document.getElementById("buscar-email-participante-editar-gasto").focus();
}

/** Testa se o texto de um e-mail segue o padrão estabelecido.
 * object Referência ao objeto que será verificado. Atenção: é a referência e não o texto.
*/
function verificar_email(object) {
  // As barras no começo e no final estabelecem um padrão
  // ^[A-Za-z0-9_\-\.]+ Busca por no mínimo uma combinação dos caracteres especificados  no COMEÇO DA STRING
  // @ Indica que deve existir um arroba (@) na string, nessa ordem
  // [A-Za-z0-9_\-\.]{2,} Busca por uma combinação de no mínimo 2 caracteres dos caracteres especificados
  // (\.[A-Za-z0-9])? Busca por uma combinação de no mínimo zero caracteres dos caracteres especificados
  // Resumindo ...
  // É preciso digitar um ou mais dos caracteres A-Z, a-z, 0-9, underline, hífen e ponto antes do @, que é obrigatório. Sendo que, depois do @, aceita-se uma combinação de no mínimo 2 caracteres e, de forma opcional, outra combinação de indefinidos caracteres precedidos por um ponto.
  var patt = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
  var email = object.val();

  if(!patt.test(email))
    return false;

  return true;
}

/**
*/
function verifica_novos_participantes_adicionados(campo_email_id, itens_name_tag) {
	var novo_email_obj = $('#' + campo_email_id);
	var email_ja_existe = true;

	$("input[type='text'][name='" + itens_name_tag + "[]'").each(function(index, element) {
		if(novo_email_obj.val() == $(element).val()) {
			email_ja_existe =  false;
			return true;
		}
	});

	return email_ja_existe;
}

/** Formata o texto de cada "item de participante" adicionado na lista do novo grupo.
* ordem Indica qual é a posição do participante na lista. Serve de ID para o participante.
* email É o e-mail do participante.
*/
function formatar_texto_membro_novo_gasto(ordem, email) {
	var participante =
		"<div class='row' id='item-participante-novo-gasto-"+ ordem +"'>" +
			"<div class='col-9'>" +
				"<label for='email-participante-"+ ordem +"' class='text-muted font-weight-bold mb-0 text-size-responsive'>" +
	                "Participante "+ ordem + ": " +
	          	"</label>" +

              	"<input type='text' readonly class='form-control-sm form-control-plaintext text-truncate text-size-responsive' id='email-participante-"+ ordem +"' name='participantes_novo_gasto[]' value='"+ email +"'>" +
            "</div>" +

            "<div class='col'>" +
                "<button type='button' class='close btn-sm' id='"+ ordem +"' onclick='retirar_participante_novo_gasto(this)' aria-label='Retirar participante da lista do gasto.'>" +
                  	"&times;" +
                "</button>" +
          	"</div>" +

          	"<hr class='mb-2 mt-2' id='separador-participante-novo-gasto-"+ ordem +"' width='85%' style='display: none;'> </div>" +
      	"</div>";

 	return participante;
}

/** Formata o texto de cada "item de participante" adicionado na lista do novo grupo.
* ordem Indica qual é a posição do participante na lista. Serve de ID para o participante.
* email É o e-mail do participante.
*/
function formatar_texto_membro_editar_gasto(ordem, email) {
	var participante =
		"<div class='row' id='item-participante-editar-gasto-"+ ordem +"'>" +
			"<div class='col-9'>" +
				"<label for='email-participante-"+ ordem +"' class='text-muted font-weight-bold mb-0 text-size-responsive'>" +
	                "Participante "+ ordem + ": " +
	          	"</label>" +

              	"<input type='text' readonly class='form-control-sm form-control-plaintext text-truncate text-size-responsive' id='email-participante-"+ ordem +"' name='participantes_editar_gasto[]' value='"+ email +"'>" +
            "</div>" +

            "<div class='col'>" +
                "<button type='button' class='close btn-sm' id='"+ ordem +"' onclick='retirar_participante_editar_gasto(this)' aria-label='Retirar participante da lista do gasto.'>" +
                  	"&times;" +
                "</button>" +
          	"</div>" +

          	"<hr class='mb-2 mt-2' id='separador-participante-editar-gasto-"+ ordem +"' width='85%' style='display: none;'> </div>" +
      	"</div>";

 	return participante;
}

/** Retira um participante da lista de participante do novo gasto.
 * membro Referência ao atributo this passado como argumento ao clicar no botão.
*/
function retirar_participante_novo_gasto(participante) {
	$('#item-participante-novo-gasto-' + participante.id).remove();

	if(participante.id == contador_participantes_novo_gasto - 1 && participante.id == contador_participantes_novo_gasto - 1) // Esconde a hr do item anterior
		$('#separador-participante-novo-gasto-' + (participante.id - 1)).css('display', 'none');

	contador_participantes_novo_gasto--;
}

/** Retira um participante da lista de participante do editar gasto.
 * membro Referência ao atributo this passado como argumento ao clicar no botão.
*/
function retirar_participante_editar_gasto(participante) {
	$('#item-participante-editar-gasto-' + participante.id).remove();

	if(participante.id == contador_participantes_editar_gasto - 1 && participante.id == contador_participantes_editar_gasto - 1) // Esconde a hr do item anterior
		$('#separador-participante-editar-gasto-' + (participante.id - 1)).css('display', 'none');

	contador_participantes_editar_gasto--;
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

/** Verifica se a opção que está selecionada é a primeira (geralmente é uma instrução)
 * select_id ID do campo select.
*/
function verifica_select_desabilitado(select_id) {
	if($('#' + select_id + ' option:selected').index() == 0)
		return false;

	return true;
}

/** Verifica o campo é um número > zero, pois não existe um gasto negativo e não faz sentido dividir um gasto de valor zero.
 * input_id ID do campo que representa uma moeda/dinheiro/valor.
*/
function verifica_valores_inteiros_e_zero(input_id) {
	if($('#' + input_id).val() <= 0)
		return false;

	return true;
}

/** Valida o formulário verificando se atende aos padrões determinados.
*/
function validar_formulario_novo_gasto() {
	var validado = true;

	if(!verifica_campo_vazio('descricao-novo-gasto')) {
		$('#alerta_mensagem_adicionar_gasto').html(
			$('#alerta_mensagem_adicionar_gasto').html() +
			formatar_texto_alerta('warning', '<u>Dê mais <strong>detalhes</strong></u> sobre o novo gasto.')
		);

		$('#descricao-novo-gasto').focus();

		validado = false;
	}

	if(!verifica_select_desabilitado('categoria-novo-gasto')) {
		$('#alerta_mensagem_adicionar_gasto').html(
			$('#alerta_mensagem_adicionar_gasto').html() +
			formatar_texto_alerta('warning', '<u><strong>Categorize</strong> o novo gasto</u>.')
		);

		$('#categoria-novo-gasto').focus();

		validado = false;
	}

	if(!verifica_campo_vazio('data-pagamento-novo-gasto')) {
		$('#alerta_mensagem_adicionar_gasto').html(
			$('#alerta_mensagem_adicionar_gasto').html() +
			formatar_texto_alerta('warning', 'Informe <u><strong>quando</strong> o gasto foi realizado</u>.')
		);

		$('#data-pagamento-novo-gasto').focus();

		validado = false;
	}

	if(!verifica_campo_vazio('valor-novo-gasto')) {
		$('#alerta_mensagem_adicionar_gasto').html(
			$('#alerta_mensagem_adicionar_gasto').html() +
			formatar_texto_alerta('warning', 'Informe a <u><strong>quantia</strong> do gasto</u>.')
		);

		$('#valor-novo-gasto').focus();

		validado = false;
	}

	if(!verifica_valores_inteiros_e_zero('valor-novo-gasto')) {
		$('#alerta_mensagem_adicionar_gasto').html(
			$('#alerta_mensagem_adicionar_gasto').html() +
			formatar_texto_alerta('warning', 'Informe uma <u><strong>quantia</strong> válida para o gasto</u>.')
		);

		$('#valor-novo-gasto').focus();

		validado = false;
	}

	if(contador_participantes_novo_gasto < 3) { // Verifica se tem pelo menos 2 membro no gasto
		$('#alerta_mensagem_adicionar_gasto').html(
			$('#alerta_mensagem_adicionar_gasto').html() +
			formatar_texto_alerta('warning', 'Inclua <u>pelo menos <b>dois participantes</b></u> no novo gasto. Lembrando que <u>você não está automaticamente incluso</u> dessa vez.')
		);

		validado = false;
	}

	return validado;
}

/** Valida o formulário verificando se atende aos padrões determinados.
*/
function validar_formulario_editar_gasto() {
	var validado = true;

	if(!verifica_campo_vazio('descricao-editar-gasto')) {
		$('#alerta_mensagem_editar_gasto').html(
			$('#alerta_mensagem_editar_gasto').html() +
			formatar_texto_alerta('warning', '<u>Dê mais <strong>detalhes</strong></u> sobre o gasto.')
		);

		$('#descricao-editar-gasto').focus();

		validado = false;
	}

	if(!verifica_select_desabilitado('categoria-editar-gasto')) {
		$('#alerta_mensagem_editar_gasto').html(
			$('#alerta_mensagem_editar_gasto').html() +
			formatar_texto_alerta('warning', '<u>Não se esqueça de <strong>categorizar o gasto</strong></u>.')
		);

		$('#categoria-editar-gasto').focus();

		validado = false;
	}

	if(!verifica_campo_vazio('data-pagamento-editar-gasto')) {
		$('#alerta_mensagem_editar_gasto').html(
			$('#alerta_mensagem_editar_gasto').html() +
			formatar_texto_alerta('warning', 'Informe <u><strong>quando</strong> o gasto foi realizado</u>.')
		);

		$('#data-pagamento-editar-gasto').focus();

		validado = false;
	}

	if(!verifica_campo_vazio('valor-editar-gasto')) {
		$('#alerta_mensagem_editar_gasto').html(
			$('#alerta_mensagem_editar_gasto').html() +
			formatar_texto_alerta('warning', 'Informe a <u><strong>quantia</strong> do gasto</u>.')
		);

		$('#valor-editar-gasto').focus();

		validado = false;
	}

	if(!verifica_valores_inteiros_e_zero('valor-editar-gasto')) {
		$('#alerta_mensagem_editar_gasto').html(
			$('#alerta_mensagem_editar_gasto').html() +
			formatar_texto_alerta('warning', 'Informe uma <u><strong>quantia</strong> válida para o gasto</u>.')
		);

		$('#valor-editar-gasto').focus();

		validado = false;
	}

	if(contador_participantes_editar_gasto < 3) { // Verifica se tem pelo menos 2 membro no gasto
		$('#alerta_mensagem_editar_gasto').html(
			$('#alerta_mensagem_editar_gasto').html() +
			formatar_texto_alerta('warning', 'Inclua <u>pelo menos <b>dois participantes</b></u> no gasto. Lembrando que <u>você não está automaticamente incluso</u>.')
		);

		validado = false;
	}

	return validado;
}

/** Retorna a quantidade de gastos marcados para exclusão.
*/
function obtem_quantidade_gastos_marcados() {
	return $("input[type=checkbox][name='item']:checked").length;;
}

/** Mostra quantos itens foram marcados para exclusão e atualiza o body do modal.
*/
function exibe_quantidade_eventos_marcados(legenda_modal_id) {
	var quantidade_eventos_marcados = obtem_quantidade_gastos_marcados();

		if(quantidade_eventos_marcados == 1) {
			$('#' + legenda_modal_id).html("o gasto selecionado");
		} else {
			$('#' + legenda_modal_id).html("os <strong>" + quantidade_eventos_marcados + " gastos selecionados</strong>");
		}
}

/* ===================================================================== */
/* ============================== EVENTOS ============================== */
/* ===================================================================== */

/**
*/
function buscar_entre_participantes_novo_gasto(id) {
	var email = $('#' + id);

	if(email.val() == '') {
		$('#caixa-pesquisa-usuarios-novo-gasto').hide();
		return false;
	}

	$.ajax({
		url: './reqs/buscar_entre_participantes_novo_gasto.php',
		type: 'POST',
		data: {
			membro_email: 	email.val(),
			grupo_id: 		$('#info_grupo_id').val()
		}
	})
	.done(function(data) {
		if(data == '') {
			$('#lista-pesquisa-usuarios-novo-gasto').html('');
			$('#caixa-pesquisa-usuarios-novo-gasto').hide();
		}
		else {
			$('#caixa-pesquisa-usuarios-novo-gasto').show();
			$('#lista-pesquisa-usuarios-novo-gasto').html(data);
		}
	})
	.fail(function() {})
	.always(function() {});

	return true;
}

/**
*/
function buscar_entre_participantes_editar_gasto(id) {
	var email = $('#' + id);

	if(email.val() == '') {
		$('#caixa-pesquisa-usuarios-editar-gasto').hide();
		return false;
	}

	$.ajax({
		url: './reqs/buscar_entre_participantes_editar_gasto.php',
		type: 'POST',
		data: {
			membro_email: 	email.val(),
			grupo_id: 		$('#info_grupo_id').val()
		}
	})
	.done(function(data) {
		if(data == '') {
			$('#lista-pesquisa-usuarios-editar-gasto').html('');
			$('#caixa-pesquisa-usuarios-editar-gasto').hide();
		}
		else {
			$('#caixa-pesquisa-usuarios-editar-gasto').show();
			$('#lista-pesquisa-usuarios-editar-gasto').html(data);
		}
	})
	.fail(function() {})
	.always(function() {});

	return true;
}

/** Insere um novo membro na lista de membros do novo gasto quando a tecla Enter for pressionada.
 * event Referência ao evento do teclado.
*/
function incluir_participante_novo_gasto(event) {
	var key = event.which || event.keyCode;
	var novo_email_obj = $('#buscar-email-participante-novo-gasto');
	var alerta_mensagem_obj = $('#alerta_mensagem_adicionar_gasto');

	if(key == 13) {
		if(!verificar_email(novo_email_obj)) { // Verifica se o e-mail foi digitado corretamente
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Digite um <u>e-mail válido</u>.')
			);

			return false;
		}

		if(!buscar_participante(novo_email_obj.val())) { // Verifica se o usuário está entre os membros do grupo
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', '<strong>Não existe um usuário com esse e-mail</strong>. <u>Escolha outro entre as opções disponíveis na caixa de pesquisa</u>.')
			);

			return false;
		}

		if(!verifica_novos_participantes_adicionados('buscar-email-participante-novo-gasto', 'participantes_novo_gasto')) {
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Esse membro <u>já foi adicionado</u>.')
			);

			return false;
		}
		
		if(contador_participantes_novo_gasto > 1) // Verifica se existe mais de um membro para inserir um hr para separá-lo do novo membro
			$('#separador-participante-novo-gasto-' + (contador_participantes_novo_gasto - 1)).css('display', 'block');

		$('#todos-participantes-novo-gasto').append( // Acrescenta o novo membro a lista
			formatar_texto_membro_novo_gasto(contador_participantes_novo_gasto, novo_email_obj.val())
		);

		contador_participantes_novo_gasto++;

		novo_email_obj.val('');

		return true;
	}
}

/** Insere um novo membro na lista de membros do gasto que está sendo editado quando a tecla Enter for pressionada.
 * event Referência ao evento do teclado.
*/
function incluir_participante_editar_gasto(event) {
	var key = event.which || event.keyCode;
	var novo_email_obj = $('#buscar-email-participante-editar-gasto');
	var alerta_mensagem_obj = $('#alerta_mensagem_editar_gasto');

	if(key == 13) {
		if(!verificar_email(novo_email_obj)) { // Verifica se o e-mail foi digitado corretamente
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Digite um <u>e-mail válido</u>.')
			);

			return false;
		}

		if(!buscar_participante(novo_email_obj.val())) { // Verifica se o usuário está entre os membros do grupo
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', '<strong>Não existe um usuário com esse e-mail</strong>. <u>Escolha outro entre as opções disponíveis na caixa de pesquisa</u>.')
			);

			return false;
		}

		if(!verifica_novos_participantes_adicionados('buscar-email-participante-editar-gasto', 'participantes_editar_gasto')) {
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Esse membro <u>já foi adicionado</u>.')
			);

			return false;
		}
		
		if(contador_participantes_editar_gasto > 1) // Verifica se existe mais de um membro para inserir um hr para separá-lo do novo membro
			$('#separador-participante-editar-gasto-' + (contador_participantes_editar_gasto - 1)).css('display', 'block');

		$('#todos-participantes-editar-gasto').append( // Acrescenta o novo membro a lista
			formatar_texto_membro_editar_gasto(contador_participantes_editar_gasto, novo_email_obj.val())
		);

		contador_participantes_editar_gasto++;

		novo_email_obj.val('');

		return true;
	}
}

/** Faz a inserção do novo gasto no banco de dados e atualiza a lista de gastos bem como seus dados.
*/
function adicionar_gasto() {
	var participantes_adicionados = [];

	$("input[type='text'][name='participantes_novo_gasto[]'").each(function() {
		participantes_adicionados.push($(this).val());
	});

	if(validar_formulario_novo_gasto()) {
		$.ajax({
			url: './reqs/adicionar_gasto.php',
			type: 'POST',
			data: {
				evento_id: $('#info_evento_id').val(),
				grupo_id: $('#info_grupo_id').val(),
				usuario_id: $('#info_usuario_id').val(),
				novo_gasto_descricao: $('#descricao-novo-gasto').val(),
				novo_gasto_categoria: $('#categoria-novo-gasto').val(),
				novo_gasto_data_pagamento: $('#data-pagamento-novo-gasto').val(),
				novo_gasto_valor: $('#valor-novo-gasto').val(),
				participantes: participantes_adicionados
			}
		})
		.done(function() {
			atualizar_lista_gastos();
		})
		.fail(function() {})
		.always(function() {
			$('#janela-adicionar-gasto').modal('hide');

			limpar_formulario_novo_gasto();
		});
	}
}

/** Edita o gasto no banco de dados e atualiza a tabela de gastos bem como seus dados.
*/
function editar_gasto() {
	var participantes_adicionados = [];

	$("input[type='text'][name='participantes_editar_gasto[]'").each(function() {
		participantes_adicionados.push($(this).val());
	});

	if(validar_formulario_editar_gasto()) {
		$.ajax({
			url: './reqs/editar_gasto.php',
			type: 'POST',
			data: {
				grupo_id: 				$('#info_grupo_id').val(),
				evento_id: 				$('#info_evento_id').val(),
				gasto_id: 				$('#info-gasto-id').val(),
				usuario_id: 			$('#info_usuario_id').val(),
				gasto_descricao: 		$('#descricao-editar-gasto').val(),
				gasto_categoria: 		$('#categoria-editar-gasto').val(),
				gasto_data_pagamento: 	$('#data-pagamento-editar-gasto').val(),
				gasto_valor: 			$('#valor-editar-gasto').val(),
				participantes: 			participantes_adicionados
			}
		})
		.done(function() {
			atualizar_lista_gastos();
		})
		.fail(function() {})
		.always(function() {
			$('#janela-editar-gasto').modal('hide');

			limpar_formulario_editar_gasto();
		});
	}
}


/**
*/
function limpar_formulario_novo_gasto() {
	$('#janela-adicionar-gasto').each(function() { this.reset();	});

	for(contador_participantes_novo_gasto; contador_participantes_novo_gasto > 0; contador_participantes_novo_gasto--) {
		$('#item-participante-novo-gasto-' + contador_participantes_novo_gasto).remove();
	}

	$('#alerta_mensagem_adicionar_gasto').html("");

	//$('#nchar_nome').html("30");
	//$('#nchar_descricao').html("100");

	contador_participantes_novo_gasto = 1;
}

/**
*/
function limpar_formulario_editar_gasto() {
	$('#janela-editar-gasto').each(function() { this.reset();	});

	for(contador_participantes_editar_gasto; contador_participantes_editar_gasto > 0; contador_participantes_editar_gasto--) {
		$('#item-participante-editar-gasto-' + contador_participantes_editar_gasto).remove();
	}

	$('#alerta_mensagem_editar_gasto').html("");

	//$('#nchar_nome').html("30");
	//$('#nchar_descricao').html("100");

	contador_participantes_editar_gasto = 1;
}

/** Marca/desmarca todas os checkboxes do corpo da tabela caso o checkbox do cabeçalho seja marcado/desmarcado.
*/
function toggle_all_checkboxes(element) {
	var todos_selecionados = $("input[type=checkbox][name='item']:checked");

	$("input[type=checkbox][name='item']").each(function(index, item) {
		item.checked = element.checked;
	});

	if(element.checked) {
		mostrar_botao_excluir_gasto();
	}
	else {
		mostrar_botao_adicionar_gasto();
	}
}

/** Verifica se existe pelo menos um checkbox selecionado na tabela. 
*/
function verificar_valor_checkboxes() {
	var todos_selecionados 		= $("input[type=checkbox][name='item']:checked");
	var todos_nao_selecionados 	= $("input[type=checkbox][name='item']:not(:checked)");

	if(todos_selecionados.length > 0) {
		mostrar_botao_excluir_gasto();
	} else {
		$('#checkbox-excluir-todos-gastos').prop('checked', false);
		mostrar_botao_adicionar_gasto();
	}

	if(todos_nao_selecionados.length == 0) {
		$('#checkbox-excluir-todos-gastos').prop('checked', true);
	}
}

/** Devolve a função do botão de adicionar gasto.
*/
function mostrar_botao_adicionar_gasto() {
	$('#btn-excluir-gasto').hide();
	$('#btn-adicionar-gasto').fadeIn();
}

/** Muda a função do botão de adicionar gasto para poder excluir os gastos marcados.
*/
function mostrar_botao_excluir_gasto() {
	$('#btn-adicionar-gasto').hide();
	$('#btn-excluir-gasto').fadeIn();
}

/** Envia uma requisição ao banco de dados para excluir os eventos selecionados.
*/
function excluir_gastos() {
	var gastos_selecionados = [];

	$("input[type=checkbox][name='item']:checked").each(function() {
		gastos_selecionados.push($(this).val());
	});

	$.ajax({
		url: './reqs/deletar_gastos.php',
		type: 'POST',
		data: {
			usuario_id: $('#info_usuario_id').val(),
			grupo_id: 	$('#info_grupo_id').val(),
			evento_id: 	$('#info_evento_id').val(),
			gastos_ids: gastos_selecionados,
		}
	})
	.done(function(mensagem) {
		if(mensagem.length != 0) {
			$('#alerta_mensagem').html(formatar_texto_alerta("danger", mensagem));
		}
		else {
			atualizar_lista_gastos();
			mostrar_botao_adicionar_gasto();
			$('#checkbox-excluir-todos-gastos').prop('checked', false);
		}
	})
	.fail(function() {console.log("error"); })
	.always(function() {
		$('#janela-excluir-gasto').modal('hide');
	});
}

/**
*/
function paginar_gastos(element) {
	var pagina_clicada = $('#' + element.id).data('pagina_clicada');
	pagina_clicada = pagina_clicada - 1; //necessário para ajusar o parâmetro offset

	//recupera os parametros de paginacao do formulario
	var registros_por_pagina = $('#registros_por_pagina').val();
	var pagina_atual = $('#pagina_atual').val();

	var offset_atualizado = pagina_clicada * registros_por_pagina;
	//aplica o valor atualizado do offset ao campo do form
	$('#offset').val(offset_atualizado);

	atualizar_lista_gastos();
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
function apagar_texto(input_id) {
	$('#' + input_id).val("");
}

/**
*/
function altera_gastoId_botao_editar_gasto(element) {
	$('#info-gasto-id').val($('#' + element.id).data('gasto_id'));
}

/* ===================================================================== */
/* ======================== OUTRAS REQUISIÇÕES ========================= */
/* ===================================================================== */

/** Verifica no banco de dados se o participante faz parte do grupo.
 * email E-mail do participante.
*/
function buscar_participante(email) {
	var membro_existe;

	$.ajax({
		url: './reqs/verifica_entre_membros.php',
		type: 'POST',
		data: {
			membro_email: 	email,
			grupo_id: 		$('#info_grupo_id').val()
		},
		async: false
	})
	.done(function(data) {
		membro_existe = data;
	})
	.fail(function() {})
	.always(function() {});

	return membro_existe;
}

/**
*/
function atualizar_lista_gastos() {
	$.ajax({
		url: './reqs/atualizar_lista_gastos.php',
		type: 'POST',
		data: {
			grupo_id: 			$('#info_grupo_id').val(),
			evento_id: 			$('#info_evento_id').val(),
			regs_por_pagina: 	$('#registros_por_pagina').val(),
			offset: 			$('#offset').val(),
			ordem: 				$('#ordem').val(),
			tipo_ordem: 		($('#btn-ordenar-asc').is(':visible') ? $('#btn-ordenar-asc').data('tipo-ordem') : $('#btn-ordenar-desc').data('tipo-ordem')),
			texto_pesquisado: 	$('#barra-de-pesquisa').val()
		}
	})
	.done(function(data) {
		try {
			var parsed = JSON.parse(data);
			$('#tabela-gastos-corpo').html(parsed.gastos);
			$('#lista_paginas').html(parsed.paginas);
		} catch(e_alerta) {
			$('#tabela-gastos-corpo').html(data);
		}
	})
	.fail(function() {})
	.always(function() {});
}

/**
*/
function buscar_titulo_evento() {
	$.ajax({
		url: './reqs/buscar_titulo_evento.php',
		type: 'POST',
		data: {
			evento_id: $('#info_evento_id').val()
		}
	})
	.done(function(data) {
		$('#btn-titulo-gasto').html(data);
		$('#tabela-gastos-caption').html("Gastos do evento " + data + ".");
	})
	.fail(function() {})
	.always(function() {});
}

/**
*/
function buscar_infos_gasto() {
	$.ajax({
		url: './reqs/buscar_infos_gasto.php',
		type: 'POST',
		data: {
			gasto_id: 	$('#info-gasto-id').val()
		}
	})
	.done(function(data) {
		try {
			var parsed = JSON.parse(data);

			$('#descricao-editar-gasto').val(parsed.descricao);
			$('#categoria-editar-gasto').val(parsed.categoria);
			$('#data-pagamento-editar-gasto').val(parsed.data_pagamento);
			$('#valor-editar-gasto').val(parsed.valor);
			$('#todos-participantes-editar-gasto').html(parsed.participantes);

			contador_participantes_editar_gasto = parsed.contador;
		} catch(e_alerta) {
			$('#alerta_mensagem_editar_gasto').html(data);
		}
	})
	.fail(function() {})
	.always(function() {});
}


/* ===================================================================== */
/* ============================== TRIGGERS ============================= */
/* ===================================================================== */

/** Quando o modal para adicionar um novo gasto é carregado atribui-se o foco ao primeiro campo do formulário.
*/
function trigger_exibir_modal_adicionar_gasto() {
	$('#janela-adicionar-gasto').on('shown.bs.modal', function() {	
		document.getElementById("descricao-novo-gasto").focus();
	})
}

/** Quando o modal para adicionar um novo gasto termina de ocultar-se (fim de todas as transições) limpa-se todo os campos do modal.
*/
function trigger_esconder_modal_adicionar_gasto() {
	$('#janela-adicionar-gasto').on('hidden.bs.modal', function(e) {
	  limpar_formulario_novo_gasto();
	})
}

/** Quando o modal para excluir um gasto é carregado atualiza-se a semântica da mensagem conforme a quantidade de gastos marcados.
*/
function trigger_exibir_modal_excluir_evento() {
	$('#janela-excluir-gasto').on('shown.bs.modal', function() {
		exibe_quantidade_eventos_marcados('legenda_quantidade_itens_marcados_excluir');
	
		document.getElementById("modal-btn-excluir-gasto").focus();
	})
}

/** Quando o modal para editar um gasto é carregado atribui-se o foco ao primeiro campo do formulário e carrega-se os dados do gasto no formulário.
*/
function trigger_exibir_modal_editar_gasto() {
	$('#janela-editar-gasto').on('shown.bs.modal', function() {	
		document.getElementById("descricao-editar-gasto").focus();
		buscar_infos_gasto();
	})
}

/** Quando o modal para editar um gasto termina de ocultar-se (fim de todas as transições) limpa-se todo os campos do modal.
*/
function trigger_esconder_modal_editar_gasto() {
	$('#janela-editar-gasto').on('hidden.bs.modal', function() {	
		limpar_formulario_editar_gasto();
	})
}


/* ===================================================================== */
/* ============================== OUTROS =============================== */
/* ===================================================================== */

$(document).ready(function() {
	buscar_titulo_evento();
	mostrar_botao_ordenar_desc();
	atualizar_lista_gastos();
	mostrar_botao_adicionar_gasto();

	trigger_exibir_modal_adicionar_gasto();
	trigger_esconder_modal_adicionar_gasto();
	trigger_exibir_modal_excluir_evento();
	trigger_exibir_modal_editar_gasto();
	trigger_esconder_modal_editar_gasto();
});