DROP DATABASE if EXISTS chestplace;
CREATE DATABASE IF NOT EXISTS  chestplace;

use chestplace;

CREATE TABLE usuario(
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
  id_tipo_usuario int(1) NOT NULL, 
  nome varchar(255) NOT NULL, 
  email varchar(255) UNIQUE NOT NULL, 
  senha varchar(255) NOT NULL, 
  banido datetime DEFAULT NULL, 
  PRIMARY KEY (id)
);

CREATE TABLE vendedor(
  id_usuario int(10) UNSIGNED, 
  nome_estabelecimento varchar(255) NOT NULL, 
  cpf char(11), 
  cnpj char(14),

  FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

CREATE TABLE comprador(
  id_usuario int(10) UNSIGNED, 
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
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  titulo varchar(255) NOT NULL, 
  descricao text DEFAULT '', 
  preco float NOT NULL, 
  imagem blob NOT NULL, 
  data_hora_publicacao datetime NOT NULL, 
  id_marca int(10) DEFAULT NULL
);

CREATE TABLE imagem(
  id_produto int(10) UNSIGNED NOT NULL, 
  imagem blob NOT NULL,
  FOREIGN KEY (id_produto) REFERENCES camiseta(id)
);

CREATE TABLE tamanho(
  id int(2) UNSIGNED PRIMARY KEY, 
  codigo varchar(3) NOT NULL, 
  descricao varchar(255) NOT NULL
);

CREATE TABLE tamanho_camiseta(
  id int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
  id_camiseta int(10) UNSIGNED, 
  id_tamanho int(10) UNSIGNED, 
  quantidade int(10) NOT NULL,
  FOREIGN KEY (id_camiseta) REFERENCES camiseta (id),
  FOREIGN KEY (id_tamanho) REFERENCES tamanho(id)
);

CREATE TABLE camiseta_nova(
  id int(10) UNSIGNED,
  FOREIGN KEY (id) REFERENCES camiseta(id)
);

CREATE TABLE camiseta_usada(
  id int(10) UNSIGNED, 
  conservacao ENUM('nova', 'seminova', 'usada', 'desgastada', 'muito desgasatda'),
  FOREIGN KEY (id) REFERENCES camiseta(id)
);

CREATE TABLE compra_venda(
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_camiseta int(10) UNSIGNED NOT NULL, 
  id_comprador int(10) NOT NULL, 
  data_hora_compra datetime NOT NULL, 
  data_hora_confirmacao_pagamento datetime DEFAULT NULL, 
  data_hora_recebimento datetime DEFAULT NULL, 
  quantidade int(5) NOT NULL, 
  PRIMARY KEY (id)
);


-- INSERTS


USE chestplace;

-- Inserção de usuários
INSERT INTO usuario (id_tipo_usuario, nome, email, senha)
VALUES
  (1, 'Lucas Oliveira', 'lucas@gmail.com', '123'),
  (1, 'Ana Silva', 'ana@gmail.com', '123'),
  (1, 'João Santos', 'joao@gmail.com', '123'),
  (1, 'Pedro Souza', 'pedro@gmail.com', '123'),
  (2, 'Ricardo Vieira', 'ricardo@gmail.com', '123'),
  (2, 'Maria Almeida', 'maria@gmail.com', '123'),
  (2, 'Fernanda Costa', 'fernanda@gmail.com', '123'),
  (2, 'Marcos Santos', 'marcos@gmail.com', '123'),
  (3, 'Administrador', 'admin@gmail.com', '123');

-- Inserção de vendedores
INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj)
VALUES
  (1, 'Loja do Lucas', '12345678900', '12345678901234'),
  (2, 'Moda da Ana', '23456789001', NULL),
  (3, 'João Fashion', '34567890102', NULL),
  (4, 'Pedro Estampas', NULL, '45678901234567'),
  (5, 'Camisetas do Ricardo', NULL, '56789012345678'),
  (6, 'Loja da Maria', '67890123456', NULL),
  (7, 'Fernanda Modas', '78901234567', NULL),
  (8, 'Moda do Marcos', '89012345678', NULL);

-- Inserção de compradores
INSERT INTO comprador (id_usuario, cpf)
VALUES
  (2, '09876543210'),
  (4, '98765432109'),
  (6, NULL),
  (8, '76543210987');

-- Inserção de marcas
INSERT INTO marca (nome)
VALUES
  ('Nike'),
  ('Adidas'),
  ('Puma'),
  ('Hering'),
  ('Calvin Klein');

-- Inserção de camisetas
INSERT INTO camiseta (titulo, descricao, preco, imagem, data_hora_publicacao, id_marca)
VALUES
  ('Camiseta Nike Branca', 'Camiseta branca de algodão da Nike', 49.90, 'imagem1', NOW(), 1),
  ('Camiseta Adidas Preta', 'Camiseta preta de poliéster da Adidas', 59.90, 'imagem2', NOW(), 2),
  ('Camiseta Puma Amarela', 'Camiseta amarela de algodão da Puma', 39.90, 'imagem3', NOW(), 3),
  ('Camiseta Hering Azul', 'Camiseta azul de algodão da Hering', 29.90, 'imagem4', NOW(), 4),
  ('Camiseta Calvin Klein Vermelha', 'Camiseta vermelha de algodão da Calvin Klein', 79.90, 'imagem5', NOW(), 5);

-- Inserção de imagens das camisetas
INSERT INTO imagem (id_produto, imagem)
VALUES
  (1, 'imagem1'),
  (2, 'imagem2'),
  (3, 'imagem3'),
  (4, 'imagem4');






-- CREATE TABLE carrinho(
--   id int(10) UNSIGNED NOT NULL PRIMARY KEY,
--   id_usuario int(10) UNSIGNED NOT NULL, 
--   id_produto int(10) UNSIGNED NOT NULL,
--   quantidade int NOT NULL,
--   FOREIGN KEY (id_usuario) REFERENCES comprador(id),
--   FOREIGN KEY (id_produto) REFERENCES tamanho_camiseta(id)
-- );

