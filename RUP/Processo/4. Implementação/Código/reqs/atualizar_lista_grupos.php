<<?php

session_start();

require_once ('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

$usuario_id = $_SESSION['id'];

$sql = "SELECT * FROM grupos WHERE grupo_id IN (SELECT grupo_id_ref FROM usuario_pertence_grupo WHERE usuario_id_ref = $usuario_id) ORDER BY titulo ASC;";

// Executa a query
$res = mysqli_query($con, $sql);

// Se houve algum erro na execução da query
if(!$res) {
	echo 'erro ao atualizar lista de grupos';
	return false;
}

$tabela = "";
$titulo = "";
$detalhes = "";

if(!mysqli_num_rows($res)) {
	ob_clean();
	echo 'Nenhum grupo';
}
else {
	while($data = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		$datetime 			= explode(" ", strval($data['ultima_att']));
		$data_modificacao 	= date_format(date_create($datetime[0]), "d/m/Y");
		$tempo_modificacao 	= $datetime[1];
		$grupo_id 			= $data['grupo_id'];

		$sql = "SELECT COUNT(usuario_id_ref) AS qtd_membros FROM usuario_pertence_grupo WHERE grupo_id_ref = $grupo_id;";
		$res2 = mysqli_query($con, $sql);
		$qtd_membros = mysqli_fetch_array($res2, MYSQLI_ASSOC);
	
		if(empty($titulo)) {
			$titulo .=
"
	<tr id='linha-grupo" . $grupo_id . "' class='bg-primary'>
  		<th class='table-max-width' scope='row'>
    		<button type='button' class='btn-sm btn-block btn-third btn-none table-text-control text-size-responsive' id='grupo" . $grupo_id . "' onclick='seleciona_grupo(this);'> " . $data['titulo'] . " </button>
  		</th>

	  	<td>
	    	<input class='align-middle' type='checkbox' id='check-grupo" . $grupo_id . "'  name='lista-exclusao-grupos' value='" . $grupo_id . "' onclick='verificar_valor_checkboxes();'>
  		</td>
	</tr>
\n\n";

			$detalhes .=
"<form class='d-block' id='ref-grupo" . $grupo_id . "' action='meuseventos.php' method='POST'>
	<div class='card border-0'>
		<div class='card-body'>
			<div class='row'>
		    	<div class='col'>
		      		<h5 class='card-title'> " . $data['titulo'] . " </h5>
		    	</div>

		    	<div class='col'>
		      		<span class='text-muted float-right' id='numero-de-membros'>
		        	" . $qtd_membros['qtd_membros'] . " membros
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
		      		<small class='text-muted' id='ultima-atualizacao'> Última atualização: " . $data_modificacao . " as " . $tempo_modificacao . ". </small>
		    	</div>

		    	<div class='col-12 col-md-7'>
		      		<button class='btn btn-sm btn-block float-right btn-submit' type='submit' name='grupo_id' value='" . $grupo_id . "'>
		        		<span class='oi oi-account-login' class='text-size-responsive' aria-labelledby='entrar-no-grupo'> </span>
		        		<span id='entrar-no-grupo' class='text-size-responsive'> Entrar no Grupo </span>
		      		</button>
		    	</div>
		  	</div>
		</div>
	</div>
</form>\n\n";
		}
		else {
			$titulo .=
"
	<tr id='linha-grupo" . $data['grupo_id'] . "' class='bg-white'>
  		<th class='table-max-width' scope='row'>
    		<button type='button' class='btn-sm btn-block btn-third btn-none table-text-control text-size-responsive' id='grupo" . $data['grupo_id'] . "' onclick='seleciona_grupo(this);'> " . $data['titulo'] . " </button>
  		</th>

	  	<td>
	    	<input class='align-middle' type='checkbox' id='check-grupo" . $data['grupo_id'] . "'  name='lista-exclusao-grupos' value='" . $data['grupo_id'] . "' onclick='verificar_valor_checkboxes();'>
  		</td>
	</tr>
\n\n";

			$detalhes .=
"
<form class='d-none' id='ref-grupo" . $grupo_id . "' action='meuseventos.php' method='POST'>
		<div class='card border-0'>
			<div class='card-body'>
				<div class='row'>
			    	<div class='col'>
			      		<h5 class='card-title'> " . $data['titulo'] . " </h5>
			    	</div>

			    	<div class='col'>
			      		<span class='text-muted float-right' id='numero-de-membros'>
			        	" . $qtd_membros['qtd_membros'] . " membros
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
			      		<button class='btn btn-sm btn-block float-right btn-submit' type='submit' name='grupo_id' value='" . $grupo_id . "'>
			        		<span class='oi oi-account-login' class='text-size-responsive' aria-labelledby='entrar-no-grupo'> </span>
			        		<span id='entrar-no-grupo' class='text-size-responsive'> Entrar no Grupo </span>
			      		</button>
			    	</div>
			  	</div>
			</div>
		</div>
	</form>
\n\n";
		}
	}

	$tabela =
"
    <div class='table-responsive'>
      	<table class='table'>
        	<caption class='sr-only'> Lista de Grupos </caption>

	        <colgroup>
	          	<col width='100%' />
	          	<col width='0%' />
	        </colgroup>

	        <thead class='sr-only'>
	          	<tr>
	            	<th scope='col'>Título do Grupo</th>
	            	<th scope='col'>Opções</th>
	          	</tr>
	        </thead>

	        <tbody>
	        	" . $titulo . "
	        </tbody>
      	</table>
    </div>
\n\n";

	ob_clean();

	echo json_encode(array('titulos' => $tabela, 'detalhes' => $detalhes));
}

return true;

?>