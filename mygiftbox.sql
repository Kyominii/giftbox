-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Mer 18 Janvier 2017 à 21:40
-- Version du serveur :  5.5.53-0+deb8u1
-- Version de PHP :  7.0.13-1~dotdeb+8.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `giftbox`
--

-- --------------------------------------------------------

--
-- Structure de la table `bestprest`
--

CREATE TABLE `bestprest` (
  `id_cat` int(11) NOT NULL,
  `id_prest` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `bestprest`
--

INSERT INTO `bestprest` (`id_cat`, `id_prest`) VALUES
(1, 1),
(2, 3),
(3, 4),
(4, 24);

-- --------------------------------------------------------

--
-- Structure de la table `cagnotte`
--

CREATE TABLE `cagnotte` (
  `id` int(11) NOT NULL,
  `id_coffret` int(11) DEFAULT NULL,
  `slug` text,
  `motdepasse` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'Attention'),
(2, 'Activité'),
(3, 'Restauration'),
(4, 'Hébergement');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `nom` text,
  `prenom` text,
  `numAdresse` int(11) DEFAULT NULL,
  `nomAdresse` text,
  `ville` text,
  `codePostal` int(11) DEFAULT NULL,
  `email` text,
  `pays` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `coffret`
--

CREATE TABLE `coffret` (
  `id` int(11) NOT NULL,
  `date_creation` date DEFAULT NULL,
  `paiement` text,
  `date_paiement` date DEFAULT NULL,
  `id_cli` int(11) DEFAULT NULL,
  `message` text,
  `slug` text,
  `urlCadeau` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contient`
--

CREATE TABLE `contient` (
  `id_coffret` int(11) NOT NULL DEFAULT '0',
  `id_prestation` int(11) NOT NULL DEFAULT '0',
  `nb_prestation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contribution`
--

CREATE TABLE `contribution` (
  `id` int(11) NOT NULL,
  `id_cagnotte` int(11) DEFAULT NULL,
  `prenom` text,
  `nom` text,
  `montant` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `notation`
--

CREATE TABLE `notation` (
  `id` int(11) NOT NULL,
  `note` int(1) NOT NULL,
  `pre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `prestation`
--

CREATE TABLE `prestation` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `descr` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `img` text NOT NULL,
  `prix` decimal(5,2) NOT NULL,
  `display` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `prestation`
--

INSERT INTO `prestation` (`id`, `nom`, `descr`, `cat_id`, `img`, `prix`, `display`) VALUES
(1, 'Champagne', 'Bouteille de champagne + flutes + jeux à gratter', 1, 'champagne.jpg', '20.00', 1),
(2, 'Musique', 'Partitions de piano à 4 mains', 1, 'musique.jpg', '25.00', 1),
(3, 'Exposition', 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel', 2, 'poirelregarder.jpg', '14.00', 1),
(4, 'Goûter', 'Goûter au FIFNL', 3, 'gouter.jpg', '20.00', 1),
(5, 'Projection', 'Projection courts-métrages au FIFNL', 2, 'film.jpg', '10.00', 1),
(6, 'Bouquet', 'Bouquet de roses et Mots de Marion Renaud', 1, 'rose.jpg', '16.00', 1),
(7, 'Diner Stanislas', 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)', 3, 'bonroi.jpg', '60.00', 1),
(8, 'Origami', 'Baguettes magiques en Origami en buvant un thé', 3, 'origami.jpg', '12.00', 1),
(9, 'Livres', 'Livre bricolage avec petits-enfants + Roman', 1, 'bricolage.jpg', '24.00', 1),
(10, 'Diner  Grand Rue ', 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)', 3, 'grandrue.jpg', '59.00', 1),
(11, 'Visite guidée', 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas', 2, 'place.jpg', '11.00', 1),
(12, 'Bijoux', 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil', 1, 'bijoux.jpg', '29.00', 1),
(13, 'Opéra', 'Concert commenté à l’Opéra', 2, 'opera.jpg', '15.00', 1),
(14, 'Thé Hotel de la reine', 'Thé de debriefing au bar de l’Hotel de la reine', 3, 'hotelreine.gif', '5.00', 1),
(15, 'Jeu connaissance', 'Jeu pour faire connaissance', 2, 'connaissance.jpg', '6.00', 1),
(16, 'Diner', 'Diner (Apéritif / Plat / Vin / Dessert / Café)', 3, 'diner.jpg', '40.00', 1),
(17, 'Cadeaux individuels', 'Cadeaux individuels sur le thème de la soirée', 1, 'cadeaux.jpg', '13.00', 1),
(18, 'Animation', 'Activité animée par un intervenant extérieur', 2, 'animateur.jpg', '9.00', 1),
(19, 'Jeu contacts', 'Jeu pour échange de contacts', 2, 'contact.png', '5.00', 1),
(20, 'Cocktail', 'Cocktail de fin de soirée', 3, 'cocktail.jpg', '12.00', 1),
(21, 'Star Wars', 'Star Wars - Le Réveil de la Force. Séance cinéma 3D', 2, 'starwars.jpg', '12.00', 1),
(22, 'Concert', 'Un concert à Nancy', 2, 'concert.jpg', '17.00', 1),
(23, 'Appart Hotel', 'Appart’hôtel Coeur de Ville, en plein centre-ville', 4, 'apparthotel.jpg', '56.00', 1),
(24, 'Hôtel d\'Haussonville', 'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas', 4, 'hotel_haussonville_logo.jpg', '169.00', 1),
(25, 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 2, 'boitedenuit.jpg', '32.00', 1),
(26, 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 2, 'laser.jpg', '15.00', 1),
(27, 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.', 2, 'fort.jpg', '25.00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `pseudo` text NOT NULL,
  `mdp` text NOT NULL,
  `grade` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `mdp`, `grade`) VALUES
(1, 'teddy', 'giVxuvcRnyOMQ', 'admin'),
(2, 'alex', 'giGsHwwgaiGyY', 'admin'),
(3, 'samir', 'gicF4swmvOOjc', 'user'),
(4, 'elias', 'giCrZE.CVd9Rs', 'user');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `cagnotte`
--
ALTER TABLE `cagnotte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_coffret` (`id_coffret`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `coffret`
--
ALTER TABLE `coffret`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cli` (`id_cli`);

--
-- Index pour la table `contient`
--
ALTER TABLE `contient`
  ADD PRIMARY KEY (`id_coffret`,`id_prestation`),
  ADD KEY `id_prestation` (`id_prestation`);

--
-- Index pour la table `contribution`
--
ALTER TABLE `contribution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cagnotte` (`id_cagnotte`);

--
-- Index pour la table `notation`
--
ALTER TABLE `notation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `prestation`
--
ALTER TABLE `prestation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `cagnotte`
--
ALTER TABLE `cagnotte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `coffret`
--
ALTER TABLE `coffret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `contribution`
--
ALTER TABLE `contribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `notation`
--
ALTER TABLE `notation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT pour la table `prestation`
--
ALTER TABLE `prestation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `cagnotte`
--
ALTER TABLE `cagnotte`
  ADD CONSTRAINT `cagnotte_ibfk_1` FOREIGN KEY (`id_coffret`) REFERENCES `coffret` (`id`);

--
-- Contraintes pour la table `coffret`
--
ALTER TABLE `coffret`
  ADD CONSTRAINT `coffret_ibfk_1` FOREIGN KEY (`id_cli`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `contient`
--
ALTER TABLE `contient`
  ADD CONSTRAINT `contient_ibfk_1` FOREIGN KEY (`id_coffret`) REFERENCES `coffret` (`id`),
  ADD CONSTRAINT `contient_ibfk_2` FOREIGN KEY (`id_prestation`) REFERENCES `prestation` (`id`);

--
-- Contraintes pour la table `contribution`
--
ALTER TABLE `contribution`
  ADD CONSTRAINT `contribution_ibfk_1` FOREIGN KEY (`id_cagnotte`) REFERENCES `cagnotte` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
