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

$titulo = "";
$detalhes = "";


while($data = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	$datetime = explode(" ", strval($data['ultima_att']));
// $data['grupo_id']	
	if(empty($titulo)) {
		$titulo .=
"
	<tr id='linha-grupo" . $data['grupo_id'] . "' class='bg-primary'>
  		<th class='table-max-width' scope='row'>
    		<button type='button' class='btn-sm btn-block btn-third btn-none table-text-control' id='grupo" . $data['grupo_id'] . "' onclick='seleciona_grupo(this);'> " . $data['titulo'] . " </button>
  		</th>

	  	<td>
	    	<input class='align-middle' type='checkbox' id='check-grupo" . $data['grupo_id'] . "'  name='lista-exclusao-grupos' value='" . $data['grupo_id'] . "' >
  		</td>
	</tr>
\n\n";

		$detalhes .=
"<div class='d-block' id='ref-grupo" . $data['grupo_id'] . "'>
	<div class='card border-0'>
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
		    	<div class='col-12 col-md-5'>
		      		<small class='text-muted' id='ultima-atualizacao'> Última atualização: " . $datetime[0] . " as " . $datetime[1] . ". </small>
		    	</div>

		    	<div class='col-12 col-md-7'>
		      		<button class='btn btn-sm btn-block float-right' id='btn-submit'>
		        		<span class='oi oi-account-login' class='text-size-responsive' aria-labelledby='entrar-no-grupo'> </span>
		        		<span id='entrar-no-grupo' class='text-size-responsive'> Entrar no Grupo </span>
		      		</button>
		    	</div>
		  	</div>
		</div>
	</div>
</div>\n\n";
	}
	else {
		$titulo .=
"
	<tr id='linha-grupo" . $data['grupo_id'] . "' class='bg-white'>
  		<th class='table-max-width' scope='row'>
    		<button type='button' class='btn-sm btn-block btn-third btn-none table-text-control' id='grupo" . $data['grupo_id'] . "' onclick='seleciona_grupo(this);'> " . $data['titulo'] . " </button>
  		</th>

	  	<td>
	    	<input class='align-middle' type='checkbox' id='check-grupo" . $data['grupo_id'] . "'  name='lista-exclusao-grupos' value='" . $data['grupo_id'] . "' >
  		</td>
	</tr>
\n\n";

		$detalhes .=
"
<div class='d-none' id='ref-grupo" . $data['grupo_id'] . "'>
		<div class='card border-0'>
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
			    	<div class='col-12 col-md-5'>
			      		<small class='text-muted' id='ultima-atualizacao'> Última atualização: <br> " . $datetime[0] . " as " . $datetime[1] . ". </small>
			    	</div>

			    	<div class='col-12 col-md-7'>
			      		<button class='btn btn-sm btn-block float-right' id='btn-submit'>
			        		<span class='oi oi-account-login' class='text-size-responsive' aria-labelledby='entrar-no-grupo'> </span>
			        		<span id='entrar-no-grupo' class='text-size-responsive'> Entrar no Grupo </span>
			      		</button>
			    	</div>
			  	</div>
			</div>
		</div>
	</div>
\n\n";
	}	
}

ob_clean();

echo json_encode(array('titulos' => $titulo, 'detalhes' => $detalhes));

return true;

?>