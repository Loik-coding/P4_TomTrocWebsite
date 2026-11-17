-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 17 nov. 2026 à 09:29
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
(3, 'The Kinkfolk Table', 'Nathan Williams', 'J\'ai récemment plongé dans les pages de \'The Kinfolk Table\' et j\'ai été enchanté par cette œuvre captivante. Ce livre va bien au-delà d\'une simple collection de recettes ; il célèbre l\'art de partager des moments authentiques autour de la table. \r\n\r\nLes photographies magnifiques et le ton chaleureux captivent dès le départ, transportant le lecteur dans un voyage à travers des recettes et des histoires qui mettent en avant la beauté de la simplicité et de la convivialité. \r\n\r\nChaque page est une invitation à ralentir, à savourer et à créer des souvenirs durables avec les êtres chers. \r\n\r\n\'The Kinfolk Table\' incarne parfaitement l\'esprit de la cuisine et de la camaraderie, et il est certain que ce livre trouvera une place spéciale dans le cœur de tout amoureux de la cuisine et des rencontres inspirantes.', 1, 'images/books/book_3_fde2c89000430c10.jpg', 1),
(4, 'Le Comte de Monte-Cristo', 'Alexandre Dumas', 'Victime d\'un complot, Edmond Dantès est injustement emprisonné au château d\'If le jour même de son mariage. Après quatorze années de captivité, il parvient à s\'évader et découvre un fabuleux trésor. Devenu le mystérieux comte de Monte-Cristo, il revient pour retrouver ceux qui l\'ont trahi et orchestrer une vengeance implacable. Un chef-d\'œuvre d\'Alexandre Dumas mêlant aventure, amour, trahison et justice.', 1, 'images/books/book_4_99ba473585db6f11.jpg', 1),
(5, 'Madame Bovary', 'Gustave Flaubert', 'Emma Bovary, jeune femme rêveuse mariée à un médecin de campagne, étouffe dans une existence provinciale qui ne répond pas à ses aspirations romantiques. En quête de passion, de luxe et d\'évasion, elle multiplie les aventures amoureuses et les dépenses démesurées. Mais ses illusions se heurtent peu à peu à la réalité, l\'entraînant dans une spirale tragique. Un chef-d\'œuvre de Gustave Flaubert sur les désillusions et les rêves inaccessibles.', 1, 'images/books/book_5_ba6e5257c7a9f30c.jpg', 1),
(6, 'Vingt mille lieues sous les mers', 'Jules Verne', 'Lorsqu\'un mystérieux monstre marin menace les navires, le professeur Aronnax, son domestique Conseil et le harponneur Ned Land partent à sa recherche. Capturés par le capitaine Nemo, ils découvrent le Nautilus, un incroyable sous-marin qui les entraîne dans une aventure extraordinaire à travers les océans. Entre découvertes scientifiques, paysages fascinants et mystères des profondeurs, Jules Verne signe un grand classique de l\'aventure et de l\'imaginaire.', 1, 'images/books/book_6_2561bfd6ea722b69.jpg', 1),
(8, 'Orgueil et Préjugés', 'Jane Austen', 'Elizabeth Bennet, jeune femme intelligente et indépendante, voit sa vie bouleversée par sa rencontre avec le mystérieux et orgueilleux Mr Darcy. Entre premières impressions, malentendus et différences sociales, une relation complexe se dessine peu à peu. Chacun devra dépasser ses préjugés et remettre en question ses certitudes pour découvrir les véritables sentiments qui les unissent. Jane Austen signe une œuvre incontournable sur l\'amour, les conventions sociales et la condition féminine.', 1, 'images/books/book_8_112b4e46c6a7add4.webp', 1),
(9, 'Harry Potter à l’école des sorciers', 'J. K. Rowling', 'Orphelin élevé par une famille qui le déteste, Harry Potter découvre le jour de ses onze ans qu\'il est un sorcier et qu\'il est attendu à Poudlard, une prestigieuse école de magie. Entre amitiés, sortilèges et aventures extraordinaires, il découvre un univers fascinant, mais aussi les mystères entourant la mort de ses parents et son propre passé. Le début d\'une saga magique signée J.K. Rowling, où courage, amitié et mystère se rencontrent.', 1, 'images/books/book_9_71f9a869050364d8.jpg', 1),
(16, 'Company of One', 'Paul Jarvis', 'Dans un monde où la croissance est souvent considérée comme le symbole ultime de la réussite, Paul Jarvis propose une autre vision de l\'entrepreneuriat. À travers des conseils concrets et des réflexions inspirantes, il démontre qu\'il est possible de bâtir une entreprise rentable et durable sans chercher à grossir indéfiniment. Un ouvrage incontournable pour repenser le succès, privilégier l\'indépendance et créer une activité à son image.', 1, 'images/books/livre11.jpg', 2),
(17, 'Your soul is a river', 'Nikita Gill', 'À travers une poésie délicate et profondément touchante, Nikita Gill explore les blessures de l\'âme, l\'amour, la perte et la reconstruction de soi. Comme une rivière qui poursuit son chemin malgré les obstacles, chaque être humain porte en lui la force de guérir et de renaître. Un recueil inspirant qui invite à accueillir ses émotions, à retrouver sa lumière intérieure et à découvrir la beauté de sa propre résilience.', 0, 'images/books/livre12.jpg', 2),
(36, 'Le seigneur des anneaux : le retour du roi', 'J.R.R Tolkien', 'Le Retour du Roi, ultime volet du Seigneur des Anneaux de J.R.R. Tolkien, scelle le destin de la Terre du Milieu. Tandis qu\'Aragorn mène l\'ultime combat des hommes contre les armées de Sauron pour revendiquer son trône, les hobbits Frodon et Sam progressent au cœur du Mordor. Leur but : détruire l\'Anneau Unique. Un chef-d\'œuvre de fantasy épique alliant bravoure, sacrifice et amitié.', 1, 'images/books/profile_36_8cd57bd6efbd0e52.jpg', 1),
(42, 'milk and honey', 'Rupi Kaur', 'À travers une poésie libre et des illustrations épurées, Rupi Kaur explore les grandes étapes de la vie émotionnelle et intime : la douleur, l\'amour, la rupture et la guérison. Divisé en quatre parties, Milk and Honey raconte le cheminement d\'une femme qui apprend à surmonter ses blessures, à retrouver sa force et à s\'aimer pleinement. Un recueil poignant et lumineux sur la résilience, la féminité et la reconstruction de soi.', 1, 'images/books/book_42_107bbe5490ad57db.jpg', 10),
(44, 'The girl who loved Tom Gordon', 'Stephen King', 'Lors d\'une randonnée en forêt avec sa mère et son frère, Trisha, une fillette de neuf ans, s\'égare et se retrouve seule dans l\'immensité sauvage. Avec pour seule compagnie son imagination et son walkman diffusant les matchs de baseball de son idole, Tom Gordon, elle tente de survivre. Mais bientôt, la forêt semble abriter une présence inquiétante qui la traque. Stephen King livre un récit haletant où peur, courage et instinct de survie se mêlent.', 1, 'images/books/book_44_de06ac0f65a2b57b.jpg', 11),
(45, 'The psychology of money', 'Morgan Housel', 'Pourquoi certaines personnes réussissent-elles à bâtir une fortune tandis que d\'autres peinent à préserver leur argent ? Morgan Housel explore les comportements, les émotions et les croyances qui façonnent notre rapport à l\'argent. À travers des histoires captivantes et des exemples concrets, il révèle que la réussite financière dépend moins des connaissances techniques que de notre capacité à prendre de bonnes décisions. Un livre essentiel pour mieux comprendre l\'argent, investir avec sagesse et construire une liberté financière durable.', 1, 'images/books/book_new_ad38926098a01e4d.jpg', 2),
(46, 'Zero to one', 'Peter Thiel', 'Comment créer une entreprise véritablement innovante plutôt que de simplement reproduire ce qui existe déjà ? Dans Zero to One, Peter Thiel, entrepreneur et cofondateur de PayPal, partage sa vision de l\'innovation et de l\'entrepreneuriat. Il encourage à penser différemment, à remettre en question les idées établies et à développer des projets uniques capables de transformer leur marché. Un ouvrage stimulant pour celles et ceux qui souhaitent bâtir des entreprises ambitieuses et créer une réelle valeur.', 1, 'images/books/book_new_92400f500399328f.jpg', 2);

