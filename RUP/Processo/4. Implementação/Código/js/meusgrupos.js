var contador_membros = 1; // Indica a ordem de inclusão dos participantes na lista
var contador_membros_editar_grupo = 1; // Indica a ordem de inclusão dos participantes na lista

/* ===================================================================== */
/* ======================== FUNÇÕES AUXILIARES ========================= */
/* ===================================================================== */

/** Habilita os Tooltips
*/
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
});

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

/** Formata o texto de cada "item de membro" adicionado na lista do novo grupo.
* ordem Indica qual é a posição do membro na lista. Serve de ID para o membro.
* email É o e-mail do membro.
*/
function formatar_texto_membro_novo_grupo(ordem, email) {
	var membro =
		"<div class='row' id='item-membro-"+ ordem +"'>" +
            "<div class='col-10'>" +
              "<div class='row'>" +
                "<div class='col-12 col-md-7'>" +
                  "<label for='email-membro-"+ ordem +"' class='col-form-label sr-only'>" +
                    "Membro novo "+ ordem +
                  "</label>" +

                  "<input type='text' readonly class='form-control-sm form-control-plaintext text-truncate text-size-responsive' id='email-membro-"+ ordem +"' name='membros[]' value='"+ email +"'>" +
                "</div>" +

                "<div class='col-12 col-md-5'>" +
                  "<label class='sr-only' for='dpbox-permissoes'>" +
                    "Defina as permissões do usuário:" +
                  "</label>" +

                  "<select class='form-control form-control-sm text-size-responsive' id='dpbox-permissoes' name='permissoes[]'>" +
                    "<option value='1'> Pode ver </option>" +
                    "<option value='2'> Pode editar </option>" +
                    "<option value='3'> É dono </option>" +
                  "</select>" +
                "</div>" +
              "</div>" +
            "</div>" +

            "<div class='col-2'>" +
              "<div class='form-check'>" +
                "<button type='button' class='close btn-sm' id='btn-retirar-membro-novo-grupo-"+ ordem +"' onclick='retirar_membro_novo_grupo(this)' aria-label='Retirar membro da lista do grupo.'>" +
                  "&times;" +
                "</button>" +
              "</div>" +
            "</div>" +

            "<hr id='separador-membro-"+ ordem +"' width='85%' style='display: none;'> </div>" +
      	"</div> <!-- item-participante -->";

 	return membro;
}

