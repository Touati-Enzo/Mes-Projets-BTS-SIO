-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 12 jan. 2026 à 17:42
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
-- Base de données : `ProjetCVVEN`
--

-- --------------------------------------------------------

--
-- Structure de la table `chambres`
--

CREATE TABLE `chambres` (
  `id` int(11) NOT NULL,
  `numero_chambre` varchar(10) NOT NULL,
  `prix_journalier` decimal(10,2) NOT NULL,
  `personne_max` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modification` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chambres`
--

INSERT INTO `chambres` (`id`, `numero_chambre`, `prix_journalier`, `personne_max`, `description`, `date_creation`, `date_modification`) VALUES
(1, '101', 80.00, 2, 'Chambre standard avec lit double, salle de bain privée et TV', '2025-12-09 16:15:35', '2025-12-09 16:15:35'),
(2, '102', 85.00, 2, 'Chambre vue jardin, lit double et bureau de travail', '2025-12-09 16:15:35', '2025-12-09 16:15:35'),
(3, '201', 120.00, 4, 'Chambre familiale avec 2 lits doubles, parfaite pour familles', '2025-12-09 16:15:35', '2025-12-09 16:15:35'),
(4, '301', 180.00, 2, 'Suite avec salon séparé, jacuzzi et vue panoramique', '2025-12-09 16:15:35', '2025-12-09 16:15:35'),
(5, '001', 90.00, 2, 'Chambre PMR accessible aux personnes à mobilité réduite', '2025-12-09 16:15:35', '2025-12-09 16:15:35');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `num_chambre` varchar(10) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `nb_personne` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `num_chambre`, `date_debut`, `date_fin`, `prix`, `nb_personne`, `created_at`, `updated_at`) VALUES
(2, 15, '102', '2026-01-25', '2026-01-28', 255.00, 2, '2026-01-12 15:31:38', '2026-01-12 15:31:38'),
(3, 1, '201', '2026-02-16', '2026-02-18', 240.00, 4, '2026-01-12 15:34:04', '2026-01-12 15:34:04'),
(4, 15, '201', '2026-01-12', '2026-01-15', 360.00, 1, '2026-01-12 16:00:37', '2026-01-12 16:00:37'),
(5, 15, '001', '2026-01-13', '2026-01-14', 90.00, 2, '2026-01-12 16:01:43', '2026-01-12 16:01:43'),
(6, 15, '101', '2026-01-13', '2026-01-21', 640.00, 1, '2026-01-12 16:06:03', '2026-01-12 16:06:03'),
(7, 15, '102', '2026-01-14', '2026-01-16', 170.00, 1, '2026-01-12 16:06:10', '2026-01-12 16:06:10');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `first_name`, `last_name`, `password`, `role`, `created_at`, `updated_at`, `phone`, `address`) VALUES
(1, 'admin@example.com', 'admin', '', '', '$2y$10$IbRSOy8Ew3BTqd65Nk2vj.jBxJAmxHYVI6vKOHr/rbcH9rb5ApLmK', 'admin', '2025-12-01 16:32:25', '2025-12-01 16:41:25', NULL, NULL),
(15, 'test@gmail.com', 'test', 'Prénom', 'Nom', '$2y$10$IchTSfFReyybS./KVQA.ZuK0obX7Fr2jsOWAWfEuK8GaKozvF4.cO', 'user', '2026-01-12 13:46:02', '2026-01-12 13:46:02', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chambres`
--
ALTER TABLE `chambres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_chambre` (`numero_chambre`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reservations_num_chambre_foreign` (`num_chambre`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chambres`
--
ALTER TABLE `chambres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_num_chambre_foreign` FOREIGN KEY (`num_chambre`) REFERENCES `chambres` (`numero_chambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;