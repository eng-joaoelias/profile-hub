-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/05/2024 às 21:04
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
-- Banco de dados: `users_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `idade` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(65) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `biografia` text DEFAULT NULL,
  `senha` varchar(100) NOT NULL,
  `ft_perfil` varchar(100) DEFAULT './images/default-avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `idade`, `email`, `telefone`, `endereco`, `biografia`, `senha`, `ft_perfil`) VALUES
(1, 'Ian Kevin Santos', 27, 'ian_kevin_santos@jetstar.com.br', '+5565986156150', 'Rua Curiangu, 253, CPA IV, Cuiabá, MT, 78058-246', 'Especialista em Desenvolvimento Web e Front-End com conhecimentos em HTML, CSS e JavaScript. Apaixonado por criar experiências digitais incríveis. #DesenvolvimentoWeb #FrontEnd #HTML #CSS #JavaScript', 'teste1234', './images/default-avatar.png'),
(2, 'Elias Rafael Vinicius Nunes', 25, 'elias_rafael_nunes@doucedoce.com.br', NULL, 'Rua São Cosmo, 119, Conjunto Rui Lino, Rio Branco, AC', '1. Especialista em Desenvolvimento Web com habilidades em HTML, CSS, JavaScript, PHP e SQL. Apaixonado por criar soluções inovadoras e funcionais para a web. Vamos trabalhar juntos para transformar suas ideias em realidade!', '6ebe8c6c6cb7862fdd2738cc9a59bae2', 'foto_eu.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
