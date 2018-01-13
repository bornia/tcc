<?php

require_once('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

// Organiza as informações de login do usuário
$user = array($_POST['usuario'], md5($_POST['senha']));

// Prepara a query
$sql = "SELECT usr_id, nome, email, senha FROM usr WHERE email = '$user[0]' AND senha = '$user[1]';";

$res = mysqli_query($con, $sql);

if(!$res) {
	echo 'query';
	return false;
}

// Transforma o resultado da consulta em array
$data = mysqli_fetch_array($res, MYSQLI_ASSOC);

if(!isset($data)) {
	echo 'invalido';
	return false;
}

$_SESSION['id'] = $data['id'];
$_SESSION['nome'] = $data['nome'];

return true;

?>