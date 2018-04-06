<<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupo_id 			= $_POST['grupo_id'];
$texto_pesquisado 	= $_POST['texto_pesquisado'];
$ordem 				= $_POST['ordem'];

// Busca os eventos pertencentes a um determinado grupo
$sql = "SELECT evento_id,titulo,ultima_att,total FROM eventos WHERE evento_id IN (SELECT evento_id_ref FROM evento_pertence_grupo WHERE grupo_id_ref = $grupo_id) AND titulo LIKE '%$texto_pesquisado%' ORDER BY $ordem DESC";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar atualizar a lista de eventos</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

$eventos = "";

if(!mysqli_num_rows($res)) {
	ob_clean();
	echo "<tr> <td class='align-middle text-center' colspan='5'> Nenhum evento.</td> </tr>";
}
else {
	while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		$datetime = explode(" ", strval($row['ultima_att']));

		$eventos .= 
"<tr>
    <td class='align-middle'> <input aria-label='Marque o item' type='checkbox' name='item' value='" . $row['evento_id'] . "' onchange='verificar_todos_status_checkboxes();'> </td>
    <td class='change-cursor align-middle' onclick='return redirect_page();'> " . $row['titulo'] . " </td>
    <td class='change-cursor align-middle text-center' onclick='return redirect_page();'> " . $row['total'] . " </td>
    <td class='change-cursor align-middle text-center' onclick='return redirect_page();'> " . $datetime[0] . " as " . $datetime[1] . " </td>
    <td class='align-middle'> <button type='button' class='btn btn-warning' id='btn-editar-evento-" . $row['evento_id'] . "' title='Editar evento.' data-toggle='modal' data-target='#janela-editar-evento' data-evento_id='" . $row['evento_id'] . "' onclick='altera_eventoId_botao_editar_evento(this);'> <span class='oi oi-pencil text-white' aria-labelledby='btn-editar-evento' aria-describedby='btn-editar-evento-descricao'> </span> <span class='sr-only' id='btn-editar-evento-descricao'> Editar evento. </span> </button> </td>
</tr>\n\n";
	}

	ob_clean();
	echo json_encode(array('eventos' => $eventos));
}

return true;

?>