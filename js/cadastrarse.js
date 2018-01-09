/** Verifica por onde o usuário conheceu a ferramenta
*/
function verifica_opcao() {
	var opcao = $('#conheceu_ferramenta').val();

	

	if(opcao == 'noticias') {
		$('conheceu_ferramenta_outro_label').html('noticias');
	}
};
