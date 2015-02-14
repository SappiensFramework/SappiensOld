-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 03-Fev-2015 às 18:11
-- Versão do servidor: 5.5.40-cll
-- versão do PHP: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `sappiens_pub`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulo_exe`
--

CREATE TABLE IF NOT EXISTS `modulo_exe` (
  `moduloExeCod` int(11) NOT NULL AUTO_INCREMENT,
  `moduloExeNome` varchar(30) NOT NULL,
  `moduloExeCpf` varchar(14) DEFAULT NULL,
  `moduloExeCnpj` varchar(30) DEFAULT NULL,
  `moduloExeTelefone` varchar(30) DEFAULT NULL,
  `moduloExeEmail` varchar(50) DEFAULT NULL,
  `moduloExeNumero` int(3) DEFAULT NULL,
  `moduloExeCep` varchar(10) DEFAULT NULL,
  `moduloExeSenha` varchar(10) DEFAULT NULL,
  `moduloExeData` date DEFAULT NULL,
  `moduloExeHora` time DEFAULT NULL,
  `moduloExeTextArea` text,
  `moduloExeEscolhaSelect` tinyint(1) NOT NULL,
  `moduloExeEscolhaDois` enum('M','F','C','V') NOT NULL,
  `moduloExeEscolhaVarios` varchar(50) NOT NULL,
  `moduloExeEscolhaUm` enum('S','N') NOT NULL,
  `moduloExeChosenSimples` tinyint(1) NOT NULL,
  `moduloExeChosenMultiplo` varchar(50) NOT NULL,
  `moduloExeStatus` enum('A','I') NOT NULL DEFAULT 'A',
  PRIMARY KEY (`moduloExeCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `modulo_exe`
--

