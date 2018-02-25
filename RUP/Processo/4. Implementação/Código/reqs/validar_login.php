<?php

session_start();

require_once('classes/db.class.php');

// Instancia a classe db para executar o seu método e fazer a conexão com o banco de dados
$con = (new db())->conecta_mysql();

// Organiza as informações de login do usuário
$user = array($_POST['usuario'], md5($_POST['senha']));

// Prepara a query
$sql = "SELECT * FROM usuarios WHERE email = '$user[0]' AND senha = '$user[1]';";

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

$_SESSION['id'] = $data['usuario_id'];
$_SESSION['nome'] = $data['nome'];
$_SESSION['email'] = $data['email'];
$_SESSION['senha'] = $data['senha'];
$_SESSION['pais_moeda'] = $data['pais_moeda'];
$_SESSION['celular'] = $data['celular'];
$_SESSION['nascimento'] = $data['nascimento'];
$_SESSION['estado'] = $data['estado'];
$_SESSION['notificacoes'] = $data['notificacoes'];
$_SESSION['conheceu_ferramenta'] = $data['conheceu_ferramenta'];

return true;

?>