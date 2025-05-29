-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/05/2025 às 04:32
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `aprumacash`
--
CREATE DATABASE IF NOT EXISTS `aprumacash` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aprumacash`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `codPagam` int(11) NOT NULL,
  `nomePagam` varchar(30) DEFAULT NULL,
  `descPagam` varchar(50) DEFAULT NULL,
  `dataInic` date DEFAULT NULL,
  `dataFim` date DEFAULT NULL,
  `periodo` varchar(9) DEFAULT NULL,
  `valorPagam` float(7,2) NOT NULL,
  `codUsu` int(11) NOT NULL,
  `tipo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamento`
--

INSERT INTO `pagamento` (`codPagam`, `nomePagam`, `descPagam`, `dataInic`, `dataFim`, `periodo`, `valorPagam`, `codUsu`, `tipo`) VALUES
(4, 'Funcionários', '', '0000-00-00', '0000-00-00', '1 months', -6300.00, 1, 'despesa'),
(8, 'Aluguel', '', '0000-00-00', '0000-00-00', '1 months', -1500.00, 1, 'Despesa'),
(10, 'Vendas da semana', 'Brigadeiro: 30<br>Beijinho: 10<br>', '2025-05-05', '2025-05-12', NULL, 102.50, 1, 'Lucro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE `perfil` (
  `codPerfil` int(11) NOT NULL,
  `nomePerfil` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perfil`
--

INSERT INTO `perfil` (`codPerfil`, `nomePerfil`) VALUES
(1, 'Online'),
(2, 'Físico'),
(3, 'Ambulante');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `codProduto` int(11) NOT NULL,
  `nomeProduto` varchar(30) NOT NULL,
  `valorProduto` float(7,2) NOT NULL,
  `codUsu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`codProduto`, `nomeProduto`, `valorProduto`, `codUsu`) VALUES
(1, 'Brigadeiro', 2.50, 1),
(3, 'Beijinho', 2.75, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtopagam`
--

CREATE TABLE `produtopagam` (
  `codProduto` int(11) NOT NULL,
  `codPagam` int(11) NOT NULL,
  `qntProduto` int(11) NOT NULL CHECK (`qntProduto` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `codUsu` int(11) NOT NULL,
  `nomeUsu` varchar(50) NOT NULL,
  `emailUsu` varchar(40) NOT NULL,
  `senhaUsu` varchar(255) NOT NULL,
  `telUsu` char(11) DEFAULT NULL,
  `nascUsu` date DEFAULT NULL,
  `perfilUsu` int(11) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`codUsu`, `nomeUsu`, `emailUsu`, `senhaUsu`, `telUsu`, `nascUsu`, `perfilUsu`, `ativo`) VALUES
(1, 'Luiz Henrique', 'luizhbf18@gmail.com', '$2y$10$eKxOh1PuxAYKK6N8vashXOglEf56YTfEtr751uN0SVNPQcfABOSDC', '11111111111', '2006-10-18', 1, 1),
(2, 'Rodrigo Jordão', 'rods@gmail.com', '$2y$10$Ff.AIXLlj9qJgeAjvBvdwOextQLZOPeWhG7XNH13qoOYn8pGnHZNS', '11111111111', '2025-04-09', 2, 1),
(12, 'Moysés', 'moyses@gmail.com', '$2y$10$E4vewqj6lRYTQiOhD3vQrez31z0/2ESu1W5jvbu2EWhv1jgTcB6tm', '11111111111', '2025-04-10', 3, 1),
(13, 'Gulherme', 'gui@gmail.com', '$2y$10$0MCc45EbYebxJex18g2X7eZkbwUPt0MKe1oT27M9Ei6P1dNb3zQ9a', '11111111111', '2025-04-10', NULL, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`codPagam`),
  ADD KEY `codUsu` (`codUsu`);

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`codPerfil`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`codProduto`),
  ADD KEY `codUsu` (`codUsu`);

--
-- Índices de tabela `produtopagam`
--
ALTER TABLE `produtopagam`
  ADD KEY `codProduto` (`codProduto`),
  ADD KEY `codPagam` (`codPagam`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codUsu`),
  ADD KEY `perfilUsu` (`perfilUsu`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `codPagam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `codPerfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `codProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`codUsu`) REFERENCES `usuario` (`codUsu`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`codUsu`) REFERENCES `usuario` (`codUsu`);

--
-- Restrições para tabelas `produtopagam`
--
ALTER TABLE `produtopagam`
  ADD CONSTRAINT `produtopagam_ibfk_1` FOREIGN KEY (`codProduto`) REFERENCES `produto` (`codProduto`),
  ADD CONSTRAINT `produtopagam_ibfk_2` FOREIGN KEY (`codPagam`) REFERENCES `pagamento` (`codPagam`);

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`perfilUsu`) REFERENCES `perfil` (`codPerfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
