<<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupo_id 			= $_POST['grupo_id'];
$texto_pesquisado 	= $_POST['texto_pesquisado'];
$ordem 				= $_POST['ordem'];
$tipo_ordem			= $_POST['tipo_ordem'];
$regs_por_pagina 	= $_POST['regs_por_pagina'];
$offset 			= $_POST['offset'];
$status 			= $_POST['status'];

// Recupera o total de registros com base no filtro
$sql = "SELECT COUNT(*) AS total_registros FROM eventos WHERE evento_id IN (SELECT evento_id_ref FROM evento_pertence_grupo WHERE grupo_id_ref = $grupo_id)";

$res = mysqli_query($con, $sql);

if(!$res) {
	ob_clean();
	echo 'Houve um erro ao tentar <u>recuperar o total de eventos</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

$registro = mysqli_fetch_array($res, MYSQLI_ASSOC);
$total_registros = $registro['total_registros'];

// Busca os eventos pertencentes a um determinado grupo
$sql = "SELECT * FROM eventos WHERE evento_id IN (SELECT evento_id_ref FROM evento_pertence_grupo WHERE grupo_id_ref = $grupo_id) $status AND titulo LIKE '%$texto_pesquisado%' ORDER BY $ordem $tipo_ordem LIMIT $regs_por_pagina OFFSET $offset";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar atualizar a lista de eventos</u>. Por gentileza, <strong>contate o suporte</strong>.' . $status;
	return false;
}

$eventos = "";

if(!mysqli_num_rows($res)) {
	ob_clean();
	echo "<tr> <td class='align-middle text-center' colspan='5'> Nenhum evento.</td> </tr>";
}
else {
	while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		$datetime 			= date_create($row['ultima_att']);
		$datetime 			= date_format($datetime, 'd/m/Y H:i:s');
		$datetime 			= explode(" ", strval($datetime));
		$status 			= $row['status'] == 0 ? "<span class='oi oi-ban text-muted' aria-label='Evento finalizado.'>" : "<span class='oi oi-check text-muted' aria-label='Evento aberto.'>";
		$total_formatado	= str_replace(".", ",", $row['total']);

		$eventos .= 
"<tr>
    <td class='align-middle'> <input aria-label='Marque o item' type='checkbox' name='item' value='" . $row['evento_id'] . "' onchange='verificar_valor_checkboxes(); ' data-evento-status='" . $row['status'] . "'> </td>
    <td class='align-middle				text-size-responsive'> " . $row['titulo'] 	. " </td>
    <td class='align-middle text-center text-size-responsive'> " . $total_formatado . " </td>
    <td class='align-middle text-center text-size-responsive'> " . $datetime[0] 	. " as " . $datetime[1] . " </td>
    <td class='align-middle text-center text-size-responsive'> " . $status 			. " </td>
    <td class='align-middle'>
    	<div style='display: inline-block;'>
	    	<div class='d-md-none'>
		    	<button type='button' class='btn btn-sm btn-warning' id='btn-editar-evento-" . $row['evento_id'] . "' title='Editar evento.' data-toggle='modal' data-target='#janela-editar-evento' data-evento_id='" . $row['evento_id'] . "' onclick='altera_eventoId_botao_editar_evento(this);'>
		    		<span class='oi oi-pencil text-white text-size-responsive' aria-labelledby='btn-editar-evento' aria-describedby='btn-editar-evento-descricao'> </span>
		    		<span class='sr-only' id='btn-editar-evento-descricao'> Editar evento. </span>
				</button>
			</div>

			<div class='d-none d-md-block'>
		    	<button type='button' class='btn btn-warning' id='btn-editar-evento-" . $row['evento_id'] . "' title='Editar evento.' data-toggle='modal' data-target='#janela-editar-evento' data-evento_id='" . $row['evento_id'] . "' onclick='altera_eventoId_botao_editar_evento(this);'>
		    		<span class='oi oi-pencil text-white text-size-responsive' aria-labelledby='btn-editar-evento' aria-describedby='btn-editar-evento-descricao'> </span>
		    		<span class='sr-only' id='btn-editar-evento-descricao'> Editar evento. </span>
				</button>
			</div>
		</div>

		<div style='display: inline-block;'>
			<div class='d-md-none'>
		    	<button type='submit' class='btn btn-sm btn-primary mt-1' id='btn-entrar-evento-" . $row['evento_id'] . "' name='evento_id' title='Entrar no evento.' value='" . $row['evento_id'] . "'>
		    		<span class='oi oi-account-login text-white text-size-responsive' aria-describedby='btn-entrar-evento-descricao'> </span>
		    		<span class='sr-only' id='btn-entrar-evento-descricao'> Entrar no evento. </span>
				</button>
			</div>

			<div class='d-none d-md-block'>
		    	<button type='submit' class='btn btn-primary' id='btn-entrar-evento-" . $row['evento_id'] . "' name='evento_id' title='Entrar no evento.' value='" . $row['evento_id'] . "'>
		    		<span class='oi oi-account-login text-white text-size-responsive' aria-describedby='btn-entrar-evento-descricao'> </span>
		    		<span class='sr-only' id='btn-entrar-evento-descricao'> Entrar no evento. </span>
				</button>
			</div>
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
		$paginas .= "				<li class='page-item'> <a id='page-item-" . $i . "' class='page-link' data-pagina_clicada=" . $i . " onclick='paginar_eventos(this);'>$i</a> </li>\n";
	}

	$paginas .= "				<li class='page-item active'> <a id='page-item-" . $pagina_atual . "' class='page-link' data-pagina_clicada=" . $pagina_atual . ">$pagina_atual</a> </li>\n";

	for($i = $pagina_atual + 1; $i <= $pagina_atual + $numero_pags_exibidas && $i <= $total_paginas; $i++) {
		$paginas .= "				<li class='page-item'> <a id='page-item-" . $i . "' class='page-link' data-pagina_clicada=" . $i . " onclick='paginar_eventos(this);'>$i</a> </li>\n";
	}

	ob_clean();
	echo json_encode(array('eventos' => $eventos, 'paginas' => $paginas));
}

return true;

?>