/** Formata o texto de cada "item de membro" adicionado na lista de editar grupo.
* ordem Indica qual é a posição do membro na lista. Serve de ID para o membro.
* email É o e-mail do membro.
*/
function formatar_texto_membro_editar_grupo(ordem, email) {
	var membro =
		"<div class='row' id='item-membro-editar-grupo-"+ ordem +"'>" +
            "<div class='col-10'>" +
              "<div class='row'>" +
                "<div class='col-12 col-md-7'>" +
                  "<label for='email-membro-editar-grupo-"+ ordem +"' class='col-form-label sr-only'>" +
                    "Membro "+ ordem +
                  "</label>" +

                  "<input type='text' readonly class='form-control-sm form-control-plaintext text-truncate text-size-responsive' id='email-membro-editar-grupo-"+ ordem +"' name='membros_editar_grupo[]' value='"+ email +"'>" +
                "</div>" +

                "<div class='col-12 col-md-5'>" +
                  "<label class='sr-only' for='dpbox-permissoes'>" +
                    "Defina as permissões do usuário:" +
                  "</label>" +

                  "<select class='form-control form-control-sm text-size-responsive' id='dpbox-permissoes' name='permissoes_editar_grupo[]'>" +
                    "<option value='1'> Pode ver </option>" +
                    "<option value='2'> Pode editar </option>" +
                    "<option value='3'> É dono </option>" +
                  "</select>" +
                "</div>" +
              "</div>" +
            "</div>" +

            "<div class='col-2'>" +
              "<div class='form-check'>" +
                "<button type='button' class='close btn-sm' id='btn-retirar-membro-editar-grupo-"+ ordem +"' onclick='retirar_membro_editar_grupo(this)' aria-label='Retirar membro da lista do grupo.'>" +
                  "&times;" +
                "</button>" +
              "</div>" +
            "</div>" +

            "<hr id='separador-membro-editar-grupo-"+ ordem +"' width='85%' style='display: none;'> </div>" +
      	"</div> <!-- item-participante -->";

 	return membro;
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

/** Valida o formulário verificando se atende aos padrões determinados.
*/
function validar_formulario() {
	var validado = true;

	if(!verifica_campo_vazio('nome_grupo')) {
		$('#alerta_mensagem_submit').html(
			$('#alerta_mensagem_submit').html() +
			formatar_texto_alerta('warning', '<u>Dê um <b>título</b></u> ao novo grupo.')
		);

		$('#nome_grupo').focus();

		validado = false;
	}

	if(contador_membros < 2) { // Verifica se tem pelo menos 1 membro no grupo
		$('#alerta_mensagem_submit').html(
			$('#alerta_mensagem_submit').html() +
			formatar_texto_alerta('warning', 'Inclua <u>pelo menos <b>um membro</b></u> ao novo grupo.')
		);

		validado = false;
	}

	return validado;
}

/** Valida o formulário verificando se atende aos padrões determinados.
*/
function validar_formulario_editar_grupo() {
	var validado = true;

	if(!verifica_campo_vazio('titulo-editar-grupo')) {
		$('#alerta-mensagem-editar-grupo').html(
			$('#alerta-mensagem-editar-grupo').html() +
			formatar_texto_alerta('warning', '<u>Dê um <b>título</b></u> ao novo grupo.')
		);

		$('#titulo-editar-grupo').focus();

		validado = false;
	}

	if(contador_membros_editar_grupo < 2) { // Verifica se tem pelo menos 1 membro no grupo
		$('#alerta-mensagem-editar-grupo').html(
			$('#alerta-mensagem-editar-grupo').html() +
			formatar_texto_alerta('warning', 'Inclua <u>pelo menos <b>um membro</b></u> ao novo grupo.')
		);

		validado = false;
	}

	return validado;
}

/**
*/
function seleciona_linha_grupo(grupoId) {
	$('.bg-primary').toggleClass('bg-primary bg-white')
	$('#linha-' + grupoId).toggleClass('bg-white bg-primary')
}

/**
*/
function seleciona_detalhe_grupo(grupoId) {
	$('.d-block').toggleClass('d-block d-none');
	$('#ref-' + grupoId).toggleClass('d-none d-block');
	$('.d-block').hide();
	$('.d-block').fadeIn();
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

/**
*/
function buscar_entre_membros(id) {
	var email = $('#' + id);

	if(email.val() == '') {
		$('#caixa-pesquisa-usuarios-novo-grupo').hide();
		return false;
	}

	$.ajax({
		url: './reqs/buscar_entre_usuarios.php',
		type: 'POST',
		data: {usuario_email: email.val()}
	})
	.done(function(data) {
		if(data == '') {
			$('#lista-pesquisa-usuarios-novo-grupo').html('');
			$('#caixa-pesquisa-usuarios-novo-grupo').hide();
		}
		else {
			$('#caixa-pesquisa-usuarios-novo-grupo').show();
			$('#lista-pesquisa-usuarios-novo-grupo').html(data);
		}
	})
	.fail(function() {})
	.always(function() {});

	return true;
}

/**
*/
function buscar_entre_membros_editar_grupo(id) {
	var email = $('#' + id);

	if(email.val() == '') {
		$('#caixa-pesquisa-usuarios-editar-grupo').hide();
		return false;
	}

	$.ajax({
		url: './reqs/buscar_entre_usuarios_editar_grupo.php',
		type: 'POST',
		data: {usuario_email: email.val()}
	})
	.done(function(data) {
		if(data == '') {
			$('#lista-pesquisa-usuarios-editar-grupo').html('');
			$('#caixa-pesquisa-usuarios-editar-grupo').hide();
		}
		else {
			$('#caixa-pesquisa-usuarios-editar-grupo').show();
			$('#lista-pesquisa-usuarios-editar-grupo').html(data);
		}
	})
	.fail(function() {})
	.always(function() {});

	return true;
}

/**
*/
function seleciona_pesquisa_usuario_novo_grupo(email) {
	$('#buscar-email-participante').val(email);
	$('#caixa-pesquisa-usuarios-novo-grupo').hide();
	$('#buscar-email-participante').get(0).focus();
}

/**
*/
function seleciona_pesquisa_usuario_editar_grupo(email) {
	$('#buscar-email-participante-editar-grupo').val(email);
	$('#caixa-pesquisa-usuarios-editar-grupo').hide();
	$('#buscar-email-participante-editar-grupo').get(0).focus();
}

/**
*/
function buscar_membro(email) {
	var membro_existe;

	$.ajax({
		url: './reqs/buscar_entre_usuarios.php',
		type: 'POST',
		data: {usuario_email: email},
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
function verifica_novos_membros_adicionados(campo_id, tag_name) {
	var novo_email_obj = $('#' + campo_id);
	var email_ja_existe = true;

	$("input[type='text'][name='" + tag_name + "[]'").each(function(index, element) {
		if(novo_email_obj.val() == $(element).val()) {
			email_ja_existe =  false;
			return true;
		}
	});

	return email_ja_existe;
}

/** Insere um novo membro na lista de membros do novo grupo quando a tecla Enter for pressionada.
 * event Referência ao evento do teclado.
*/
function incluir_membro(event) {
	var key = event.which || event.keyCode;
	var novo_email_obj = $('#buscar-email-participante');
	var alerta_mensagem_obj = $('#alerta_mensagem');

	if(key == 13) {
		if(!verificar_email(novo_email_obj)) { // Verifica se o e-mail foi digitado corretamente
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Digite um <u>e-mail válido</u>.')
			);

			return false;
		}

		if($('#aux_usuario_email').val() == novo_email_obj.val()) { // Verifica se o usuário está adicionando ele próprio
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Você será <u>automaticamente incluído</u> no grupo. <strong>Adicione os outros membros</strong>.')
			);

			return false;
		}

		if(!buscar_membro(novo_email_obj.val())) { // Verifica se o usuário está cadastrado no Banco de Dados
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', '<strong>Não existe um usuário com esse e-mail</strong>. <u>Escolha outro entre as opções disponíveis na caixa de pesquisa</u>.')
			);

			return false;
		}

		if(!verifica_novos_membros_adicionados('buscar-email-participante', 'membros')) {
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Esse membro <u>já foi adicionado</u>.')
			);

			return false;
		}
		
		if(contador_membros > 1) // Verifica se existe mais de um membro para inserir um hr para separá-lo do novo membro
			$('#separador-membro-' + (contador_membros - 1)).css('display', 'block');

		$('#todos-membros-novos').append( // Acrescenta o novo membro a lista
			formatar_texto_membro_novo_grupo(contador_membros, novo_email_obj.val())
		);

		contador_membros++;

		novo_email_obj.val('');

		return true;
	}
}

/** Insere um novo membro na lista de membros do novo grupo quando a tecla Enter for pressionada.
 * event Referência ao evento do teclado.
*/
function incluir_membro_editar_grupo(event) {
	var key = event.which || event.keyCode;
	var novo_email_obj = $('#buscar-email-participante-editar-grupo');
	var alerta_mensagem_obj = $('#alerta-mensagem-editar-grupo');

	if(key == 13) {
		if(!verificar_email(novo_email_obj)) { // Verifica se o e-mail foi digitado corretamente
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Digite um <u>e-mail válido</u>.')
			);

			return false;
		}

		if($('#aux_usuario_email').val() == novo_email_obj.val()) { // Verifica se o usuário está adicionando ele próprio
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Você será <u>automaticamente incluído</u> no grupo. <strong>Adicione os outros membros</strong>.')
			);

			return false;
		}

		if(!buscar_membro(novo_email_obj.val())) { // Verifica se o usuário está cadastrado no Banco de Dados
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', '<strong>Não existe um usuário com esse e-mail</strong>. <u>Escolha outro entre as opções disponíveis na caixa de pesquisa</u>.')
			);

			return false;
		}

		if(!verifica_novos_membros_adicionados('buscar-email-participante-editar-grupo', 'membros_editar_grupo')) {
			alerta_mensagem_obj.html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Esse membro <u>já foi adicionado</u>.')
			);

			return false;
		}
		
		if(contador_membros_editar_grupo > 1) // Verifica se existe mais de um membro para inserir um hr para separá-lo do novo membro
			$('#separador-membro-editar-grupo-' + (contador_membros_editar_grupo - 1)).css('display', 'block');

		$('#todos-membros-editar-grupo').append( // Acrescenta o novo membro a lista
			formatar_texto_membro_editar_grupo(contador_membros_editar_grupo, novo_email_obj.val())
		);

		contador_membros_editar_grupo++;

		novo_email_obj.val('');

		return true;
	}
}

