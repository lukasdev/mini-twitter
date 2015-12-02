-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 02-Dez-2015 às 19:24
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mini_twitter`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `follows`
--

CREATE TABLE IF NOT EXISTS `follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seguidor` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `follows`
--

INSERT INTO `follows` (`id`, `seguidor`, `usuario`) VALUES
(1, 1, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `trending`
--

CREATE TABLE IF NOT EXISTS `trending` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hashtag` varchar(100) NOT NULL,
  `mencoes` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `trending`
--

INSERT INTO `trending` (`id`, `hashtag`, `mencoes`) VALUES
(1, '#downs_master', 3),
(2, '#tweet', 1),
(3, '#sou_demais', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tweets`
--

CREATE TABLE IF NOT EXISTS `tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tweet` varchar(250) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tweets`
--

INSERT INTO `tweets` (`id`, `user_id`, `tweet`, `data`) VALUES
(1, 1, 'Este é o primeiro tweet do Zezin da Silva <a href="http://localhost/videoaulas/mini-twitter/hashtag/downs_master">#downs_master</a>', '2015-11-28 12:18:37'),
(2, 1, 'Este é o segundo tweet do zezin', '2015-11-28 12:18:46'),
(3, 4, 'Este é o primeiro tweet do Lucas Silva <a href="http://localhost/videoaulas/mini-twitter/hashtag/sou_demais">#sou_demais</a>', '2015-11-28 12:19:09'),
(4, 4, 'Outro tweet do lucas pra encher linguiça', '2015-11-28 12:19:20'),
(5, 4, 'Mais um tweet e tal', '2015-11-28 12:19:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` varchar(200) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `nickname` varchar(200) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `foto`, `nome`, `nickname`, `email`, `senha`, `descricao`) VALUES
(1, 'a6ccafaf9d519ca756914778daf93414.jpg', 'Zézinho da Silva', 'zezin_santos', 'zezin@gmei.com', '123zezin', 'Esta é a descrição do zezin do santos, ele é muito legal!'),
(4, '5fe00ac6fd0dd46a665befee0b34bc95.jpg', 'Lucas Silva', 'lukas_dev', 'lukasdev@hotmail.com', '123456', 'Esta é a descrição do lucas silva');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
