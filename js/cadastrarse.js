/** Exibe um campo de texto para o usuário especificar de onde conheceu a ferramenta.
*/
function especifica_opcao() {
	var opcao = $('#conheceu_ferramenta').val();

	if(opcao == 'outro') {
		$('#conheceu_ferramenta_outro').show();
		$('#conheceu_ferramenta_especificacao').attr('placeholder', 'Especifique... (opcional)');
		
	}
	else {
		$('#conheceu_ferramenta_outro').hide();
	}
};