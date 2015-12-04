

CREATE TABLE utilizador (
	username 		VARCHAR PRIMARY KEY NOT NULL,
	nome 			VARCHAR NOT NULL,
	password 		VARCHAR NOT NULL,
	img 			INTEGER NOT NULL
);

CREATE TABLE evento (
	id 				INTEGER PRIMARY KEY NOT NULL,
	nome 			VARCHAR NOT NULL,
	data 			DATE NOT NULL,
	local 			VARCHAR,
	descricao 		MEDIUMTEXT NOT NULL,
	tipo 			VARCHAR NOT NULL,
	imagem 			LONGBLOB NOT NULL,
	criador			VARCHAR NOT NULL,
	FOREIGN KEY (criador) REFERENCES utilizador(username)
	-- participantes SET
);

CREATE TABLE comentario (
	id 				INTEGER PRIMARY KEY NOT NULL,
	id_evento 		INTEGER NOT NULL,
	texto 			VARCHAR NOT NULL,
	username 		VARCHAR NOT NULL
);