/** Retira um membro da lista de membros do novo grupo.
 * membro Referência ao atributo this passado como argumento ao clicar no botão.
*/
function retirar_membro_novo_grupo(membro) {
	var membro_id = $('#' + membro.id).attr('id').replace("btn-retirar-membro-novo-grupo-", "");

	$('#item-membro-' + membro_id).remove();

	if(membro_id == contador_membros - 1) // Esconde a hr do item anterior
		$('#separador-membro-' + (membro_id - 1)).css('display', 'none');

	contador_membros--;
}

/** Retira um membro da lista de membros do novo grupo.
 * membro Referência ao atributo this passado como argumento ao clicar no botão.
*/
function retirar_membro_editar_grupo(membro) {
	var membro_id = $('#' + membro.id).attr('id').replace("btn-retirar-membro-editar-grupo-", "");
	
	$('#item-membro-editar-grupo-' + membro_id).remove();

	if(membro_id == contador_membros_editar_grupo - 1) // Esconde a hr do item anterior
		$('#separador-membro-editar-grupo' + (membro_id - 1)).css('display', 'none');

	contador_membros_editar_grupo--;
}

/**
*/
function limpar_formulario() {
	$('#janela_novo_grupo').each(function() { this.reset();	});

	for(contador_membros; contador_membros > 0; contador_membros--) {
		$('#item-membro-' + contador_membros).remove();
	}

	$('#alerta_mensagem_submit').html("");

	$('#nchar_nome').html("30");
	$('#nchar_descricao').html("100");

	$('#caixa-pesquisa-usuarios-novo-grupo').hide();

	contador_membros = 1;
}

