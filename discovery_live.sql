-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 02 avr. 2026 à 16:41
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
-- Base de données : `discovery_live`
--

-- --------------------------------------------------------

--
-- Structure de la table `concerts`
--

CREATE TABLE `concerts` (
  `id` int(11) NOT NULL,
  `artiste` varchar(100) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `date_concert` date NOT NULL,
  `heure` time NOT NULL DEFAULT '20:30:00',
  `id_salle` int(11) NOT NULL,
  `prix_min` decimal(6,2) DEFAULT NULL,
  `prix_max` decimal(6,2) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `lien_reservation` varchar(300) DEFAULT NULL,
  `lien_spotify` varchar(255) DEFAULT NULL,
  `lien_youtube` varchar(255) DEFAULT NULL,
  `lien_applemusic` varchar(255) DEFAULT NULL,
  `lien_deezer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `concerts`
--

INSERT INTO `concerts` (`id`, `artiste`, `genre`, `date_concert`, `heure`, `id_salle`, `prix_min`, `prix_max`, `image`, `description`, `lien_reservation`, `lien_spotify`, `lien_youtube`, `lien_applemusic`, `lien_deezer`) VALUES
(1, 'Novelists', 'metal', '2025-11-19', '20:30:00', 2, 18.00, 25.00, 'IMAGES/novelists.jpg', 'Novelists est un groupe français de metal moderne connu pour son mélange puissant de riffs techniques, de mélodies aériennes et d\'émotions intenses.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(2, 'Devourment', 'metal', '2025-12-12', '20:00:00', 1, 22.00, 30.00, 'IMAGES/devourment.jpg', 'Death Metal Brutal américain à son paroxysme. Une performance live dévastratrice.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(3, 'Myrath', 'metal', '2026-10-16', '20:00:00', 2, 60.00, 90.00, 'IMAGES/myrath.jpg', 'Groupe franco-tunisien de Blazing Desert Metal, Myrath mêle riffs puissants et mélodies orientales envoûtantes.', 'https://access-live.net/Myrath-billet-concert-france-2026', 'https://open.spotify.com/artist/72500XOYPw5e7OgFWuW2Gl', 'https://www.youtube.com/channel/UCBZIyqn0Jl66ndrxT1I6qwA', 'https://music.apple.com/us/artist/myrath/317299570', 'https://www.deezer.com/en/artist/246392'),
(4, 'Behemoth', 'metal', '2026-02-25', '20:00:00', 2, 35.00, 50.00, 'IMAGES/behemoth.jpg', 'Géants du Blackened Death Metal polonais, Behemoth offre un spectacle visuel et sonore d\'une intensité rare.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(5, 'Maneskin', 'rock', '2026-02-03', '20:30:00', 14, 45.00, 75.00, 'IMAGES/maneskin.jpg', 'Le groupe de rock alternatif italien qui a conquis l\'Europe. Énergie scénique explosive garantie.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(6, 'Skillet', 'rock', '2026-02-10', '20:00:00', 2, 30.00, 45.00, 'IMAGES/skillet.jpg', 'Rock chrétien américain à l\'énergie communicative. Skillet est connu pour ses concerts enflammés.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(7, 'Foo Fighters', 'rock', '2026-03-17', '20:30:00', 3, 55.00, 90.00, 'IMAGES/foofighters.jpg', 'Les légendes du rock américain de retour en France pour une soirée mémorable.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(8, 'Kendrick Lamar', 'rap', '2026-04-15', '21:00:00', 3, 65.00, 120.00, 'IMAGES/kendrick.jpg', 'Le rappeur de Compton, lauréat du prix Pulitzer, s\'arrête à Bordeaux pour un show exceptionnel.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(9, 'Joey Bada$$', 'rap', '2026-04-21', '20:30:00', 2, 35.00, 50.00, 'IMAGES/joeybadas.jpg', 'Représentant de l\'East Coast old school, Joey Bada$$ livre des performances intenses et précises.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(10, 'Travis Scott', 'rap', '2026-05-28', '21:00:00', 3, 70.00, 130.00, 'IMAGES/travisscott.jpg', 'Le maître de la trap et des expériences immersives. Un show Travis Scott est une autre dimension.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(11, 'Julien Doré', 'variete', '2025-11-28', '20:30:00', 3, 35.00, 55.00, 'IMAGES/juliendore.jpg', 'Julien Doré en tournée pour son dernier album. Pop folk douce et poétique dans une grande salle.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(12, 'Angèle', 'variete', '2026-04-02', '20:30:00', 3, 40.00, 65.00, 'IMAGES/angele.jpg', 'La star belge de la pop revient avec son univers coloré et ses tubes imparables.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(13, 'Zaz', 'variete', '2026-04-08', '20:00:00', 5, 30.00, 45.00, 'IMAGES/zaz.jpg', 'La voix envoûtante de Zaz pour une soirée variété chaleureuse dans un cadre intimiste.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(14, 'Vianney', 'variete', '2026-04-15', '20:30:00', 2, 28.00, 40.00, 'IMAGES/vianney.jpg', 'Chanson française sincère et mélodique. Vianney touche droit au cœur à chaque concert.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(15, 'Yamè', 'variete', '2025-11-28', '20:30:00', 2, 15.00, 22.00, 'IMAGES/yame.jpg', 'Artiste rap/soul bordelais en pleine ascension. Un concert à ne pas manquer.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(16, 'Héléna', 'variete', '2025-12-03', '20:30:00', 3, 20.00, 35.00, 'IMAGES/helena.jpg', 'Pop française fraîche et sincère. Héléna séduit par sa voix cristalline et ses textes poétiques.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(17, 'Damian Marley', 'reggae', '2026-05-14', '20:30:00', 2, 30.00, 45.00, 'IMAGES/damianmarley.jpg', 'Le fils de Bob Marley perpétue et réinvente le reggae roots avec une énergie communicative.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(18, 'Biga*Ranx', 'reggae', '2026-05-20', '20:30:00', 4, 20.00, 30.00, 'IMAGES/bigaranx.jpg', 'Figure incontournable du reggae digital français, Biga*Ranx enflamme les salles depuis 15 ans.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(19, 'SOJA', 'reggae', '2026-05-27', '20:00:00', 2, 25.00, 38.00, 'IMAGES/soja.jpg', 'Reggae fusion américain aux textes engagés et aux mélodies profondes.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(20, 'Daft Punk', 'electro', '2026-06-01', '22:00:00', 3, 60.00, 100.00, 'IMAGES/daftpunk.jpg', 'Les robots français du French Touch pour une soirée mythique. Si ça se produit, ne le ratez pas.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(21, 'Madeon', 'electro', '2026-06-09', '22:00:00', 2, 35.00, 55.00, 'IMAGES/madeon.jpg', 'Prodige de l\'electro pop française, Madeon offre des sets visuels et sonores époustouflants.', 'https://www.fnacspectacles.com', NULL, NULL, NULL, NULL),
(22, 'Justice', 'electro', '2026-06-15', '22:00:00', 14, 45.00, 70.00, 'IMAGES/justice.jpg', 'Le duo parisien de l\'electro rock au son lourd et distinctif. Un live Justice est une expérience.', 'https://www.ticketmaster.fr', NULL, NULL, NULL, NULL),
(23, 'Nana Sapritch', 'rock', '2026-05-08', '21:00:00', 7, 0.00, 0.00, 'IMAGES/factice.avif', 'Quatuor féminin bordelais au son mélodieux et puissant. Rock alternatif local à découvrir absolument au Pulp.', '', NULL, NULL, NULL, NULL),
(24, 'Placid Parc', 'rock', '2026-05-15', '21:00:00', 6, 0.00, 0.00, 'IMAGES/factice.avif', 'Groupe d\'indie rock bordelais aux mélodies douces et riffs percutants. Une belle découverte de la scène locale au Molotov.', '', NULL, NULL, NULL, NULL),
(25, 'Fetish', 'rock', '2026-05-22', '20:00:00', 7, 0.00, 0.00, 'IMAGES/factice.avif', 'Dark wave bordelaise à l\'ambiance gothique et immersive. Un concert intimiste et envoûtant au Pulp.', '', NULL, NULL, NULL, NULL),
(26, 'Adieu Valentine', 'rock', '2026-06-05', '21:00:00', 8, 0.00, 0.00, 'IMAGES/factice.avif', 'Rock alternatif bordelais aux textes engagés en français. Énergie brute fusionnant rock, rap et électro.', '', NULL, NULL, NULL, NULL),
(27, 'St. Franck', 'electro', '2026-06-12', '22:00:00', 6, 0.00, 0.00, 'IMAGES/factice.avif', 'Projet electro pop rock bordelais aux influences indie rock. Un son à la Tame Impala ou MGMT, à vivre au Molotov.', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `propositions`
--

CREATE TABLE `propositions` (
  `id` int(11) NOT NULL,
  `artiste` varchar(100) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `date_concert` date NOT NULL,
  `salle` varchar(150) DEFAULT NULL,
  `lien_billetterie` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_soumission` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `propositions`
--

INSERT INTO `propositions` (`id`, `artiste`, `genre`, `date_concert`, `salle`, `lien_billetterie`, `email`, `date_soumission`) VALUES
(1, 'The Barking Spiders', 'rock', '2026-06-21', 'Deux Es Machina', 'https://www.fnacspectacles.com/?srsltid=AfmBOoqUjwFUA4UZjTeumje1eVpdUQTcGw3j9nwmrctiCfNdRkBaXsvQ', 'soual.clara@gmail.com', '2026-04-02 14:23:30');

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL DEFAULT 'Bordeaux',
  `adresse` varchar(200) DEFAULT NULL,
  `capacite` int(11) DEFAULT NULL,
  `type` enum('bar','salle','zenith','arena','festival') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`id`, `nom`, `ville`, `adresse`, `capacite`, `type`) VALUES
