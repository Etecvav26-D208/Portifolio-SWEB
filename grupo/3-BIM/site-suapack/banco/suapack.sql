-- =========================================================
-- SUA PACK
-- BANCO DE DADOS COMPLETO
-- =========================================================

-- Apaga o banco anterior para criar tudo novamente do zero.
-- ATENÇÃO: isso apaga os dados antigos desse banco.
DROP DATABASE IF EXISTS suapack;

-- Cria o banco
CREATE DATABASE suapack;

-- Seleciona o banco
USE suapack;


-- =========================================================
-- TABELA DE CATEGORIAS
-- =========================================================

CREATE TABLE categorias (

    id_categoria INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL

);


-- =========================================================
-- TABELA DE PRODUTOS
-- =========================================================

CREATE TABLE produtos (

    id_produto INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL,

    descricao TEXT,

    preco DECIMAL(10,2) NOT NULL,

    preco_promocional DECIMAL(10,2) DEFAULT NULL,

    imagem VARCHAR(255) DEFAULT NULL,

    estoque INT DEFAULT 0,

    em_promocao BOOLEAN DEFAULT FALSE,

    id_categoria INT

);


-- =========================================================
-- TABELA DE PEDIDOS
-- =========================================================

CREATE TABLE pedidos (

    id_pedido INT AUTO_INCREMENT PRIMARY KEY,

    nome_cliente VARCHAR(100) NOT NULL,

    endereco VARCHAR(255) NOT NULL,

    forma_pagamento VARCHAR(50) NOT NULL,

    valor_total DECIMAL(10,2) NOT NULL,

    status_pedido VARCHAR(50) DEFAULT 'Pendente'

);


-- =========================================================
-- TABELA DE ITENS DO PEDIDO
-- =========================================================

CREATE TABLE itens_pedido (

    id_item INT AUTO_INCREMENT PRIMARY KEY,

    id_pedido INT NOT NULL,

    id_produto INT NOT NULL,

    quantidade INT NOT NULL,

    preco_unitario DECIMAL(10,2) NOT NULL

);


-- =========================================================
-- CATEGORIAS
-- =========================================================

INSERT INTO categorias
(nome)
VALUES
('Mochilas'),
('Bonés'),
('Chaveiros'),
('Adesivos'),
('Pulseiras');


-- =========================================================
-- PRODUTOS - MOCHILAS
-- 7 produtos
-- Estoque inicial: 5 unidades cada
-- =========================================================

INSERT INTO produtos
(
    nome,
    descricao,
    preco,
    preco_promocional,
    imagem,
    estoque,
    em_promocao,
    id_categoria
)
VALUES

(
    'Bolsa Gótica',
    'Bolsa com estilo gótico e visual marcante. Ideal para completar looks urbanos e alternativos.',
    89.90,
    NULL,
    'bolsa_gotica.png',
    5,
    FALSE,
    1
),

(
    'Mochila Gótica',
    'Mochila com estética gótica e urbana, perfeita para escola, passeios e looks streetwear.',
    119.90,
    NULL,
    'mochila_gotica.png',
    5,
    FALSE,
    1
),

(
    'Mochila Personalizável',
    'Mochila urbana personalizável para você montar seu próprio estilo.',
    129.90,
    NULL,
    'mochila_personalizavel.png',
    5,
    FALSE,
    1
),

(
    'Mochila Dreamy',
    'Mochila com visual divertido e moderno, inspirada na estética dreamy.',
    109.90,
    NULL,
    'mochila_dreamy.jpeg',
    5,
    FALSE,
    1
),

(
    'Mochila Custom Style',
    'Mochila exclusiva da SUA PACK com estilo urbano e espaço para seus acessórios.',
    139.90,
    NULL,
    'mochila_custom_style.jpeg',
    5,
    FALSE,
    1
),

(
    'Mochila Azul Aqua',
    'Mochila em tons de azul aqua para quem gosta de um visual diferente e moderno.',
    114.90,
    NULL,
    'mochila_azul_aqua.png',
    5,
    FALSE,
    1
),

(
    'Bolsa Urban',
    'Bolsa compacta com inspiração streetwear para completar produções urbanas.',
    79.90,
    NULL,
    'bolsa_urban.jpeg',
    5,
    FALSE,
    1
);


-- =========================================================
-- PRODUTOS - BONÉS
-- 7 produtos
-- Estoque inicial: 5 unidades cada
-- =========================================================

INSERT INTO produtos
(
    nome,
    descricao,
    preco,
    preco_promocional,
    imagem,
    estoque,
    em_promocao,
    id_categoria
)
VALUES

(
    'Boné Amarelo',
    'Boné amarelo com visual urbano e descontraído.',
    59.90,
    NULL,
    'bone_amarelo.jpeg',
    5,
    FALSE,
    2
),

