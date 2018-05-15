<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$evento_titulo 	= $_POST['titulo'];
$grupo_id 		= $_POST['grupo_id'];
$contador_erros = 1;

$sql = "SELECT nome, usuario_id_ref FROM usuario_pertence_grupo INNER JOIN usuarios ON usuario_id = usuario_id_ref WHERE grupo_id_ref = $grupo_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<strong>Houve um erro ao tentar recuperar o nome dos membros do grupo</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>.'));
	$contador_erros++;
	return false;
}

$infos_membros = array();

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	$infos_membros[strval($row['usuario_id_ref'])] = $row['nome'];
}

/* OBTEM O TOTAL GASTO SOMANDO TODOS OS EVENTOS */

$sql = "SELECT SUM(total) AS 'Total Gasto pelo Grupo' FROM eventos WHERE status <> 0 AND evento_id IN (SELECT evento_id_ref FROM evento_pertence_grupo WHERE grupo_id_ref = $grupo_id);";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<strong>Houve um erro ao tentar recuperar o total gasto pelo grupo</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>. ' . $sql));
	$contador_erros++;
	return false;
}

$total_eventos = mysqli_fetch_array($res, MYSQLI_ASSOC)['Total Gasto pelo Grupo'];
$quantidade_membros = count($infos_membros);
$tbody = "";
$saldo_total = 0;

foreach ($infos_membros as $key => $membro_nome) {
	/* OBTEM QUANTO O MEMBRO GASTOU EM TODOS OS EVENTOS */

	$sql = "SELECT SUM(valor) AS 'Total Gasto pelo Membro' FROM gasto_pertence_evento WHERE usuario_id_ref = $key AND evento_id_ref IN (SELECT evento_id FROM eventos WHERE status <> 0 AND evento_id IN (SELECT evento_id_ref FROM evento_pertence_grupo WHERE grupo_id_ref = $grupo_id)) GROUP BY usuario_id_ref;";

	// Executa a query
	$res = mysqli_query($con, $sql);

	// Se houve algum erro na execução da query
	if(!$res) {
		ob_clean();
		echo json_encode(array('erro_id' => $contador_erros, 'erro_mensagem' => '<strong>Houve um erro ao tentar recuperar o total gasto pelo membro do grupo</strong> no Banco de Dados. <u>Por favor, contate o suporte urgentemente</u>.'));
		$contador_erros++;
		return false;
	}

	$total_gastos = mysqli_fetch_array($res, MYSQLI_ASSOC)['Total Gasto pelo Membro'];
	$saldo = (($total_eventos / $quantidade_membros) - $total_gastos) * -1;
	$saldo_total += $saldo;
	$positivo_negativo_cor = ($saldo<0?'text-danger':'text-success');
	$positivo_negativo_operador = ($saldo<0?'':'+');

	$tbody .=
		"<tr>
          	<th scope='row'> " 	. $membro_nome 	. " </th>
          	<td class=''> " 	. number_format($total_gastos, 2, ',', '.') . " </td>
          	<td class='$positivo_negativo_cor'> $positivo_negativo_operador" 	. number_format($saldo, 2, ',', '.') 		. " </td>
        </tr>\n"
	;
}

$tbody .=
	"<tr class='total-row'>
		<th class='text-center' scope='row'> TOTAL </th>
      	<td class=''> " . number_format($total_eventos, 2, ',', '.') 	. " </td>
      	<td class=''> " . number_format($saldo_total, 2, ',', '.') 		. " </td>
    </tr>\n"
;

ob_clean();
echo json_encode(array('erro_id' => 0, 'tbody_saldo' => $tbody));
return true;

?>