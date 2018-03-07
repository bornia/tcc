<<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$sql = "SELECT * FROM grupos;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	echo 'erro ao atualizar lista de grupos';
	return false;
} 

//echo json_encode(array("teste" => "isso funfa"));

$titulo = "";
$detalhes = "";

while($data = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	$datetime = explode(" ", strval($data['ultima_att']));

	$titulo .=
"<a class='list-group-item list-group-item-action text-size-responsive' id='grupo" . $data['grupo_id'] . "' data-toggle='list' href='#ref-grupo" . $data['grupo_id'] . "' role='tab' aria-controls='home'> " . $data['titulo'] . " </a> \n\n";

	$detalhes .=
"<div class='card border-0' id='ref-grupo" . $data['grupo_id'] . "' aria-labelledby='grupo" . $data['grupo_id'] . "'>
	<div class='card-body'>
		<div class='row'>
	    	<div class='col'>
	      		<h5 class='card-title'> " . $data['titulo'] . " </h5>
	    	</div>

	    	<div class='col'>
	      		<span class='text-muted float-right' id='numero-de-membros'>
	        	7 Membros
	      		</span>
	    	</div>
		</div>

		<div class='row'>
    		<div class='col'>
	      		<p class='card-text'> <small> " . $data['descricao'] . " </small> </p>
	    	</div>
	  	</div>                    
	</div>

	<div class='card-footer border-light'>
	  	<div class='row'>
	    	<div class='col-12 col-md-6'>
	      		<small class='text-muted' id='ultima-atualizacao'> Última atualização: " . $datetime[0] . " as " . $datetime[1] . ". </small>
	    	</div>

	    	<div class='col-12 col-md-6'>
	      		<button class='btn btn-sm btn-block float-right' id='btn-submit'>
	        		<span class='oi oi-account-login' class='text-size-responsive' aria-labelledby='entrar-no-grupo'> </span>
	        		<span id='entrar-no-grupo' class='text-size-responsive'> Entrar no Grupo </span>
	      		</button>
	    	</div>
	  	</div>
	</div>
</div>\n\n";
}

ob_clean();

echo json_encode(array('titulos' => $titulo, 'detalhes' => $detalhes));

return true;

?>