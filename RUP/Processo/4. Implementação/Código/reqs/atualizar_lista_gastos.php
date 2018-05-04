<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupo_id 			= $_POST['grupo_id'];
$evento_id 			= $_POST['evento_id'];
//$ordem 				= $_POST['ordem'];
//$tipo_ordem			= $_POST['tipo_ordem'];
//$regs_por_pagina 	= $_POST['regs_por_pagina'];
//$offset 			= $_POST['offset'];
//$status 			= $_POST['status'];



// Busca os eventos pertencentes a um determinado grupo
$sql = "SELECT * FROM gastos WHERE gasto_id IN (SELECT gasto_id_ref FROM gasto_pertence_evento WHERE evento_id_ref = $evento_id AND evento_id_ref IN (SELECT evento_id_ref FROM evento_pertence_grupo WHERE grupo_id_ref = $grupo_id));";
// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar atualizar a lista de gastos</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

$gastos = "";

if(!mysqli_num_rows($res)) {
	ob_clean();
	echo "<tr> <td class='align-middle text-center' colspan='6'> Nenhum gasto.</td> </tr>";
}
else {
	while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		$payment_date 	= date_create($row['data_pagamento']);
		$payment_date 	= date_format($payment_date, 'd/m/Y');

		$gastos .= 
"<tr>
	<td class='align-middle'>
		<input aria-label='Marque o item' type='checkbox' name='item' value='item-selecionado-" . $row['gasto_id'] . "'>
	</td>
	<td class='change-cursor adjust-width align-middle'> " . $row['descricao'] 	. " </td>
	<td class='change-cursor adjust-width align-middle'> " . $row['categoria'] 	. " </td>
	<td class='change-cursor adjust-width align-middle'> " . $payment_date 		. " </td>
	<td class='change-cursor adjust-width align-middle'> " . $row['valor'] 		. " </td>
	<td class='align-middle'>
		<button type='button' class='btn btn-warning' title='Editar gasto'>
			<span class='sr-only' id='btn-editar-evento-descricao-" . $row['gasto_id'] . "'> Editar gasto. </span>
			<span class='oi oi-pencil text-white' aria-describedby='btn-editar-evento-descricao-" . $row['gasto_id'] . "'> </span>
		</button>
	</td>
</tr>\n\n";
	}

	ob_clean();
	echo json_encode(array('gastos' => $gastos));
}

return true;

?>