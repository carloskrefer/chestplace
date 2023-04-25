DROP DATABASE IF EXISTS chestplace;
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
  id_usuario int(10) UNSIGNED NOT NULL PRIMARY KEY, 
  nome_estabelecimento varchar(255) NOT NULL, 
  cpf char(11), 
  cnpj char(14),

  FOREIGN KEY (id_usuario) REFERENCES usuario(id)
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
  descricao text DEFAULT '', 
  preco float NOT NULL,
  conservacao ENUM('nova', 'seminova', 'usada', 'desgastada', 'muito desgasatda'),
  data_hora_publicacao datetime NOT NULL,
  id_vendedor int(10) UNSIGNED NOT NULL,
  id_marca int(10) UNSIGNED DEFAULT NULL,
  
  FOREIGN KEY (id_vendedor) REFERENCES vendedor(id_usuario),
  FOREIGN KEY (id_marca) REFERENCES marca(id)
);

CREATE TABLE imagem(
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
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

INSERT INTO usuario (id_tipo_usuario, nome, email, senha) VALUES
(1, 'João', 'joao@gmail.com', '123'),
(1, 'Maria', 'maria@gmail.com', '456'),
(2, 'Ana', 'ana@gmail.com', '789'),
(2, 'Pedro', 'pedro@gmail.com', 'qwe'),
(2, 'Lucas', 'lucas@gmail.com', 'asd'),
(2, 'Julia', 'julia@gmail.com', 'zxc'),
(1, 'Fernanda', 'fernanda@gmail.com', 'poi'),
(1, 'Roberto', 'roberto@gmail.com', 'lkj'),
(2, 'Sandra', 'sandra@gmail.com', 'mnb'),
(2, 'Marcos', 'marcos@gmail.com', 'fgh');

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj) VALUES
(1, 'Loja do João', '11111111111', '11111111111111'),
(2, 'Loja da Maria', '22222222222', '22222222222222'),
(3, 'Loja da Ana', NULL, NULL),
(4, 'Loja do Pedro', NULL, NULL),
(5, 'Loja do Lucas', '33333333333', NULL),
(6, 'Loja da Julia', '44444444444', NULL),
(7, 'Loja da Fernanda', '55555555555', NULL),
(8, 'Loja do Roberto', NULL, '33333333333333'),
(9, 'Loja da Sandra', NULL, '44444444444444'),
(10, 'Loja do Marcos', '66666666666', NULL);

INSERT INTO comprador (id_usuario, cpf) VALUES
(1, '12345678900'),
(2, '23456789011'),
(3, '34567890122'),
(4, '45678901233'),
(5, '56789012344'),
(6, '67890123455'),
(7, '78901234566'),
(8, '89012345677'),
(9, '90123456788'),
(10, '01234567899');

INSERT INTO marca(nome) VALUES
  ('Adidas'),
  ('Nike'),
  ('Puma'),
  ('Fila'),
  ('Reebok'),
  ('Vans'),
  ('Converse'),
  ('Under Armour'),
  ('New Balance'),
  ('Asics');
  
INSERT INTO camiseta(titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca) VALUES
  ('Camiseta Nike Masculina', 'Camiseta com logo Nike na frente', 99.99, 'nova', '2023-04-20 15:00:00', 1, 2),
  ('Camiseta Adidas Feminina', 'Camiseta com logo Adidas na frente', 79.99, 'seminova', '2023-04-19 16:00:00', 2, 1),
  ('Camiseta Puma Masculina', 'Camiseta com logo Puma na frente', 69.99, 'usada', '2023-04-18 14:00:00', 3, 3),
  ('Camiseta Fila Feminina', 'Camiseta com logo Fila na frente', 49.99, 'desgastada', '2023-04-17 13:00:00', 4, 4),
  ('Camiseta Reebok Masculina', 'Camiseta com logo Reebok na frente', 89.99, 'muito desgasatda', '2023-04-16 12:00:00', 5, 5),
  ('Camiseta Vans Feminina', 'Camiseta com logo Vans na frente', 59.99, 'nova', '2023-04-15 11:00:00', 6, 6),
  ('Camiseta Converse Masculina', 'Camiseta com logo Converse na frente', 39.99, 'seminova', '2023-04-14 10:00:00', 7, 7),
  ('Camiseta Under Armour Feminina', 'Camiseta com logo Under Armour na frente', 119.99, 'usada', '2023-04-13 09:00:00', 8, 8),
  ('Camiseta New Balance Masculina', 'Camiseta com logo New Balance na frente', 79.99, 'desgastada', '2023-04-12 08:00:00', 9, 9),
  ('Camiseta Asics Feminina', 'Camiseta com logo Asics na frente', 99.99, 'muito desgasatda', '2023-04-11 07:00:00', 10, 10);

