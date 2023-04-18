CREATE DATABASE IF NOT EXISTS  chestplace;

use chestplace;

CREATE TABLE usuario(
  id int(10) unsigned NOT NULL AUTO_INCREMENT, 
  id_tipo_usuario int(1) NOT NULL, 
  nome varchar(255) NOT NULL, 
  email varchar(255) NOT NULL, 
  senha varchar(255) NOT NULL, 
  banido datetime DEFAULT NULL, 
  PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE vendedor(
  id int(10) FOREIGN KEY REFERENCES usuario(id), 
  nome_estabelecimento varchar(255) NOT NULL, 
  cpf char(11), 
  cnpj char(14)
);

CREATE TABLE comprador(
  id int(10) FOREIGN KEY REFERENCES usuario(id), 
  cpf varchar(11) DEFAULT NULL 
);

CREATE TABLE administrador(
  id int(10) FOREIGN KEY REFERENCES usuario(id)
  -- Tabela feita apenas para diferenciar o admin dos outros
);

CREATE TABLE tamanho(
  id int(2) unsigned PRIMARY KEY, 
  codigo varchar(3) NOT NULL, 
  descricao varchar(255) NOT NULL
);

CREATE TABLE camiseta(
  id int(10) unsigned NOT NULL AUTO_INCREMENT, 
  titulo varchar(255) NOT NULL, 
  descricao text DEFAULT '', 
  preco float NOT NULL, 
  imagem blob NOT NULL, 
  data_hora_publicacao datetime NOT NULL, 
  id_marca int(10) DEFAULT NULL
)ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE tamanho_camiseta(
  id_camiseta int(10) FOREIGN KEY REFERENCES camiseta (id), 
  id_tamanho int(10) FOREIGN KEY REFERENCES tamanho(id), 
  quantidade int(10) NOT NULL
);

CREATE TABLE camiseta_nova(
  id int(10) FOREIGN KEY REFERENCES camiseta(id)
);

CREATE TABLE camiseta_usada(
  id int(10) FOREIGN KEY REFERENCES camiseta(id), 
  conservacao ENUM('nova', 'seminova', 'usada', 'desgastada', 'muito desgasatda')
);

CREATE TABLE venda(
  id int(10) unsigned NOT NULL AUTO_INCREMENT, 
  id_camiseta int(10) unsigned NOT NULL AUTO_INCREMENT, 
  id_comprador int(10) NOT NULL, 
  data_hora_compra datetime NOT NULL, 
  data_hora_confirmacao_pagamento datetime DEFAULT NULL, 
  data_hora_recebimento datetime DEFAULT NULL, 
  quantidade int(5) NOT NULL, 
  PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE carrinho(
  id_tipo_usuario int(10) FOREIGN KEY REFERENCES comprador(id), 
  id_produto int(10) FOREIGN KEY REFERENCES camiseta(id)
);

DROP DATABASE chestplace;