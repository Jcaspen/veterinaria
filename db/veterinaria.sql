------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id         BIGSERIAL   PRIMARY KEY
  , login      VARCHAR(50) NOT NULL UNIQUE
                           CONSTRAINT ck_login_sin_espacios
                           CHECK (login NOT LIKE '% %')
  , password   VARCHAR(60) NOT NULL
  , created_at TIMESTAMP   NOT NULL DEFAULT current_timestamp
  ,rol         VARCHAR(60) NOT NULL
);


INSERT INTO usuarios (login, password,rol)
   VALUES ('jlcast', crypt('jlcast1988', gen_salt('bf', 10)),'mediador')
        , ('admin', crypt('admin', gen_salt('bf', 10)),'admin')
        , ('agente', crypt('agente', gen_salt('bf', 10)),'agente');