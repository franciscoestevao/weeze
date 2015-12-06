
CREATE TABLE utilizador (
	username 		VARCHAR PRIMARY KEY NOT NULL,
	nome 			VARCHAR NOT NULL,
	password 		VARCHAR NOT NULL,
	img 			INTEGER
)

CREATE TABLE evento (
	id				INTEGER NOT NULL,
	nome			VARCHAR NOT NULL,
	data			DATE NOT NULL,
	local			VARCHAR,
	descricao		MEDIUMTEXT NOT NULL,
	tipo			VARCHAR NOT NULL,
	imagem			LONGBLOB NOT NULL,
	criador			varchar,
	privado			BOOLEAN,
	PRIMARY KEY(id)
)


CREATE TABLE convidado (
	id				INTEGER NOT NULL,
	convidado		TEXT NOT NULL
)

CREATE TABLE participante (
	id				INTEGER NOT NULL,
	participante	TEXT NOT NULL
)


CREATE TABLE comentario (
	id 				INTEGER PRIMARY KEY NOT NULL,
	id_evento 		INTEGER NOT NULL,
	texto 			VARCHAR NOT NULL,
	username 		VARCHAR NOT NULL
)
