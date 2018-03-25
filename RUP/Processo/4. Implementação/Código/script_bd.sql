CREATE DATABASE wip;

USE wip;

CREATE TABLE usr (
	usuario_id INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL UNIQUE, -- Serve para o usuário fazer login
	senha VARCHAR(32) NOT NULL,
	pais_moeda VARCHAR(30) NOT NULL,
	celular CHAR(11) NULL,
	nascimento CHAR(10) NULL,
	estado VARCHAR(30) NULL,
	notificacoes VARCHAR(7) NOT NULL, -- Separador: vírgula (,) sem espaços
	/*
		Ligado 1/-1 Desligado ------ Um grupo for criado/modificado
		Ligado 2/-2 Desligado ------ Um evento for incluído/alterado
		Ligado 3/-3 Desligado ------ Faltar 2 dias para uma conta expirar
		Ligado 4/-4 Desligado ------ Novas funcionalidades forem lançadas
	*/
	conheceu_ferramenta VARCHAR(10) NOT NULL,

	PRIMARY KEY(usr_id),
);

CREATE TABLE grupos (
	grupo_id INT NOT NULL AUTO_INCREMENT,
	titulo VARCHAR(30) NOT NULL,
	descricao VARCHAR(100) NULL,
	ultima_att DATETIME DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY(grupo_id)
);

CREATE TABLE usuario_pertence_grupo (
	grupos_membros_id INT NOT NULL AUTO_INCREMENT,
	grupo_id_ref INT NOT NULL,
	usuario_id_ref INT NOT NULL,
	permissao TINYINT NOT NULL,
	/*
		1 ------ Pode ver
		2 ------ Pode editar
		3 ------ É dono
	*/

	PRIMARY KEY(grupos_membros_id),
	FOREIGN KEY(grupo_id_ref) REFERENCES grupos(grupo_id),
	FOREIGN KEY (usuario_id_ref) REFERENCES usuarios(usuario_id)
);