-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 19 jan. 2020 à 12:35
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `choptaphoto`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `create_range_date`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_range_date` (IN `startdate` TIMESTAMP, IN `enddate` TIMESTAMP, IN `intval` INT, IN `unitval` VARCHAR(10))  NO SQL
BEGIN

   declare thisDate timestamp;
   declare nextDate timestamp;
   set thisDate = startdate;

   drop temporary table if exists time_intervals;
   create temporary table if not exists time_intervals
      (
      interval_start timestamp,
      interval_end timestamp
      );

   repeat
      select
         case unitval
            when 'MICROSECOND' then timestampadd(MICROSECOND, intval, thisDate)
            when 'SECOND'      then timestampadd(SECOND, intval, thisDate)
            when 'MINUTE'      then timestampadd(MINUTE, intval, thisDate)
            when 'HOUR'        then timestampadd(HOUR, intval, thisDate)
            when 'DAY'         then timestampadd(DAY, intval, thisDate)
            when 'WEEK'        then timestampadd(WEEK, intval, thisDate)
            when 'MONTH'       then timestampadd(MONTH, intval, thisDate)
            when 'QUARTER'     then timestampadd(QUARTER, intval, thisDate)
            when 'YEAR'        then timestampadd(YEAR, intval, thisDate)
         end into nextDate;

      insert into time_intervals select thisDate, timestampadd(MICROSECOND, -1, nextDate);
      set thisDate = nextDate;
   until thisDate >= enddate
   end repeat;

 END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `billing`
--

DROP TABLE IF EXISTS `billing`;
CREATE TABLE IF NOT EXISTS `billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_billing_order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `postal` int(5) NOT NULL,
  `ville` text NOT NULL,
  `debut` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `created_at` date NOT NULL,
  `product_id` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_booking_product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `booking`
--

INSERT INTO `booking` (`id`, `nom`, `prenom`, `email`, `adresse`, `postal`, `ville`, `debut`, `fin`, `created_at`, `product_id`) VALUES
(2, 'nom 1', 'prenom1', 'email1@gmail.com', 'adresse 1', 59890, 'lille', '2020-01-18 00:00:00', '2020-01-25 00:00:00', '2020-01-18', 17),
(3, 'nom 2', 'prenom2', 'email2@gmail.com', 'adresse 2', 56230, 'Bordeau', '2020-01-18 00:00:00', '2020-01-30 00:00:00', '2020-01-18', 3),
(4, 'nom 3', 'prenom3', 'email3@gmail.com', 'adresse 3', 56230, 'Nantes', '2020-01-18 00:00:00', '2020-01-30 00:00:00', '2020-01-18', 17),
(5, 'nom 4', 'prenom4', 'email4@gmail.com', 'adresse 4', 56230, 'Toulouse', '2020-01-18 00:00:00', '2020-01-30 00:00:00', '2020-01-18', 17),
(6, 'nom 5', 'prenom5', 'email5@gmail.com', 'adresse 5', 75000, 'Nancy', '2020-01-20 00:00:00', '2020-01-30 00:00:00', '2020-01-18', 17),
(7, 'nom 6', 'prenom6', 'email6@gmail.com', 'adresse 6', 59000, 'Marseille', '2020-01-21 00:00:00', '2020-01-28 00:00:00', '2020-01-18', 17),
(8, 'nom 7', 'prenom7', 'email7@gmail.com', 'adresse 7', 75000, 'Rennes', '2020-01-18 00:00:00', '2020-01-22 00:00:00', '2020-01-18', 7),
(9, 'nom 8', 'prenom8', 'email8@gmail.com', 'adresse 8', 75000, 'Grenoble', '2020-01-18 00:00:00', '2020-01-20 00:00:00', '2020-01-18', 7),
(11, 'nom 9', 'prenom9', 'email9@gmail.com', 'adresse 9', 75001, 'Bruxelles', '2020-01-21 00:00:00', '2020-01-31 00:00:00', '2020-01-19', 3),
(12, 'nom 10', 'prenom10', 'email10@gmail.com', 'adresse 10', 74001, 'Londres', '2020-02-15 00:00:00', '2020-02-22 00:00:00', '2020-01-19', 3);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Papier'),
(2, 'Encre'),
(3, 'Cartouche'),
(4, 'petite'),
(5, 'grande'),
(6, 'quantite'),
(7, 'disponible'),
(9, 'en solde');