-- Populando tabela "tamanho"
INSERT INTO tamanho (id, codigo, descricao) VALUES 
  (1, 'PP', 'Extra Pequeno'),
  (2, 'P', 'Pequeno'),
  (3, 'M', 'Médio'),
  (4, 'G', 'Grande'),
  (5, 'GG', 'Extra Grande'),
  (6, 'XG', 'Extra Grande'),
  (7, 'XXG', 'Extra Extra Grande'),
  (8, 'U', 'Único'),
  (9, 'U1', 'Único');

-- Populando tabela "tamanho_camiseta"
INSERT INTO tamanho_camiseta (id_camiseta, id_tamanho, quantidade) VALUES
  (1, 1, 5),
  (1, 2, 10),
  (1, 3, 10),
  (1, 4, 5),
  (1, 5, 2),
  (2, 2, 5),
  (2, 3, 5),
  (2, 4, 5),
  (2, 5, 5),
  (2, 6, 5),
  (2, 7, 5),
  (3, 1, 1),
  (3, 2, 2),
  (3, 3, 2),
  (3, 4, 1),
  (3, 5, 1),
  (3, 6, 1),
  (3, 7, 1),
  (4, 1, 10),
  (4, 2, 5),
  (4, 3, 2),
  (4, 4, 1),
  (5, 3, 10),
  (5, 4, 5),
  (5, 5, 5),
  (5, 6, 5),
  (5, 7, 5),
  (6, 3, 10),
  (6, 4, 10),
  (6, 5, 10),
  (7, 1, 5),
  (7, 2, 10),
  (7, 3, 10),
  (7, 4, 5),
  (7, 5, 2),
  (8, 8, 10),
  (9, 9, 10);

-- Populando tabela "imagem"
INSERT INTO imagem (id_produto, imagem) VALUES
  (1, 'imagem1'),
  (1, 'imagem2'),
  (1, 'imagem3'),
  (2, 'imagem4'),
  (2, 'imagem5'),
  (2, 'imagem6'),
  (3, 'imagem7'),
  (3, 'imagem8'),
  (3, 'imagem9'),
  (4, 'imagem10'),
  (5, 'imagem11'),
  (5, 'imagem12'),
  (6, 'imagem13'),
  (7, 'imagem14'),
  (7, 'imagem15'),
  (7, 'imagem16'),
  (8, 'imagem17'),
  (9, 'imagem18'),
  (9, 'imagem19'),
  (10, 'imagem20');


INSERT INTO compra_venda (id_camiseta, id_comprador, data_hora_compra, data_hora_confirmacao_pagamento, data_hora_recebimento, quantidade)
VALUES 
  (1, 1, '2023-04-20 10:30:00', '2023-04-21 14:00:00', '2023-04-25 09:30:00', 1),
  (1, 1, '2023-05-20 10:30:00', '2023-05-21 14:00:00', '2023-05-25 09:30:00', 1),
  (2, 1, '2023-04-20 11:45:00', '2023-04-21 15:30:00', NULL, 2),
  (3, 2, '2023-04-20 14:00:00', NULL, NULL, 1),
  (4, 3, '2023-04-20 15:20:00', '2023-04-22 10:00:00', '2023-04-26 15:00:00', 1),
  (5, 4, '2023-04-20 16:40:00', '2023-04-22 12:30:00', NULL, 1),
  (6, 5, '2023-04-20 18:00:00', NULL, NULL, 3),
  (7, 5, '2023-04-20 19:30:00', '2023-04-23 08:45:00', '2023-04-28 11:00:00', 2),
  (8, 6, '2023-04-20 20:10:00', '2023-04-24 13:15:00', '2023-04-28 17:30:00', 1),
  (9, 7, '2023-04-20 21:00:00', NULL, NULL, 1),
  (10, 7, '2023-04-20 22:00:00', NULL, NULL, 2);
  
-- SELECT * 
-- FROM camiseta c 
-- INNER JOIN imagem i
-- ON c.id = i.id_produto
-- WHERE c.id_vendedor = 1;