/**
*/
function limpar_formulario_editar_grupo() {
	$('#janela-editar-grupo').each(function() { this.reset();	});

	for(contador_membros_editar_grupo; contador_membros_editar_grupo > 0; contador_membros_editar_grupo--) {
		$('#item-membro-editar-grupo-' + contador_membros_editar_grupo).remove();
	}

	$('#alerta-mensagem-editar-grupo').html("");

	$('#nchar_nome_editar_grupo').html("30");
	$('#nchar_descricao_editar_grupo').html("100");

	$('#caixa-pesquisa-usuarios-editar-grupo').hide();

	contador_membros_editar_grupo = 1;
}

/** Faz a inserção do novo grupo no banco de dados e atualiza a lista de grupos bem como seus dados.
*/
function criar_grupo() {
	if(validar_formulario()) {
		$.ajax({
			url: './reqs/adicionar_grupo.php',
			type: 'POST',
			data: $('#janela_novo_grupo').serialize()
		})
		.done(function(novos_membros_emails) {
			var parsed = JSON.parse(novos_membros_emails);
			enviar_notificacao_email(parsed);
			atualizar_lista_grupos();
		})
		.fail(function() {})
		.always(function() {
			$('#janela_novo_grupo').modal('hide');

			limpar_formulario();
		});
	}
}

/** 
*/
function editar_grupo() {
	var membros		= [];
	var permissoes 	= [];

	$("input[type='text'][name='membros_editar_grupo[]'").each(function() {
		membros.push($(this).val());
	});

	$("select[name='permissoes_editar_grupo[]'").each(function() {
		permissoes.push($(this).val());
	});

	if(validar_formulario_editar_grupo()) {
		$.ajax({
			url: './reqs/editar_grupo.php',
			type: 'POST',
			data: {
				grupo_id: 			$('.bg-primary').attr('id').replace("linha-grupo", ""),
				usuario_id: 		$('#info_usuario_id').val(),
				titulo_grupo: 		$('#titulo-editar-grupo').val(),
				descricao_grupo: 	$('#descricao-editar-grupo').val(),
				permissoes_grupo: 	permissoes,
				emails_grupo: 		membros
			}
		})
		.done(function(data) {
			try {
				var parsed = JSON.parse(data);
				
				if(parseInt(parsed.erro_id) != 0) {
					$('#alerta-mensagem-editar-grupo').html(formatar_texto_alerta('warning', parsed.erro_mensagem));
				} else {
					$('#alerta_info_grupos').html(formatar_texto_alerta('success', parsed.sucesso_mensagem));
					atualizar_lista_grupos();
					$('#janela-editar-grupo').modal('hide');
				}
			} catch(e_alerta) {
				$('#alerta-mensagem-editar-grupo').html(
					formatar_texto_alerta('warning', data)
				);
			}
		})
		.fail(function() {})
		.always(function() {});
	}
}

