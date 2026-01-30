-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 30 jan. 2026 à 12:14
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `catalogue`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `idCategorie` int(11) NOT NULL,
  `nomCategorie` varchar(30) NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `nomCategorie`, `dateCreation`) VALUES
(1, 'Électronique', '2025-10-03 13:36:12'),
(2, 'Livres', '2025-10-03 13:36:12'),
(3, 'Vêtements', '2025-10-03 13:36:12'),
(4, 'Maison', '2025-10-03 13:36:12'),
(5, 'Sport', '2025-10-03 13:36:12'),
(6, 'Informatique', '2025-01-10 09:20:00'),
(7, 'Beauté & Santé', '2025-01-10 09:21:00'),
(8, 'Jouets', '2025-01-10 09:22:00'),
(9, 'Alimentation', '2025-01-10 09:23:00'),
(10, 'Automobile', '2025-01-10 09:24:00');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `idProduit` varchar(11) NOT NULL CHECK (`idProduit` like 'PROD%'),
  `designationProduit` varchar(50) NOT NULL,
  `prix` double NOT NULL CHECK (`prix` >= 0),
  `quantite` int(11) NOT NULL DEFAULT 0 CHECK (`quantite` >= 0),
  `idCategorie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `designationProduit`, `prix`, `quantite`, `idCategorie`) VALUES
('PROD001', 'Smartphone Samsung Galaxy S23', 899.99, 25, 1),
('PROD002', 'Livre \"Introduction à UML 2\"', 35.5, 100, 2),
('PROD003', 'T-shirt coton bio', 24.99, 150, 3),
('PROD004', 'Cafetière programmable', 49.9, 30, 4),
('PROD005', 'Ballon de football professionnel', 29.99, 75, 5),
('PROD006', 'Le Seigneur des Anneaux – Tome 1', 19.99, 60, 2),
('PROD007', 'Clean Code – Robert C. Martin', 42, 40, 2),
('PROD008', 'Harry Potter et la Coupe de Feu', 24.99, 70, 2),
('PROD009', 'T-shirt coton bio', 24.99, 150, 3),
('PROD010', 'Jean slim homme', 59.99, 80, 3),
('PROD011', 'Veste en cuir femme', 149.99, 35, 3),
('PROD012', 'Sweat à capuche unisexe', 39.99, 90, 3),
('PROD013', 'Cafetière programmable', 49.9, 30, 4),
('PROD014', 'Aspirateur Dyson V11', 599.99, 12, 4),
('PROD015', 'Lampe de bureau LED', 29.99, 50, 4),
('PROD016', 'Fauteuil de salon moderne', 199.99, 20, 4),
('PROD017', 'Vélo tout terrain Rockrider', 399.99, 15, 5),
('PROD018', 'Tapis de yoga antidérapant', 19.99, 100, 5),
('PROD019', 'Gants de boxe 12 oz', 45, 40, 5),
('PROD020', 'Ordinateur portable Lenovo ThinkPad', 1099.99, 20, 6),
('PROD021', 'Clavier mécanique Logitech', 89.99, 45, 6),
('PROD022', 'Souris gaming Razer Viper', 59.99, 60, 6),
('PROD023', 'Écran PC 27 pouces 144Hz MSI', 279.99, 25, 6),
('PROD024', 'Crème hydratante Nivea', 7.99, 120, 7),
('PROD025', 'Shampoing bio 500ml', 8.99, 80, 7),
('PROD026', 'Brosse à dents électrique Oral-B', 49.99, 35, 7),
('PROD027', 'Lego Star Wars – X-Wing Fighter', 89.99, 25, 8),
('PROD028', 'Peluche géante ours brun', 34.99, 40, 8),
('PROD029', 'Jeu société \"Cortex Challenge\"', 24.99, 50, 8),
('PROD030', 'Pâtes complètes 1kg', 2.49, 200, 9),
('PROD031', 'Huile d’olive extra vierge 1L', 8.99, 120, 9),
('PROD032', 'Café moulu arabica 500g', 5.99, 100, 9),
('PROD033', 'Kit d’entretien voiture 6 pièces', 29.99, 50, 10),
('PROD034', 'Autoradio Bluetooth Pioneer', 129.99, 25, 10),
('PROD035', 'Tapis de voiture universels', 39.99, 40, 10);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `mdp` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `mdp`) VALUES
(1, 'Dupont', 'dupont@1234');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`idCategorie`),
  ADD UNIQUE KEY `nomCategorie` (`nomCategorie`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idProduit`),
  ADD KEY `idCategorie` (`idCategorie`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
