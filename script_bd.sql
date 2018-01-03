CREATE DATABASE wip;

USE wip;

CREATE TABLE usr (
	usr_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL, -- Serve para o usuário fazer login
	senha VARCHAR(32) NOT NULL,
	pais_moeda VARCHAR(30) NOT NULL,
	celular CHAR(11) NULL,
	nascimento CHAR(10) NULL,
	estado VARCHAR(30) NULL,
	notificacoes VARCHAR(7) NOT NULL -- Separador: vírgula (,) sem espaços
	/*
		Ligado 1/-1 Desligado ------ Um grupo for criado/modificado
		Ligado 2/-2 Desligado ------ Um evento for incluído/alterado
		Ligado 3/-3 Desligado ------ Faltar 2 dias para uma conta expirar
		Ligado 4/-4 Desligado ------ Novas funcionalidades forem lançadas
	*/
);