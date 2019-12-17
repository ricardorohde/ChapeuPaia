-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 01-Dez-2019 às 00:12
-- Versão do servidor: 5.7.26
-- versão do PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chapeu`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario`
--

DROP TABLE IF EXISTS `comentario`;
CREATE TABLE IF NOT EXISTS `comentario` (
  `com_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `com_comentario` varchar(500) DEFAULT NULL,
  `usu_codigo` int(11) NOT NULL,
  PRIMARY KEY (`com_codigo`),
  KEY `usuario_comentario` (`usu_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
CREATE TABLE IF NOT EXISTS `ingredientes` (
  `igr_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `igr_nome` varchar(50) DEFAULT NULL,
  `igr_valor` double DEFAULT NULL,
  PRIMARY KEY (`igr_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ingredientes`
--

INSERT INTO `ingredientes` (`igr_codigo`, `igr_nome`, `igr_valor`) VALUES
(1, 'Pão', 1),
(2, 'Hambúrguer', 1.5),
(3, 'Queijo(Mussarela)', 0.5),
(4, 'Presunto', 0.5),
(5, 'Milho', 0.3),
(6, 'Tomate', 0.5),
(7, 'Alface', 0.5),
(8, 'Calabresa', 1.5),
(9, 'Salame', 3),
(10, 'Bacon', 2),
(11, 'Lombo', 3),
(12, 'Batata Palha', 1),
(13, 'Maionese', 0.3),
(14, 'Carne', 4),
(15, 'Costela', 3),
(16, 'Ovo', 1),
(17, 'Frango', 3),
(18, 'Salsicha ', 1.5),
(19, 'Ervilha', 1),
(20, 'Vinagrete', 1),
(21, 'Picanha', 5),
(22, 'Cebola', 0.5),
(23, 'Orégano', 0.2),
(24, 'Azeitona', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE IF NOT EXISTS `mensagens` (
  `men_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `men_texto` varchar(60) DEFAULT NULL,
  `men_visualizado` int(11) DEFAULT NULL,
  `usu_codigo` int(11) NOT NULL,
  PRIMARY KEY (`men_codigo`),
  KEY `usuario_mensagens` (`usu_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`men_codigo`, `men_texto`, `men_visualizado`, `usu_codigo`) VALUES
(2, 'Seu pedido esta a caminho!Obrigado', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `pp_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usu_codigo` int(11) NOT NULL,
  `ped_confirmacao` int(11) DEFAULT NULL,
  `ped_confirmUsu` int(11) DEFAULT NULL,
  `ped_confirmCozinha` int(11) DEFAULT NULL,
  `ped_valor` double DEFAULT NULL,
  `ped_estado` varchar(40) DEFAULT NULL,
  `ped_cidade` varchar(200) DEFAULT NULL,
  `ped_bairro` varchar(200) DEFAULT NULL,
  `ped_rua` varchar(200) DEFAULT NULL,
  `ped_numeroCasa` int(11) DEFAULT NULL,
  `ped_hora` datetime DEFAULT NULL,
  `ped_pagamento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`pp_codigo`),
  KEY `usuario_pedidos` (`usu_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`pp_codigo`, `usu_codigo`, `ped_confirmacao`, `ped_confirmUsu`, `ped_confirmCozinha`, `ped_valor`, `ped_estado`, `ped_cidade`, `ped_bairro`, `ped_rua`, `ped_numeroCasa`, `ped_hora`, `ped_pagamento`) VALUES
(3, 1, 0, 0, 0, 32, 'SP', 'Teodoro Sampaio', 'Jardim Esplanado', 'Avenida João Paz', 2392, '2019-11-30 15:35:16', 'Cartão');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos_produtos`
--

DROP TABLE IF EXISTS `pedidos_produtos`;
CREATE TABLE IF NOT EXISTS `pedidos_produtos` (
  `ppp_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `pp_codigo` int(11) NOT NULL,
  `pro_codigo` int(11) NOT NULL,
  `ppp_qtd` int(11) DEFAULT NULL,
  PRIMARY KEY (`ppp_codigo`),
  KEY `pedidos_pedidos_produtos` (`pp_codigo`),
  KEY `produtos_pedidos_produtos` (`pro_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos_produtos`
--

INSERT INTO `pedidos_produtos` (`ppp_codigo`, `pp_codigo`, `pro_codigo`, `ppp_qtd`) VALUES
(7, 3, 13, 1),
(6, 3, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `pro_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `pro_nome` varchar(200) DEFAULT NULL,
  `pro_valor` double DEFAULT NULL,
  `pro_foto` varchar(200) DEFAULT NULL,
  `pro_pontos` int(11) DEFAULT NULL,
  `pro_pontosUsu` int(11) DEFAULT NULL,
  `tip_codigo` int(11) NOT NULL,
  PRIMARY KEY (`pro_codigo`),
  KEY `tipo_produtos` (`tip_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`pro_codigo`, `pro_nome`, `pro_valor`, `pro_foto`, `pro_pontos`, `pro_pontosUsu`, `tip_codigo`) VALUES
(1, 'X-Mailo', 10, '7832cbbb738eac10072ae1a4371ca3cb.png', 100, 10, 2),
(2, 'X-Burguer', 13, 'b700e4ecfcdb4ab78857b33bc1de34b2.png', 130, 10, 2),
(3, 'X-Bacon', 15, '39fdfe93f786afed9dd1213c716ee3a6.png', 150, 10, 2),
(4, 'X-Costela', 13.5, '74c15f8ad0e30e65438e4e5550bc1e65.png', 135, 10, 2),
(5, 'X-Americano', 12, '7027bab7e07f8da8a8a796a9b5db7bf0.png', 120, 10, 2),
(6, 'X-Guete', 9, 'b2fee3d3b99b571df79571ec8227c5f6.png', 100, 10, 2),
(7, 'X-Frango', 15, 'proDefaut.png', 150, 10, 2),
(8, 'X-Picanha', 18, 'd977845bde2da3aabfa2626c49974b4e.png', 180, 10, 2),
(9, 'Coca Cola (2lt)', 8, '86f0a15985dadb3d77d4eb2c8f1caa5c.png', 80, 8, 3),
(10, 'Coca Cola(350ml)', 5, '88bcdbdf8006d741d4c9e7631f8fecb3.png', 50, 5, 3),
(11, 'Guaraná Antartica(350ml)', 4.5, '78c24b5bf5a6472bc2b233afdde5939a.png', 45, 4, 3),
(12, 'Suco de Laranja(natural)', 6, 'ec2bbb0366fef1b20ed22e0e9f2856c4.png', 60, 6, 3),
(13, 'Suco de Morango(natural)', 6, '8ac6370464f5ce163b4dda437843612b.png', 60, 6, 3),
(14, 'Suco de Maracuja(350ml)', 6, 'b78ed12285d30831c694b5d4907ed797.png', 60, 6, 3),
(15, 'Porção Batata + Carne', 30, 'ccca6a02cad5af00043cf7f9e3fea0be.png', 300, 30, 4),
(16, 'Batata Frita', 20, 'bd62d53806b007e865330feb45635a19.png', 200, 20, 4),
(17, 'Mandioca + Costela Frita', 22, 'proDefaut.png', 220, 22, 4),
(18, 'Filé de Tilápia Frita', 25, 'f9610b9352795cb28819d67b6f2d9123.png', 250, 25, 4),
(19, 'Medalhãozinho', 35, 'proDefaut.png', 350, 35, 4),
(20, 'Mussela', 38, '9404a74ff6d82db92c85b9a42110812f.png', 380, 38, 5),
(21, 'Calabresa', 35, '99e43e2197f95c184a2460303e1f7081.png', 350, 35, 5),
(22, 'Moda da Casa', 40, '6f4e50c858d3aaed3d8d3acb6a48b05a.png', 400, 40, 5),
(23, 'Catu Frango', 38, '7c7ba222892c2d0fe670014942c3fd5b.png', 380, 38, 5),
(24, 'Carne', 4.5, '6f90eaa7f243aeb8e82229610ece79dc.png', 45, 4, 6),
(25, 'Carne com queijo', 6.5, '2037fe6aa70af86f08a1120cc701c357.png', 65, 6, 6),
(26, 'Frango com Queijo', 6, '4bddaadc45c8a7bdbde6622aad0e2659.png', 60, 6, 6),
(27, 'Pizza', 4.5, '811e60325f94bd54928cae37364b441a.png', 45, 4, 6),
(28, '1 X-Mailo + 1 X-Burguer', 20, 'dc8d9227ad41ff0210d095f6dfb6f52f.jpg', 200, 20, 1),
(29, '3 X-Costela', 30, '1b03ec2aa90d5ae6473cd8c5671c4971.jpg', 300, 30, 1),
(30, 'Compre 1 X-Burguer e ganhe 1 Batata', 18, 'e5932d8908187089c4bbcacd4ff48cab.jpg', 180, 18, 1),
(31, '1 X-Bacon + 1 X Picanha', 38, '0341b42294f93b97c9d664a993481808.jpg', 380, 38, 1),
(32, '1 X-Costela + 1 Coca Lata (300ml)', 18, '529803b737521dfb95af0a90bbc33397.jpg', 180, 18, 1),
(33, '1 X-Picanha', 21.99, '0ffca9089f2bd4e799a60c81c76a9dd0.png', 210, 21, 1),
(34, '3 Chopp ', 10, '7782992f4ef208928e86140e282e9d31.jpg', 100, 10, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita`
--

DROP TABLE IF EXISTS `receita`;
CREATE TABLE IF NOT EXISTS `receita` (
  `rec_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `igr_codigo` int(11) NOT NULL,
  `pro_codigo` int(11) NOT NULL,
  PRIMARY KEY (`rec_codigo`),
  KEY `ingredientes_receita` (`igr_codigo`),
  KEY `produtos_receita` (`pro_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `receita`
--

INSERT INTO `receita` (`rec_codigo`, `igr_codigo`, `pro_codigo`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 1, 2),
(6, 2, 2),
(7, 6, 2),
(8, 12, 2),
(9, 13, 2),
(10, 20, 2),
(11, 1, 3),
(12, 2, 3),
(13, 3, 3),
(14, 4, 3),
(15, 5, 3),
(16, 10, 3),
(17, 1, 4),
(18, 3, 4),
(19, 4, 4),
(20, 6, 4),
(21, 7, 4),
(22, 13, 4),
(23, 15, 4),
(38, 6, 5),
(37, 4, 5),
(36, 3, 5),
(35, 2, 5),
(34, 1, 5),
(39, 1, 6),
(40, 6, 6),
(41, 7, 6),
(42, 12, 6),
(43, 1, 7),
(44, 2, 7),
(45, 3, 7),
(46, 4, 7),
(47, 17, 7),
(48, 19, 7),
(49, 1, 8),
(50, 2, 8),
(51, 3, 8),
(52, 4, 8),
(53, 6, 8),
(54, 7, 8),
(55, 21, 8),
(56, 3, 20),
(57, 22, 20),
(58, 23, 20),
(59, 3, 21),
(60, 8, 21),
(61, 22, 21),
(62, 23, 21),
(97, 3, 25),
(96, 14, 24),
(95, 23, 22),
(94, 22, 22),
(93, 19, 22),
(92, 10, 22),
(91, 5, 22),
(90, 4, 22),
(87, 23, 23),
(86, 17, 23),
(85, 16, 23),
(84, 3, 23),
(89, 3, 22),
(88, 24, 23),
(98, 14, 25),
(99, 3, 26),
(100, 17, 26),
(101, 3, 27),
(102, 4, 27),
(103, 23, 27);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo`
--

DROP TABLE IF EXISTS `tipo`;
CREATE TABLE IF NOT EXISTS `tipo` (
  `tip_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tip_nome` varchar(40) DEFAULT NULL,
  `tip_ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`tip_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipo`
--

INSERT INTO `tipo` (`tip_codigo`, `tip_nome`, `tip_ativo`) VALUES
(1, 'Promoções', 1),
(2, 'Lanches', 1),
(3, 'Bebidas', 1),
(4, 'Porções', 0),
(5, 'Pizzas', 1),
(6, 'Pastel', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `usu_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usu_nome` varchar(200) DEFAULT NULL,
  `usu_email` varchar(200) DEFAULT NULL,
  `usu_senha` varchar(40) DEFAULT NULL,
  `usu_telefone` varchar(40) DEFAULT NULL,
  `usu_estado` varchar(2) DEFAULT NULL,
  `usu_cidade` varchar(200) DEFAULT NULL,
  `usu_bairro` varchar(200) DEFAULT NULL,
  `usu_rua` varchar(200) DEFAULT NULL,
  `usu_numeroCasa` int(11) DEFAULT NULL,
  `usu_pontos` int(11) DEFAULT NULL,
  `usu_foto` varchar(40) DEFAULT NULL,
  `usu_nivel` int(11) DEFAULT NULL,
  `usu_status` int(11) DEFAULT NULL,
  `usu_block` int(11) DEFAULT NULL,
  PRIMARY KEY (`usu_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usu_codigo`, `usu_nome`, `usu_email`, `usu_senha`, `usu_telefone`, `usu_estado`, `usu_cidade`, `usu_bairro`, `usu_rua`, `usu_numeroCasa`, `usu_pontos`, `usu_foto`, `usu_nivel`, `usu_status`, `usu_block`) VALUES
(1, 'Uirá', 'uira@gmail.com', '123', '18 98193-9311', 'SP', 'Teodoro Sampaio', 'Jardim Esplanado', 'Avenida João Paz', 2392, 32, 'userDefaut.png', 3, 0, 0),
(4, 'Jennifer Mamédio', 'jennifer@gmail.com', 'jen123', '18 98199-9999', 'SP', 'Teodoro Sampaio', 'Vila Furlan', 'Avenida José Figueredo', 1999, 0, '7447f1ed7298ecf399e524754452179b.jpg', 0, 0, 0),
(3, 'Gabriel Neves', 'cozinha@gmail.com', '123', '18 98192-9211', 'SP', 'Teodoro Sampaio', 'Estação', 'Avenida Gonçalvez', 1888, 0, 'userDefaut.png', 1, 0, 0),
(5, 'Daniele Martins', 'daniele@gmail.com', 'dan123', '11 11111-1111', 'SP', 'Teodoro Sampaio', 'Nova Teodoro', 'Alcir Bezerra', 1888, 0, '7203f139ae83c2c2e96b891e2c31fe98.jpg', 0, 0, 0),
(6, 'Hellen Camilli', 'hellen@gmail.com', 'hel123', '13 33333-3333', 'SP', 'Teodoro Sampaio', 'Estação', 'Avenida João Paz', 2434, 0, '341a596f52ef55a75cd4eb2db101471c.jpg', 0, 0, 0),
(7, 'Caio Vinicius', 'caio@gmail.com', 'cai123', '17 12717-1727', 'SP', 'Teodoro Sampaio', 'Cafézinho', 'José Figueredo', 1333, 0, '272f15f760f2bc2fa9b66e94816659b1.jpg', 0, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