(1, 'Rock School Barbey', 'Bordeaux', '18 Cours Barbey, 33800 Bordeaux', 500, 'salle'),
(2, 'Rocher de Palmer', 'Cenon', '1 Rue Aristide Briand, 33150 Cenon', 1200, 'salle'),
(3, 'Arkéa Arena', 'Floirac', '68 Rue Jacques Ellul, 33100 Floirac', 16000, 'arena'),
(4, 'Krakatoa', 'Mérignac', '3 Rue Guynemer, 33700 Mérignac', 700, 'salle'),
(5, 'TnBA — Théâtre du Port de la Lune', 'Bordeaux', '3 Place Renaudel, 33800 Bordeaux', 700, 'salle'),
(6, 'Le Molotov', 'Bordeaux', '26 Pl. Fernand Lafargue, 33000 Bordeaux', 200, 'bar'),
(7, 'Le Pulp', 'Bordeaux', '25 Rue Piliers de Tutelle, 33000 Bordeaux', 150, 'bar'),
(8, 'L\'Aliénor', 'Bordeaux', '19 Rue du Parlement Sainte-Catherine, 33000 Bordeaux', 100, 'bar'),
(9, 'Le Bootlegger', 'Bordeaux', '6 Rue des Remparts, 33000 Bordeaux', 120, 'bar'),
(10, 'Le Void', 'Bordeaux', '14 Rue du Mirail, 33000 Bordeaux', 80, 'bar'),
(11, 'Salle des Fêtes du Grand Parc', 'Bordeaux', 'Rue Achard, 33300 Bordeaux', 400, 'salle'),
(12, 'Le Glob Théâtre', 'Bordeaux', '69 Rue Joséphine, 33300 Bordeaux', 300, 'salle'),
(13, 'Base sous-marine', 'Bordeaux', 'Boulevard Alfred Daney, 33300 Bordeaux', 1500, 'salle'),
(14, 'Médoquine', 'Talence', 'Rue du Médoquine, 33400 Talence', 6000, 'zenith');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `concerts`
--
ALTER TABLE `concerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_salle` (`id_salle`);

--
-- Index pour la table `propositions`
--
ALTER TABLE `propositions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `salles`
--
ALTER TABLE `salles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `concerts`
--
ALTER TABLE `concerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `propositions`
--
ALTER TABLE `propositions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `concerts`
--
ALTER TABLE `concerts`
  ADD CONSTRAINT `concerts_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
