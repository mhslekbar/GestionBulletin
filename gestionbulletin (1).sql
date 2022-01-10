-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 jan. 2022 à 08:10
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionbulletin`
--

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `idClasse` int(11) NOT NULL,
  `NomClasse` varchar(255) NOT NULL,
  `idMatiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`idClasse`, `NomClasse`, `idMatiere`) VALUES
(26, '3DI', 1),
(27, '3DI', 3),
(28, '3DI', 2),
(29, '3DI', 5),
(40, '3DI', 6),
(41, '3DI', 8),
(54, '3FM', 1),
(55, '3DI', 7),
(59, '3dd', 1),
(61, '3dd', 3),
(73, 'TCM', 1),
(77, 'TCM', 2),
(96, 'TCM', 3),
(97, 'TCM', 4),
(98, '2DI', 1);

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(11) NOT NULL,
  `Matricule` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Telephone` int(11) NOT NULL,
  `Addresse` varchar(255) NOT NULL,
  `idClasse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `Matricule`, `FullName`, `Telephone`, `Addresse`, `idClasse`) VALUES
(17, 'ss-100', 'Ademo', 12567454, 'djskj', 26),
(18, 'ss-101', 'ADKhey', 56665, 'dhdfj', 26),
(19, 'ss-102', 'sniper', 15486465, 'djsk', 26),
(20, 'ss-103', 'pnl', 65456652, 'djsjk', 26),
(23, 'ss-104', 'karimTakTak', 35656656, 'TVZ', 98),
(24, 'ss-105', 'kader', 56533, 'sukuk', 54);

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE `matieres` (
  `idMatiere` int(11) NOT NULL,
  `NomMatiere` varchar(255) NOT NULL,
  `Coeff` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`idMatiere`, `NomMatiere`, `Coeff`) VALUES
(1, 'C++', 4),
(2, 'JavaScript', 5),
(3, 'PHP', 3),
(4, 'Ajax', 3),
(5, 'MySQL', 4),
(6, 'HTML', 2),
(7, 'CSS', 2),
(8, 'JQuery', 3);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `idNote` int(11) NOT NULL,
  `Matricule` varchar(255) NOT NULL,
  `idClasse` int(11) NOT NULL,
  `idMatiere` int(11) NOT NULL,
  `NoteDevoir` decimal(10,2) NOT NULL DEFAULT 0.00,
  `NoteCompo` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`idNote`, `Matricule`, `idClasse`, `idMatiere`, `NoteDevoir`, `NoteCompo`) VALUES
(1, 'ss-100', 26, 1, '14.50', '16.00'),
(2, 'ss-100', 26, 3, '17.00', '10.00'),
(3, 'ss-100', 26, 2, '17.50', '0.00'),
(4, 'ss-100', 26, 5, '11.00', '10.00'),
(5, 'ss-101', 26, 1, '15.00', '16.00'),
(6, 'ss-101', 26, 3, '10.00', '20.00'),
(7, 'ss-101', 26, 2, '5.00', '0.00'),
(8, 'ss-101', 26, 5, '16.00', '0.00'),
(9, 'ss-102', 26, 1, '18.00', '20.00'),
(10, 'ss-102', 26, 3, '18.00', '15.00'),
(11, 'ss-102', 26, 2, '0.00', '0.00'),
(12, 'ss-102', 26, 5, '0.00', '0.00'),
(19, 'ss-100', 26, 6, '0.00', '0.00'),
(20, 'ss-101', 26, 6, '0.00', '0.00'),
(21, 'ss-102', 26, 6, '0.00', '0.00'),
(22, 'ss-103', 26, 1, '20.00', '20.00'),
(23, 'ss-103', 26, 3, '0.00', '0.00'),
(24, 'ss-103', 26, 2, '0.00', '0.00'),
(25, 'ss-103', 26, 5, '0.00', '0.00'),
(26, 'ss-103', 26, 6, '0.00', '0.00'),
(27, 'ss-100', 26, 8, '0.00', '0.00'),
(28, 'ss-101', 26, 8, '0.00', '0.00'),
(29, 'ss-102', 26, 8, '0.00', '0.00'),
(30, 'ss-103', 26, 8, '0.00', '0.00'),
(31, 'ss-100', 26, 7, '0.00', '0.00'),
(32, 'ss-101', 26, 7, '0.00', '0.00'),
(33, 'ss-102', 26, 7, '0.00', '0.00'),
(34, 'ss-103', 26, 7, '0.00', '0.00'),
(38, 'ss-104', 98, 1, '0.00', '0.00'),
(39, 'ss-105', 54, 1, '0.00', '0.00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `Username`, `Password`) VALUES
(1, 'sniper', '1212'),
(2, 'ad', '1212');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`idClasse`),
  ADD KEY `idMatiere` (`idMatiere`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`Matricule`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `etudiants_ibfk_1` (`idClasse`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`idMatiere`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`idNote`),
  ADD KEY `Matricule` (`Matricule`),
  ADD KEY `idClasse` (`idClasse`),
  ADD KEY `idMatiere` (`idMatiere`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `idClasse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `idMatiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `idNote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`idMatiere`) REFERENCES `matieres` (`idMatiere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_ibfk_1` FOREIGN KEY (`idClasse`) REFERENCES `classes` (`idClasse`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`Matricule`) REFERENCES `etudiants` (`Matricule`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`idClasse`) REFERENCES `classes` (`idClasse`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_ibfk_3` FOREIGN KEY (`idMatiere`) REFERENCES `matieres` (`idMatiere`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
