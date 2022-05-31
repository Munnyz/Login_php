-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31-Maio-2022 às 16:59
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `login`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `recupera_senha` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `cod_confirmacao` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `data_cadastro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `recupera_senha`, `token`, `cod_confirmacao`, `status`, `data_cadastro`) VALUES
(2, 'Larissa Salles', 'd36salles@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '65f713e931200ade7be600af7fe5dbdf31d836a4', '6295371bf17ec', 'confirmado', '30-05-2022'),
(3, 'Henry', 'luca@hotmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '62962bc28ee26', 'confirmado', '31-05-2022'),
(4, 'maysa', '1@hotmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '407e062e03b7b09ba6d6db4f304aa5d60f3b78c1', '62962cb218da0', 'confirmado', '31-05-2022');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