-- --------------------------------------------------------

--
-- Structure de la table `messenger`
--

CREATE TABLE `messenger` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messenger`
--

INSERT INTO `messenger` (`id`, `sender_id`, `receiver_id`, `date`, `content`) VALUES
(1, 1, 2, '2026-11-04 15:00:00', 'Salut Plume comment tu va ?'),
(2, 2, 1, '2026-11-05 06:00:00', 'Salut Loïk, écoute ça va super, j\'ai lu plein de nouveaux livres depuis ! :)'),
(3, 3, 1, '2026-11-06 19:09:09', 'Salut Loik, \r\nest-ce que ton livre Le seigneur des anneaux est toujours dispo ?'),
(4, 1, 3, '2026-11-06 19:10:24', 'Salut, oui il est toujours dispo ! Je peux l\'envoyer rapidement ! :)'),
(5, 3, 1, '2026-11-06 19:11:29', 'Ah super nouvelle ! Je t\'envoi le bordereau d\'expédition dans la journée.'),
(6, 3, 1, '2026-11-06 19:12:08', 'Voilà le bordereau :\r\n#0215648641251651COL'),
(7, 1, 3, '2026-11-06 19:12:32', 'C\'est bon, le livre vient de partir. \r\nBonne journée'),
(8, 3, 1, '2026-11-06 19:13:04', 'Merci Loïk pour ta réactivité, j\'ai hâte de le lire ! Je te dis quand je l\'aurais reçu.\r\nBonne journée !'),
(9, 1, 4, '2026-11-06 20:10:23', 'Bonsoir, \r\nAs-tu terminé de lire le Hobbit ?\r\nJ\'ai quelqu\'un d\'autre qui voudrait le lire. A+'),
(29, 1, 4, '2026-11-06 21:42:56', 'Salut, tu as bien reçu mon dernier message ?'),
(30, 2, 1, '2026-11-07 13:45:55', 'ceci est un test'),
(31, 1, 2, '2026-11-12 14:03:31', 'test'),
(43, 1, 11, '2026-11-16 11:30:04', 'Bonjour ErnandesKiliBocou,\r\n\r\nTon livre ceci est un test de messagerie m\'intéresse, est-il toujours disponible ?'),
(48, 1, 3, '2026-11-16 15:22:54', 'Salut, as-tu bien reçu mon livre ?'),
(49, 1, 11, '2026-11-16 20:22:51', 'salut, comment tu vas ?');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `register_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `password`, `email`, `profile_picture`, `register_date`) VALUES
(1, 'Loïklecture66', '$2y$10$eY8BIIdFl010rqlcoejmdOPqZfEQbT0QLZD3ciyW59c6VB/b3YQNO', 'lolo@example.com', 'images/users/user_1_aa43c92c0b37c3a7.jpg', '2026-02-11 21:40:40'),
(2, 'PlumePartage', '$2y$10$1Th5kowA4HEqmqVuyV.LReG7efLXkegoB1LiX6pS8KlHihVjelSZ2', 'plume.partage@example.com', 'images/users/profil2.jpg', '2026-11-02 21:40:40'),
(3, 'BouquinBoum', '$2y$12$0u7Wn5wg4qqolD/fg1MCbOFv5FjsVu9gTVuaNHl0.D3lTWiWaEfue', 'bouquin.boum@example.com', 'images/users/profil3.jpg', '2026-11-02 21:40:40'),
(4, 'LisEtRelis', '$2y$12$7JJrmRW/YLzjzPJe9am.8.hHXponO2J0KoGBmR0VnMYagEuKoREFu', 'lis.et.relis@example.com', 'images/users/profil4.jpg', '2026-11-02 21:40:40'),
(5, 'RomanTique', '$2y$12$2UZGHOf/iRGEAzISTq0.luwhPhY5A6mTSoyN5PW7FhpiYhJeWb2Ty', 'roman.tique@example.com', 'images/users/profil5.jpg', '2026-11-02 21:40:40'),
(6, 'PasseTonLivre', '$2y$12$1NdcR2Wh/mklFTVElad.reSylf4TlOTArLQjZFx77PP0kAwgdiH0y', 'passe.ton.livre@example.com', '', '2026-11-02 21:40:40'),
(7, 'LivreOuvert', '$2y$12$tfoWYbH9uRH4lOWq5pM8ausJYq7F45u4OYt4ip7ADDax/ihOlT6iK', 'livre.ouvert@example.com', '', '2026-11-02 21:40:40'),
(8, 'ChapitreSuivant', '$2y$12$hFyKMYUrqLpiRNS4Nq5FruIffwYDY1XvomxUF.Ru75LxFgQ85Ifu.', 'chapitre.suivant@example.com', '', '2026-11-02 21:40:40'),
(9, 'PassePage', '$2y$12$PsDs9RufqRS4ZM/88ZjDZ.i.PwWzkoO9w3NJngXTbHCOxsqNBCnVC', 'passe.page@example.com', '', '2026-11-02 21:40:40'),
(10, 'BiblioPhil', '$2y$12$xKHqGF9WlL907KzKquDtheZ.rlLpE2YIxTKOv/g5H/wdV74Ks4gt6', 'biblio.phil@example.com', '', '2026-11-02 21:40:40'),
(11, 'ErnandesKiliBocou', '$2a$12$JCVjyuAhLw1xXOLbJC6vie5oIYYIQS705meSvMPzW4hiqVBua2RF2', 'ernandes@hotmail.fr', 'images/users/profil5.jpg', '2026-11-02 21:40:40'),
(12, 'aaaa', '$2y$10$4Jw8gof9iraZ7Lc0v5EqoOl6y59aUMTA9H.olr2.PKwS9fNHwuaPW', 'aadzeabd@hotmail.fr', '', '2026-11-02 21:40:40');

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
-- Index pour la table `messenger`
--
ALTER TABLE `messenger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_from_user` (`sender_id`) USING BTREE,
  ADD KEY `fk_messenger_to_user` (`receiver_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `messenger`
--
ALTER TABLE `messenger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `messenger`
--
ALTER TABLE `messenger`
  ADD CONSTRAINT `fk_messenger_from_user` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_messenger_to_user` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
