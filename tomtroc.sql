-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 28 oct. 2026 à 15:17
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `description`, `availability`, `cover`, `user_id`) VALUES
(1, 'Le Petit Prince', 'Antoine de Saint-Exupéry', 'Un aviateur rencontre un mystérieux petit prince.', 1, '', 1),
(2, 'Les Misérables', 'Victor Hugo', 'Le destin de Jean Valjean dans la France du XIXe siècle.', 1, '', 1),
(3, 'L’Étranger', 'Albert Camus', 'Le parcours de Meursault face à la société et à la justice.', 1, '', 1),
(4, 'Le Comte de Monte-Cristo', 'Alexandre Dumas', 'Une histoire de vengeance après une longue incarcération.', 1, '', 1),
(5, 'Madame Bovary', 'Gustave Flaubert', 'Emma Bovary rêve d’une vie différente.', 1, '', 1),
(6, 'Vingt mille lieues sous les mers', 'Jules Verne', 'Une aventure extraordinaire à bord du Nautilus.', 1, '', 1),
(7, '1984', 'George Orwell', 'Un homme tente de résister à un régime totalitaire.', 1, '', 1),
(8, 'Orgueil et Préjugés', 'Jane Austen', 'Une histoire d’amour et de préjugés sociaux.', 1, '', 1),
(9, 'Harry Potter à l’école des sorciers', 'J. K. Rowling', 'Harry découvre le monde de la sorcellerie.', 1, '', 1),
(10, 'La Peste', 'Albert Camus', 'Les habitants d’Oran font face à une épidémie.', 1, '', 1),
(16, 'La Bibliothèque des rêves oubliés', 'Clara Moreau', 'Une jeune bibliothécaire découvre des livres capables de révéler les souvenirs oubliés de leurs lecteurs.', 1, '', 2),
(17, 'Le Dernier Train pour Marseille', 'Thomas Delcourt', 'Au cours d’un voyage en train vers Marseille, un inconnu confie à un passager un secret qui bouleverse sa vie.', 0, '', 2),
(18, 'La Bibliothèque des rêves oubliés', 'Clara Moreau', 'Une jeune bibliothécaire découvre des livres capables de révéler les souvenirs oubliés de leurs lecteurs.', 1, '', 3),
(19, 'Le Dernier Train pour Marseille', 'Thomas Delcourt', 'Au cours d’un voyage en train vers Marseille, un inconnu confie à un passager un secret qui bouleverse sa vie.', 1, '', 3),
(20, 'La Bibliothèque des rêves oubliés', 'Clara Moreau', 'Une jeune bibliothécaire découvre des livres capables de révéler les souvenirs oubliés de leurs lecteurs.', 1, '', 4),
(21, 'Le Dernier Train pour Marseille', 'Thomas Delcourt', 'Au cours d’un voyage en train vers Marseille, un inconnu confie à un passager un secret qui bouleverse sa vie.', 1, '', 4),
(22, 'La Bibliothèque des rêves oubliés', 'Clara Moreau', 'Une jeune bibliothécaire découvre des livres capables de révéler les souvenirs oubliés de leurs lecteurs.', 0, '', 5),
(23, 'Le Dernier Train pour Marseille', 'Thomas Delcourt', 'Au cours d’un voyage en train vers Marseille, un inconnu confie à un passager un secret qui bouleverse sa vie.', 1, '', 5),
(24, 'La Bibliothèque des rêves oubliés', 'Clara Moreau', 'Une jeune bibliothécaire découvre des livres capables de révéler les souvenirs oubliés de leurs lecteurs.', 1, '', 6),
(25, 'Le Dernier Train pour Marseille', 'Thomas Delcourt', 'Au cours d’un voyage en train vers Marseille, un inconnu confie à un passager un secret qui bouleverse sa vie.', 1, '', 6),
(26, 'La Bibliothèque des rêves oubliés', 'Clara Moreau', 'Une jeune bibliothécaire découvre des livres capables de révéler les souvenirs oubliés de leurs lecteurs.', 1, '', 7),
(27, 'Le Dernier Train pour Marseille', 'Thomas Delcourt', 'Au cours d’un voyage en train vers Marseille, un inconnu confie à un passager un secret qui bouleverse sa vie.', 1, '', 7),
(28, 'La Bibliothèque des rêves oubliés', 'Clara Moreau', 'Une jeune bibliothécaire découvre des livres capables de révéler les souvenirs oubliés de leurs lecteurs.', 0, '', 8),
(29, 'Le Dernier Train pour Marseille', 'Thomas Delcourt', 'Au cours d’un voyage en train vers Marseille, un inconnu confie à un passager un secret qui bouleverse sa vie.', 0, '', 8),
(30, 'La Bibliothèque des rêves oubliés', 'Clara Moreau', 'Une jeune bibliothécaire découvre des livres capables de révéler les souvenirs oubliés de leurs lecteurs.', 1, '', 9),
(31, 'Le Dernier Train pour Marseille', 'Thomas Delcourt', 'Au cours d’un voyage en train vers Marseille, un inconnu confie à un passager un secret qui bouleverse sa vie.', 0, '', 9),
(32, 'La Bibliothèque des rêves oubliés', 'Clara Moreau', 'Une jeune bibliothécaire découvre des livres capables de révéler les souvenirs oubliés de leurs lecteurs.', 1, '', 10),
(33, 'Le Dernier Train pour Marseille', 'Thomas Delcourt', 'Au cours d’un voyage en train vers Marseille, un inconnu confie à un passager un secret qui bouleverse sa vie.', 1, '', 10);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `password`, `email`) VALUES
(1, 'lolo', '$2y$12$/g069RVjHVXXWop4fgCgPOH5/znPZjME/F8k9DQErPYgYNsAOTCGW', 'lolo@example.com'),
(2, 'PlumePartage', '$2y$12$LHTnnjReskMwrzaOqsjroeTLwyz/Qdp6zUdZ9cC1eUbljJCcSFdTi', 'plume.partage@example.com'),
(3, 'BouquinBoum', '$2y$12$0u7Wn5wg4qqolD/fg1MCbOFv5FjsVu9gTVuaNHl0.D3lTWiWaEfue', 'bouquin.boum@example.com'),
(4, 'LisEtRelis', '$2y$12$7JJrmRW/YLzjzPJe9am.8.hHXponO2J0KoGBmR0VnMYagEuKoREFu', 'lis.et.relis@example.com'),
(5, 'RomanTique', '$2y$12$2UZGHOf/iRGEAzISTq0.luwhPhY5A6mTSoyN5PW7FhpiYhJeWb2Ty', 'roman.tique@example.com'),
(6, 'PasseTonLivre', '$2y$12$1NdcR2Wh/mklFTVElad.reSylf4TlOTArLQjZFx77PP0kAwgdiH0y', 'passe.ton.livre@example.com'),
(7, 'LivreOuvert', '$2y$12$tfoWYbH9uRH4lOWq5pM8ausJYq7F45u4OYt4ip7ADDax/ihOlT6iK', 'livre.ouvert@example.com'),
(8, 'ChapitreSuivant', '$2y$12$hFyKMYUrqLpiRNS4Nq5FruIffwYDY1XvomxUF.Ru75LxFgQ85Ifu.', 'chapitre.suivant@example.com'),
(9, 'PassePage', '$2y$12$PsDs9RufqRS4ZM/88ZjDZ.i.PwWzkoO9w3NJngXTbHCOxsqNBCnVC', 'passe.page@example.com'),
(10, 'BiblioPhil', '$2y$12$xKHqGF9WlL907KzKquDtheZ.rlLpE2YIxTKOv/g5H/wdV74Ks4gt6', 'biblio.phil@example.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_users` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
