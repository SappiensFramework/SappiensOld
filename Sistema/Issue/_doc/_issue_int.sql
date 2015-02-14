-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 25-Jan-2015 às 22:43
-- Versão do servidor: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sappiens`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `_issue_int`
--

CREATE TABLE IF NOT EXISTS `_issue_int` (
  `issueIntCod` int(11) unsigned NOT NULL,
  `issueCod` int(11) NOT NULL,
  `issueIntNum` int(6) unsigned zerofill DEFAULT NULL,
  `issueIntNome` varchar(50) NOT NULL,
  `issueIntDesc` text NOT NULL,
  `issueIntRep` varchar(30) NOT NULL,
  `issueIntData` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