-- --------------------------------------------------------

--
-- Structure de la table `category_product`
--

DROP TABLE IF EXISTS `category_product`;
CREATE TABLE IF NOT EXISTS `category_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_product_product_id` (`product_id`),
  KEY `fk_category_product_category_id_idx` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_token` varchar(255) DEFAULT NULL,
  `register_at` datetime NOT NULL,
  `connection_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `name`, `firstname`, `email`, `password`, `email_token`, `register_at`, `connection_at`, `reset_token`, `reset_at`, `role`) VALUES
(1, 'quenti77', '77', 'quentin@gmail.com', '$2y$10$6dbWbmDNHu/veVILnLnOE.WVoyQXKMqTscPMgbc03WAglg9RBs9Ca', NULL, '2019-11-16 10:15:25', '2020-01-19 10:26:38', 'FpOLD2ykmIPRazqKl4QvyTSIeIHF1j2KoamRZ7qAzcqlZchgh0cwRS0APTFV', '2020-01-18 12:02:29', 1),
(2, 'test', 'test', 'test@gmail.com', '$2y$10$6dbWbmDNHu/veVILnLnOE.WVoyQXKMqTscPMgbc03WAglg9RBs9Ca', 'QR1maEBSjQUVrErxu19CWmnzr3QpqZ2N2si5Wqic0SKTYnnIQxebvCCJfILV', '2019-11-16 14:40:23', NULL, '', NULL, 2),
(3, 'geoffrey', 'geo', 'geo@ff.fr', '$2y$10$6dbWbmDNHu/veVILnLnOE.WVoyQXKMqTscPMgbc03WAglg9RBs9Ca', NULL, '2019-11-23 15:57:41', '2019-12-17 21:07:00', '1OAq7V15XC4TgAr1X6jMjlVbYC9e7EszZkhOJ6kYfpQe7yc5yBkpFRI1hYyv', '2019-12-06 12:46:09', 1),
(4, 'pizza', 'pizz', 'pizza@gmail.com', '$2y$10$6dbWbmDNHu/veVILnLnOE.WVoyQXKMqTscPMgbc03WAglg9RBs9Ca', NULL, '2019-12-01 13:32:31', '2019-12-01 16:36:03', NULL, NULL, 2),
(5, 'a', 'a', 'aaa@gmail.com', '$2y$10$6dbWbmDNHu/veVILnLnOE.WVoyQXKMqTscPMgbc03WAglg9RBs9Ca', 'lo0A0EQzqqCw6bouY9YB9fRciv5JEn8eqekCUZZGgA8yMKg3lWc1y2vo93yO', '2020-01-18 11:00:44', NULL, NULL, NULL, 2),
(6, 'aaa', 'aaa', 'aaa@gmail.com', '$2y$10$6dbWbmDNHu/veVILnLnOE.WVoyQXKMqTscPMgbc03WAglg9RBs9Ca', NULL, '2020-01-18 11:03:18', '2020-01-18 11:06:13', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `client_coupon`
--

DROP TABLE IF EXISTS `client_coupon`;
CREATE TABLE IF NOT EXISTS `client_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `nb_use` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_client_coupon_client_id` (`client_id`),
  KEY `fk_client_coupon_coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `coupon`
--

DROP TABLE IF EXISTS `coupon`;
CREATE TABLE IF NOT EXISTS `coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price_reduc` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `started_at` datetime NOT NULL,
  `finished_at` datetime NOT NULL,
  `max_use` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_coupon_product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `coupon`
--

INSERT INTO `coupon` (`id`, `product_id`, `code`, `name`, `price_reduc`, `created_at`, `updated_at`, `started_at`, `finished_at`, `max_use`) VALUES
(1, 7, 'black_Friday_23', 'quentin', 5, '2019-11-23 16:20:00', NULL, '2019-11-25 00:00:00', '2019-11-29 00:00:00', 2),
(14, 4, '1478965231', 'fin black friday', 120, '2019-11-30 13:45:14', NULL, '2012-02-01 00:00:00', '2015-05-01 00:00:00', 20),
(15, 8, '456', 'azdazd', 1000, '2019-11-30 13:46:35', NULL, '2005-02-01 00:00:00', '2006-02-01 00:00:00', 12);

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `num` varchar(255) NOT NULL,
  `total_ht` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_client_id` (`client_id`),
  KEY `fk_order_coupon_id` (`coupon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `client_id`, `num`, `total_ht`, `created_at`, `updated_at`, `coupon_id`) VALUES
(1, 1, 'order_1', NULL, '2019-12-10 08:25:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `finished_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_order_order_id` (`order_id`),
  KEY `fk_product_order_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` bigint(20) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `is_location` bigint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `quantity`, `ref`, `is_location`, `created_at`) VALUES
(3, 'Produit 333', 'Nihil harum cum ut id distinctio.', 814, 2, 'ref_2320', 0, '2019-12-01 10:58:32'),
(4, 'Produit 4', 'Voluptas et laudantium aut molestias.', 1201, 4, 'ref_22', 0, '2019-12-01 10:58:32'),
(5, 'Produit 5', 'Consectetur dolores iste omnis natus aut.', 1968, 8, 'ref_111', 0, '2019-12-01 10:58:32'),
(6, 'produit 6ddd', 'Amet ', 1612, 19, 'ref_144', 1, '2019-12-01 10:58:32'),
(7, 'produit 7', 'Ea eveniet sint voluptatum autem officia ad.', 444, 8, 'ref_116', 1, '2019-12-01 10:58:32'),
(8, 'produit 8', 'Ut a ad non tempore facilis.', 1500, 6, 'ref_37', 0, '2019-12-01 10:58:32'),
(9, 'Produit 9', 'Qui voluptatem ut ut maxime non voluptates.', 562, 3, 'ref_163', 0, '2019-12-01 10:58:32'),
(10, 'Produit 10.', 'Fugiat occaecati enim provident et.', 573, 8, 'ref_24', 1, '2019-12-01 10:58:32'),
(14, 'produit 14', 'desc', 12, 1, 'ref_14597', 0, '2019-12-01 10:58:32'),
(16, 'produit 16', 'pizz', 12, 20, 'ref_ref_1616', 0, '2019-12-01 11:14:59'),
(17, 'produit 17', 'bradjdbfhb', 50, 1000, 'ref_1717', 0, '2019-12-28 10:44:02'),
(18, 'produit 18', 'bnnddjddjndjn', 20, 30, 'ref_1818', 0, '2019-12-29 13:39:21'),
(19, 'dddd', 'd', 120, 130, 'endgameproduct', 0, '2020-01-18 10:44:19');

-- --------------------------------------------------------

--
-- Structure de la table `product_image`
--

DROP TABLE IF EXISTS `product_image`;
CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `is_main` tinyint(4) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_image_product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `is_main`, `path`, `name`) VALUES
(1, 8, 1, 'public/images/shop/1.jpg', 'image1'),
(2, 17, 1, 'public/images/shop/2.jpg', 'image 2'),
(3, 18, 1, 'images/shop/wall1.png', ''),
(4, 19, 1, 'images/shop/bg2.png', '');

-- --------------------------------------------------------

--
-- Structure de la table `product_stocks`
--

DROP TABLE IF EXISTS `product_stocks`;
CREATE TABLE IF NOT EXISTS `product_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(255) NOT NULL,
  `product_quantity` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `category_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `fk_billing_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `category_product`
--
ALTER TABLE `category_product`
  ADD CONSTRAINT `fk_category_product_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `test` FOREIGN KEY (`category_id`) REFERENCES `chotaphoto`.`category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `client_coupon`
--
ALTER TABLE `client_coupon`
  ADD CONSTRAINT `fk_client_coupon_client_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_client_coupon_coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `coupon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `coupon`
--
ALTER TABLE `coupon`
  ADD CONSTRAINT `fk_coupon_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_client_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `coupon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `fk_product_order_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_order_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `fk_product_image_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
