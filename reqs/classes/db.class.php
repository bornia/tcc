<?php

class db {
	private $host = 'localhost';
	private $user = 'root';
	private $pass = '';
	private $database = 'wip';

	public function conecta_mysql() {
		// Estabelecer conexão
		$con = mysqli_connect($this->host, $this->user, $this->pass, $this->database);

		// Verifica se houve algum erro de conexão
		// Se o valor for != 0 houve algum erro
		if(mysqli_connect_errno()) {
			die('Erro ao tentar se conectar com o banco de dados: ' . mysqli_connect_error());
		}

		// Configurar charset entre PHP e MySQL
		mysqli_set_charset($con, 'utf8');

		return $con;
	}
}

?>