<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$gasto_id 			= $_POST['gasto_id'];

//
$sql = "SELECT * FROM gastos WHERE gasto_id = $gasto_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar recuperar os dados do gasto</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
$descricao 		= $row['descricao'];
$categoria 		= $row['categoria'];
$data_pagamento = $row['data_pagamento'];
$valor 			= $row['total'];

//
$sql = "SELECT usuario_id_ref FROM gasto_pertence_evento WHERE gasto_id_ref = $gasto_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar consultar quais usuários participam do gasto</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

$participantes_ids = array();

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	array_push($participantes_ids, $row['usuario_id_ref']);
}

$participantes_ids = implode(",", $participantes_ids);


//
$sql = "SELECT email, valor FROM usuarios INNER JOIN gasto_pertence_evento ON usuario_id = usuario_id_ref WHERE usuario_id IN ($participantes_ids) AND gasto_id_ref = $gasto_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<u>Houve um erro ao tentar recuperar os e-mails dos usuários que participam do gasto</u>. Por gentileza, <strong>contate o suporte</strong>.';
	return false;
}

$participantes_html = "";
$contador_membros = 1;

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	$participantes_html .=
		"<div class='row' id='item-participante-editar-gasto-". $contador_membros ."'>" .
			"<div class='col-10'>" .
				"<div class='row'>" .
                	"<div class='col-12 col-md-7'>" .
						"<label for='email-participante-editar-gasto-". $contador_membros ."' class='text-muted font-weight-bold mb-0 text-size-responsive'>" .
			                "Participante ". $contador_membros . ": " .
			          	"</label>" .

              			"<input type='text' readonly class='form-control-sm form-control-plaintext text-truncate text-size-responsive' id='email-participante-editar-gasto-". $contador_membros ."' name='participantes_editar_gasto[]' value='". $row['email'] ."'>" .
            		"</div>" .

            		"<div class='col-12 col-md-5'>" .
	                	"<label class='text-muted font-weight-bold mb-0 text-size-responsive' for='valor-participante-editar-gasto-". $contador_membros ."'>" .
	                    	"Quantia Paga:" .
	                	"</label>" .

                  		"<input type='number' class='form-control form-control-sm text-size-responsive' id='valor-participante-editar-gasto-". $contador_membros ."' name='valor_participante_editar_gasto[]' value='". $row['valor'] ."' min='0.01' step='0.01' placeholder='ex. 20,50' onfocusout='ajusta_total_editar_gasto();' onkeypress='return formata_numero(event);'>" .
		           	"</div>" .
            	"</div>" .
            "</div>" .

            "<div class='col-2'>" .
                "<button type='button' class='close btn-sm' id='". $contador_membros ."' onclick='retirar_participante_editar_gasto(this);' aria-label='Retirar participante da lista do gasto.'>" .
                  	"&times;" .
                "</button>" .
          	"</div>" .

          	"<hr class='mb-2 mt-2' id='separador-participante-editar-gasto-". $contador_membros ."' width='85%' style='display: none;'> </div>" .
      	"</div>\n\n"
  	;

	$contador_membros++;
}

ob_clean();
echo json_encode(array(
	'descricao' 		=> $descricao,
	'categoria' 		=> $categoria,
	'data_pagamento' 	=> $data_pagamento,
	'valor' 			=> $valor,
	'participantes' 	=> $participantes_html,
	'contador' 			=> $contador_membros)
);

return true;

?>