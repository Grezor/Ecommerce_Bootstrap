-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 18 déc. 2019 à 21:45
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
(1, 'Laure'),
(2, 'Paulette'),
(3, 'Olivier'),
(4, 'AmÃ©lie'),
(5, 'Lucas'),
(6, 'evoltion'),
(7, 'evoltion'),
(9, 'Fred');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `name`, `firstname`, `email`, `password`, `email_token`, `register_at`, `connection_at`, `reset_token`, `reset_at`, `role`) VALUES
(1, 'quenti77', '77', 'quentin@gmail.com', '$2y$10$JDQctR2aUSdLnmBLWo2X3.427GU6u2obmyqNgTIpC9cW5lmcBw3Ei', NULL, '2019-11-16 10:15:25', '2019-11-30 14:59:16', 'ZD3tIq9BWLJZ7wpGtyO8oIzMRYy7GtveWwr1eY7MSEE5goYTZJ2ekpEomK1I', '2019-11-30 10:35:41', 1),
(2, 'test', 'test', 'test@gmail.com', '$2y$10$JDQctR2aUSdLnmBLWo2X3.427GU6u2obmyqNgTIpC9cW5lmcBw3Ei', 'QR1maEBSjQUVrErxu19CWmnzr3QpqZ2N2si5Wqic0SKTYnnIQxebvCCJfILV', '2019-11-16 14:40:23', NULL, '', NULL, 2),
(3, 'geoffrey', 'geo', 'geo@ff.fr', '$2y$10$JDQctR2aUSdLnmBLWo2X3.427GU6u2obmyqNgTIpC9cW5lmcBw3Ei', NULL, '2019-11-23 15:57:41', '2019-12-17 21:07:00', '1OAq7V15XC4TgAr1X6jMjlVbYC9e7EszZkhOJ6kYfpQe7yc5yBkpFRI1hYyv', '2019-12-06 12:46:09', 1),
(4, 'pizza', 'pizz', 'pizza@gmail.com', '$2y$10$JDQctR2aUSdLnmBLWo2X3.427GU6u2obmyqNgTIpC9cW5lmcBw3Ei', NULL, '2019-12-01 13:32:31', '2019-12-01 16:36:03', NULL, NULL, 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `coupon`
--

INSERT INTO `coupon` (`id`, `product_id`, `code`, `name`, `price_reduc`, `created_at`, `updated_at`, `started_at`, `finished_at`, `max_use`) VALUES
(1, 7, 'black_Friday_23', 'quentin', 5, '2019-11-23 16:20:00', NULL, '2019-11-25 00:00:00', '2019-11-29 00:00:00', 2),
(2, 15, '12345', 'pizza', 10, '2019-11-30 11:35:33', NULL, '2019-11-30 00:00:00', '2019-12-25 00:00:00', 15),
(14, 4, '1478965231', 'fin black friday', 120, '2019-11-30 13:45:14', NULL, '2012-02-01 00:00:00', '2015-05-01 00:00:00', 20),
(15, 8, '456', 'azdazd', 1000, '2019-11-30 13:46:35', NULL, '2005-02-01 00:00:00', '2006-02-01 00:00:00', 12),
(16, 12, 'fred10', 'fred', 20, '2019-12-06 12:50:06', NULL, '2019-12-09 00:00:00', '2019-12-16 00:00:00', 10),
(17, 1, 'test123', 'promo_laurence', 10, '2019-12-07 09:45:00', NULL, '2019-12-23 00:00:00', '2019-12-25 00:00:00', 2);

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
  `image_product` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `quantity`, `ref`, `is_location`, `image_product`, `created_at`) VALUES
(1, 'Laurence', 'Et et esse aut nostrum magnam.', 1804, 13, 'ref_166', 1, '', '2019-11-13 10:58:32'),
(2, 'GrÃ©goire', 'Dolorem autem et laudantium.', 669, 8, 'ref_132', 0, '', '2019-12-01 10:58:32'),
(3, 'Raymond', 'Nihil harum cum ut id distinctio.', 814, 2, 'ref_55', 0, '', '2019-12-01 10:58:32'),
(4, 'Alix', 'Voluptas et laudantium aut molestias.', 1201, 4, 'ref_22', 0, '', '2019-12-01 10:58:32'),
(5, 'Marthe', 'Consectetur dolores iste omnis natus aut.', 1968, 8, 'ref_111', 0, '', '2019-12-01 10:58:32'),
(6, 'Alfred', 'Amet assumenda odio aliquam unde eum.', 1612, 19, 'ref_144', 1, '', '2019-12-01 10:58:32'),
(7, 'Dominique', 'Ea eveniet sint voluptatum autem officia ad.', 444, 8, 'ref_116', 1, '', '2019-12-01 10:58:32'),
(8, 'Luc', 'Ut a ad non tempore facilis.', 1500, 6, 'ref_37', 0, '', '2019-12-01 10:58:32'),
(9, 'Isabelle', 'Qui voluptatem ut ut maxime non voluptates.', 562, 3, 'ref_163', 0, '', '2019-12-01 10:58:32'),
(10, 'CÃ©lina', 'Fugiat occaecati enim provident et.', 573, 8, 'ref_24', 1, '', '2019-12-01 10:58:32'),
(11, 'pikachu', 'ddddddddddddddddddddddddddddddddddddddd', 1200, 200, 'ref_pika', 1, '', '2019-12-01 10:58:32'),
(12, 'dracofeu', 'dracofeu is comming ', 500, 150, 'ref_draco', 1, '', '2019-12-01 10:58:32'),
(13, 'admin', 'ddd', 500, 200, 'ref_pika', 1, '', '2019-12-01 10:58:32'),
(14, 'quenti77', 'desc', 12, 1, 're_admin', 0, '', '2019-12-01 10:58:32'),
(15, 'azd', 'zefczf', 100, 1, 'az32de1', 0, '', '2019-12-01 10:58:32'),
(16, 'pizza', 'pizz', 12, 20, 'ref_pizza', 0, '', '2019-12-01 11:14:59');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `is_main`, `path`, `name`) VALUES
(1, 8, 1, 'http://lorempixel.com/640/480/', 'image1');

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
