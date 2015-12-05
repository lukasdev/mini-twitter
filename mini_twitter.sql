-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 06-Dez-2015 às 00:51
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `follows`
--

INSERT INTO `follows` (`id`, `seguidor`, `usuario`) VALUES
(1, 1, 4),
(2, 4, 1);

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
  `timestamp` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `tweets`
--

INSERT INTO `tweets` (`id`, `user_id`, `tweet`, `data`, `timestamp`) VALUES
(1, 4, 'Olá Zezin', '2015-12-05 15:26:12', '1449336372'),
(2, 1, 'E ae', '2015-12-05 15:26:36', '1449336396'),
(3, 4, 'Tudo beleza', '2015-12-05 15:26:50', '1449336410'),
(4, 4, 'msg', '2015-12-05 15:27:38', '1449336458');

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
(4, '2d4b1439f8ce16be1541397c55d8810b.jpg', 'Lucas Silva', 'lukas_dev', 'lukasdev@hotmail.com', '123456', 'Esta é a descrição do lucas silva');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
