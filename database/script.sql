DROP DATABASE IF EXISTS chestplace;
CREATE DATABASE IF NOT EXISTS  chestplace;

use chestplace;

CREATE TABLE endereco(
	id int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
  cep char(9) NOT NULL,
  rua varchar(255) NOT NULL, 
  numero varchar(10) NOT NULL, 
  complemento varchar (255), 
  bairro varchar(255),
  cidade varchar(255) NOT NULL,
  uf ENUM ('AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO') NOT NULL
);

CREATE TABLE usuario(
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
  nome varchar(255) NOT NULL, 
  email varchar(255) UNIQUE NOT NULL, 
  senha varchar(255) NOT NULL, 
  banido datetime DEFAULT NULL,
  inativo datetime DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE vendedor(
  id_usuario int(10) UNSIGNED NOT NULL PRIMARY KEY, 
  nome_estabelecimento varchar(255) NOT NULL, 
  cpf char(14), 
  cnpj char(18),
  id_endereco int(10) UNSIGNED NOT NULL,
  email_contato varchar(255) NOT NULL,
  telefone_contato varchar(30) NOT NULL,
  
  FOREIGN KEY (id_usuario) REFERENCES usuario(id), 
  FOREIGN KEY (id_endereco) REFERENCES endereco(id)
);

CREATE TABLE comprador(
  id_usuario int(10) UNSIGNED NOT NULL PRIMARY KEY, 
  cpf varchar(11) DEFAULT NULL, 
  FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

CREATE TABLE administrador(
  id_usuario int(10) UNSIGNED, 
  FOREIGN KEY (id_usuario) REFERENCES usuario(id)
  -- Tabela feita apenas para diferenciar o admin dos outros
);

CREATE TABLE marca(
  id int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
  nome varchar(255)
);

CREATE TABLE camiseta(
  id int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  titulo varchar(255) NOT NULL, 
  descricao text, 
  preco float NOT NULL,
  conservacao ENUM('nova', 'seminova', 'usada', 'desgastada', 'muito desgasatda'),
  data_hora_publicacao datetime NOT NULL,
  data_hora_cadastro datetime NOT NULL,
  inativo datetime DEFAULT NULL,
  id_vendedor int(10) UNSIGNED NOT NULL,
  id_marca int(10) UNSIGNED DEFAULT NULL,
  
  FOREIGN KEY (id_vendedor) REFERENCES vendedor(id_usuario),
  FOREIGN KEY (id_marca) REFERENCES marca(id)
);

CREATE TABLE imagem(
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_produto int(10) UNSIGNED NOT NULL, 
  imagem MEDIUMBLOB NOT NULL,
  FOREIGN KEY (id_produto) REFERENCES camiseta(id)
);

CREATE TABLE tamanho(
  id int(2) UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
  codigo varchar(4) NOT NULL, 
  descricao varchar(255) NOT NULL
);

CREATE TABLE estoque(
  id int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
  id_camiseta int(10) UNSIGNED NOT NULL, 
  id_tamanho int(10) UNSIGNED NOT NULL, 
  quantidade int(10) NOT NULL,
  FOREIGN KEY (id_camiseta) REFERENCES camiseta (id),
  FOREIGN KEY (id_tamanho) REFERENCES tamanho(id)
);

CREATE TABLE compra_venda(
  id int(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  id_camiseta int(10) UNSIGNED NOT NULL, 
  id_comprador int(10) UNSIGNED NOT NULL, 
  data_hora_compra datetime NOT NULL, 
  data_hora_confirmacao_pagamento datetime DEFAULT NULL, 
  data_hora_recebimento datetime DEFAULT NULL, 
  quantidade int(5) NOT NULL,
  
  FOREIGN KEY (id_camiseta) REFERENCES camiseta(id),
  FOREIGN KEY (id_comprador) REFERENCES comprador(id_usuario)
);

/*

POPULAÇÃO DAS TABELAS

*/

-- Inserts para tabela "endereco"
INSERT INTO endereco (cep, rua, numero, complemento, bairro, cidade, uf) 
VALUES (80000000, 'Rua A', '123', 'Apto 1', 'Centro', 'Curitiba', 'PR');

INSERT INTO endereco (cep, rua, numero, complemento, bairro, cidade, uf) 
VALUES (20000000, 'Avenida B', '456', NULL, 'Barra', 'Rio de Janeiro', 'RJ');

INSERT INTO endereco (cep, rua, numero, complemento, bairro, cidade, uf) 
VALUES (70000000, 'Rua C', '789', 'Casa 2', 'Centro', 'Brasília', 'DF');

INSERT INTO endereco (cep, rua, numero, complemento, bairro, cidade, uf) 
VALUES (90000000, 'Avenida D', '321', NULL, 'Moinhos de Vento', 'Porto Alegre', 'RS');

INSERT INTO endereco (cep, rua, numero, complemento, bairro, cidade, uf) 
VALUES (60000000, 'Rua E', '987', 'Sala 3', 'Aldeota', 'Fortaleza', 'CE');


-- Inserts para tabela "usuario"
INSERT INTO usuario (nome, email, senha) VALUES ('João Silva', 'joao.silva@example.com', '123456');
INSERT INTO usuario (nome, email, senha) VALUES ('Maria Santos', 'maria.santos@example.com', 'abcdef');
INSERT INTO usuario (nome, email, senha) VALUES ('Pedro Oliveira', 'pedro.oliveira@example.com', 'qwerty');
INSERT INTO usuario (nome, email, senha) VALUES ('Ana Souza', 'ana.souza@example.com', '987654');
INSERT INTO usuario (nome, email, senha) VALUES ('Lucas Pereira', 'lucas.pereira@example.com', 'mnbvc');
INSERT INTO usuario (nome, email, senha) VALUES ('Maria Silva', 'maria@example.com', 'senha123');
INSERT INTO usuario (nome, email, senha) VALUES ('João Santos', 'joao@example.com', 'senha456');
INSERT INTO usuario (nome, email, senha) VALUES ('Ana Oliveira', 'ana@example.com', 'senha789');
INSERT INTO usuario (nome, email, senha) VALUES ('Pedro Souza', 'pedro@example.com', 'senhaabc');
INSERT INTO usuario (nome, email, senha) VALUES ('Juliana Pereira', 'juliana@example.com', 'senha123456');
INSERT INTO usuario (nome, email, senha) VALUES ('Lucas Lima', 'lucas@example.com', 'senhaabcdef');
INSERT INTO usuario (nome, email, senha) VALUES ('Carolina Ferreira', 'carolina@example.com', 'senha789abc');
INSERT INTO usuario (nome, email, senha) VALUES ('Rafael Torres', 'rafael@example.com', 'senhaxyz');
INSERT INTO usuario (nome, email, senha) VALUES ('Fernanda Rodrigues', 'fernanda@example.com', 'senhatest');
INSERT INTO usuario (nome, email, senha) VALUES ('Gustavo Almeida', 'gustavo@example.com', 'senha123xyz');



-- Inserts para tabela "vendedor"
INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco, email_contato, telefone_contato) VALUES 
(1, 'Loja A', '12345678901', NULL, 1, 'contato@lojaa.com', '999999999'),
(2, 'Loja B', NULL, '12345678901234', 2, 'contato@lojab.com', '888888888'),
(3, 'Loja C', '98765432109', NULL, 3, 'contato@lojac.com', '777777777'),
(4, 'Loja D', '11122233344', NULL, 4, 'contato@lojad.com', '666666666'),
(5, 'Loja E', '55566677788', NULL, 5, 'contato@lojae.com', '555555555');


-- Comprador
INSERT INTO comprador (id_usuario, cpf) VALUES (6, '11122233344');
INSERT INTO comprador (id_usuario, cpf) VALUES (7, '22233344455');
INSERT INTO comprador (id_usuario, cpf) VALUES (8, '33344455566');
INSERT INTO comprador (id_usuario, cpf) VALUES (9, '44455566677');
INSERT INTO comprador (id_usuario, cpf) VALUES (10, '55566677788');

-- Administrador
INSERT INTO administrador (id_usuario) VALUES (11);
INSERT INTO administrador (id_usuario) VALUES (12);
INSERT INTO administrador (id_usuario) VALUES (13);
INSERT INTO administrador (id_usuario) VALUES (14);
INSERT INTO administrador (id_usuario) VALUES (15);

-- Marca
INSERT INTO marca (nome) VALUES ('Nike');
INSERT INTO marca (nome) VALUES ('Adidas');
INSERT INTO marca (nome) VALUES ('Puma');
INSERT INTO marca (nome) VALUES ('Vans');
INSERT INTO marca (nome) VALUES ('Under Armour');
INSERT INTO marca (nome) VALUES ('H&M');
INSERT INTO marca (nome) VALUES ('Zara');
INSERT INTO marca (nome) VALUES ('Levi''s');
INSERT INTO marca (nome) VALUES ('Tommy Hilfiger');
INSERT INTO marca (nome) VALUES ('Calvin Klein');
INSERT INTO marca (nome) VALUES ('Ralph Lauren');
INSERT INTO marca (nome) VALUES ('GAP');
INSERT INTO marca (nome) VALUES ('Hollister');
INSERT INTO marca (nome) VALUES ('Forever 21');
INSERT INTO marca (nome) VALUES ('American Eagle');

-- Tamanho
INSERT INTO tamanho (codigo, descricao) VALUES ('PP', 'Pequeno Pequeno');
INSERT INTO tamanho (codigo, descricao) VALUES ('P', 'Pequeno');
INSERT INTO tamanho (codigo, descricao) VALUES ('M', 'Médio');
INSERT INTO tamanho (codigo, descricao) VALUES ('G', 'Grande');
INSERT INTO tamanho (codigo, descricao) VALUES ('GG', 'Grande Grande');
INSERT INTO tamanho (codigo, descricao) VALUES ('XG', 'Extra Grande');
INSERT INTO tamanho (codigo, descricao) VALUES ('XGG', 'Extra Grande Grande');
INSERT INTO tamanho (codigo, descricao) VALUES ('XXG', 'Duplo Extra Grande');
INSERT INTO tamanho (codigo, descricao) VALUES ('XXXG', 'Triplo Extra Grande');

USE CHESTPLACE;
DELETE FROM imagem WHERE id IN (1);
SELECT  id, imagem FROM imagem where id_produto =33 limit 1;
