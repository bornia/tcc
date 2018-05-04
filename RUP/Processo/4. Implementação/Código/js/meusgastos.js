var contador_participantes = 1; // Indica a ordem de inclusão dos participantes na lista

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
function seleciona_pesquisa_usuario(email) {
	$('#buscar-email-participante').val(email);
	$('#caixa-pesquisa-usuarios').hide();
	$('#buscar-email-participante').get(0).focus();
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
function verifica_novos_participantes_adicionados() {
	var novo_email_obj = $('#buscar-email-participante');
	var email_ja_existe = true;

	$("input[type='text'][name='participantes[]'").each(function(index, element) {
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
function formatar_texto_novo_membro(ordem, email) {
	var participante =
		"<div class='row' id='item-participante-"+ ordem +"'>" +
			"<div class='col-9'>" +
				"<label for='email-participante-"+ ordem +"' class='text-muted font-weight-bold mb-0 text-size-responsive'>" +
	                "Participante "+ ordem + ": " +
	          	"</label>" +

              	"<input type='text' readonly class='form-control-sm form-control-plaintext text-truncate text-size-responsive' id='email-participante-"+ ordem +"' name='participantes[]' value='"+ email +"'>" +
            "</div>" +

            "<div class='col'>" +
                "<button type='button' class='close btn-sm' id='"+ ordem +"' onclick='retirar_participante(this)' aria-label='Retirar participante da lista do grupo.'>" +
                  	"&times;" +
                "</button>" +
          	"</div>" +

          	"<hr class='mb-2 mt-2' id='separador-participante-"+ ordem +"' width='85%' style='display: none;'> </div>" +
      	"</div>";

 	return participante;
}

/** Retira um participante da lista de participante do novo gasto.
 * membro Referência ao atributo this passado como argumento ao clicar no botão.
*/
function retirar_participante(participante) {
	$('#item-participante-' + participante.id).remove();

	if(participante.id == contador_participantes - 1 && participante.id == contador_participantes - 1) // Esconde a hr do item anterior
		$('#separador-participante-' + (participante.id - 1)).css('display', 'none');

	contador_participantes--;
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
function validar_formulario() {
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

	if(contador_participantes < 3) { // Verifica se tem pelo menos 2 membro no gasto
		$('#alerta_mensagem_adicionar_gasto').html(
			$('#alerta_mensagem_adicionar_gasto').html() +
			formatar_texto_alerta('warning', 'Inclua <u>pelo menos <b>dois participantes</b></u> no novo gasto. Lembrando que <u>você não está automaticamente incluso</u> dessa vez.')
		);

		validado = false;
	}

	return validado;
}

/* ===================================================================== */
/* ============================== EVENTOS ============================== */
/* ===================================================================== */

/**
*/
function buscar_entre_participantes(id) {
	var email = $('#' + id);

	if(email.val() == '') {
		$('#caixa-pesquisa-usuarios').hide();
		return false;
	}

	$.ajax({
		url: './reqs/buscar_entre_participantes.php',
		type: 'POST',
		data: {
			membro_email: 	email.val(),
			grupo_id: 		$('#info_grupo_id').val()
		}
	})
	.done(function(data) {
		if(data == '') {
			$('#lista-pesquisa-usuarios').html('');
			$('#caixa-pesquisa-usuarios').hide();
		}
		else {
			$('#caixa-pesquisa-usuarios').show();
			$('#lista-pesquisa-usuarios').html(data);
		}
	})
	.fail(function() {})
	.always(function() {});

	return true;
}

/** Insere um novo membro na lista de membros do novo grupo quando a tecla Enter for pressionada.
 * event Referência ao evento do teclado.
*/
function incluir_participante(event) {
	var key = event.which || event.keyCode;
	var novo_email_obj = $('#buscar-email-participante');
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

		if(!verifica_novos_participantes_adicionados()) {
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Esse membro <u>já foi adicionado</u>.')
			);

			return false;
		}
		
		if(contador_participantes > 1) // Verifica se existe mais de um membro para inserir um hr para separá-lo do novo membro
			$('#separador-participante-' + (contador_participantes - 1)).css('display', 'block');

		$('#todos-participantes-novos').append( // Acrescenta o novo membro a lista
			formatar_texto_novo_membro(contador_participantes, novo_email_obj.val())
		);

		contador_participantes++;

		novo_email_obj.val('');

		return true;
	}
}

/** Faz a inserção do novo gasto no banco de dados e atualiza a lista de gastos bem como seus dados.
*/
function adicionar_gasto() {
	var participantes_adicionados = [];

	$("input[type='text'][name='participantes[]'").each(function() {
		participantes_adicionados.push($(this).val());
	});

	if(validar_formulario()) {
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
		.done(function(novos_membros_emails) {
			atualizar_lista_gastos();
		})
		.fail(function() {})
		.always(function() {
			$('#janela-adicionar-gasto').modal('hide');

			limpar_formulario();
		});
	}
}

/**
*/
function limpar_formulario() {
	$('#janela-adicionar-gasto').each(function() { this.reset();	});

	for(contador_participantes; contador_participantes > 0; contador_participantes--) {
		$('#item-participante-' + contador_participantes).remove();
	}

	$('#alerta_mensagem_adicionar_gasto').html("");

	//$('#nchar_nome').html("30");
	//$('#nchar_descricao').html("100");

	contador_participantes = 1;
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
			grupo_id: $('#info_grupo_id').val(),
			evento_id: $('#info_evento_id').val()
		}
	})
	.done(function(data) {
		try {
			var parsed = JSON.parse(data);
			$('#tabela-gastos-corpo').html(parsed.gastos);
			//$('#lista_paginas').html(parsed.paginas);
		} catch(e_alerta) {
			$('#tabela-gastos-corpo').html(data);
		}
	})
	.fail(function() {})
	.always(function() {});
}

/**
*/
function buscar_titulo_gasto() {
	$.ajax({
		url: './reqs/buscar_titulo_gasto.php',
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


/* ===================================================================== */
/* ============================== TRIGGERS ============================= */
/* ===================================================================== */

/** Quando o modal para adicionar um novo evento termina de ocultar-se (fim de todas as transições) limpa-se todo os campos do modal.
*/
function trigger_esconder_modal_adicionar_gasto() {
	$('#janela-adicionar-gasto').on('hidden.bs.modal', function(e) {
	  limpar_formulario();
	})
}


/* ===================================================================== */
/* ============================== OUTROS =============================== */
/* ===================================================================== */

$(document).ready(function() {
	buscar_titulo_gasto();
	atualizar_lista_gastos();

	trigger_esconder_modal_adicionar_gasto();
});