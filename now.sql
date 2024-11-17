-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/11/2024 às 15:20
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
  `favorita` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `album`
--

INSERT INTO `album` (`id`, `id_memoria`, `id_user`, `favorita`) VALUES
(1, 1, 1, 0),
(2, 8, 1, 0),
(3, 4, 1, 0),
(4, 5, 1, 0),
(5, 10, 1, 0),
(6, 7, 1, 0),
(7, 9, 1, 0),
(8, 3, 1, 0),
(9, 2, 1, 0),
(10, 6, 1, 0),
(11, 4, 2, 0),
(12, 10, 2, 0),
(13, 3, 2, 0),
(14, 5, 2, 0),
(15, 2, 2, 1),
(16, 1, 2, 0),
(17, 8, 2, 0),
(18, 6, 2, 0),
(19, 7, 2, 0),
(20, 16, 3, 0),
(21, 19, 3, 0),
(22, 2, 3, 0),
(23, 9, 3, 0),
(24, 7, 3, 0),
(25, 10, 3, 0),
(26, 5, 3, 0),
(27, 11, 3, 0),
(28, 13, 3, 0),
(29, 21, 3, 0),
(30, 22, 3, 0),
(31, 3, 3, 0),
(32, 17, 3, 0),
(33, 18, 3, 0),
(34, 8, 3, 0),
(35, 14, 3, 0),
(36, 6, 3, 0),
(37, 20, 3, 0),
(38, 4, 3, 0),
(39, 1, 3, 0),
(40, 52, 3, 0),
(41, 48, 3, 0),
(42, 24, 3, 0),
(43, 36, 3, 0),
(44, 28, 3, 0),
(45, 42, 3, 0),
(46, 57, 3, 0),
(47, 76, 3, 0),
(48, 71, 3, 0),
(49, 80, 3, 0),
(50, 78, 3, 0),
(51, 15, 3, 0),
(52, 55, 3, 0),
(53, 26, 3, 0),
(54, 54, 3, 0),
(55, 73, 3, 0),
(56, 65, 3, 0),
(57, 45, 3, 0),
(58, 23, 3, 0),
(59, 33, 3, 0),
(60, 29, 3, 0),
(61, 44, 3, 0),
(62, 47, 3, 0),
(63, 61, 3, 0),
(64, 59, 3, 0),
(65, 77, 3, 0),
(66, 25, 3, 0),
(67, 63, 3, 0),
(68, 39, 3, 0),
(69, 81, 3, 0),
(70, 64, 3, 0),
(71, 35, 3, 0),
(72, 43, 3, 0),
(73, 66, 3, 0),
(74, 30, 3, 0),
(75, 68, 3, 0),
(76, 38, 3, 0),
(77, 51, 3, 0),
(78, 37, 3, 0),
(79, 67, 3, 0),
(80, 63, 4, 0),
(81, 12, 4, 0),
(82, 1, 4, 1),
(83, 57, 4, 0),
(84, 10, 4, 0),
(85, 78, 4, 0),
(86, 7, 4, 0),
(87, 38, 4, 0),
(88, 59, 4, 0),
(89, 54, 4, 0),
(90, 8, 4, 0),
(91, 5, 4, 0),
(92, 43, 4, 0),
(93, 30, 4, 0),
(94, 31, 4, 0),
(95, 22, 4, 0),
(96, 65, 4, 0),
(97, 50, 4, 0),
(98, 82, 4, 0),
(99, 4, 4, 0),
(100, 28, 4, 1),
(101, 35, 4, 0),
(102, 16, 4, 0),
(103, 32, 4, 0),
(104, 24, 4, 0);

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
(10, 'Matemática III', 'Nem precisa de descrição.', 'raiva', '2023-08-14', 'imagens/matematica3.png'),
(11, '69?', 'Apelido que ficou...', 'outofcontext', '2021-04-23', 'imagens/69.png'),
(12, 'Mostras Técnica 2022', 'Novos mini alunos no IFRS', 'nostalgia', '2022-10-20', 'imagens/aluninhos.png'),
(13, 'O que é arte?', 'Contemplando arte contemporânea', 'outofcontext', '2024-11-12', 'imagens/arte.png'),
(14, 'Assoprando Dente-de-leão', 'Mais um dia normal...', 'outofcontext', '2022-05-24', 'imagens/assoprando.png'),
(15, 'Fotinho numa aula', 'Uma das várias fotos', 'felicidade', '2023-08-18', 'imagens/banco.png'),
(16, 'Mais uma mudança?', 'Mudando os bancos toda hora', 'tristeza', '2022-11-11', 'imagens/bancolevado.png'),
(17, 'Linux', 'Instalar todos os serviços em Redes de Computadores', 'raiva', '2022-09-15', 'imagens/biblialinux.png'),
(18, 'Vencedores da vez', 'Time Capivara ganhou!!', 'nostalgia', '2022-07-13', 'imagens/capivaratime2.png'),
(19, 'Confraternização final de 2022', 'Com direito a comida e champanhe SEM álcool', 'felicidade', '2022-12-15', 'imagens/confraternizacaocomc.png'),
(20, 'Copa 2022', 'Sem comentários', 'raiva', '2022-12-07', 'imagens/copa22.png'),
(21, 'Dancinha e música', 'Com direito a dança do TikTok', 'outofcontext', '2023-07-14', 'imagens/danca.png'),
(22, 'Descansando na mostra técnica', 'Sol, plicplac e fofoca', 'nostalgia', '2023-10-19', 'imagens/descansando.png'),
(23, 'Quem era para ser?', 'Desenho abstrato ', 'outofcontext', '2022-11-10', 'imagens/desenho.png'),
(24, 'Doguinhos de balão', 'Britney, Tiffany e Marcos', 'outofcontext', '2024-06-13', 'imagens/doguinhos.png'),
(25, 'ZZZZZZZ...', 'Aquela dormida depois da visita técnica', 'outofcontext', '2024-11-12', 'imagens/dormida2.png'),
(26, 'Não se pode dormir mais', 'Depois de um dia cheio...', 'tristeza', '2024-11-12', 'imagens/dormidaonibus.png'),
(27, 'Primeiro ano de aula', 'Lembranças do EAD', 'nostalgia', '2021-10-21', 'imagens/ead.png'),
(28, 'Quando não tínhamos quadra', 'E o sol de rachar', 'nostalgia', '2023-08-17', 'imagens/edfisicasol.png'),
(29, 'Período de eleições', 'Eleições federais 2022', 'nostalgia', '2022-10-13', 'imagens/eleicoes.png'),
(30, 'Música na Ed. Física', 'Quando o Enrico ainda fazia parte da turma', 'tristeza', '2022-09-23', 'imagens/falecido.png'),
(31, 'Experimento na aula de física', 'Quando o experimento da errado...', 'raiva', '2022-11-16', 'imagens/fisica.png'),
(32, 'Experimentando a câmera da D4', 'Depois de descobrir as câmeras escondidas', 'felicidade', '2022-10-13', 'imagens/gabeejulia.png'),
(33, 'Julia adotou um gato', 'O gato chamou a atenção de todos', 'outofcontext', '2023-10-20', 'imagens/gatopreto2.png'),
(34, 'Gaudério', 'Mais uma foto aleatória', 'outofcontext', '2022-11-09', 'imagens/gauderio.png'),
(35, '1° Hackathon', 'Participação no 1° Hackathon do Câmpus', 'felicidade', '2024-08-16', 'imagens/hackathon.png'),
(36, 'Fotinho nas aulas', 'Hardware e Software II', 'felicidade', '2022-06-16', 'imagens/hardwareesoftware.png'),
(37, 'Glória do desporto nacional...', 'Gremista cantando o hino do Internacional', 'tristeza', '2021-12-15', 'imagens/hino.png'),
(38, 'ICarly sem som', 'Projetor da D5 sem som e imagem péssima', 'raiva', '2022-11-04', 'imagens/icarly.png'),
(39, 'Resquício da Guerra entre 3° e 4° de TI', 'Luan Santana????', 'outofcontext', '2023-09-15', 'imagens/luan.png'),
(40, 'Por que?', 'Era Halloween em 2023', 'outofcontext', '2023-10-31', 'imagens/lucascoelho.png'),
(41, 'Observando a lua', 'Mais um dia normal no IFRS', 'felicidade', '2022-09-28', 'imagens/meteoro.png'),
(42, 'Mostra Técnica 2023', 'Chimas e informática', 'felicidade', '2023-10-05', 'imagens/mostratec.png'),
(43, 'Oficina', 'O que aconteceu?', 'outofcontext', '2023-08-18', 'imagens/naosei.png'),
(44, 'Sem contexto mesmo! ', 'Sem palavras', 'outofcontext', '2022-05-20', 'imagens/naosei2.png'),
(45, 'Tempos do BeReal', 'Era fotos todos os dias', 'felicidade', '2023-09-13', 'imagens/nickejulia.png'),
(46, 'O Corvo', 'Aula de inglês temática', 'felicidade', '2022-11-04', 'imagens/ocorvo.png'),
(47, 'Recadinho no mural dos professores', 'Quando nosso PAI Tiago estava entre nós', 'nostalgia', '2023-10-13', 'imagens/paitiago.png'),
(48, 'Foto da turma', 'Dia de espanhol e parque', 'felicidade', '2024-04-17', 'imagens/parque.png'),
(49, 'Não sei o que aconteceu', 'Voltinha de 10 pessoas no parque da Feliz', 'outofcontext', '2023-11-17', 'imagens/parque2.png'),
(50, 'Voltinha no Parque', 'Comes, bebes e \"hablamos\" muito', 'felicidade', '2024-04-18', 'imagens/parqueizandra.png'),
(51, 'Aulas livres para jogar', 'Muitos jogos na garagem do IF', 'nostalgia', '2022-06-17', 'imagens/pingpong.png'),
(52, 'Muita Pizza!!', 'Ganhamos um bandeja inteira', 'felicidade', '2023-08-23', 'imagens/pizzaif.png'),
(53, 'Momento de despedida', 'Despedida do nosso professor homenageado', 'felicidade', '2024-06-20', 'imagens/pizzatiago.png'),
(54, 'Pizza, conversa e bebidas', 'Primeira confraternização da turma 2024', 'felicidade', '2024-07-26', 'imagens/pizzatri1.png'),
(55, 'Plantinhas', 'Aulas da Ocinéia de botânica ', 'nostalgia', '2022-09-13', 'imagens/plantinhas.png'),
(56, 'Plic Plac', 'Mostra Técnica e comida', 'nostalgia', '2022-10-14', 'imagens/plicplac.png'),
(57, 'Fofocas', 'Fofocando...', 'raiva', '2023-06-08', 'imagens/plicplac2.png'),
(58, 'Feira do Livro 2024', 'Mais um passeio', 'felicidade', '2024-11-12', 'imagens/poa.png'),
(59, 'Muita chuva kkkkk', 'Primeira vez na trilha em 2024 e choveu', 'tristeza', '2024-03-18', 'imagens/protecaodachuva.png'),
(60, 'Visita técnica 2023', 'Foto aleatória na PUCRS', 'nostalgia', '2023-09-21', 'imagens/puc.png'),
(61, 'Visita Técnica 2023', 'Descanso na PUC', 'felicidade', '2023-09-21', 'imagens/pucgarotas.png'),
(62, 'Aprendendo na prática', 'Aula de química', 'nostalgia', '2022-11-09', 'imagens/quimica.png'),
(63, 'Destruição', 'Destruindo a tabela periódica que não valeu nota', 'tristeza', '2022-12-09', 'imagens/riptabela.png'),
(64, 'RED PEN', 'Vulgo Caneta Azul', 'nostalgia', '2023-09-19', 'imagens/redpen.png'),
(65, 'Medindo Ph', 'Aula prática de química I', 'nostalgia', '2022-10-18', 'imagens/quimica2.png'),
(66, 'Verão de 35°', 'Passando calor', 'raiva', '2022-02-22', 'imagens/saladeaula.png'),
(67, 'Sala com nova decoração', 'Terceira parte do Luan Santana vs. Caneta Azul', 'outofcontext', '2023-07-19', 'imagens/salaluan.png'),
(68, 'Convite para ser professor conselheiro', 'Com direito a estourar confeites e presente', 'felicidade', '2024-02-27', 'imagens/surpresa.png'),
(69, 'Mais uma foto aleatória', 'Aula de Banco de Dados', 'felicidade', '2023-05-19', 'imagens/tecnicos.png'),
(70, 'Não sei', 'A imagem fala por si', 'outofcontext', '2022-07-18', 'imagens/theisen.png'),
(71, 'Halloween ', 'Mais um professor com a fantasia de coelho', 'outofcontext', '2023-10-31', 'imagens/tiagocoelho2.png'),
(72, 'Trilha final de 2022', 'Quando não tem mais aula...', 'nostalgia', '2022-12-09', 'imagens/trilha.png'),
(73, 'Dia de trazer ursinho de pelúcia', 'Toda semana era algo novo', 'felicidade', '2024-06-26', 'imagens/ursopelucia.png'),
(74, 'Mais fotos em aulas', 'Bem aleatório', 'outofcontext', '2023-06-21', 'imagens/usgu.png'),
(75, 'Vettori ama 4° TI', 'Obs: fez com todos os 4° anos', 'outofcontext', '2024-07-12', 'imagens/vettori.png'),
(76, 'Fofocas e pizza', 'Mais lembranças da noite da pizza', 'felicidade', '2024-07-26', 'imagens/vinho.png'),
(77, 'Visita na PUCRS', 'Visita técnica de 2023', 'felicidade', '2023-09-21', 'imagens/visitapuc.png'),
(78, 'Confraternização 2023', 'Foto com a concelheira', 'felicidade', '2023-12-13', 'imagens/vivianparque.png'),
(79, 'Cansados de jogar vôlei', 'Quando ninguém mais tinha vontade de jogar', 'tristeza', '2022-10-13', 'imagens/volei.png'),
(80, 'Volta no parque da Feliz', 'Andar, andar e andar', 'outofcontext', '2023-10-19', 'imagens/voltinha.png'),
(81, 'Halloween 2024', 'Poucos aderiram as vestimentas', 'felicidade', '2024-10-31', 'imagens/halloween2024.png'),
(82, 'Brinquedos infláveis ', 'Muita diversão', 'felicidade', '2024-10-17', 'imagens/brinquedos.png'),
(83, 'Ainda precisava de máscara', 'Mais fotos em aula', 'outofcontext', '2021-11-19', 'imagens/guriasaula.png'),
(84, '1° Visita Técnica', 'Visita na Rech ', 'felicidade', '0000-00-00', 'imagens/visitarech.png'),
(85, 'Ainda precisava de máscara', 'Mais fotos em aula', 'outofcontext', '2021-11-19', 'imagens/guriasaula.png'),
(86, '1° Visita Técnica', 'Visita na Rech ', 'felicidade', '2022-10-02', 'imagens/visitarech.png'),
(87, 'Fotos tiradas em aula', 'Mathias e seu óculos', 'outofcontext', '2022-09-20', 'imagens/mathias.png'),
(88, 'Filmes e filmes', 'Usando o auditório', 'nostalgia', '2023-05-24', 'imagens/guris.png'),
(89, 'Vencemos!!', 'Ganhadores das interseries', 'felicidade', '2022-10-22', 'imagens/campeoes.png'),
(90, 'Não faço ideia', 'O que aconteceu?', 'outofcontext', '2022-07-22', 'imagens/festajunina.png');

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
(1, 'us4us', 'senha1234'),
(2, 'teste', 'teste1234'),
(3, 'julia', 'julia123'),
(4, 'teste2', 'teste123');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de tabela `memoria`
--
ALTER TABLE `memoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
