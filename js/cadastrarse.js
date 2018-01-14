/** Faz contagem dos caracteres digitados em um input e exibe a contagem
 * element_checked = input que terá seus caracteres contados
 * element_nchar = elemento no qual a contagem será exibida
 * limite = máximo de caracteres do input
*/
function check_nchar(element_checked, element_nchar, limite) {
  var campo_contador = document.getElementById(element_nchar);
  var campo_checado = document.getElementById(element_checked).value;
  var max_tam = limite - campo_checado.length;

  if(max_tam == -1) {
      return false;
  }

  campo_contador.innerHTML = max_tam;
  return true;
}

/**
*/
function criar_alerta(tipo, mensagem) {
  var alerta =
    "<div class='alert alert-" + tipo + "' role='alert'>" +
      "<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>" +
        "<span aria-hidden='true'> &times; </span>" +
      "</button>" +
      "<div> " + mensagem + " </div>" +
    "</div>";

  return alerta.toString();
}

/** Valida se o nome não está vázio
*/
function verificar_nome(object) {
  var nome = object.val();

  if(nome.length == 0)
    return false;

  return true;
}

/** Valida o e-mail digitado
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
function verificar_tamanho_senha(object) {
  var senha = object.val();
  var minlength = object.attr('minlength');

  if(senha.length < minlength)
    return false;

  return true;
}

/**
*/
function verificar_igualdade_senhas(object1, object2) {
  var senha1 = object1.val();
  var senha2 = object2.val();

  if(senha1 != senha2)
    return false;

  return true;
}

/**
*/
function verificar_opcao(object) {
  var opcao = object.val();
  
  if(opcao == null || opcao == "")
    return false;

  return true;
}

/**
*/
function validar_formulario() {
  var validado = true;
  $('#alerta_mensagem').html("");

  if(!verificar_nome($('#nome'))) { // Se o nome não foi validado
    $('#alerta_mensagem').html( 
      $('#alerta_mensagem').html() + 
      criar_alerta('warning', '<b>Nome em branco</b>. <u>Preencha-o</u>.')
    );

    validado = false;
  }
  
  if(!verificar_email($('#email'))) { // Se o e-mail não foi validado
    $('#alerta_mensagem').html(
      $('#alerta_mensagem').html() +
      criar_alerta('warning', '<b>E-mail inválido</b>. <u>Verifique-o</u>.')
    );

    validado = false;
  }

  if(!verificar_tamanho_senha($('#senha'))) { // Se a senha não foi validada
    $('#alerta_mensagem').html(
      $('#alerta_mensagem').html() +
      criar_alerta('warning', '<b>Senha inválida</b>. A senha deve conter, no <u>mínimo, 6 caracteres</u>.')
    );

    validado = false;
  }
  else if(!verificar_igualdade_senhas($('#senha'), $('#confirmar_senha'))) { // Se a senha confirmada não foi validada
    $('#alerta_mensagem').html(
      $('#alerta_mensagem').html() +
      criar_alerta('warning', '<b>Senhas não correspondem</b>. <u>Digite-as novamente</u>.')
    );

    validado = false;
  }

  if(!verificar_opcao($('#pais_moeda'))) {
    $('#alerta_mensagem').html(
      $('#alerta_mensagem').html() +
      criar_alerta('warning', 'Selecione em <u>qual país você está</u>.')
    );

    validado = false;
  }

  if(!verificar_opcao($('#conheceu_ferramenta'))) {
    $('#alerta_mensagem').html(
      $('#alerta_mensagem').html() +
      criar_alerta('warning', 'Selecione o meio pelo qual <u>ouviu falar da ferramenta</u>.')
    );

    validado = false;
  }

  return validado;
}

/* ----------------------------------------------- */
/* ------------------- Eventos ------------------- */
/* ----------------------------------------------- */

$(document).ready(function() {

  /** Mostra quantos caracteres faltam para atingir o máximo */
  $('#senha').keyup(function() {
    var maxlength = $('#' + this.id).attr('maxlength');

    return check_nchar(this.id, 'senha_contador', maxlength);
  });

  /** Mostra quantos caracteres faltam para atingir o máximo */
  $('#confirmar_senha').keyup(function() {
    var maxlength = $('#' + this.id).attr('maxlength');

    return check_nchar(this.id, 'confirmar_senha_contador', maxlength);
  });

  /** Submete o formulário */
  $('#btn-submit').click(function(){
    if(validar_formulario()) {
      $.ajax({
        url: './reqs/cadastrar_usuario.php',
        type: 'POST',
        data: $('#form_cadastro').serialize()
      })
      .done(function(data) {
        var alerta = "";
        if(data == 'email') {
          $('#alerta_mensagem').html(
            "<div class='alert alert-danger' role='alert'>" +
              "<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>" +
                "<span aria-hidden='true'> &times; </span>" +
              "</button>" +
              "<div>" +
                "<u>O <b>e-mail</b> inserido já existe.</u> Por favor, escolha outro." +
              "</div>" +
            "</div>"
          );
        }
        else if(data == 'banco') { 
          $('#alerta_mensagem').html(
            "<div class='alert alert-danger' role='alert'>" +
              "<button type='button' class='close' data-dismiss='alert' aria-label='Fechar'>" +
                "<span aria-hidden='true'> &times; </span>" +
              "</button>" +
              "<div>" +
                "Problema com o <b> banco de dados</b>: <u>erro ao inserir novo usuário</u>." +
              "</div>" +
            "</div>"
          );
        }
        else {
          alerta = criar_alerta("success", "<p> <b> Usuário cadastrado com sucesso! </b> Um <u>e-mail de confirmação</u> foi enviado para o seu e-mail para que a conta seja validada. </p> <p class='text-right'> Você está sendo redirecionado... </p>");
          $('#alerta_mensagem').html(alerta);

          $('#form_cadastro').hide();

          setTimeout(function() {
            location.href="login.php";
          }, 5000);
        }
      });
    }
  }); // Função de clique

});