-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/10/2024 às 13:47
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `now`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `id_memoria` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `favorita` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `album`
--

INSERT INTO `album` (`id`, `id_memoria`, `id_user`, `favorita`) VALUES
(1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `memoria`
--

CREATE TABLE `memoria` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` varchar(600) NOT NULL,
  `sentimento` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `foto` varchar(900) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `memoria`
--

INSERT INTO `memoria` (`id`, `titulo`, `descricao`, `sentimento`, `data`, `foto`) VALUES
(1, 'Confraternização final de ano!', 'Turma unida no parque da Feliz', 'felicidade', '2023-12-13', 'imagens/confraternizacao2023.jpg'),
(2, 'Decoração da sala', 'Metallica ou Luan Santana?', 'outofcontext', '2024-02-19', 'imagens/postersdaturma.jpg'),
(3, 'Luan Santana vs Caneta Azul', 'Quem ganhou?', 'outofcontext', '2023-05-05', 'imagens/guerraentreTI.jpg'),
(4, 'Despedida da profa Fernanda', 'Último dia com a profa Fernanda', 'tristeza', '2024-03-15', 'imagens/despedidaproffernanda.jpg'),
(5, 'Trilha com chuva', 'Primeira vez na trilha em 2024 e começou a chover', 'tristeza', '2024-04-17', 'imagens/trilhacomchuva.jpg'),
(6, 'Planilha de notas', 'Paulo e suas notas no Moodle', 'raiva', '2023-02-17', 'imagens/notasmatematica.png'),
(7, 'Diagramas e mais diagramas', 'Casos de uso e os vários comentários da profa Ana', 'nostalgia', '2023-10-16', 'imagens/casosdeuso.png'),
(8, 'Leitura e muita comida', 'Cafés literários \"básicos\" ', 'felicidade', '2023-11-20', 'imagens/cafesliterarios.png'),
(9, 'Aulas e aulas', 'As melhores aulas com nosso querido professor', 'nostalgia', '2023-07-19', 'imagens/aulasdotiago.png'),
(10, 'Matemática III', 'Nem precisa de descrição.', 'raiva', '2023-08-14', 'imagens/matematica3.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user`
--

INSERT INTO `user` (`id`, `nome`, `senha`) VALUES
(1, 'us4us', 'senha1234');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_memoria` (`id_memoria`),
  ADD KEY `id_user` (`id_user`);

--
-- Índices de tabela `memoria`
--
ALTER TABLE `memoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `memoria`
--
ALTER TABLE `memoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`id_memoria`) REFERENCES `memoria` (`id`),
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
