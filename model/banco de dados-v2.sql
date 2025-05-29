/* Requisitos funcionais
3 perfis: 1=Online, 2=físico ou 3=ambulante
Mesmas ferramentas para ambos
Informação do tipo de perfil armazenada para estatística */

-- Criação do Banco
CREATE DATABASE aprumacash;
USE aprumacash;

-- Tabela Auxiliar: Perfis
CREATE TABLE perfil (
	codPerfil	INT PRIMARY KEY AUTO_INCREMENT,
	nomePerfil	VARCHAR(15) NOT NULL
);
-- Inserção de perfis
insert into Perfil(codPerfil, nomePerfil) values
	(1,'Online'),
	(2,'Físico'),
	(3,'Ambulante');

-- Função Cadastro: Perfil do usuário
create table usuario (
	codUsu		INT PRIMARY KEY AUTO_INCREMENT,
	nomeUsu		VARCHAR(50) NOT NULL,
	emailUsu	VARCHAR(40) NOT NULL,
	senhaUsu	VARCHAR(255) NOT NULL,
	telUsu		CHAR(11) NULL,
	nascUsu		DATE NULL,
	perfilUsu	INT NULL,
	FOREIGN KEY (perfilUsu) REFERENCES perfil(codPerfil),
	ativo		TINYINT(1) NOT NULL DEFAULT 1
);

INSERT INTO `usuario` (`codUsu`, `emailUsu`, `nomeUsu`, `senhaUsu`, `telUsu`, `nascUsu`, `perfilUsu`, `ativo`) VALUES
(1,		'luizhbf18@gmail.com',	'Luiz Henrique',	'$2y$10$eKxOh1PuxAYKK6N8vashXOglEf56YTfEtr751uN0SVNPQcfABOSDC', '11111111111', '2006-10-18', 1, 1),
(2,		'rods@gmail.com',		'Rodrigo Jordão',	'$2y$10$Ff.AIXLlj9qJgeAjvBvdwOextQLZOPeWhG7XNH13qoOYn8pGnHZNS', '11111111111', '2025-04-09', 2, 1),
(12,	'moyses@gmail.com',		'Moysés',			'$2y$10$E4vewqj6lRYTQiOhD3vQrez31z0/2ESu1W5jvbu2EWhv1jgTcB6tm', '11111111111', '2025-04-10', 3, 1),
(13,	'gui@gmail.com',		'Gulherme',			'$2y$10$0MCc45EbYebxJex18g2X7eZkbwUPt0MKe1oT27M9Ei6P1dNb3zQ9a', '11111111111', '2025-04-10', NULL, 0);

-- Função Produto: Valores fixos
CREATE TABLE produto (
	codProduto		INT PRIMARY KEY AUTO_INCREMENT,
	nomeProduto		VARCHAR(30) NOT NULL,
	valorProduto	FLOAT(7,2) NOT NULL,
	codUsu			INT NOT NULL,
	FOREIGN KEY (codUsu) REFERENCES usuario(codUsu)
);

-- Função Pagamentos: Histórico de lucros semanais e registro de despesas mensais fixas
CREATE TABLE pagamento (
	codPagam	INT PRIMARY KEY AUTO_INCREMENT,
	nomePagam	VARCHAR(30) NULL,
	descPagam	VARCHAR(50) NULL,
	dataInic	DATE NULL,
	dataFim		DATE NULL,
	periodo		VARCHAR(9) NULL,
	valorPagam	FLOAT(7,2) NOT NULL,
	codUsu		INT NOT NULL,
	FOREIGN KEY (codUsu) REFERENCES usuario(codUsu)
);

-- Tabela Associativa: Produtos de pagamentos
CREATE TABLE produtoPagam (
	codProduto	INT NOT NULL,
	FOREIGN KEY (codProduto) REFERENCES produto(codProduto),
	codPagam	INT NOT NULL,
	FOREIGN KEY (codPagam) REFERENCES pagamento(codPagam),
	qntProduto	INT NOT NULL CHECK(qntProduto > 0)
);