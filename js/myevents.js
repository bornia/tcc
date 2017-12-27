/*
 * Redireciona o usuário para consultar mais informações acerca do evento clicado na tabela.
*/
function redirect_page() {
	window.location.href = 'event.php';
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
	document.getElementById("btn-crud-add").innerHTML = 
		"<button type='button' class='btn btn-danger btn-crud' title='Excluir evento'" +
		"data-toggle='modal' data-target='#janela-excluir-evento'>" +
			"<span class='glyphicon glyphicon-remove'> </span>" +
        "</button>";
}

/*
 * Devolve a função do botão de adicionar evento.
*/
function giveback_add_btn_function() {
	document.getElementById("btn-crud-add").innerHTML =
		"<button type='button' class='form-control btn btn-success btn-crud'" +
		"data-toggle='modal' data-target='#janela-adicionar-evento' title='Adicionar novo evento'>" +
			"<span class='glyphicon glyphicon-plus' aria-label='Pequeno ícone simbolizando um" +
			"botão de deletar.'> </span>" +
		"</button>";
}