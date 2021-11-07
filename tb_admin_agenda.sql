-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Nov-2021 às 21:45
-- Versão do servidor: 10.4.20-MariaDB
-- versão do PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.agenda`
--

CREATE TABLE `tb_admin.agenda` (
  `id` int(11) NOT NULL,
  `tarefa` varchar(255) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_admin.agenda`
--

INSERT INTO `tb_admin.agenda` (`id`, `tarefa`, `data`) VALUES
(1, 'Dar comida para o Nico', '2021-09-05'),
(2, 'Ir para a Academia', '2021-09-06'),
(3, 'Fazer curso', '2021-09-04'),
(4, 'Tarefa', '2017-09-01'),
(5, '', '2017-09-01'),
(6, 'Tarefa', '2021-09-06'),
(7, 'Ir para academia novamente', '2021-09-06'),
(8, '', '2021-09-06'),
(9, 'Ola', '2021-09-01'),
(10, 'Tarefa dia 8', '2021-09-08'),
(11, 'tAREFA DOIS', '2021-09-06'),
(12, 'Ir para academia novamente', '2021-09-27'),
(13, 'Aula', '2021-09-30'),
(14, 'Ir para academia novamente', '2021-09-11');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_admin.agenda`
--
ALTER TABLE `tb_admin.agenda`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_admin.agenda`
--
ALTER TABLE `tb_admin.agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
