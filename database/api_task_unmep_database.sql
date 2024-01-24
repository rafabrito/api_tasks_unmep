-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Jan-2024 às 19:02
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `unmep_back_end`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `task`
--

CREATE TABLE `task` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pendente','executando','concluída') DEFAULT NULL,
  `date_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `task`
--

INSERT INTO `task` (`id`, `title`, `description`, `status`, `date_at`) VALUES
(1, 'Tarefa 1', 'Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames lectus mattis.', 'pendente', '2024-01-23 02:13:14'),
(2, 'Tarefa 2', 'Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames lectus mattis.', 'concluída', '2024-01-23 15:00:41'),
(3, 'Tarefa 3', 'Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames lectus mattis.', 'concluída', '2024-01-20 21:37:27'),
(4, 'Tarefa 4', 'Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames lectus mattis.', 'executando', '2024-01-20 21:38:14');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `task`
--
ALTER TABLE `task`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
