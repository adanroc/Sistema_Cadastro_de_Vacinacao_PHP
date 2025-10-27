-- Criar o banco de dados se não existir
CREATE DATABASE IF NOT EXISTS SisSASS;

-- Selecionar o banco de dados que será utilizado
USE SisSASS;

-- Criar a tabela para os dados do servidor com 'numMatricula' único
CREATE TABLE IF NOT EXISTS ListaDeUsuarios (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    dataCadastro DATETIME NOT NULL,
    dataUltimaEdicao DATETIME,
    apagadoFalso ENUM('0', '1') NOT NULL DEFAULT '0',
    dataApagado DATETIME,
    
    nome VARCHAR(255) NOT NULL,
    login VARCHAR(255) NOT NULL, 
    senha VARCHAR(255) NOT NULL,
    dataUltimaAlteracaoSenha DATETIME,
    dataUltimoResetSenha DATETIME,
    email VARCHAR(255),
    cargo VARCHAR(255),
    setor VARCHAR(255),    
    unidade VARCHAR(255) NOT NULL,       
    municipio VARCHAR(100), 
    perfil ENUM('1', '2', '3') NOT NULL DEFAULT '2',
    imagemPerfil VARCHAR(255)
);
-- perfil ENUM('administrador', 'padrao', 'visitante') DEFAULT 'padrao';
-- 1 - admin
-- 2 - padrao
-- 3 - visitante ou externo


select * from ListaDeUsuarios
DROP TABLE IF EXISTS ListaDeUsuarios;

-- Usuario Administrador
INSERT INTO ListaDeUsuarios
(dataCadastro, nome, login, senha, email, cargo, setor, unidade, municipio, perfil)
VALUES 
(NOW(), 'admin', 'admin', MD5('123'), 'admin@email.com', 'Gerente', 'TI', 'Sede', 'Belém', '1');

-- Novas colunas Adicionadas após a criação da tabela entre as colunas
ALTER TABLE listadeusuarios 
ADD COLUMN dataUltimaAlteracaoSenha DATETIME NULL AFTER senha,
ADD COLUMN dataUltimoResetSenha DATETIME NULL AFTER dataUltimaAlteracaoSenha;

ALTER TABLE listadeusuarios
ADD COLUMN status VARCHAR(255) AFTER Username_apelido;

-- Adicionar novas colunas por padrão depois da ultima coluna
ALTER TABLE listadeusuarios
ADD COLUMN Username_apelido VARCHAR(255), 
ADD COLUMN Picture_fotoReal VARCHAR(1000) NOT NULL DEFAULT 'user.jpg',
ADD COLUMN Online DATETIME,
ADD COLUMN Token VARCHAR(255),
ADD COLUMN Secure BIGINT;

-- Online é uma palavra reservada do workbench então ficou Online_

-- Armazenando imagem no banco

-- Se quiser armazenar a imagem diretamente no banco (o que geralmente não é recomendado, mas pode ser feito), você usaria o tipo BLOB:

-- sql
-- Copiar
-- Editar
-- ALTER TABLE nome_da_tabela
-- ADD COLUMN foto_perfil LONGBLOB
-- AFTER nome_usuario;
-- Mas o mais comum e recomendado é salvar apenas o caminho/URL da imagem no banco de dados e armazenar os arquivos em um servidor.

-- Se quiser posso te ajudar com o código de upload e exibição depois também.

-- ALTER TABLE nome_da_tabela
-- ADD COLUMN foto_perfil VARCHAR(255)
-- AFTER nome_usuario;
-- Explicação:
-- ALTER TABLE nome_da_tabela: indica qual tabela será modificada.

-- ADD COLUMN foto_perfil VARCHAR(255): adiciona a nova coluna com tipo VARCHAR(255) (pode ajustar o tamanho conforme necessário).

-- AFTER nome_usuario: posiciona a nova coluna logo após nome_usuario.

-- Se quiser armazenar a imagem diretamente no banco (o que geralmente não é recomendado, mas pode ser feito), você usaria o tipo BLOB: