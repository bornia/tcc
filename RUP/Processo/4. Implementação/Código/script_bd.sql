CREATE DATABASE wip;

USE wip;

CREATE TABLE usuarios (
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
	ultima_att DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,

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

CREATE TABLE eventos (
	evento_id INT NOT NULL AUTO_INCREMENT,
	titulo VARCHAR(40) NOT NULL,
	ultima_att DATETIME DEFAULT CURRENT_TIMESTAMP,
	total DECIMAL(10,2) DEFAULT 0 NOT NULL,
	status TINYINT DEFAULT 1 NOT NULL,
	/*
		0 ------ Evento fechado/finalizado
		1 ------ Evento aberto/funcionando
	*/

	PRIMARY KEY(evento_id)
);

CREATE TABLE evento_pertence_grupo (
	evento_grupo_id INT NOT NULL AUTO_INCREMENT,
	grupo_id_ref INT NOT NULL,
	evento_id_ref INT NOT NULL,

	PRIMARY KEY(evento_grupo_id),
	FOREIGN KEY(grupo_id_ref) REFERENCES grupos(grupo_id),
	FOREIGN KEY (evento_id_ref) REFERENCES eventos(evento_id)
);

CREATE TABLE gastos (
	gasto_id INT NOT NULL AUTO_INCREMENT,
	descricao VARCHAR(35) NOT NULL,
	categoria VARCHAR(20) NOT NULL,
	data_pagamento DATE NOT NULL,
	valor DECIMAL(10,2) NOT NULL,

	PRIMARY KEY(gasto_id)
);

CREATE TABLE gasto_pertence_evento (
	gasto_evento_id INT NOT NULL AUTO_INCREMENT,
	usuario_id_ref INT NOT NULL,
	evento_id_ref INT NOT NULL,
	gasto_id_ref INT NOT NULL,

	PRIMARY KEY(gasto_evento_id),
	FOREIGN KEY (usuario_id_ref) REFERENCES usuarios(usuario_id),
	FOREIGN KEY(evento_id_ref) REFERENCES eventos(evento_id),
	FOREIGN KEY(gasto_id_ref) REFERENCES gastos(gasto_id)
);


/* ===================================================================== */
/* ============================== TRIGGERS ============================= */
/* ===================================================================== */

DELIMITER //

/* TABELA evento_pertence_grupo */

/** Atualiza a data de quando ocorreu a última modificação (INSERÇÃO) em um grupo
*/
CREATE TRIGGER trg_ins_evento_pertence_grupo AFTER INSERT ON evento_pertence_grupo
FOR EACH ROW
BEGIN
	UPDATE grupos SET ultima_att = CURRENT_TIMESTAMP WHERE grupo_id = (
        SELECT grupo_id_ref FROM evento_pertence_grupo WHERE evento_id_ref = NEW.evento_id_ref GROUP BY grupo_id_ref
	);
END //

/** Atualiza a data de quando ocorreu a última modificação (EXCLUSÃO) em um grupo
*/
CREATE TRIGGER trg_del_evento_pertence_grupo BEFORE DELETE ON evento_pertence_grupo
FOR EACH ROW
BEGIN
	UPDATE grupos SET ultima_att = CURRENT_TIMESTAMP WHERE grupo_id = (
        SELECT grupo_id_ref FROM evento_pertence_grupo WHERE evento_id_ref = OLD.evento_id_ref GROUP BY grupo_id_ref
	);
END //

/* TABELA eventos */

/** Atualiza a data de quando ocorreu a última modificação (ATUALIZAÇÃO) em um grupo
*/
CREATE TRIGGER trg_upd_eventos AFTER UPDATE ON eventos
FOR EACH ROW
BEGIN
	UPDATE grupos SET ultima_att = CURRENT_TIMESTAMP WHERE grupo_id = (
        SELECT grupo_id_ref FROM evento_pertence_grupo WHERE evento_id_ref = NEW.evento_id GROUP BY grupo_id_ref
	);
END //