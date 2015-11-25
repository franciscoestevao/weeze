

CREATE TABLE utilizador (
	username 		VARCHAR PRIMARY KEY NOT NULL,
	nome 			VARCHAR NOT NULL,
	password 		VARCHAR NOT NULL
);

CREATE TABLE evento (
	id 				INTEGER PRIMARY KEY NOT NULL,
	nome 			VARCHAR NOT NULL,
	data 			DATE NOT NULL,
	local 			VARCHAR,
	descricao 		MEDIUMTEXT NOT NULL,
	tipo 			VARCHAR NOT NULL,
	imagem 			LONGBLOB NOT NULL
	-- participantes SET
);
