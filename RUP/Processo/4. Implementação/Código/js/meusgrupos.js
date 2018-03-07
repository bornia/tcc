var contador_membros = 1; // Indica a ordem de inclusão dos participantes na lista

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
function formatar_texto_novo_membro(ordem, email) {
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
                    "<option value='dono'> É dono </option>" +
                    "<option value='editar'> Pode editar </option>" +
                    "<option value='ver'> Pode ver </option>" +
                  "</select>" +
                "</div>" +
              "</div>" +
            "</div>" +

            "<div class='col-2'>" +
              "<div class='form-check'>" +
                "<button type='button' class='close btn-sm' id='"+ ordem +"' onclick='retirar_membro(this)' aria-label='Retirar membro da lista do grupo.'>" +
                  "&times;" +
                "</button>" +
              "</div>" +
            "</div>" +

            "<hr id='separador-membro-"+ ordem +"' width='85%' style='display: none;'> </div>" +
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

	if(contador_membros < 2) { // Significa que tem pelo menos 1 membro no grupo
		$('#alerta_mensagem_submit').html(
			$('#alerta_mensagem_submit').html() +
			formatar_texto_alerta('warning', 'Inclua <u>pelo menos <b>um membro</b></u> ao novo grupo.')
		);

		validado = false;
	}

	return validado;
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

/** Insere um novo membro na lista de membros do novo grupo quando a tecla Enter for pressionada.
 * event Referência ao evento do teclado.
*/
function incluir_membro(event) {
	var key = event.which || event.keyCode;

	if(key == 13) {
		if(!verificar_email($('#buscar-email-participante'))) { // Verifica se o e-mail foi digitado corretamente
			$('#alerta_mensagem').html( // Exibe um alerta
				formatar_texto_alerta('warning', 'Digite um <u>e-mail válido</u>.')
			);

			return false;
		}
		
		if(contador_membros > 1) // Verifica se existe mais de um membro para inserir um hr para separá-lo do novo membro
			$('#separador-membro-' + (contador_membros - 1)).css('display', 'block');

		$('#todos-membros-novos').append( // Acrescenta o novo membro a lista
			formatar_texto_novo_membro(contador_membros, $('#buscar-email-participante').val())
		);

		contador_membros++;

		$('#buscar-email-participante').val('');

		return true;
	}
}

/** Retira um membro da lista de membros do novo grupo.
 * membro Referência ao atributo this passado como argumento ao clicar no botão.
*/
function retirar_membro(membro) {
	$('#item-membro-' + membro.id).remove();

	if(membro.id == contador_membros - 1) // Esconde a hr do item anterior
		$('#separador-membro-' + (membro.id - 1)).css('display', 'none');

	contador_membros--;
}

/** Busca pelo título grupo selecionado para exibí-lo no modal de excluir um grupo.
*/
function buscar_titulo_grupo() {
	var titulo = $('.list-group-item.active').html();

	$('#aux-grupo-titulo').html(titulo);
}

/**
*/
function limpar_formulario() {
	$('#janela_novo_grupo').each(function() { this.reset();	});
	for(contador_membros; contador_membros > 0; contador_membros--) {
		$('#item-membro-' + contador_membros).remove();
	}
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
		.done(function() {
			atualizar_lista_grupos();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			$('#janela_novo_grupo').modal('hide');

			limpar_formulario();
		});
	}
}

/**
*/
function atualizar_lista_grupos() {
	$.ajax({
		url: './reqs/atualizar_lista_grupos.php',
		type: 'POST',
	})
	.done(function(data) {
		var grupos = jQuery.parseJSON(data);

		$('#lista-de-grupos').html(grupos.titulos);
		$('#lista-de-grupos-detalhes').html(grupos.detalhes);
	})
	.fail(function() {})
	.always(function() {});
}

/* ===================================================================== */
/* ===================== AUXILIARES DE REQUISIÇÕES ===================== */
/* ===================================================================== */