/**
*/
function enviar_notificacao_email(emails) {
	$.ajax({
		url: './reqs/envia_email_novo_grupo.php',
		type: 'POST',
		data: {membros_emails: emails},
	})
	.done(function(data) {
		$('#alerta_info_grupos').html(
			formatar_texto_alerta('info', 'Os membros adicionados serão <u>notificados por e-mail</u>.')
		);
	})
	.fail(function() {})
	.always(function() {});
	
}

/** Faz uma requisição ao Banco de Dados para obter todos os grupos criados pelo usuário e dos quais ele participa.
*/
function atualizar_lista_grupos() {
	$.ajax({
		url: './reqs/atualizar_lista_grupos.php',
		type: 'POST',
	})
	.done(function(data) {
		if(data == 'Nenhum grupo') {
			$('#lista-de-grupos').html("<span class='text-muted'>Não há nenhum grupo para ser exibido.</span>");
			$('#lista-de-grupos-detalhes').html("");
		}
		else {
			var grupos = jQuery.parseJSON(data);

			$('#lista-de-grupos').html(grupos.titulos);
			$('#lista-de-grupos-detalhes').html(grupos.detalhes);
		}
	})
	.fail(function() {})
	.always(function() {});
}

/**
*/
function verifica_permissao_usuario(grupos_ids) {
	var grupos_permitidos;

	$.ajax({
		url: './reqs/busca_permissao_grupo_usuario.php',
		type: 'POST',
		data: {grupos: grupos_ids},
		//dataType: 'json',
		async: false
	})
	.done(function(grupos) {
		var grupos_json_parsed = jQuery.parseJSON(grupos);
		
		if(grupos_json_parsed.proibidos.length != 0) {
			$('#alerta_info_grupos').html(
				formatar_texto_alerta('primary', '<strong>Não foi possível excluir</strong> os grupos <i>' + grupos_json_parsed.proibidos.join() + '</i>. <u>Você não tem a permissão de dono</u> sobre eles.')
			);
		}

		grupos_permitidos = grupos_json_parsed.permitidos_ids;
	})
	.fail(function() {})
	.always(function() {});

	return grupos_permitidos;
}

/** Obtém todas as checkboxes selecionadas para exclusão, manda a requisição ao Banco de Dados e atualiza a lista de grupos.
*/
function excluir_grupos() {
	var grupos_selecionados = [];
	$("input[type=checkbox][name='lista-exclusao-grupos']:checked").each(function() {
		grupos_selecionados.push($(this).val());
	});

	var grupos_permitidos = verifica_permissao_usuario(grupos_selecionados);

	$.ajax({
		url: './reqs/deletar_grupos.php',
		type: 'POST',
		data: {grupos: grupos_permitidos},
	})
	.done(function() {
		atualizar_lista_grupos();
		$('#janela_excluir_grupo').modal('hide');
	})
	.fail(function() {})
	.always(function() {});

	return true;
}

/**
*/
function seleciona_grupo(element) {
	seleciona_linha_grupo(element.id);
	seleciona_detalhe_grupo(element.id);
}

/** Verifica quantos grupos estão marcados para exclusão para poder mostrar a mensagem correta ao usuário bem como impedir que seja excluído zero grupos.
*/
function marcar_excluir_grupos() {
	var qtd_grupos = 0;

	$("input[type=checkbox][name='lista-exclusao-grupos']:checked").each(function(){
		qtd_grupos++;
	});

	if(qtd_grupos == 0) {
		$('#aux-grupo-titulo').html('Não há <u>nenhum grupo selecionado</u>.');
		if(!$('#btn-excluir-grupo').hasClass('disabled')) {
			$('#btn-excluir-grupo').addClass('disabled');
			$('#btn-excluir-grupo').attr("aria-disabled", true);
		}

		return false;
	}
	else if(qtd_grupos == 1)
		$('#aux-grupo-titulo').html('Tem certeza que deseja excluir <u>o grupo selecionado</u>?');
	else
		$('#aux-grupo-titulo').html('Tem certeza que deseja excluir <u>todos os <strong>' + qtd_grupos + '</strong> selecionados</u>');

	if($('#btn-excluir-grupo').hasClass('disabled')) {
		$('#btn-excluir-grupo').removeClass('disabled');
		$('#btn-excluir-grupo').attr("aria-disabled", false);
	}

	return true;
}

