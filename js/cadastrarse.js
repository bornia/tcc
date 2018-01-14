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
    $.ajax({
      url: './reqs/cadastrar_usuario.php',
      type: 'POST',
      data: $('#form_cadastro').serialize()
    })
    .done(function(data) {
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
        $('#alerta_mensagem').html(
          "<div class='alert alert-success' role='alert'>" +
            "<div>" +
              "<p> <b> Usuário cadastrado com sucesso! </b> Um <u>e-mail de confirmação</u> foi enviado para o seu e-mail para que a conta seja validada. </p> <p class='text-right'> Você está sendo redirecionado... </p>" +
            "</div>" +
          "</div>"
        );

        $('#form_login').hide();

        setTimeout(function() {
          location.href="login.php";
        }, 5000);
      }
    });
  }); // Função de clique

});