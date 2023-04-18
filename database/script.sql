CREATE DATABASE IF NOT EXISTS  chestplace;

use chestplace;

CREATE TABLE usuario(
  id int(10) unsigned NOT NULL AUTO_INCREMENT, 
  id_tipo_usuario int(1) NOT NULL, 
  nome varchar(255) NOT NULL, 
  email varchar(255) UNIQUE NOT NULL, 
  senha varchar(255) NOT NULL, 
  banido datetime DEFAULT NULL, 
  PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE vendedor(
  id int(10), 
  nome_estabelecimento varchar(255) NOT NULL, 
  cpf char(11), 
  cnpj char(14),

  FOREIGN KEY (id) REFERENCES usuario(id)
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
  id_camiseta int(10), 
  id_tamanho int(10), 
  quantidade int(10) NOT NULL,
  FOREIGN KEY (id_camiseta) REFERENCES camiseta (id),
  FOREIGN KEY (id_tamanho) REFERENCES tamanho(id)
);

CREATE TABLE camiseta_nova(
  id int(10),
  FOREIGN KEY (id) REFERENCES camiseta(id)
);

CREATE TABLE camiseta_usada(
  id int(10), 
  conservacao ENUM('nova', 'seminova', 'usada', 'desgastada', 'muito desgasatda')
  FOREIGN KEY (id) REFERENCES camiseta(id)
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
  id_tipo_usuario int(10), 
  id_produto int(10),
  FOREIGN KEY (id_tipo_usuario) REFERENCES comprador(id),
  FOREIGN KEY (id_tipo_usuario) REFERENCES camiseta(id)
);

DROP DATABASE chestplace;