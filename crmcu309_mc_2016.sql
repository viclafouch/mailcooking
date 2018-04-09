-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 19 Mars 2018 à 16:19
-- Version du serveur :  5.6.35
-- Version de PHP :  5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `crmcu309_mc_2016`
--

-- --------------------------------------------------------

--
-- Structure de la table `api`
--

CREATE TABLE IF NOT EXISTS `api` (
  `api_id` int(11) NOT NULL,
  `user_admin_id` int(11) NOT NULL,
  `router_name` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `api`
--

INSERT INTO `api` (`api_id`, `user_admin_id`, `router_name`) VALUES
(6, 60, 'MAILCHIMP');

-- --------------------------------------------------------

--
-- Structure de la table `api_available`
--

CREATE TABLE IF NOT EXISTS `api_available` (
  `router_name` text COLLATE utf8_bin NOT NULL,
  `table_name` text COLLATE utf8_bin NOT NULL,
  `mirror` text COLLATE utf8_bin,
  `unsub` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `api_available`
--

INSERT INTO `api_available` (`router_name`, `table_name`, `mirror`, `unsub`) VALUES
('SENDINBLUE', 'api_sendinblue', NULL, NULL),
('MAILCHIMP', 'api_mailchimp', '*|ARCHIVE|*', '*|UNSUB|*'),
('MAILJET', 'api_mailjet', NULL, NULL),
('CAMPAIGNMONITOR', 'api_campaignmonitor', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `api_campaignmonitor`
--

CREATE TABLE IF NOT EXISTS `api_campaignmonitor` (
  `api_id` int(11) NOT NULL,
  `api_key` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `api_mailchimp`
--

CREATE TABLE IF NOT EXISTS `api_mailchimp` (
  `api_id` int(11) NOT NULL,
  `api_key` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `api_mailchimp`
--

INSERT INTO `api_mailchimp` (`api_id`, `api_key`) VALUES
(6, 'a9461c27cbcedcfbf51ee9c3c9e02eef-us17');

-- --------------------------------------------------------

--
-- Structure de la table `api_mailjet`
--

CREATE TABLE IF NOT EXISTS `api_mailjet` (
  `api_id` int(11) NOT NULL,
  `api_key` text COLLATE utf8_bin NOT NULL,
  `api_secret` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `api_sendinblue`
--

CREATE TABLE IF NOT EXISTS `api_sendinblue` (
  `api_id` int(11) NOT NULL,
  `api_key` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `email_cat`
--

CREATE TABLE IF NOT EXISTS `email_cat` (
  `cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=154 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `forgotten_pass`
--

CREATE TABLE IF NOT EXISTS `forgotten_pass` (
  `id_unique` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `timestamp` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mail_editor`
--

CREATE TABLE IF NOT EXISTS `mail_editor` (
  `id_mail` int(11) NOT NULL,
  `id_user` varchar(255) COLLATE utf8_bin NOT NULL,
  `email_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'Sans Titre',
  `email_dom` longtext CHARACTER SET utf8 NOT NULL,
  `email_background` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '#f0f0f0',
  `template_id` int(11) NOT NULL,
  `email_cat_id` int(11) DEFAULT NULL,
  `saved` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Statut de sauvegarde',
  `saved_by` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `mail_editor`
--

INSERT INTO `mail_editor` (`id_mail`, `id_user`, `email_name`, `email_dom`, `email_background`, `template_id`, `email_cat_id`, `saved`, `saved_by`, `archive`, `timestamp`) VALUES
(86, '60', 'Sans Titre', '<table data-section="f0aae2" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_6/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="9c088e" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 6, NULL, 0, NULL, 0, '2018-03-15 14:04:26'),
(88, '65', 'Sans Titre', '<table data-section="516bbd" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="1994b7" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 47, NULL, 0, NULL, 0, '2018-03-15 14:12:53'),
(89, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-15 14:15:30'),
(90, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-15 15:37:30'),
(91, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-16 09:14:10'),
(92, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-16 17:39:30'),
(93, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="44ca5c" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="64a858" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;" class="medium-editor-element" role="textbox" aria-multiline="true" data-placeholder="Votre texte ici...">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 1, 'hello N', 0, '2018-03-17 16:05:22'),
(94, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="7e0f48" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="a9710e" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;" class="medium-editor-element" role="textbox" aria-multiline="true" data-placeholder="Votre texte ici...">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 1, 'hello N', 0, '2018-03-17 16:06:39'),
(95, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.png" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-17 16:19:12'),
(96, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.png" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-17 16:32:25'),
(97, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.png" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-17 16:38:43'),
(98, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-17 16:42:15'),
(99, '60', 'Sans Titre', '<table data-section="516bbd" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="1994b7" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 47, NULL, 0, NULL, 0, '2018-03-17 16:54:47'),
(100, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-17 17:00:00'),
(101, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.png" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-17 17:00:47'),
(102, '60', 'Sans Titre', '<table data-section="f0aae2" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_6/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="9c088e" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 6, NULL, 0, NULL, 0, '2018-03-17 17:28:12'),
(103, '60', 'Sans Titre', '<table data-section="dfb679" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="client/60_neo/templates/22_T_OU/images/cover.png" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="6aa2f3" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 46, NULL, 0, NULL, 0, '2018-03-17 17:32:17'),
(104, '60', 'Sans Titre', '<table data-section="f0aae2" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_6/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="9c088e" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 6, NULL, 0, NULL, 0, '2018-03-19 09:45:17'),
(105, '65', 'Sans Titre', '<table data-section="bf57b9" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="preheader" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;">\n						Je suis un preheader\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2f5b54" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="mirror" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:2px;padding-bottom:10px">\n						<a href="{mc_mirror}" style="color:#298DF2">\n							Voir la version en ligne\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="b5a6a0" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2b9a93" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2450b5" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="unsub" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:10px;padding-bottom:10px">\n						<a href="{mc_unsub}" style="color:#298DF2">\n							Se désinscrire\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 47, NULL, 0, NULL, 0, '2018-03-19 12:32:40'),
(106, '60', 'Sans Titre', '<table data-section="bf57b9" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="preheader" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;">\n						Je suis un preheader\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2f5b54" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="mirror" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:2px;padding-bottom:10px">\n						<a href="{mc_mirror}" style="color:#298DF2">\n							Voir la version en ligne\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="b5a6a0" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2b9a93" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2450b5" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="unsub" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:10px;padding-bottom:10px">\n						<a href="{mc_unsub}" style="color:#298DF2">\n							Se désinscrire\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 47, NULL, 0, NULL, 0, '2018-03-19 12:36:25'),
(107, '60', 'Sans Titre', '<table data-section="bf57b9" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="preheader" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;">\n						Je suis un preheader\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2f5b54" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:2px;padding-bottom:10px">\n						<a href="{mc_mirror}" style="color:#298DF2">\n							Voir la version en ligne\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="b5a6a0" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2b9a93" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2450b5" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:10px;padding-bottom:10px">\n						<a href="{mc_unsub}" style="color:#298DF2">\n							Se désinscrire\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 47, NULL, 0, NULL, 0, '2018-03-19 13:43:12'),
(108, '60', 'Sans Titre', '<table data-section="bf57b9" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="preheader" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;">\n						Je suis un preheader\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2f5b54" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:2px;padding-bottom:10px">\n						<a href="{mc_mirror}" style="color:#298DF2">\n							Voir la version en ligne\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="b5a6a0" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2b9a93" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2450b5" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:10px;padding-bottom:10px">\n						<a href="{mc_unsub}" style="color:#298DF2">\n							Se désinscrire\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 47, NULL, 0, NULL, 0, '2018-03-19 14:15:14'),
(109, '60', 'Sans Titre', '<table data-section="bf57b9" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="preheader" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;">\n						Je suis un preheader\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2f5b54" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="mirror" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:2px;padding-bottom:10px">\n						<a href="{mc_mirror}" style="color:#298DF2">\n							Voir la version en ligne\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="b5a6a0" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2b9a93" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2450b5" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="unsub" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:10px;padding-bottom:10px">\n						<a href="{mc_unsub}" style="color:#298DF2">\n							Se désinscrire\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 47, NULL, 0, NULL, 0, '2018-03-19 15:52:08'),
(110, '60', 'Sans Titre', '<table data-section="bf57b9" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="preheader" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;">\n						Je suis un preheader\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2f5b54" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:2px;padding-bottom:10px">\n						<a href="{mc_mirror}" style="color:#298DF2" id="mirror">\n							Voir la version en ligne\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="b5a6a0" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2b9a93" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2450b5" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:10px;padding-bottom:10px">\n						<a href="{mc_unsub}" style="color:#298DF2" id="unsub">\n							Se désinscrire\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 47, NULL, 0, NULL, 0, '2018-03-19 15:56:25'),
(111, '60', 'Sans Titre', '<table data-section="bf57b9" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="preheader" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;">\n						Je suis un preheader\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2f5b54" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:2px;padding-bottom:10px">\n						<a href="{mc_mirror}" style="color:#298DF2" data-mirror="mirror">\n							Voir la version en ligne\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="b5a6a0" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2b9a93" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2450b5" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:10px;padding-bottom:10px">\n						<a href="{mc_unsub}" style="color:#298DF2" data-unsub="unsub">\n							Se désinscrire\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '#f0f0f0', 47, NULL, 0, NULL, 0, '2018-03-19 16:12:14');

-- --------------------------------------------------------

--
-- Structure de la table `payments_stripe`
--

CREATE TABLE IF NOT EXISTS `payments_stripe` (
  `id_payment` int(11) NOT NULL,
  `id_stripe` text COLLATE utf8_bin NOT NULL,
  `amount` smallint(6) NOT NULL,
  `customer_email` text COLLATE utf8_bin NOT NULL,
  `designation` text COLLATE utf8_bin NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `payments_stripe`
--

INSERT INTO `payments_stripe` (`id_payment`, `id_stripe`, `amount`, `customer_email`, `designation`, `date_created`) VALUES
(1, 'ch_1AeNY8EhR8Uf42bcZvJWv5Fp', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(2, 'ch_1AeQMXEhR8Uf42bcRQPsp2Hs', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(3, 'ch_1AeQNBEhR8Uf42bcpfbMiRdI', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(4, 'ch_1AeQOTEhR8Uf42bcMk6WQEeZ', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(5, 'ch_1AeQPLEhR8Uf42bcMBf1gPd0', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(6, 'ch_1AeQTfEhR8Uf42bcQEo9PbXK', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(7, 'ch_1AeQWaEhR8Uf42bcfoE0Htgl', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(8, 'ch_1AeQgUEhR8Uf42bcSHLzD6Tu', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(9, 'ch_1AeQjMEhR8Uf42bccKX85iva', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(10, 'ch_1AeQm6EhR8Uf42bcGwGRuhu0', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(11, 'ch_1AeQmtEhR8Uf42bcP7yWUwoS', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(12, 'ch_1AeQnXEhR8Uf42bcsaXbobya', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(13, 'ch_1AeQo5EhR8Uf42bcWuWLgphO', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(14, 'ch_1AeQokEhR8Uf42bcSQ25wL9V', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(15, 'ch_1AeQqnEhR8Uf42bcTueU4FEt', 48, '@', 'Abonnement Mailcooking', '2017-07-11'),
(16, 'ch_1AgrkWEhR8Uf42bcBmHLW85v', 48, '@', 'Abonnement Mailcooking', '2017-07-18'),
(17, 'ch_1AgsVWEhR8Uf42bcS3geR26y', 48, '@', 'Abonnement Mailcooking', '2017-07-18'),
(18, 'ch_1AguyVEhR8Uf42bcCCac6OkR', 108, '@', 'Abonnement Mailcooking', '2017-07-18'),
(19, 'ch_1Agv0kEhR8Uf42bcDq3y0pbY', 108, '@', 'Abonnement Mailcooking', '2017-07-18'),
(20, 'ch_1Agv1zEhR8Uf42bcTESV6GfW', 108, '@', 'Abonnement Mailcooking', '2017-07-18'),
(21, 'ch_1Agv6SEhR8Uf42bc6C6iTr5L', 108, '@', 'Abonnement Mailcooking', '2017-07-18'),
(22, 'ch_1Agv8IEhR8Uf42bcYFfgcbVw', 72, '@', 'Abonnement Mailcooking', '2017-07-18'),
(23, 'ch_1AhJasEhR8Uf42bcoddhzIS4', 108, '@', 'Abonnement Mailcooking', '2017-07-19'),
(24, 'ch_1AhJr5EhR8Uf42bcHdwqSXeK', 48, '@', 'Abonnement Mailcooking', '2017-07-19'),
(25, 'ch_1AhJuVEhR8Uf42bcJmZT5YL8', 48, '@', 'Abonnement Mailcooking', '2017-07-19'),
(26, 'ch_1AhJvbEhR8Uf42bcdq3nmMya', 48, '@', 'Abonnement Mailcooking', '2017-07-19'),
(27, 'ch_1AhJwOEhR8Uf42bca6CWIQ1C', 48, '@', 'Abonnement Mailcooking', '2017-07-19'),
(28, 'ch_1AhK6CEhR8Uf42bcVvFhfWNM', 48, '@', 'Abonnement Mailcooking', '2017-07-19'),
(29, 'ch_1AjrTDEhR8Uf42bce0hkWE2h', 108, '@', 'Abonnement Mailcooking', '2017-07-26'),
(30, 'ch_1AjrauEhR8Uf42bc9l89uRBh', 108, '@', 'Abonnement Mailcooking', '2017-07-26'),
(31, 'ch_1AkCIzEhR8Uf42bcwidq0Oh5', 48, '@', 'Abonnement Mailcooking', '2017-07-27'),
(32, 'ch_1AkCWPEhR8Uf42bcaC4DDYEW', 48, '@', 'Abonnement Mailcooking', '2017-07-27'),
(33, 'ch_1AkCpFEhR8Uf42bcBksCKS2H', 48, '@', 'Abonnement Mailcooking', '2017-07-27'),
(34, 'ch_1AkDPfEhR8Uf42bcQHQg5EHT', 72, '@', 'Abonnement Mailcooking', '2017-07-27'),
(35, 'ch_1AkTwyEhR8Uf42bcft4Qp2Bd', 72, '@', 'Abonnement Mailcooking', '2017-07-28'),
(36, 'ch_1AkV9kEhR8Uf42bcAccp89sm', 72, '@', 'Abonnement Mailcooking', '2017-07-28'),
(37, 'ch_1AkVDjEhR8Uf42bcLgTwZ0tP', 72, '@', 'Abonnement Mailcooking', '2017-07-28'),
(38, 'ch_1AkVFAEhR8Uf42bccKVbGukW', 72, '@', 'Abonnement Mailcooking', '2017-07-28'),
(39, 'ch_1AkWENEhR8Uf42bcDjlaS4GQ', 48, '@', 'Abonnement Mailcooking', '2017-07-28'),
(40, 'ch_1AkYUKEhR8Uf42bcDMOOsfnc', 48, '@', 'Abonnement Mailcooking', '2017-07-28'),
(41, 'ch_1AkYYhEhR8Uf42bc0OGX7vix', 108, '@', 'Abonnement Mailcooking', '2017-07-28'),
(42, 'ch_1AkZyaEhR8Uf42bcBSrA4kiI', 48, '@', 'Abonnement Mailcooking', '2017-07-28'),
(43, 'ch_1Aka4vEhR8Uf42bcr48TcVKr', 72, '@', 'Abonnement Mailcooking', '2017-07-28'),
(44, 'ch_1AkacXEhR8Uf42bcgbAFBgcy', 72, '@', 'Abonnement Mailcooking', '2017-07-28'),
(45, 'ch_1AvpiSEhR8Uf42bc9yjW5gtS', 48, '@', 'Abonnement Mailcooking', '2017-08-28'),
(46, 'ch_1AvqKgEhR8Uf42bcW1sN1taB', 72, '@', 'Abonnement Mailcooking', '2017-08-28'),
(47, 'ch_1B0t89EhR8Uf42bc2NrWwxUg', 72, '@', 'Abonnement Mailcooking', '2017-09-11'),
(48, 'ch_1B1CneEhR8Uf42bcv38ESw9Y', 10, '@', 'Abonnement Mailcooking', '2017-09-12'),
(49, 'ch_1B1CwtEhR8Uf42bcg7ztGlcb', 10, '@', 'Abonnement Mailcooking', '2017-09-12'),
(50, 'ch_1B1ECtEhR8Uf42bcIY9mrhvH', 10, '@', 'Abonnement Mailcooking', '2017-09-12'),
(51, 'ch_1B1EEBEhR8Uf42bcRWpbnXbH', 10, '@', 'Abonnement Mailcooking', '2017-09-12'),
(52, 'ch_1B1Gt2EhR8Uf42bcKUnHUhLt', 200, '@', 'Abonnement Mailcooking', '2017-09-12'),
(53, 'ch_1B1GtNEhR8Uf42bcJpq3SPil', 200, '@', 'Abonnement Mailcooking', '2017-09-12'),
(54, 'ch_1B1XGfEhR8Uf42bcUFc9ucv7', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(55, 'ch_1B1XGvEhR8Uf42bcWkU09lDH', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(56, 'ch_1B1XHSEhR8Uf42bcsopnwzap', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(57, 'ch_1B1XIgEhR8Uf42bcBG94N7KX', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(58, 'ch_1B1XJaEhR8Uf42bcT184oVdX', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(59, 'ch_1B1XL1EhR8Uf42bcImDZwFVI', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(60, 'ch_1B1XT3EhR8Uf42bcwOEAfqMg', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(61, 'ch_1B1XTVEhR8Uf42bcmfmnokW6', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(62, 'ch_1B1XU7EhR8Uf42bcsyp6DuTx', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(63, 'ch_1B1XUeEhR8Uf42bcz3JFtvvr', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(64, 'ch_1B1XUwEhR8Uf42bcqqi5ANZj', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(65, 'ch_1B1XWZEhR8Uf42bcvcOhZcNE', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(66, 'ch_1B1XWzEhR8Uf42bcbLMng4y3', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(67, 'ch_1B1XZGEhR8Uf42bcdlTUTwFk', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(68, 'ch_1B1XZQEhR8Uf42bcKvguZnyx', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(69, 'ch_1B1XaXEhR8Uf42bcPx4XG5ZN', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(70, 'ch_1B1Xb4EhR8Uf42bchimK6ZFl', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(71, 'ch_1B1Xd7EhR8Uf42bcTf9YiVLg', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(72, 'ch_1B1XdOEhR8Uf42bcw4YQ250L', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(73, 'ch_1B1Xe7EhR8Uf42bcbgbUtWd4', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(74, 'ch_1B1XehEhR8Uf42bcpcMeNS6l', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(75, 'ch_1B1XfPEhR8Uf42bcWFquVTRE', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(76, 'ch_1B1XlYEhR8Uf42bcTkvmTg53', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(77, 'ch_1B1ZENEhR8Uf42bc4zk4hgze', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(78, 'ch_1B1ZF9EhR8Uf42bc7htCyBD2', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(79, 'ch_1B1ZW5EhR8Uf42bcAGLgcorr', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(80, 'ch_1B1ZWrEhR8Uf42bcC76ud2dq', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(81, 'ch_1B1ZqwEhR8Uf42bcXDkLSZVw', 200, '@', 'Abonnement Mailcooking', '2017-09-13'),
(82, 'ch_1B31c8EhR8Uf42bcsHcMis4o', 72, '@', 'Abonnement Mailcooking', '2017-09-17'),
(83, 'ch_1B31jpEhR8Uf42bcqAj6BR0e', 72, '@', 'Abonnement Mailcooking', '2017-09-17'),
(84, 'ch_1B3QGdEhR8Uf42bcmyukn1Qp', 72, '@', 'Abonnement Mailcooking', '2017-09-18'),
(85, 'ch_1B3Sb9EhR8Uf42bcPtenNRdm', 72, '@', 'Abonnement Mailcooking', '2017-09-18'),
(86, 'ch_1B3SuCEhR8Uf42bca8q4MlfP', 72, '@', 'Abonnement Mailcooking', '2017-09-18'),
(87, 'ch_1B3T1lEhR8Uf42bcSSH2xtYJ', 72, '@', 'Abonnement Mailcooking', '2017-09-18'),
(88, 'ch_1B74V4EhR8Uf42bcovDIiiiT', 48, '@', 'Abonnement Mailcooking', '2017-09-28'),
(89, 'ch_1BBmRUEhR8Uf42bciHt4mfbf', 70, '@', 'Abonnement Mailcooking', '2017-10-11'),
(90, 'ch_1BDurIEhR8Uf42bc0YOzcZPJ', 72, '@', 'Abonnement Mailcooking', '2017-10-17'),
(91, 'ch_1BEMH5EhR8Uf42bcbJws5bkN', 72, '@', 'Abonnement Mailcooking', '2017-10-18'),
(92, 'ch_1BHwleEhR8Uf42bck9eoJbpo', 48, '@', 'Abonnement Mailcooking', '2017-10-28'),
(93, 'ch_1BN18rEhR8Uf42bcKa0j5TqD', 72, '@', 'Abonnement Mailcooking', '2017-11-11'),
(94, 'ch_1BP9dsEhR8Uf42bctR0ObM7h', 72, '@', 'Abonnement Mailcooking', '2017-11-17'),
(95, 'ch_1BPb2WEhR8Uf42bcHgdyZCos', 72, '@', 'Abonnement Mailcooking', '2017-11-18'),
(96, 'ch_1BTBYkEhR8Uf42bcY9sU05dt', 48, '@', 'Abonnement Mailcooking', '2017-11-28'),
(97, 'ch_1BXtS1EhR8Uf42bcQYcKm6hP', 72, '@', 'Abonnement Mailcooking', '2017-12-11'),
(98, 'ch_1Ba1w9EhR8Uf42bc55ksFrzF', 72, '@', 'Abonnement Mailcooking', '2017-12-17'),
(99, 'ch_1BaTL1EhR8Uf42bcc4xzIq4b', 72, '@', 'Abonnement Mailcooking', '2017-12-18'),
(100, 'ch_1Be3rjEhR8Uf42bcy7B6GrM9', 48, '@', 'Abonnement Mailcooking', '2017-12-28'),
(101, 'ch_1Bj8EoEhR8Uf42bc6ZWXon9N', 72, '@', 'Abonnement Mailcooking', '2018-01-11'),
(102, 'ch_1BlGhrEhR8Uf42bcyd2uuIbf', 72, '@', 'Abonnement Mailcooking', '2018-01-17'),
(103, 'ch_1Bli6pEhR8Uf42bc2cmkDeKs', 72, '@', 'Abonnement Mailcooking', '2018-01-18'),
(104, 'ch_1BpIeQEhR8Uf42bccPYaJc1g', 48, '@', 'Abonnement Mailcooking', '2018-01-28'),
(105, 'ch_1BuN07EhR8Uf42bcuv4OAWwj', 72, '@', 'Abonnement Mailcooking', '2018-02-11'),
(106, 'ch_1BwVTHEhR8Uf42bcDpFpFV5Y', 72, '@', 'Abonnement Mailcooking', '2018-02-17'),
(107, 'ch_1BwwtHEhR8Uf42bcwsQYYd6B', 72, '@', 'Abonnement Mailcooking', '2018-02-18'),
(108, 'ch_1Bxta1EhR8Uf42bcIBeGYnQT', 72, '@', 'Abonnement Mailcooking', '2018-02-21'),
(109, 'ch_1BxtcgEhR8Uf42bcRSedsN2I', 72, '@', 'Abonnement Mailcooking', '2018-02-21'),
(110, 'ch_1BxtnqEhR8Uf42bcrzOJ6mJQ', 72, '@', 'Abonnement Mailcooking', '2018-02-21'),
(111, 'ch_1BxtqVEhR8Uf42bctjYHw0fi', 72, '@', 'Abonnement Mailcooking', '2018-02-21'),
(112, 'ch_1BxtroEhR8Uf42bcV4y5YOhS', 72, '@', 'Abonnement Mailcooking', '2018-02-21'),
(113, 'ch_1Bxu68EhR8Uf42bcXJoo4NWD', 72, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-21'),
(114, 'ch_1Bxu7LEhR8Uf42bcNOnDWa60', 72, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-21'),
(115, 'ch_1BxuAhEhR8Uf42bcJx52hL1f', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-21'),
(116, 'ch_1BxuGOEhR8Uf42bcY3D1wkAM', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-21'),
(117, 'ch_1ByLj3EhR8Uf42bcB7ehuJP6', 130, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-22'),
(118, 'ch_1BzlF6EhR8Uf42bckhH0h47w', 58, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(119, 'ch_1BzlLFEhR8Uf42bc4TOqkKxo', 58, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(120, 'ch_1BzlbiEhR8Uf42bcM3kIFmI3', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(121, 'ch_1Bzld1EhR8Uf42bc0HZINTFl', 58, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(122, 'ch_1Bzll8EhR8Uf42bcam7Rx3rL', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(123, 'ch_1BzlmoEhR8Uf42bcYxDGsxpk', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(124, 'ch_1BzlnZEhR8Uf42bcgP4R4duL', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(125, 'ch_1BzlqDEhR8Uf42bc16Lrzma1', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(126, 'ch_1Bzm46EhR8Uf42bcKrc9p3uY', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(127, 'ch_1Bzm8BEhR8Uf42bcspC7x9Kt', 58, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(128, 'ch_1BzmC1EhR8Uf42bcUoGpIC8o', 130, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(129, 'ch_1BzmMsEhR8Uf42bc76LpGWqi', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(130, 'ch_1BzmfzEhR8Uf42bcPHHNVtRN', 200, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(131, 'ch_1Bzo8dEhR8Uf42bcU5cKLBuE', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(132, 'ch_1BzpIwEhR8Uf42bcHVgIyZxR', 86, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(133, 'ch_1BzpomEhR8Uf42bcsqqNPBou', 72, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-02-26'),
(134, 'ch_1C0XfVEhR8Uf42bcuWWd1Nii', 48, 'victor.dlf@outlook.fr', 'Abonnement Mailcooking', '2018-02-28'),
(135, 'ch_1C1B3dEhR8Uf42bc8uoATV97', 72, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-02'),
(136, 'ch_1C1EOrEhR8Uf42bcIPtl9vKC', 48, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-02'),
(137, 'ch_1C1ESgEhR8Uf42bc6LhgIfpk', 48, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-02'),
(138, 'ch_1C1ETpEhR8Uf42bcg0d5whRU', 48, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-02'),
(139, 'ch_1C1FJFEhR8Uf42bcFKdIwjjS', 72, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-02'),
(140, 'ch_1C2KWqEhR8Uf42bcw8WjzJLj', 48, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-05'),
(141, 'ch_1C2KYqEhR8Uf42bc6DD4d3aJ', 72, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-05'),
(142, 'ch_1C47nXEhR8Uf42bcyzPT1p4X', 72, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-10'),
(143, 'ch_1C4qbOEhR8Uf42bczCsUs9uO', 72, 'fauchet.jeancharles@gmail.com', 'abonnement', '2018-03-12'),
(144, 'ch_1C4rBOEhR8Uf42bcxXmDaxNW', 200, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-12'),
(145, 'ch_1C5AH1EhR8Uf42bczaUa3LBW', 200, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-13'),
(146, 'ch_1C5DDvEhR8Uf42bcY9gvYpWy', 200, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-13'),
(147, 'ch_1C5DSsEhR8Uf42bcTzoXn1Mi', 200, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-13'),
(148, 'ch_1C5DpEEhR8Uf42bcSMOkG5H3', 200, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-13'),
(149, 'ch_1C5DsTEhR8Uf42bcFnXPLqa5', 200, 'fauchet.jeancharles@gmail.com', 'coucou', '2018-03-13'),
(150, 'ch_1C5EP2EhR8Uf42bcK3U6gDqv', 36, 'fauchet.jeancharles@gmail.com', 'Abonnement Mailcooking', '2018-03-13'),
(151, 'ch_1C5EYCEhR8Uf42bcWOGhFDP1', 48, 'antoine.chapuset@crmcurve.fr', 'Abonnement Mailcooking', '2018-03-13'),
(152, 'ch_1C5EZUEhR8Uf42bcvYogd9ao', 200, 'antoine.chapuset@crmcurve.fr', 'test', '2018-03-13'),
(153, 'ch_1C5EclEhR8Uf42bcWa23aXjk', 58, 'antoine.chapuset@crmcurve.fr', 'Abonnement Mailcooking', '2018-03-13'),
(154, 'ch_1C5WorEhR8Uf42bcpEgVDozk', 200, 'fauchet.jeancharles@gmail.com', 'test', '2018-03-14'),
(155, 'ch_1C5b5bEhR8Uf42bcWDx61tXE', 200, 'fauchet.jeancharles@gmail.com', 'test', '2018-03-14'),
(156, 'ch_1C5bHwEhR8Uf42bcbkPgMdE0', 200, 'fauchet.jeancharles@gmail.com', 'bla la', '2018-03-14'),
(157, 'ch_1C5uLFEhR8Uf42bcm97qTuk9', 200, 'fauchet.jeancharles@gmail.com', 'NOW !', '2018-03-15'),
(158, 'ch_1C5uMYEhR8Uf42bcIOUd8zSP', 200, 'fauchet.jeancharles@gmail.com', 'first', '2018-03-15'),
(159, 'ch_1C5uN4EhR8Uf42bcobYCQCKI', 200, 'fauchet.jeancharles@gmail.com', 'second', '2018-03-15'),
(160, 'ch_1C5uPmEhR8Uf42bcSSdGv6ze', 200, 'fauchet.jeancharles@gmail.com', 'aaaaa', '2018-03-15'),
(161, 'ch_1C5uQFEhR8Uf42bcnhpZvdor', 200, 'fauchet.jeancharles@gmail.com', 'bbbb', '2018-03-15');

-- --------------------------------------------------------

--
-- Structure de la table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `user_id` int(11) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `subscription_id` varchar(200) NOT NULL,
  `plan` varchar(100) NOT NULL,
  `date_end_trial` tinytext NOT NULL,
  `renew` tinyint(1) NOT NULL DEFAULT '1',
  `status_stripe` varchar(60) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `subscribers`
--

INSERT INTO `subscribers` (`user_id`, `customer_id`, `subscription_id`, `plan`, `date_end_trial`, `renew`, `status_stripe`) VALUES
(66, 'cus_CUD2CTSaUqa2hJ', 'sub_CUD2CKfSgGfOTz', '1', '1523631671', 1, 'active'),
(60, 'cus_CTlRfF8emP85DW', 'sub_CTlRvnOsHPlpfj', '3', '1520855100', 1, 'active');

-- --------------------------------------------------------

--
-- Structure de la table `template_commande`
--

CREATE TABLE IF NOT EXISTS `template_commande` (
  `id_user` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_commande` int(11) NOT NULL,
  `nom_commande` varchar(255) COLLATE utf8_bin NOT NULL,
  `commentaire_commande` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` varchar(255) COLLATE utf8_bin NOT NULL,
  `paid` int(11) NOT NULL,
  `date_creat` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `template_counter`
--

CREATE TABLE IF NOT EXISTS `template_counter` (
  `count_id` int(11) NOT NULL,
  `template_commande_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expiration_date` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `template_mail`
--

CREATE TABLE IF NOT EXISTS `template_mail` (
  `id_template` int(11) NOT NULL,
  `id_template_commande` int(11) DEFAULT NULL,
  `DOM` text CHARACTER SET utf8,
  `medias` text COLLATE utf8_bin NOT NULL,
  `title_template` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'Titre du template',
  `statut` int(11) NOT NULL DEFAULT '0' COMMENT 'Disponibilité du template',
  `id_allow` varchar(255) COLLATE utf8_bin NOT NULL,
  `upload_template_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date de la mise en ligne du template'
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `template_mail`
--

INSERT INTO `template_mail` (`id_template`, `id_template_commande`, `DOM`, `medias`, `title_template`, `statut`, `id_allow`, `upload_template_date`) VALUES
(6, NULL, '<table data-section="f0aae2" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_6/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="9c088e" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '	.maincontainer{\n		width:100%!important;\n	}\n	.container{\n		width:90%!important;\n	}\n	.container2{\n		width:80%!important;\n	}\n	.fullimg{\n		width:100%!important;\n		height:auto!important;\n	}\n	.nomobile{\n		display:none!important;\n	}\n	.forcecol{\n		display:block!important;\n		width:100%!important;\n	}', 'cover', 1, 'all', '2018-03-12 11:14:25'),
(47, NULL, '<table data-section="bf57b9" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="preheader" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;">\n						Je suis un preheader\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2f5b54" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:2px;padding-bottom:10px">\n						<a href="{mc_mirror}" style="color:#298DF2" data-mirror="mirror">\n							Voir la version en ligne\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="b5a6a0" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td align="center">\n						<img data-img="" class="fullimg" src="template_all/template_public_47/images/cover.jpg" width="600" height="360" style="display:blocks" border="0">\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2b9a93" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">\n				<tbody><tr>\n					<td data-text="" align="left" style="font-family:Arial;color:#909090;font-size:14px;padding-top:30px;padding-right:10px;padding-left:10px;padding-bottom:30px;">\n						Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum \n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>\n<table data-section="2450b5" class="maincontainer" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">\n	<tbody><tr>\n		<td align="center">\n			<table data-content="variables" class="container" align="center" width="600" border="0" cellpadding="0" cellspacing="0">\n				<tbody><tr>\n					<td data-text="" align="center" style="font-family:Arial;color:#909090;font-size:10px;padding-top:10px;padding-bottom:10px">\n						<a href="{mc_unsub}" style="color:#298DF2" data-unsub="unsub">\n							Se désinscrire\n						</a>\n					</td>\n				</tr>\n			</tbody></table>\n		</td>\n	</tr>\n</tbody></table>', '@media screen and (max-width: 600px) {\n	.maincontainer{\n		width:100%!important;\n	}\n	.container{\n		width:90%!important;\n	}\n	.container2{\n		width:80%!important;\n	}\n	.fullimg{\n		width:100%!important;\n		height:auto!important;\n	}\n	.nomobile{\n		display:none!important;\n	}\n	.forcecol{\n		display:block!important;\n		width:100%!important;\n	}\n	.w84{\n		width:69px!important;\n	}\n	.w60{\n		width:45px!important;\n	}\n	.f14{\n		font-size:14px!important;\n	}\n}', 'Unsub & Mirror', 1, 'all', '2018-03-19 12:32:38');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_societe` varchar(450) COLLATE utf8_bin NOT NULL DEFAULT 'test' COMMENT 'Société modifiabale du user',
  `first_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `societe` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'test',
  `nb_phone` varchar(255) COLLATE utf8_bin NOT NULL,
  `gender` varchar(255) COLLATE utf8_bin NOT NULL,
  `valide` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `adress` text COLLATE utf8_bin
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_password`, `user_societe`, `first_name`, `last_name`, `societe`, `nb_phone`, `gender`, `valide`, `timestamp`, `adress`) VALUES
(60, 'fauchet.jeancharles@gmail.com', '$2y$10$FIL.u/PtxavEnqmIie4f7Ot10EqKJ6uj75l8EDm131mfewCUm9RYG', 'test', 'hello', 'nhemloe', 'neoud', 'njoeee', 'male', 1, '2018-02-20 16:57:10', '28, rue du chemin vert, 75011 PARIS'),
(65, 'jean-charles.fauchet@crmcurve.fr', '$2y$10$V0sDLL4sONTPJZdCfHMDi.7qf.cFPSmwGggq7YSXCu.fCo2NYP0sC', 'test', 'aa', 'aa', 'ff', 'dede', 'male', 2, '2018-03-05 14:09:42', NULL),
(66, 'antoine.chapuset@crmcurve.fr', '$2y$10$joadz9nJIaCxBx8SxKVBOO5wuZ0IWm294OMyR1UGDotdaNia7AfdS', 'test', 'test', 'test', 'test', 'test', 'male', 1, '2018-03-13 14:53:27', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users_additional`
--

CREATE TABLE IF NOT EXISTS `users_additional` (
  `user_additional_id` int(11) NOT NULL COMMENT 'ID de l''utilisateur',
  `user_additional_admin_id` int(11) NOT NULL COMMENT 'ID de l''administrateur',
  `user_additional_fn` varchar(100) DEFAULT NULL,
  `user_additional_ln` varchar(100) DEFAULT NULL,
  `user_additional_email` varchar(100) NOT NULL COMMENT 'Email de l''utilisateur',
  `user_additional_password` varchar(500) DEFAULT NULL COMMENT 'Mot de passe de l''utilisateur',
  `user_additional_key` mediumtext NOT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users_additional`
--

INSERT INTO `users_additional` (`user_additional_id`, `user_additional_admin_id`, `user_additional_fn`, `user_additional_ln`, `user_additional_email`, `user_additional_password`, `user_additional_key`, `statut`) VALUES
(122, 60, 'aa', 'bc', 'crmcurve@gmail.com', '$2y$10$qOtObonDShQQdXmiMhxNNOypBI6/ZBnA2kZU/.j72V3OuUYaishUe', '5a9d27a4a8b89', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`api_id`);

--
-- Index pour la table `email_cat`
--
ALTER TABLE `email_cat`
  ADD PRIMARY KEY (`cat_id`);

--
-- Index pour la table `forgotten_pass`
--
ALTER TABLE `forgotten_pass`
  ADD PRIMARY KEY (`id_unique`);

--
-- Index pour la table `mail_editor`
--
ALTER TABLE `mail_editor`
  ADD PRIMARY KEY (`id_mail`);

--
-- Index pour la table `payments_stripe`
--
ALTER TABLE `payments_stripe`
  ADD PRIMARY KEY (`id_payment`);

--
-- Index pour la table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Index pour la table `template_commande`
--
ALTER TABLE `template_commande`
  ADD PRIMARY KEY (`id_commande`);

--
-- Index pour la table `template_counter`
--
ALTER TABLE `template_counter`
  ADD PRIMARY KEY (`count_id`);

--
-- Index pour la table `template_mail`
--
ALTER TABLE `template_mail`
  ADD PRIMARY KEY (`id_template`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `users_additional`
--
ALTER TABLE `users_additional`
  ADD PRIMARY KEY (`user_additional_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `api`
--
ALTER TABLE `api`
  MODIFY `api_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `email_cat`
--
ALTER TABLE `email_cat`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=154;
--
-- AUTO_INCREMENT pour la table `mail_editor`
--
ALTER TABLE `mail_editor`
  MODIFY `id_mail` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT pour la table `payments_stripe`
--
ALTER TABLE `payments_stripe`
  MODIFY `id_payment` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=162;
--
-- AUTO_INCREMENT pour la table `template_commande`
--
ALTER TABLE `template_commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `template_counter`
--
ALTER TABLE `template_counter`
  MODIFY `count_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `template_mail`
--
ALTER TABLE `template_mail`
  MODIFY `id_template` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT pour la table `users_additional`
--
ALTER TABLE `users_additional`
  MODIFY `user_additional_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID de l''utilisateur',AUTO_INCREMENT=123;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