(
    'Boné Azul',
    'Boné azul com estilo streetwear para completar diferentes looks.',
    59.90,
    NULL,
    'bone_azul.jpeg',
    5,
    FALSE,
    2
),

(
    'Boné Feminino Gótico',
    'Boné com estética gótica e visual alternativo.',
    64.90,
    NULL,
    'bone_feminino_gotico.png',
    5,
    FALSE,
    2
),

(
    'Boné Floral',
    'Boné com estampa floral e proposta urbana.',
    64.90,
    NULL,
    'bone_floral.jpeg',
    5,
    FALSE,
    2
),

(
    'Boné Masculino Gótico',
    'Boné com visual gótico e inspiração streetwear.',
    64.90,
    NULL,
    'bone_masculino_gotico.png',
    5,
    FALSE,
    2
),

(
    'Boné Preto',
    'Boné preto básico e versátil para compor diferentes estilos.',
    54.90,
    NULL,
    'bone_preto.jpeg',
    5,
    FALSE,
    2
),

(
    'Boné Vermelho',
    'Boné vermelho com visual marcante e urbano.',
    59.90,
    NULL,
    'bone_vermelho.jpeg',
    5,
    FALSE,
    2
);


-- =========================================================
-- PRODUTOS - CHAVEIROS
-- 5 produtos
-- R$ 21,90 cada
-- Estoque inicial: 5 unidades cada
-- =========================================================

INSERT INTO produtos
(
    nome,
    descricao,
    preco,
    preco_promocional,
    imagem,
    estoque,
    em_promocao,
    id_categoria
)
VALUES

(
    'Chaveiro Colorido',
    'Chaveiro colorido para deixar mochila, bolsa ou chave ainda mais personalizada.',
    21.90,
    NULL,
    'chaveiro_colorido.jpg',
    5,
    FALSE,
    3
),

(
    'Chaveiro Cinza',
    'Chaveiro cinza com visual moderno e discreto.',
    21.90,
    NULL,
    'chaveiro_cinza.jpg',
    5,
    FALSE,
    3
),

(
    'Chaveiro Preto e Azul',
    'Chaveiro preto e azul com estética urbana.',
    21.90,
    NULL,
    'chaveiro_preto_azul.jpg',
    5,
    FALSE,
    3
),

(
    'Chaveiro Branco e Verde',
    'Chaveiro branco e verde com visual divertido e moderno.',
    21.90,
    NULL,
    'chaveiro_branco_verde.jpg',
    5,
    FALSE,
    3
),

(
    'Chaveiro Cachorro',
    'Chaveiro inspirado em cachorro para personalizar seus acessórios.',
    21.90,
    NULL,
    'chaveiro_cachorro.jpg',
    5,
    FALSE,
    3
);


-- =========================================================
-- PRODUTOS - ADESIVOS
-- 4 produtos
-- R$ 18,90 cada
-- Estoque inicial: 5 unidades cada
-- =========================================================

INSERT INTO produtos
(
    nome,
    descricao,
    preco,
    preco_promocional,
    imagem,
    estoque,
    em_promocao,
    id_categoria
)
VALUES

(
    'Pack de Adesivos 1',
    'Pack de adesivos para personalizar notebooks, celulares, cadernos, garrafas e acessórios.',
    18.90,
    NULL,
    'adesivo_pack_1.png',
    5,
    FALSE,
    4
),

(
    'Pack de Adesivos 2',
    'Pack de adesivos com diferentes artes para deixar seus objetos com a sua cara.',
    18.90,
    NULL,
    'adesivo_pack_2.png',
    5,
    FALSE,
    4
),

(
    'Pack de Adesivos 3',
    'Pack de adesivos com estética jovem e urbana.',
    18.90,
    NULL,
    'adesivo_pack_3.png',
    5,
    FALSE,
    4
),

(
    'Pack de Adesivos 4',
    'Pack de adesivos para personalização e composição de diferentes estilos.',
    18.90,
    NULL,
    'adesivo_pack_4.png',
    5,
    FALSE,
    4
);


-- =========================================================
-- PRODUTOS - PULSEIRAS
-- 2 produtos
-- R$ 20,00 cada
-- Estoque inicial: 5 unidades cada
-- =========================================================

INSERT INTO produtos
(
    nome,
    descricao,
    preco,
    preco_promocional,
    imagem,
    estoque,
    em_promocao,
    id_categoria
)
VALUES

(
    'Pulseira Estilizada Preta',
    'Pulseira preta com estilo urbano para complementar seu visual.',
    20.00,
    NULL,
    'pulseira_estilizada_preta.jpeg',
    5,
    FALSE,
    5
),

(
    'Pulseira Estilizada Rosa',
    'Pulseira rosa com visual moderno e delicado para completar seu estilo.',
    20.00,
    NULL,
    'pulseira_estilizada_rosa.jpeg',
    5,
    FALSE,
    5
);


-- =========================================================
-- FIM DO BANCO SUA PACK
-- =========================================================