/** Devolve a função do botão de adicionar gasto.
*/
function mostrar_botao_criar_grupo() {
	$('#btn-excluir-grupo-marcado').hide();
	$('#btn-criar-grupo').fadeIn();
}

/** Muda a função do botão de adicionar gasto para poder excluir os gastos marcados.
*/
function mostrar_botao_excluir_grupo() {
	$('#btn-criar-grupo').hide();
	$('#btn-excluir-grupo-marcado').fadeIn();
}

/** Verifica se existe pelo menos um checkbox selecionado na tabela. 
*/
function verificar_valor_checkboxes() {
	var todos_selecionados 		= $("input[type=checkbox][name='lista-exclusao-grupos']:checked");
	//var todos_nao_selecionados 	= $("input[type=checkbox][name='lista-exclusao-grupos']:not(:checked)");

	if(todos_selecionados.length > 0) {
		mostrar_botao_excluir_grupo();
	} else {
		//$('#checkbox-excluir-todos-gastos').prop('checked', false);
		mostrar_botao_criar_grupo();
	}

	/*if(todos_nao_selecionados.length == 0) {
		$('#checkbox-excluir-todos-gastos').prop('checked', true);
	}*/
}

function buscar_info_grupo() {	
	$.ajax({
		url: './reqs/recuperar_info_grupo.php',
		type: 'POST',
		data: {
			grupo_id: $('.bg-primary').attr('id').replace("linha-grupo", ""),
			usuario_id: $('#info_usuario_id').val()
		}
	})
	.done(function(data) {
		try {
			var parsed = JSON.parse(data);

			$('#titulo-editar-grupo').val(parsed.titulo);
			$('#descricao-editar-grupo').val(parsed.descricao);
			$('#todos-membros-editar-grupo').html(parsed.membros);
			contador_membros_editar_grupo = parsed.contador;
		} catch(e_alerta) {
			$('#alerta-mensagem-editar-grupo').html(
				formatar_texto_alerta('warning', data)
			);
		}
	})
	.fail(function() {})
	.always(function() {});
}

/* ===================================================================== */
/* ===================== AUXILIARES DE REQUISIÇÕES ===================== */
/* ===================================================================== */


/* ===================================================================== */
/* ============================= TRIGGERS ============================== */
/* ===================================================================== */

/**
*/
function trigger_exibir_modal_novo_grupo() {
	$('#janela_novo_grupo').on('shown.bs.modal', function() {
		document.getElementById("nome_grupo").focus();
	})
}

/** Quando o modal para editar um gasto é carregado atribui-se o foco ao primeiro campo do formulário e carrega-se os dados do gasto no formulário.
*/
function trigger_exibir_modal_editar_grupo() {
	$('#janela-editar-grupo').on('shown.bs.modal', function() {	
		document.getElementById("titulo-editar-grupo").focus();
	})
}

/** Quando o modal para editar um gasto termina de ocultar-se (fim de todas as transições) limpa-se todo os campos do modal.
*/
function trigger_esconder_modal_editar_grupo() {
	$('#janela-editar-grupo').on('hidden.bs.modal', function() {	
		limpar_formulario_editar_grupo();
	})
}

/* ===================================================================== */
/* ============================== OUTROS =============================== */
/* ===================================================================== */

$(document).ready(function() {
	mostrar_botao_criar_grupo();
	atualizar_lista_grupos();

	$('.caixa-pesquisa-usuarios').hide();
	
  	$('html>body').click(function(event) {
  		if($('.caixa-pesquisa-usuarios').css('display') != 'none') {
  			$('.caixa-pesquisa-usuarios').hide();
  		}
  	});

  	trigger_exibir_modal_novo_grupo();

  	trigger_exibir_modal_editar_grupo();
  	trigger_esconder_modal_editar_grupo();
});
