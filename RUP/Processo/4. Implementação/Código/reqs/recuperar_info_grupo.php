<?php

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$grupo_id 	= $_POST['grupo_id'];
$usuario_id = $_POST['usuario_id'];

$sql = "SELECT titulo, descricao, ultima_att FROM grupos WHERE grupo_id = $grupo_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<strong>Houve um erro ao tentar recuperar os dados do grupo</strong>. <u>Entre em contato com o suporte, por gentileza</u>.';
	return false;
}

$titulo = mysqli_fetch_array($res, MYSQLI_ASSOC)['titulo'];
$descricao = mysqli_fetch_array($res, MYSQLI_ASSOC)['descricao'];

$sql = "SELECT usuario_id_ref FROM usuario_pertence_grupo WHERE grupo_id_ref = $grupo_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<strong>Houve um erro ao tentar recuperar os dados de associação entre usuário e o grupo</strong>. <u>Entre em contato com o suporte, por gentileza</u>.';
	return false;
}

$membros_ids = array();
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	array_push($membros_ids, $row['usuario_id_ref']);
}
$membros_ids = implode(",", $membros_ids);

$sql = "SELECT email, permissao FROM usuarios INNER JOIN usuario_pertence_grupo ON usuario_id = usuario_id_ref WHERE usuario_id IN ($membros_ids) AND grupo_id_ref = $grupo_id;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	ob_clean();
	echo '<strong>Houve um erro ao tentar recuperar os dados dos membros do grupo</strong>. <u>Entre em contato com o suporte, por gentileza</u>.';
	return false;
}

$membros = "";
$contador_membros = 1;

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	$membros .=
		"<div class='row' id='item-membro-editar-grupo-". $contador_membros ."'>" .
            "<div class='col-10'>" .
				"<div class='row'>" .
					"<div class='col-12 col-md-7'>" .
						"<label for='email-membro-editar-grupo-". $contador_membros ."' class='col-form-label sr-only'>" .
							"Membro ". $contador_membros .
						"</label>" .

						"<input type='text' readonly class='form-control-sm form-control-plaintext text-truncate text-size-responsive' id='email-membro-editar-grupo-". $contador_membros ."' name='membros_editar_grupo[]' value='". $row['email'] ."'>" .
					"</div>" .

					"<div class='col-12 col-md-5'>" .
						"<label class='sr-only' for='dpbox-permissoes'>" .
							"Defina as permissões do usuário:" .
						"</label>" .

						"<select class='form-control form-control-sm text-size-responsive' id='dpbox-permissoes' name='permissoes_editar_grupo[]'>" .
							"<option value='1'> Pode ver </option>" .
							"<option value='2'> Pode editar </option>" .
							"<option value='3'> É dono </option>" .
						"</select>" .
					"</div>" .
				"</div>" .
            "</div>" .

	        "<div class='col-2'>" .
	          	"<div class='form-check'>" .
	            	"<button type='button' class='close btn-sm' id='btn-retirar-membro-editar-grupo-". $contador_membros ."' onclick='retirar_membro_editar_grupo(this)' aria-label='Retirar membro da lista do grupo.'>" .
	              		"&times;" .
	            	"</button>" .
	          	"</div>" .
	        "</div>" .

	        "<hr id='separador-membro-editar-grupo-". $contador_membros ."' width='85%' style='display: none;'> </div>" .
	  	"</div>\n\n"
  	;

  	$contador_membros++;
}

ob_clean();
echo json_encode(
	array(
		'titulo' 		=> $titulo,
		'descricao' 	=> $descricao,
		'membros'		=> $membros,
		'contador'		=> $contador_membros
	)
);

return true;

?>