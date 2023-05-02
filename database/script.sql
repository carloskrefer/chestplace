DROP DATABASE IF EXISTS chestplace;
CREATE DATABASE IF NOT EXISTS  chestplace;

use chestplace;

CREATE TABLE estado(
	id int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
    nome varchar(255) NOT NULL
);

CREATE TABLE cidade(
	id int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
    nome varchar(255) NOT NULL, 
    id_estado int(10) UNSIGNED NULL,
    
    FOREIGN KEY (id_estado) REFERENCES estado(id)
);

CREATE TABLE endereco(
	id int(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
    cep int(10) UNSIGNED NOT NULL, 
    rua varchar(255) NOT NULL, 
    numero varchar(10) NOT NULL, 
    complemento varchar (255), 
    bairro varchar(255),
    id_cidade int(10) UNSIGNED NOT NULL,
    
    FOREIGN KEY (id_cidade) REFERENCES cidade(id)
);

CREATE TABLE usuario(
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
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
  id_endereco int(10) UNSIGNED NOT NULL,

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

CREATE TABLE estoque(
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
  id_endereco int(10) NOT NULL,
  
  FOREIGN KEY (id_camiseta) REFERENCES camiseta(id),
  FOREIGN KEY (id_comprador) REFERENCES comprador(id_usuario)
);

/*
POPULAÇÃO DAS TABELAS
*/

INSERT INTO estado (nome) VALUES ('Acre');
INSERT INTO estado (nome) VALUES ('Alagoas');
INSERT INTO estado (nome) VALUES ('Amapá');
INSERT INTO estado (nome) VALUES ('Amazonas');
INSERT INTO estado (nome) VALUES ('Bahia');
INSERT INTO estado (nome) VALUES ('Ceará');
INSERT INTO estado (nome) VALUES ('Distrito Federal');
INSERT INTO estado (nome) VALUES ('Espírito Santo');
INSERT INTO estado (nome) VALUES ('Goiás');
INSERT INTO estado (nome) VALUES ('Maranhão');
INSERT INTO estado (nome) VALUES ('Mato Grosso');
INSERT INTO estado (nome) VALUES ('Mato Grosso do Sul');
INSERT INTO estado (nome) VALUES ('Minas Gerais');
INSERT INTO estado (nome) VALUES ('Pará');
INSERT INTO estado (nome) VALUES ('Paraíba');
INSERT INTO estado (nome) VALUES ('Paraná');
INSERT INTO estado (nome) VALUES ('Pernambuco');
INSERT INTO estado (nome) VALUES ('Piauí');
INSERT INTO estado (nome) VALUES ('Rio de Janeiro');
INSERT INTO estado (nome) VALUES ('Rio Grande do Norte');
INSERT INTO estado (nome) VALUES ('Rio Grande do Sul');
INSERT INTO estado (nome) VALUES ('Rondônia');
INSERT INTO estado (nome) VALUES ('Roraima');
INSERT INTO estado (nome) VALUES ('Santa Catarina');
INSERT INTO estado (nome) VALUES ('São Paulo');
INSERT INTO estado (nome) VALUES ('Sergipe');
INSERT INTO estado (nome) VALUES ('Tocantins');

-- Populando tabela cidade com exemplos de cidades de alguns estados brasileiros

-- Paraná

INSERT INTO cidade(nome, id_estado) VALUES
('Curitiba', 16),
('Londrina', 16),
('Maringá', 16),
('Foz do Iguaçu', 16),
('Ponta Grossa', 16),
('Cascavel', 16),
('Colombo', 16),
('Paranaguá', 16),
('Araucária', 16),
('Toledo', 16);

-- Acre
INSERT INTO cidade (nome, id_estado) VALUES 
('Rio Branco', 1),
('Cruzeiro do Sul', 1),
('Tarauacá', 1),
('Feijó', 1),
('Senador Guiomard', 1),
('Brasiléia', 1),
('Plácido de Castro', 1),
('Marechal Thaumaturgo', 1),
('Epitaciolândia', 1),
('Xapuri', 1);

-- Alagoas
INSERT INTO cidade (nome, id_estado) VALUES 
('Maceió', 2),
('Arapiraca', 2),
('Rio Largo', 2),
('Palmeira dos Índios', 2),
('São Miguel dos Campos', 2),
('Penedo', 2),
('Santana do Ipanema', 2),
('Coruripe', 2),
('Delmiro Gouveia', 2),
('Campo Alegre', 2);

-- Amapá
INSERT INTO cidade (nome, id_estado) VALUES 
('Macapá', 3),
('Santana', 3),
('Laranjal do Jari', 3),
('Oiapoque', 3),
('Porto Grande', 3),
('Pedra Branca do Amapari', 3),
('Tartarugalzinho', 3),
('Serra do Navio', 3),
('Amapá', 3),
('Vitória do Jari', 3);

-- Amazonas
INSERT INTO cidade (nome, id_estado) VALUES 
('Manaus', 4),
('Parintins', 4),
('Itacoatiara', 4),
('Manacapuru', 4),
('Coari', 4),
('Tefé', 4),
('Tabatinga', 4),
('Humaitá', 4),
('Maués', 4),
('Borba', 4);

-- Bahia
INSERT INTO cidade (nome, id_estado) VALUES 
('Salvador', 5),
('Feira de Santana', 5),
('Vitória da Conquista', 5),
('Camaçari', 5),
('Itabuna', 5),
('Juazeiro', 5),
('Lauro de Freitas', 5),
('Ilhéus', 5),
('Jequié', 5),
('Teixeira de Freitas', 5);

-- Ceará
INSERT INTO cidade (nome, id_estado) VALUES 
('Fortaleza', 6),
('Caucaia', 6),
('Juazeiro do Norte', 6),
('Maracanaú', 6),
('Sobral', 6),
('Crato', 6),
('Itapipoca', 6),
('Maranguape', 6),
('Iguatu', 6),
('Quixadá', 6);

INSERT INTO endereco (cep, rua, numero, complemento, bairro, id_cidade) VALUES
(80010010, 'Rua Marechal Deodoro', '869', 'Apto 23', 'Centro', 1),
(80010020, 'Rua Voluntários da Pátria', '520', NULL, 'Centro', 1),
(80010120, 'Rua Conselheiro Laurindo', '257', NULL, 'Centro', 1),
(80010250, 'Rua Alferes Poli', '277', 'Apto 54', 'Rebouças', 1),
(80020370, 'Rua Fagundes Varela', '127', NULL, 'Bigorrilho', 1),
(80030010, 'Rua Professor Ulisses Vieira', '86', NULL, 'Cristo Rei', 1),
(80035060, 'Rua Francisco Juglair', '131', NULL, 'Hugo Lange', 1),
(80040160, 'Rua Arthur de Azevedo', '788', NULL, 'Juvevê', 1),
(80050250, 'Rua Dom Alberto Gonçalves', '60', 'Apto 12', 'Água Verde', 1),
(80240180, 'Rua Guaianases', '244', NULL, 'Boa Vista', 1);
 
 -- vendedor
 
INSERT INTO usuario (nome, email, senha)
VALUES ('Ana Silva', 'ana.silva@gmail.com', '123456');

INSERT INTO usuario (nome, email, senha)
VALUES ('Bruno Santos', 'bruno.santos@hotmail.com', 'senha123');

INSERT INTO usuario (nome, email, senha)
VALUES ('Carla Oliveira', 'carla.oliveira@yahoo.com.br', 'abc123');

INSERT INTO usuario (nome, email, senha)
VALUES ('David Souza', 'david.souza@gmail.com', 'davidsouza123');

INSERT INTO usuario (nome, email, senha)
VALUES ('Eduardo Fernandes', 'eduardo.fernandes@gmail.com', 'fernandes321');

INSERT INTO usuario (nome, email, senha)
VALUES ('Fernanda Lima', 'fernanda.lima@hotmail.com', 'senha1234');

INSERT INTO usuario (nome, email, senha)
VALUES ('Gustavo Pereira', 'gustavo.pereira@gmail.com', 'gustavopereira123');

INSERT INTO usuario (nome, email, senha)
VALUES ('Helena Martins', 'helena.martins@yahoo.com.br', 'martins123');

INSERT INTO usuario (nome, email, senha)
VALUES ('Isabela Ferreira', 'isabela.ferreira@hotmail.com', 'isabela123');

INSERT INTO usuario (nome, email, senha)
VALUES ('João Castro', 'joao.castro@gmail.com', 'joaocastro123');
 
 -- comprador
 
INSERT INTO usuario (nome, email, senha) VALUES 
('João Silva', 'joao.silva@gmail.com', 'senha123'),
('Maria Souza', 'maria.souza@hotmail.com', '123456'),
('Pedro Oliveira', 'pedro.oliveira@yahoo.com.br', 'senha123'),
('Carla Santos', 'carla.santos@gmail.com', 'abc123'),
('Lucas Pereira', 'lucas.pereira@gmail.com', 'senha456'),
('Camila Ferreira', 'camila.ferreira@yahoo.com.br', '123abc'),
('Fernando Costa', 'fernando.costa@hotmail.com', 'senha789'),
('Ana Paula Lima', 'ana.paula.lima@gmail.com', 'abcdef'),
('Rafaela Oliveira', 'rafaela.oliveira@yahoo.com.br', '123abc'),
('Daniel Almeida', 'daniel.almeida@gmail.com', 'senha123');

-- administrador

INSERT INTO usuario (nome, email, senha) VALUES ('Roberto Carlos', 'roberto@gmail.com', 'senharoberto');
INSERT INTO usuario (nome, email, senha) VALUES ('Amanda Souza', 'amanda@gmail.com', 'senhaamanda');
INSERT INTO usuario (nome, email, senha) VALUES ('Felipe Silva', 'felipe@gmail.com', 'senhafelipe');
INSERT INTO usuario (nome, email, senha) VALUES ('Isabela Santos', 'isabela@gmail.com', 'senhaisabela');
INSERT INTO usuario (nome, email, senha) VALUES ('Lucas Ferreira', 'lucas@gmail.com', 'senhalucas');
INSERT INTO usuario (nome, email, senha) VALUES ('Vitória Alves', 'vitoria@gmail.com', 'senhavitoria');
INSERT INTO usuario (nome, email, senha) VALUES ('Pedro Henrique', 'pedro@gmail.com', 'senhapedro');
INSERT INTO usuario (nome, email, senha) VALUES ('Carla Oliveira', 'carla@gmail.com', 'senhacarla');
INSERT INTO usuario (nome, email, senha) VALUES ('Ricardo Souza', 'ricardo@gmail.com', 'senharicardo');
INSERT INTO usuario (nome, email, senha) VALUES ('Juliana Rodrigues', 'juliana@gmail.com', 'senhajuliana');

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (1, 'Loja A', '12345678901', NULL, 1);

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (2, 'Loja B', '23456789012', NULL, 2);

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (3, 'Loja C', '34567890123', NULL, 3);

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (4, 'Loja D', NULL, '12345678901234', 4);

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (5, 'Loja E', NULL, '23456789012345', 5);

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (6, 'Loja F', NULL, '34567890123456', 6);

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (7, 'Loja G', '45678901234', NULL, 7);

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (8, 'Loja H', '56789012345', NULL, 8);

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (9, 'Loja I', '67890123456', NULL, 9);

INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco)
VALUES (10, 'Loja J', '78901234567', NULL, 10);

INSERT INTO comprador (id_usuario, cpf) VALUES (11, '111.111.111-11');
INSERT INTO comprador (id_usuario, cpf) VALUES (12, '222.222.222-22');
INSERT INTO comprador (id_usuario, cpf) VALUES (13, '333.333.333-33');
INSERT INTO comprador (id_usuario, cpf) VALUES (14, '444.444.444-44');
INSERT INTO comprador (id_usuario, cpf) VALUES (15, '555.555.555-55');
INSERT INTO comprador (id_usuario, cpf) VALUES (16, '666.666.666-66');
INSERT INTO comprador (id_usuario, cpf) VALUES (17, '777.777.777-77');
INSERT INTO comprador (id_usuario, cpf) VALUES (18, '888.888.888-88');
INSERT INTO comprador (id_usuario, cpf) VALUES (19, '999.999.999-99');
INSERT INTO comprador (id_usuario, cpf) VALUES (20, '000.000.000-00');

INSERT INTO administrador (id_usuario) VALUES (21);
INSERT INTO administrador (id_usuario) VALUES (22);
INSERT INTO administrador (id_usuario) VALUES (23);
INSERT INTO administrador (id_usuario) VALUES (24);
INSERT INTO administrador (id_usuario) VALUES (25);
INSERT INTO administrador (id_usuario) VALUES (26);
INSERT INTO administrador (id_usuario) VALUES (27);
INSERT INTO administrador (id_usuario) VALUES (28);
INSERT INTO administrador (id_usuario) VALUES (29);
INSERT INTO administrador (id_usuario) VALUES (30);

INSERT INTO marca (nome) VALUES ('Nike');
INSERT INTO marca (nome) VALUES ('Adidas');
INSERT INTO marca (nome) VALUES ('Puma');
INSERT INTO marca (nome) VALUES ('Reebok');
INSERT INTO marca (nome) VALUES ('Under Armour');
INSERT INTO marca (nome) VALUES ('New Balance');
INSERT INTO marca (nome) VALUES ('Asics');
INSERT INTO marca (nome) VALUES ('Fila');
INSERT INTO marca (nome) VALUES ('Vans');
INSERT INTO marca (nome) VALUES ('Converse');

INSERT INTO camiseta (titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca)
VALUES ('Camiseta branca básica', 'Camiseta branca lisa, sem estampas, tamanho P', 25.99, 'nova', '2023-05-01 10:00:00', 1, 1);

INSERT INTO camiseta (titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca)
VALUES ('Camiseta cinza básica', 'Camiseta cinza lisa, sem estampas, tamanho M', 29.99, 'seminova', '2023-05-01 11:00:00', 2, 2);

INSERT INTO camiseta (titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca)
VALUES ('Camiseta preta estampada', 'Camiseta preta com estampa de gato, tamanho G', 39.99, 'usada', '2023-05-01 12:00:00', 3, 3);

INSERT INTO camiseta (titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca)
VALUES ('Camiseta vermelha básica', 'Camiseta vermelha lisa, sem estampas, tamanho P', 25.99, 'nova', '2023-05-01 13:00:00', 4, 4);

INSERT INTO camiseta (titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca)
VALUES ('Camiseta amarela básica', 'Camiseta amarela lisa, sem estampas, tamanho M', 29.99, 'seminova', '2023-05-01 14:00:00', 5, 5);

INSERT INTO camiseta (titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca)
VALUES ('Camiseta azul estampada', 'Camiseta azul com estampa de onda, tamanho G', 39.99, 'usada', '2023-05-01 15:00:00', 1, 6);

INSERT INTO camiseta (titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca)
VALUES ('Camiseta verde básica', 'Camiseta verde lisa, sem estampas, tamanho P', 25.99, 'nova', '2023-05-01 16:00:00', 2, 7);

INSERT INTO camiseta (titulo, descricao, preco, conservacao, data_hora_publicacao, id_vendedor, id_marca)
VALUES ('Camiseta preta básica', 'Camiseta preta lisa, sem estampas, tamanho M', 29.99, 'seminova', '2023-05-01 17:00:00', 3, 8);

INSERT INTO imagem (id_produto, imagem) VALUES (1, 'conteúdo da imagem 1');
INSERT INTO imagem (id_produto, imagem) VALUES (1, 'conteúdo da imagem 2');
INSERT INTO imagem (id_produto, imagem) VALUES (1, 'conteúdo da imagem 3');
INSERT INTO imagem (id_produto, imagem) VALUES (2, 'conteúdo da imagem 4');
INSERT INTO imagem (id_produto, imagem) VALUES (2, 'conteúdo da imagem 5');
INSERT INTO imagem (id_produto, imagem) VALUES (2, 'conteúdo da imagem 6');
INSERT INTO imagem (id_produto, imagem) VALUES (3, 'conteúdo da imagem 7');
INSERT INTO imagem (id_produto, imagem) VALUES (3, 'conteúdo da imagem 8');
INSERT INTO imagem (id_produto, imagem) VALUES (3, 'conteúdo da imagem 9');
INSERT INTO imagem (id_produto, imagem) VALUES (4, 'conteúdo da imagem 10');
INSERT INTO imagem (id_produto, imagem) VALUES (4, 'conteúdo da imagem 11');
INSERT INTO imagem (id_produto, imagem) VALUES (4, 'conteúdo da imagem 12');
INSERT INTO imagem (id_produto, imagem) VALUES (5, 'conteúdo da imagem 13');
INSERT INTO imagem (id_produto, imagem) VALUES (5, 'conteúdo da imagem 14');
INSERT INTO imagem (id_produto, imagem) VALUES (5, 'conteúdo da imagem 15');
INSERT INTO imagem (id_produto, imagem) VALUES (1, 'conteúdo da imagem 16');
INSERT INTO imagem (id_produto, imagem) VALUES (2, 'conteúdo da imagem 17');
INSERT INTO imagem (id_produto, imagem) VALUES (3, 'conteúdo da imagem 18');
INSERT INTO imagem (id_produto, imagem) VALUES (4, 'conteúdo da imagem 19');
INSERT INTO imagem (id_produto, imagem) VALUES (5, 'conteúdo da imagem 20');

INSERT INTO tamanho (id, codigo, descricao) VALUES
  (1, 'PP', 'Extra Pequeno'),
  (2, 'P', 'Pequeno'),
  (3, 'M', 'Médio'),
  (4, 'G', 'Grande'),
  (5, 'GG', 'Extra Grande'),
  (6, 'U', 'Único');

INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (1, 1, 10);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (1, 2, 5);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (1, 3, 8);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (1, 4, 0);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (1, 5, 2);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (1, 6, 3);

INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (2, 1, 12);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (2, 2, 3);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (2, 3, 6);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (2, 4, 0);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (2, 5, 0);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (2, 6, 4);

INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (3, 1, 8);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (3, 2, 2);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (3, 3, 4);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (3, 4, 0);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (3, 5, 0);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (3, 6, 1);

INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (4, 1, 15);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (4, 2, 5);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (4, 3, 10);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (4, 4, 0);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (4, 5, 3);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (4, 6, 2);

INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (5, 1, 6);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (5, 2, 0);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (5, 3, 2);
INSERT INTO estoque (id_camiseta, id_tamanho, quantidade) VALUES (5, 4, 0);


