<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupo_id 			= $_POST['grupo_id'];
$evento_id 			= $_POST['evento_id'];
//$ordem 				= $_POST['ordem'];
//$tipo_ordem			= $_POST['tipo_ordem'];
$regs_por_pagina 	= $_POST['regs_por_pagina'];
$offset 			= $_POST['offset'];
//$status 			= $_POST['status'];

//
$sql = "SELECT COUNT(*) as total_registros FROM gastos WHERE gasto_id IN (SELECT gasto_id_ref FROM gasto_pertence_evento WHERE evento_id_ref = $evento_id AND evento_id_ref IN (SELECT evento_id_ref FROM evento_pertence_grupo WHERE grupo_id_ref = $grupo_id));";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar atualizar a lista de gastos</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

$total_registros = mysqli_fetch_array($res, MYSQLI_ASSOC)['total_registros'];

// Busca os eventos pertencentes a um determinado grupo
$sql = "SELECT * FROM gastos WHERE gasto_id IN (SELECT gasto_id_ref FROM gasto_pertence_evento WHERE evento_id_ref = $evento_id AND evento_id_ref IN (SELECT evento_id_ref FROM evento_pertence_grupo WHERE grupo_id_ref = $grupo_id)) LIMIT $regs_por_pagina OFFSET $offset;";

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
		$data_pagamento 	= date_create($row['data_pagamento']);
		$data_pagamento 	= date_format($data_pagamento, 'd/m/Y');
		$valor_formatado	= str_replace(".", ",", $row['valor']);

		$gastos .= 
"<tr>
	<td class='align-middle'>
		<input aria-label='Marque o item' type='checkbox' name='item' value='" . $row['gasto_id'] . "' onclick='verificar_valor_checkboxes();'>
	</td>
	<td class='align-middle 			text-size-responsive'> " . $row['descricao'] 	. " </td>
	<td class='align-middle text-center text-size-responsive'> " . $row['categoria'] 	. " </td>
	<td class='align-middle text-center text-size-responsive'> " . $data_pagamento 		. " </td>
	<td class='align-middle text-center text-size-responsive'> " . $valor_formatado		. " </td>
	<td class='align-middle'>
		<div class='d-md-none'>
			<button type='button' class='btn btn-sm btn-warning' title='Editar gasto'>
				<span class='sr-only' id='btn-editar-evento-descricao-" . $row['gasto_id'] . "'> Editar gasto. </span>
				<span class='oi oi-pencil text-white text-size-responsive' aria-describedby='btn-editar-evento-descricao-" . $row['gasto_id'] . "'> </span>
			</button>
		</div>

		<div class='d-none d-md-block'>
			<button type='button' class='btn btn-warning' title='Editar gasto'>
				<span class='sr-only' id='btn-editar-evento-descricao-" . $row['gasto_id'] . "'> Editar gasto. </span>
				<span class='oi oi-pencil text-white text-size-responsive' aria-describedby='btn-editar-evento-descricao-" . $row['gasto_id'] . "'> </span>
			</button>
		</div>
	</td>
</tr>\n\n";
	}

	$offset++; // Ajuste para que visualmente as páginas sejam exibidas de 1 a N, ao invés de 0 a N
	$total_paginas = ceil($total_registros / $regs_por_pagina); // Descobre a quantidade total de páginas
	$pagina_atual = ceil($offset / $regs_por_pagina); //localiza a pagna atual
	$paginas = "";
	$numero_pags_exibidas = 2;


	for($i = ($pagina_atual - $numero_pags_exibidas <= 0 ? 1 : $pagina_atual - $numero_pags_exibidas); $i < $pagina_atual && $i > 0; $i++) {
		$paginas .= "				<li class='page-item'> <a id='page-item-" . $i . "' class='page-link' data-pagina_clicada=" . $i . " onclick='paginar_gastos(this);'>$i</a> </li>\n";
	}

	$paginas .= "				<li class='page-item active'> <a id='page-item-" . $pagina_atual . "' class='page-link' data-pagina_clicada=" . $pagina_atual . ">$pagina_atual</a> </li>\n";

	for($i = $pagina_atual + 1; $i <= $pagina_atual + $numero_pags_exibidas && $i <= $total_paginas; $i++) {
		$paginas .= "				<li class='page-item'> <a id='page-item-" . $i . "' class='page-link' data-pagina_clicada=" . $i . " onclick='paginar_gastos(this);'>$i</a> </li>\n";
	}

	ob_clean();
	echo json_encode(array('gastos' => $gastos, 'paginas' => $paginas));
}

return true;

?>