INSERT INTO `modulo_exe` (`moduloExeCod`, `moduloExeNome`, `moduloExeCpf`, `moduloExeCnpj`, `moduloExeTelefone`, `moduloExeEmail`, `moduloExeNumero`, `moduloExeCep`, `moduloExeSenha`, `moduloExeData`, `moduloExeHora`, `moduloExeTextArea`, `moduloExeEscolhaSelect`, `moduloExeEscolhaDois`, `moduloExeEscolhaVarios`, `moduloExeEscolhaUm`, `moduloExeChosenSimples`, `moduloExeChosenMultiplo`, `moduloExeStatus`) VALUES
(2, 'Vinícius Pozzebon', '002.028.801-84', '10.582.517/0001-90', '(81) 9777-6667', 'vpozzebon@gmail.com', 10, '78.045-008', '123123', '2001-01-01', '10:10:00', ' Text area ', 1, 'V', 'E,B,A', 'S', 8, '3,8', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `organograma`
--

CREATE TABLE IF NOT EXISTS `organograma` (
  `organogramaCod` int(11) NOT NULL AUTO_INCREMENT,
  `organogramaReferenciaCod` int(11) DEFAULT NULL,
  `organogramaAncestral` varchar(100) DEFAULT NULL,
  `organogramaClassificacaoCod` tinyint(4) DEFAULT NULL,
  `organogramaOrdem` varchar(30) DEFAULT NULL,
  `organogramaNome` varchar(100) DEFAULT NULL,
  `organogramaOrdenavel` enum('A','I') DEFAULT 'A',
  `organogramaStatus` enum('A','I') DEFAULT 'A',
  PRIMARY KEY (`organogramaCod`),
  KEY `organogramaCategoriaCod` (`organogramaClassificacaoCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Extraindo dados da tabela `organograma`
--

INSERT INTO `organograma` (`organogramaCod`, `organogramaReferenciaCod`, `organogramaAncestral`, `organogramaClassificacaoCod`, `organogramaOrdem`, `organogramaNome`, `organogramaOrdenavel`, `organogramaStatus`) VALUES
(1, 1, '|1|', 1, NULL, 'Sappiens', 'A', 'A'),
(26, 1, '|26|1|', 1, NULL, 'BRA Consultoria', 'A', 'A'),
(27, 26, '|27|26|1|', 3, NULL, 'Clientes', 'I', 'A'),
(28, 27, '|28|27|26|1|', 6, NULL, 'Sorriso, MT', 'I', 'A'),
(29, 28, '|29|28|27|26|1|', 8, '1', 'Prefeitura de Sorriso', 'I', 'A'),
(30, 29, '|30|29|28|27|26|1|', 11, '1.1', 'Secretaria de Administração', 'A', 'A'),
(31, 30, '|31|30|29|28|27|26|1|', 12, '1.1.1', 'Departamento de Gestão de Gastos', 'A', 'A'),
(32, 1, '|32|1|', 1, '1', 'Center Sis', 'A', 'A'),
(33, 32, '|33|32|1|', 3, '1.1', 'Clientes', 'A', 'A'),
(34, 33, '|34|33|32|1|', 1, NULL, 'Centopeia Trading', 'I', 'A'),
(35, 29, '|35|29|28|27|26|1|', 11, '1.2', 'Secretaria de Obras', 'A', 'A'),
(36, 35, '|36|35|29|28|27|26|1|', 12, '1.2.1', 'Departamento de Coletas', 'A', 'A'),
(37, 29, '|37|29|28|27|26|1|', 11, '1.3', 'Secretaria tal', 'A', 'A'),
(38, 31, '|38|31|30|29|28|27|26|1|', 16, '1.1.1.1', 'Gestão de Ativos', 'A', 'A'),
(39, 38, '|39|38|31|30|29|28|27|26|1|', 17, '1.1.1.1.1', 'Entradas e Saídas de Ativos', 'A', 'A'),
(40, 37, '|40|37|29|28|27|26|1|', 17, '1.3.1', 'Protocolo', 'A', 'A'),
(41, 37, '|41|37|29|28|27|26|1|', 17, '1.3.2', 'Cadastro', 'A', 'A'),
(42, 27, '|42|27|26|1|', 6, NULL, 'Nova Mutum, MT', 'I', 'A'),
(43, 42, '|43|42|27|26|1|', 8, '1', 'Prefeitura de Nova Mutum', 'A', 'A'),
(44, 43, '|44|43|42|27|26|1|', 11, '1.1', 'Secretaria de Administração', 'A', 'A'),
(45, 42, '|45|42|27|26|1|', 9, '2', 'Câmara de Vereadores de Nova Mutum', 'A', 'A'),
(46, 42, '|46|42|27|26|1|', 10, '3', 'Instituto de Previdência Social dos Servidores de Nova Mutum', 'A', 'A'),
(47, 43, '|47|43|42|27|26|1|', 11, '1.2', 'Secretaria de Educação', 'A', 'A'),
(48, 44, '|48|44|43|42|27|26|1|', 12, '1.1.1', 'Departamento de Gestão de Pessoas', 'A', 'A'),
(49, 48, '|49|48|44|43|42|27|26|1|', 17, '1.1.1.1', 'Recursos Humanos', 'A', 'A'),
(50, 46, '|50|46|42|27|26|1|', 19, '3.1', 'Folha de Pagamento', 'A', 'A'),
(51, 50, '|51|50|46|42|27|26|1|', 20, '3.1.1', 'Folha de Ativos', 'A', 'A'),
(52, 50, '|52|50|46|42|27|26|1|', 20, '3.1.2', 'Folha de Inativos e Pensionistas', 'A', 'A'),
(53, 46, '|53|46|42|27|26|1|', 19, '3.2', 'Cálculos', 'A', 'A'),
(54, 30, '|54|30|29|28|27|26|1|', 21, '1.1.2', 'Auditor', 'A', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `organograma_classificacao`
--

CREATE TABLE IF NOT EXISTS `organograma_classificacao` (
  `organogramaClassificacaoCod` tinyint(4) NOT NULL AUTO_INCREMENT,
  `organogramaClassificacaoReferenciaCod` int(4) DEFAULT NULL,
  `organogramaClassificacaoAncestral` varchar(100) DEFAULT NULL,
  `organogramaClassificacaoTipoCod` tinyint(4) NOT NULL,
  `organogramaClassificacaoNome` varchar(30) NOT NULL,
  `organogramaClassificacaoOrdem` varchar(30) DEFAULT NULL,
  `organogramaClassificacaoReordenavel` enum('S','N') NOT NULL DEFAULT 'N',
  `organogramaClassificacaoStatus` enum('A','I') NOT NULL DEFAULT 'A',
  PRIMARY KEY (`organogramaClassificacaoCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `organograma_classificacao`
--

INSERT INTO `organograma_classificacao` (`organogramaClassificacaoCod`, `organogramaClassificacaoReferenciaCod`, `organogramaClassificacaoAncestral`, `organogramaClassificacaoTipoCod`, `organogramaClassificacaoNome`, `organogramaClassificacaoOrdem`, `organogramaClassificacaoReordenavel`, `organogramaClassificacaoStatus`) VALUES
(1, NULL, '|1|', 2, 'Matriz', '1', 'N', 'A'),
(2, 1, '|2|1|', 2, 'Filial', '1.1', 'N', 'A'),
(3, 1, '|3|1|', 2, 'Clientes', '1.2', 'S', 'A'),
(4, NULL, '|4|', 1, 'Esfera Federal', '1', 'N', 'A'),
(5, NULL, '|5|', 1, 'Esfera Estadual', '2', 'N', 'A'),
(6, NULL, '|6|', 1, 'Esfera Municipal', '3', 'N', 'A'),
(8, 6, '|8|6|', 1, 'Prefeitura', '3.1', 'N', 'A'),
(9, 6, '|9|6|', 1, 'Câmara de Vereadores', '3.2', 'N', 'A'),
(10, 6, '|10|6|', 1, 'Previdência Social', '3.3', 'N', 'A'),
(11, 8, '|11|8|6|', 1, 'Lotação', '3.1.1', 'N', 'A'),
(12, 11, '|12|11|8|6|', 1, 'Departamento', '3.1.1.1', 'N', 'A'),
(16, 12, '|16|12|11|8|6|', 1, 'Subdepartamento', '3.1.1.1.1', 'N', 'A'),
(17, 16, '|17|16|12|11|8|6|', 1, 'Setor', '3.1.1.1.1.1', 'N', 'A'),
(18, 17, '|18|17|16|12|11|8|6|', 1, 'Subsetor', '3.1.1.1.1.1.1', 'N', 'A'),
(19, 10, '|19|10|6|', 1, 'Departamento', '3.3.1', 'N', 'A'),
(20, 19, '|20|19|10|6|', 1, 'Setor', '3.3.1.1', 'N', 'A'),
(21, 11, '|21|11|8|6|', 1, 'Cargo', '3.1.1.2', 'N', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `organograma_classificacao_tipo`
--

CREATE TABLE IF NOT EXISTS `organograma_classificacao_tipo` (
  `organogramaClassificacaoTipoCod` tinyint(4) NOT NULL AUTO_INCREMENT,
  `organogramaClassificacaoTipoNome` varchar(30) NOT NULL,
  `organogramaClassificacaoTipoStatus` enum('A','I') NOT NULL DEFAULT 'A',
  PRIMARY KEY (`organogramaClassificacaoTipoCod`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `organograma_classificacao_tipo`
--

INSERT INTO `organograma_classificacao_tipo` (`organogramaClassificacaoTipoCod`, `organogramaClassificacaoTipoNome`, `organogramaClassificacaoTipoStatus`) VALUES
(1, 'Iniciativa Pública', 'A'),
(2, 'Iniciativa Privada', 'A'),
(3, 'Ordem Maçônica', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `organograma_relacao`
--

CREATE TABLE IF NOT EXISTS `organograma_relacao` (
  `organogramaRelacaoCod` int(11) NOT NULL AUTO_INCREMENT,
  `organogramaCod` int(11) NOT NULL,
  `organogramaReferenciaCod` int(11) DEFAULT NULL,
  PRIMARY KEY (`organogramaRelacaoCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `organograma_relacao`
--

INSERT INTO `organograma_relacao` (`organogramaRelacaoCod`, `organogramaCod`, `organogramaReferenciaCod`) VALUES
(2, 3, 2),
(6, 7, 2),
(7, 8, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `uf`
--

CREATE TABLE IF NOT EXISTS `uf` (
  `ufCod` tinyint(4) NOT NULL,
  `paisCod` tinyint(4) NOT NULL,
  `ufSigla` varchar(2) NOT NULL,
  `ufNome` varchar(100) DEFAULT NULL,
  `ufIbgeCod` varchar(10) NOT NULL DEFAULT '0',
  `ufStatus` enum('A','I') NOT NULL DEFAULT 'A',
  PRIMARY KEY (`ufSigla`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `uf`
--

INSERT INTO `uf` (`ufCod`, `paisCod`, `ufSigla`, `ufNome`, `ufIbgeCod`, `ufStatus`) VALUES
(1, 33, 'AC', 'Acre', '12', 'A'),
(2, 33, 'AL', 'Alagoas', '27', 'A'),
(3, 33, 'AM', 'Amazonas', '13', 'A'),
(4, 33, 'AP', 'Amapá', '16', 'A'),
(5, 33, 'BA', 'Bahia', '29', 'A'),
(6, 33, 'CE', 'Ceará', '23', 'A'),
(7, 33, 'DF', 'Distrito Federal', '53', 'A'),
(8, 33, 'ES', 'Espírito Santo', '32', 'A'),
(9, 33, 'GO', 'Goiás', '52', 'A'),
(10, 33, 'MA', 'Maranhão', '21', 'A'),
(11, 33, 'MG', 'Minas Gerais', '31', 'A'),
(12, 33, 'MS', 'Mato Grosso do Sul', '50', 'A'),
(13, 33, 'MT', 'Mato Grosso', '51', 'A'),
(14, 33, 'PA', 'Pará', '15', 'A'),
(15, 33, 'PB', 'Paraíba', '25', 'A'),
(16, 33, 'PE', 'Pernambuco', '26', 'A'),
(17, 33, 'PI', 'Piauí', '22', 'A'),
(18, 33, 'PR', 'Paraná', '41', 'A'),
(19, 33, 'RJ', 'Rio de Janeiro', '33', 'A'),
(20, 33, 'RN', 'Rio Grande do Norte', '24', 'A'),
(21, 33, 'RO', 'Rondônia', '11', 'A'),
(22, 33, 'RR', 'Roraima', '14', 'A'),
(23, 33, 'RS', 'Rio Grande do Sul', '43', 'A'),
(24, 33, 'SC', 'Santa Catarina', '42', 'A'),
(25, 33, 'SE', 'Sergipe', '28', 'A'),
(26, 33, 'SP', 'São Paulo', '35', 'A'),
(27, 33, 'TO', 'Tocantins', '17', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `_acao_modulo`
--

CREATE TABLE IF NOT EXISTS `_acao_modulo` (
  `acaoModuloCod` int(7) NOT NULL AUTO_INCREMENT,
  `moduloCod` int(7) NOT NULL,
  `acaoModuloPermissao` varchar(50) NOT NULL,
  `acaoModuloIdPermissao` varchar(10) NOT NULL,
  `acaoModuloClass` varchar(50) NOT NULL,
  `acaoModuloIcon` varchar(50) NOT NULL,
  `acaoModuloToolTipComPermissao` varchar(75) DEFAULT NULL,
  `acaoModuloToolTipeSemPermissao` varchar(75) DEFAULT NULL,
  `acaoModuloFuncaoJS` varchar(50) NOT NULL,
  `acaoModuloPosicao` tinyint(2) NOT NULL,
  `acaoModuloApresentacao` enum('E','R','I') NOT NULL COMMENT 'E = Expandido, R = Recolhido, I = Acao invisivel',
  PRIMARY KEY (`acaoModuloCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=486 ;

--
-- Extraindo dados da tabela `_acao_modulo`
--

INSERT INTO `_acao_modulo` (`acaoModuloCod`, `moduloCod`, `acaoModuloPermissao`, `acaoModuloIdPermissao`, `acaoModuloClass`, `acaoModuloIcon`, `acaoModuloToolTipComPermissao`, `acaoModuloToolTipeSemPermissao`, `acaoModuloFuncaoJS`, `acaoModuloPosicao`, `acaoModuloApresentacao`) VALUES
(17, 18, 'Atualizar', 'filtrar', '', 'fa fa-repeat', '', '', 'sisFiltrarPadrao()', 1, 'E'),
(18, 18, 'Visualizar', 'visualizar', '', 'fa fa-search', '', '', 'sisVisualizarPadrao()', 2, 'E'),
(19, 18, 'Inserir', 'cadastrar', '', 'fa fa-plus', '', '', 'sisCadastrarLayoutPadrao()', 3, 'E'),
(20, 18, 'Alterar', 'alterar', '', 'fa fa-pencil', '', '', 'sisAlterarLayoutPadrao()', 4, 'E'),
(21, 18, 'Remover', 'remover', '', 'fa fa-trash-o', '', '', 'sisRemoverPadrao()', 5, 'E'),
(22, 18, 'Imprimir', 'prnt', '', 'fa fa-print', '', '', '', 1, 'R'),
(23, 19, 'Atualizar', 'filtrar', '', 'fa fa-repeat', '', '', 'sisFiltrarPadrao()', 1, 'E'),
(24, 19, 'Visualizar', 'visualizar', '', 'fa fa-search', '', '', 'sisVisualizarPadrao()', 2, 'E'),
(25, 19, 'Inserir', 'cadastrar', '', 'fa fa-plus', '', '', 'sisCadastrarLayoutPadrao()', 3, 'E'),
(26, 19, 'Alterar', 'alterar', '', 'fa fa-pencil', '', '', 'sisAlterarLayoutPadrao()', 4, 'E'),
(27, 19, 'Imprimir', 'prnt', '', 'fa fa-print', '', '', '', 1, 'R'),
(28, 19, 'Remover', 'remover', '', 'fa fa-trash-o', '', '', 'sisRemoverPadrao()', 5, 'E'),
(29, 18, 'Personalizar organograma', 'chOrg', '', '', '', '', '', 1, 'I'),
(30, 19, 'Alterar tipo de classificação ', 'chTipoClas', '', '', '', '', '', 1, 'I'),
(31, 19, 'Permitir reordenar classificação', 'chReorClas', '', '', '', '', '', 1, 'I'),
(422, 76, 'Atualizar', 'filtrar', '', 'fa fa-repeat', '', '', 'sisFiltrarPadrao()', 1, 'E'),
(423, 76, 'Visualizar', 'visualizar', '', 'fa fa-search', '', '', 'sisVisualizarPadrao()', 2, 'E'),
(424, 76, 'Inserir', 'cadastrar', '', 'fa fa-plus', '', '', 'sisCadastrarLayoutPadrao()', 3, 'E'),
(425, 76, 'Alterar', 'alterar', '', 'fa fa-pencil', '', '', 'sisAlterarLayoutPadrao()', 4, 'E'),
(426, 76, 'Remover', 'remover', '', 'fa fa-trash-o', '', '', 'sisRemoverPadrao()', 5, 'E'),
(427, 76, 'Imprimir', 'imprimir', '', 'fa fa-print', '', '', 'sisImprimir()', 1, 'R'),
(428, 76, 'Salvar em arquivo PDF', 'salvarPDF', '', 'fa fa-file-pdf-o', '', '', 'sisSalvarPDF()', 1, 'R'),
(457, 83, 'Remover', 'remover', '', 'fa fa-trash-o', '', '', 'sisRemoverPadrao()', 5, 'E'),
(458, 83, 'Alterar', 'alterar', '', 'fa fa-pencil', '', '', 'sisAlterarLayoutPadrao()', 4, 'E'),
(459, 83, 'Cadastrar', 'cadastrar', '', 'fa fa-plus', '', '', 'sisCadastrarLayoutPadrao()', 3, 'E'),
(460, 83, 'Visualizar', 'visualizar', '', 'fa fa-search', '', '', 'sisVisualizarPadrao()', 2, 'E'),
(461, 83, 'Atualizar', 'filtrar', '', 'fa fa-repeat', '', '', 'sisFiltrarPadrao()', 1, 'E'),
(469, 82, 'Salvar em arquivo PDF', 'salvarPDF', '', 'fa fa-file-pdf-o', NULL, NULL, 'sisSalvarPDF()', 1, 'R'),
(470, 82, 'Imprimir', 'imprimir', '', 'fa fa-print', NULL, NULL, 'sisImprimir()', 2, 'R'),
(471, 82, 'Remover', 'remover', '', 'fa fa-trash-o', NULL, NULL, 'sisRemoverPadrao()', 5, 'E'),
(472, 82, 'Alterar', 'alterar', '', 'fa fa-pencil', NULL, NULL, 'sisAlterarLayoutPadrao()', 4, 'E'),
(473, 82, 'Cadastrar', 'cadastrar', '', 'fa fa-plus', NULL, NULL, 'sisCadastrarLayoutPadrao()', 3, 'E'),
(474, 82, 'Visualizar', 'visualizar', '', 'fa fa-search', NULL, NULL, 'sisVisualizarPadrao()', 2, 'E'),
(475, 82, 'Atualizar', 'filtrar', '', 'fa fa-repeat', NULL, NULL, 'sisFiltrarPadrao()', 1, 'E'),
(476, 84, 'Atualizar', 'filtrar', '', 'fa fa-repeat', '', '', 'sisFiltrarPadrao()', 1, 'E'),
(477, 84, 'Visualizar', 'visualizar', '', 'fa fa-search', '', '', 'sisVisualizarPadrao()', 2, 'E'),
(478, 84, 'Inserir', 'cadastrar', '', 'fa fa-plus', '', '', 'sisCadastrarLayoutPadrao()', 3, 'E'),
(479, 84, 'Alterar', 'alterar', '', 'fa fa-pencil', '', '', 'sisAlterarLayoutPadrao()', 4, 'E'),
(480, 84, 'Remover', 'remover', '', 'fa fa-trash-o', '', '', 'sisRemoverPadrao()', 5, 'E'),
(481, 84, 'Imprimir', 'imprimir', '', 'fa fa-print', '', '', '', 1, 'R'),
(482, 84, 'Salvar em arquivo PDF', 'salvarPDF', '', 'fa fa-file-pdf-o', '', '', 'imprimirPDF()', 1, 'R');

-- --------------------------------------------------------

--
-- Estrutura da tabela `_grupo`
--

CREATE TABLE IF NOT EXISTS `_grupo` (
  `GrupoCod` tinyint(3) NOT NULL,
  `grupoNome` varchar(50) NOT NULL,
  `grupoPacote` varchar(50) NOT NULL,
  `grupoPosicao` tinyint(2) NOT NULL DEFAULT '0',
  `grupoClass` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`GrupoCod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `_grupo`
--

INSERT INTO `_grupo` (`GrupoCod`, `grupoNome`, `grupoPacote`, `grupoPosicao`, `grupoClass`) VALUES
(7, 'Sistema', 'Sistema', 99, 'menu-icon fa fa-cogs'),
(99, 'Grupo de Exemplo', 'GrupoExemplo', 9, 'menu-icon fa fa-university');

-- --------------------------------------------------------

--
-- Estrutura da tabela `_issue`
--

CREATE TABLE IF NOT EXISTS `_issue` (
  `issueCod` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usuarioCod` int(11) NOT NULL,
  `issueNum` int(6) unsigned zerofill DEFAULT NULL,
  `issueNome` varchar(50) NOT NULL,
  `issueDesc` text NOT NULL,
  `issueData` datetime NOT NULL,
  `issueStatus` enum('N','C','T','H') NOT NULL DEFAULT 'N' COMMENT 'N=Nova, C=Corrigindo, T=Testando, H=Homologado',
  PRIMARY KEY (`issueCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `_issue`
--

INSERT INTO `_issue` (`issueCod`, `usuarioCod`, `issueNum`, `issueNome`, `issueDesc`, `issueData`, `issueStatus`) VALUES
(1, 1, 000001, 'Deu problema na parada', 'A parada ficou parada!', '2015-01-27 00:00:00', 'T'),
(2, 1, 000002, 'Teste de função now() em PHP', 'Puxa que puxa!', '2015-01-27 13:29:35', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `_issue_int`
--

CREATE TABLE IF NOT EXISTS `_issue_int` (
  `issueIntCod` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issueCod` int(11) NOT NULL,
  `usuarioCod` int(11) NOT NULL,
  `issueIntNum` int(6) unsigned zerofill DEFAULT NULL,
  `issueIntDesc` text NOT NULL,
  `issueIntHist` varchar(30) NOT NULL,
  `issueIntData` datetime NOT NULL,
  PRIMARY KEY (`issueIntCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `_issue_int`
--

INSERT INTO `_issue_int` (`issueIntCod`, `issueCod`, `usuarioCod`, `issueIntNum`, `issueIntDesc`, `issueIntHist`, `issueIntData`) VALUES
(1, 1, 1, 000001, 'Puxa vida, que chato!', 'N => T', '2015-01-27 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `_modulo`
--

CREATE TABLE IF NOT EXISTS `_modulo` (
  `moduloCod` int(7) NOT NULL AUTO_INCREMENT,
  `grupoCod` tinyint(3) NOT NULL,
  `moduloCodReferente` int(7) DEFAULT NULL,
  `moduloNome` varchar(70) DEFAULT NULL,
  `moduloNomeMenu` varchar(50) NOT NULL,
  `moduloDesc` varchar(250) NOT NULL,
  `moduloVisivelMenu` enum('S','N') NOT NULL DEFAULT 'S',
  `moduloPosicao` tinyint(2) NOT NULL DEFAULT '0',
  `moduloBase` enum('Sistema') DEFAULT NULL,
  `moduloClass` varchar(30) DEFAULT NULL,
  `moduloOrigem` enum('E','S') DEFAULT 'S',
  PRIMARY KEY (`moduloCod`),
  UNIQUE KEY `ModuloNome` (`moduloNome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;

--
-- Extraindo dados da tabela `_modulo`
--

INSERT INTO `_modulo` (`moduloCod`, `grupoCod`, `moduloCodReferente`, `moduloNome`, `moduloNomeMenu`, `moduloDesc`, `moduloVisivelMenu`, `moduloPosicao`, `moduloBase`, `moduloClass`, `moduloOrigem`) VALUES
(18, 7, NULL, 'Organograma', 'Organograma', 'Configuração de organograma', 'S', 0, NULL, 'menu-icon fa fa-sitemap', 'S'),
(19, 7, NULL, 'OrganogramaClassificacao', 'Classificação de níveis', 'Classificação do organograma', 'S', 1, NULL, 'menu-icon fa fa-yelp', 'S'),
(76, 99, NULL, 'ModuloExemplo', 'Módulo de Exemplo', 'Exemplo de um módulo', 'S', 1, 'Sistema', 'menu-icon fa fa-user', 'S'),
(82, 7, NULL, 'Modulo', 'Módulos', ' Gerenciar Módulos ', 'S', 2, NULL, 'menu-icon fa fa-puzzle-piece', 'E'),
(83, 7, NULL, 'Grupo', 'Grupos', ' Gerenciar Grupos ', 'S', 1, 'Sistema', 'menu-icon fa fa-users', 'E'),
(84, 7, NULL, 'Issue', 'Reportar bug', 'Reportar bug', 'S', 9, NULL, 'menu-icon fa fa-bug', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `_modulo_tab`
--

CREATE TABLE IF NOT EXISTS `_modulo_tab` (
  `moduloTabCod` int(7) NOT NULL AUTO_INCREMENT,
  `moduloCod` int(7) DEFAULT NULL,
  `moduloTabNome` varchar(70) DEFAULT NULL,
  `moduloTabNomeMenu` varchar(50) NOT NULL,
  `moduloTabDesc` varchar(250) NOT NULL,
  `moduloTabPosicao` tinyint(2) NOT NULL DEFAULT '1',
  `moduloTabClass` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`moduloTabCod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `_perfil`
--

CREATE TABLE IF NOT EXISTS `_perfil` (
  `perfilCod` int(11) NOT NULL AUTO_INCREMENT,
  `perfilNome` varchar(100) NOT NULL,
  `perfilDescricao` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`perfilCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `_perfil`
--

INSERT INTO `_perfil` (`perfilCod`, `perfilNome`, `perfilDescricao`) VALUES
(1, 'Administrador', 'Acesso irrestrito a todos os módulos do sistema');

-- --------------------------------------------------------

--
-- Estrutura da tabela `_permissao`
--

CREATE TABLE IF NOT EXISTS `_permissao` (
  `permissaoCod` int(7) NOT NULL AUTO_INCREMENT,
  `acaoModuloCod` int(7) NOT NULL,
  `perfilCod` int(11) NOT NULL,
  PRIMARY KEY (`permissaoCod`),
  KEY `fk__permissao__acao_modulo1_idx` (`acaoModuloCod`),
  KEY `fk__permissao__perfil1_idx` (`perfilCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=103 ;

--
-- Extraindo dados da tabela `_permissao`
--

INSERT INTO `_permissao` (`permissaoCod`, `acaoModuloCod`, `perfilCod`) VALUES
(10, 17, 1),
(11, 18, 1),
(12, 19, 1),
(13, 20, 1),
(14, 21, 1),
(15, 22, 1),
(16, 23, 1),
(17, 24, 1),
(18, 25, 1),
(19, 26, 1),
(20, 27, 1),
(21, 28, 1),
(22, 29, 1),
(23, 30, 1),
(42, 422, 1),
(43, 423, 1),
(44, 424, 1),
(45, 425, 1),
(46, 426, 1),
(47, 427, 1),
(48, 428, 1),
(77, 462, 1),
(78, 463, 1),
(79, 464, 1),
(80, 465, 1),
(81, 466, 1),
(82, 467, 1),
(83, 468, 1),
(84, 457, 1),
(85, 458, 1),
(86, 459, 1),
(87, 460, 1),
(88, 461, 1),
(89, 476, 1),
(90, 477, 1),
(91, 478, 1),
(92, 479, 1),
(93, 480, 1),
(94, 481, 1),
(95, 482, 1),
(96, 469, 1),
(97, 470, 1),
(98, 471, 1),
(99, 472, 1),
(100, 473, 1),
(101, 474, 1),
(102, 475, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `_upload`
--

CREATE TABLE IF NOT EXISTS `_upload` (
  `uploadCod` int(11) NOT NULL AUTO_INCREMENT,
  `moduloCod` int(11) NOT NULL,
  `uploadCodReferencia` int(11) NOT NULL,
  `uploadNomeCampo` varchar(100) NOT NULL,
  `uploadNomeFisico` varchar(100) DEFAULT NULL,
  `uploadNomeOriginal` varchar(200) NOT NULL,
  `uploadDataCadastro` date NOT NULL,
  `uploadMime` varchar(50) NOT NULL,
  `uploadDownloads` int(11) NOT NULL DEFAULT '0',
  KEY `uploadCod` (`uploadCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Extraindo dados da tabela `_upload`
--

INSERT INTO `_upload` (`uploadCod`, `moduloCod`, `uploadCodReferencia`, `uploadNomeCampo`, `uploadNomeFisico`, `uploadNomeOriginal`, `uploadDataCadastro`, `uploadMime`, `uploadDownloads`) VALUES
(18, 76, 2, 'anexos', '16zvA1ayb9g5M64gYqNwfGr9YI18.jpg', '4188363378.jpg', '2015-01-27', 'image/jpeg', 0),
(19, 22, 29, 'pessoaDocumentoTipoCod29', '12yNT1mfeCVk976WL4SnFQ253k19.jpg', '4184712147.jpg', '2015-01-27', 'image/jpeg', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `_usuario`
--

CREATE TABLE IF NOT EXISTS `_usuario` (
  `usuarioCod` int(10) NOT NULL AUTO_INCREMENT,
  `organogramaCod` int(11) NOT NULL,
  `perfilCod` int(11) NOT NULL,
  `usuarioNome` varchar(100) NOT NULL,
  `usuarioLogin` varchar(200) NOT NULL,
  `usuarioSenha` varchar(255) DEFAULT NULL,
  `numeroAcessos` int(7) DEFAULT NULL,
  `usuarioDataCadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuarioUltimoAcesso` datetime DEFAULT NULL,
  PRIMARY KEY (`usuarioCod`),
  UNIQUE KEY `UsuarioLogin_UNIQUE` (`usuarioLogin`),
  KEY `fk__usuario__perfil1_idx` (`perfilCod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `_usuario`
--

INSERT INTO `_usuario` (`usuarioCod`, `organogramaCod`, `perfilCod`, `usuarioNome`, `usuarioLogin`, `usuarioSenha`, `numeroAcessos`, `usuarioDataCadastro`, `usuarioUltimoAcesso`) VALUES
(1, 26, 1, 'The Sappiens Team', 'team@sappiens.com.br', '91hBP1Z6Pi8ZU', NULL, '2015-01-29 18:25:45', '2015-01-28 16:17:35');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
