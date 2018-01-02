function check_nchar(element_checked, element_nchar, limite) {
	var campo_contador = document.getElementById(element_nchar);
	var nome_grupo = document.getElementById(element_checked).value;
	var max_tam = limite - nome_grupo.length;

	if(max_tam == -1)
	  return false;

	campo_contador.innerHTML = max_tam;
	return true;
}