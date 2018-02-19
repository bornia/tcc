/*
 * Redireciona o usuário para consultar mais informações acerca do evento clicado na tabela.
*/
function redirect_page() {
	window.location.href = 'evento.php';
}

/*
 * Marca/desmarca todas os checkboxes do corpo da tabela caso o checkbox do cabeçalho seja marcado/desmarcado.
*/
function toggle_all_checkboxes(element) {
	checkboxes = document.getElementsByName('item');

	for(var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].checked = element.checked;
	}
}

/*
 * Verifica se existem checkboxes selecionados na tabela.
*/
function verify_checkbox_status(element) {
	if(element.checked) {
		change_add_btn_function();
	}
	else {
		giveback_add_btn_function();
	}
}

/*
 * Muda a função do botão de adicionar evento para poder excluir os eventos marcados.
*/
function change_add_btn_function() {
	$('#btn-excluir-evento').fadeIn();
	$('#btn-criar-evento').hide();
}

/*
 * Devolve a função do botão de adicionar evento.
*/
function giveback_add_btn_function() {
	$('#btn-excluir-evento').hide();
	$('#btn-criar-evento').fadeIn();
}

$(document).ready(function() {
	$('#btn-excluir-evento').hide();
	$('[data-toggle="tooltip"]').tooltip();
});