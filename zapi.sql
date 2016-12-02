-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 16 Novembre 2016 à 17:15
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `zapi`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fonction` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `admins`
--

INSERT INTO `admins` (`id`, `name`, `phone`, `fonction`) VALUES
(2, 'admin', '+225 08 87 46 97', 'Super Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `cast`
--

CREATE TABLE `cast` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `function` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `presentation` longtext COLLATE utf8_unicode_ci NOT NULL,
  `staring` tinyint(1) DEFAULT NULL,
  `published_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `content_changed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `created_by`, `updated_by`, `name`, `slug`, `created_at`, `updated_at`, `content_changed_at`) VALUES
(6, 2, 2, 'Article', 'article', '2016-09-27 15:05:42', '2016-09-27 15:05:42', NULL),
(7, 2, 2, 'Affairage', 'affairage', '2016-09-27 15:05:42', '2016-09-27 15:05:42', NULL),
(8, 2, 2, 'Célébrité', 'celebrite', '2016-09-27 15:05:42', '2016-09-27 15:05:42', NULL),
(9, 2, 2, 'Showtime', 'showtime', '2016-09-27 15:05:42', '2016-09-27 15:05:42', NULL),
(10, 2, 2, 'News', 'news', '2016-09-27 15:05:42', '2016-09-27 15:05:42', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `code`
--

CREATE TABLE `code` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `profil_id` int(11) NOT NULL,
  `professionnel_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `professionalisme` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `recomendation` int(11) NOT NULL,
  `commentaire` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id` int(11) NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `lastLogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `compte`
--

INSERT INTO `compte` (`id`, `pass`, `created`, `modified`, `lastLogin`) VALUES
(3, '4OwsRDYd', '2016-09-29 12:55:39', '2016-09-29 12:55:39', NULL),
(7, 'xv6owKTO', '2016-09-30 08:05:11', '2016-09-30 08:05:11', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `professionnel_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `TypeMessage` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `disponible`
--

CREATE TABLE `disponible` (
  `id` int(11) NOT NULL,
  `docteur_id` int(11) NOT NULL,
  `heure` time NOT NULL,
  `heureFin` time NOT NULL,
  `jour_id` int(11) DEFAULT NULL,
  `creno` int(11) NOT NULL,
  `domicile` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `disponible`
--

INSERT INTO `disponible` (`id`, `docteur_id`, `heure`, `heureFin`, `jour_id`, `creno`, `domicile`) VALUES
(17, 1, '11:07:00', '11:10:00', 2, 10, 0),
(18, 1, '15:00:00', '20:18:00', 1, 10, 0),
(19, 1, '06:00:00', '18:00:00', 4, 25, 1);

-- --------------------------------------------------------

--
-- Structure de la table `docteur`
--

CREATE TABLE `docteur` (
  `id` int(11) NOT NULL,
  `professionnel_id` int(11) NOT NULL,
  `remove` tinyint(1) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `titre_id` int(11) DEFAULT NULL,
  `compte_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `docteur`
--

INSERT INTO `docteur` (`id`, `professionnel_id`, `remove`, `nom`, `mail`, `tel`, `created`, `modified`, `image_id`, `titre_id`, `compte_id`) VALUES
(1, 5, 0, 'KOUASSI', 'charles.kouassi@gmail.com', '08874697', '2016-09-29 12:55:39', '2016-09-29 13:13:09', 3, 4, 3),
(4, 5, 0, 'KOUASSI', 'kouassi@gmail.com', '08874697', '2016-09-30 08:05:10', '2016-09-30 08:13:14', NULL, 2, 7);

-- --------------------------------------------------------

--
-- Structure de la table `docteur_liste_specialite`
--

CREATE TABLE `docteur_liste_specialite` (
  `docteur_id` int(11) NOT NULL,
  `liste_specialite_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `docteur_liste_specialite`
--

INSERT INTO `docteur_liste_specialite` (`docteur_id`, `liste_specialite_id`) VALUES
(4, 1),
(4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `ext_translations`
--

CREATE TABLE `ext_translations` (
  `id` int(11) NOT NULL,
  `locale` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `galeries`
--

CREATE TABLE `galeries` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `galleryimage`
--

CREATE TABLE `galleryimage` (
  `id` int(11) NOT NULL,
  `professionnel_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `gallery_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gallery_videos`
--

CREATE TABLE `gallery_videos` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `setting_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `images`
--

INSERT INTO `images` (`id`, `setting_id`, `url`, `alt`) VALUES
(3, NULL, 'jpeg', 'emotionheader.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `jour`
--

CREATE TABLE `jour` (
  `id` int(11) NOT NULL,
  `libele` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `anglais` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `jour`
--

INSERT INTO `jour` (`id`, `libele`, `anglais`) VALUES
(1, 'Lundi', 'Monday'),
(2, 'Mardi', 'Tuesday'),
(3, 'Mercredi', 'Wednesday'),
(4, 'Jeudi', 'Thursday'),
(5, 'Vendredi', 'Friday'),
(6, 'Samedi', 'Saturday'),
(7, 'Dimanche', 'Sunday');

-- --------------------------------------------------------

--
-- Structure de la table `liste_specialite`
--

CREATE TABLE `liste_specialite` (
  `id` int(11) NOT NULL,
  `libele` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `liste_specialite`
--

INSERT INTO `liste_specialite` (`id`, `libele`, `description`) VALUES
(1, 'Généraliste', NULL),
(2, 'Dentiste', NULL),
(3, 'Dermatologue', NULL),
(4, 'Gynécologue', NULL),
(5, 'Ophtalmologue', NULL),
(6, 'Ostéopathe', NULL),
(7, 'Pédiatre', NULL),
(8, 'ORL', NULL),
(9, 'Acousticien', NULL),
(10, 'Acupuncteur', NULL),
(11, 'Addictologue', NULL),
(12, 'Allergologue', NULL),
(13, 'Allergo-pneumo-pédiatre', NULL),
(14, 'Andrologue', NULL),
(15, 'Anesthésiste', NULL),
(16, 'Andrologue', NULL),
(17, 'Auriculothérapeute', NULL),
(18, 'Bilan Lunettes Express', NULL),
(19, 'Bilan REF', NULL),
(20, 'Cancérologue', NULL),
(21, 'Cardiologue', NULL),
(22, 'Chiropracteur', NULL),
(23, 'Chirurgie de la main', NULL),
(24, 'Chirurgie de la main', NULL),
(25, 'Chirurgie de l`obésité morbide', NULL),
(26, 'Chirurgie dermatologique', NULL),
(27, 'Chirurgie digestive', NULL),
(28, 'esthétique', NULL),
(29, 'Chirurgie générale', NULL),
(30, 'Chirurgie pédiatrique', NULL),
(31, 'Chirurgie réparatrice', NULL),
(32, 'Chirurgien cervico-facial', NULL),
(33, 'Chirurgien Dentiste', NULL),
(34, 'Chirurgien maxillo-facial', NULL),
(35, 'Chirurgien orthopédiste', NULL),
(36, 'Chirurgien plasticien', NULL),
(37, 'Chirurgien vasculaire', NULL),
(38, 'Chirurgien vasculaire', NULL),
(39, 'Chirurgien Viscéral', NULL),
(40, 'Contactologie', NULL),
(41, 'Cosmétologue', NULL),
(42, 'Cryolipolyse', NULL),
(43, 'Dentiste', NULL),
(44, 'Dermatologue', NULL),
(45, 'Dermographe esthétique', NULL),
(46, 'Dermographe médical et esthétique', NULL),
(47, 'Diabétologue', NULL),
(48, 'Diététicien', NULL),
(49, 'Echographie gynécologique', NULL),
(50, 'Endocrinologue', NULL),
(51, 'Epilation laser', NULL),
(52, 'Esthéticienne', NULL),
(53, 'Etiopathe', NULL),
(54, 'Gastro-entérologue', NULL),
(55, 'Généraliste', NULL),
(56, 'Gériatre', NULL),
(57, 'Gynécologue', NULL),
(58, 'Haptonomie', NULL),
(59, 'Homéopathe', NULL),
(60, 'Hypnothérapeute', NULL),
(61, 'Immunologiste', NULL),
(62, 'Implantologie', NULL),
(63, 'IRM', NULL),
(64, 'Kinésithérapeute', NULL),
(65, 'Laboratoire d`analyse', NULL),
(66, 'Médecin aéronautique', NULL),
(67, 'Médecin de la reproduction', NULL),
(68, 'Médecin du sport', NULL),
(69, 'Médecin thermal', NULL),
(70, 'Medecin urgentiste', NULL),
(71, 'Médecine chinoise', NULL),
(72, 'Médecine Douce', NULL),
(73, 'Médecine du sommeil', NULL),
(74, 'Médecine esthétique', NULL),
(75, 'Médecine interne', NULL),
(76, 'Médecine tropicale', NULL),
(77, 'Mésothérapeute', NULL),
(78, 'Micro-Nutritionniste', NULL),
(79, 'Neurochirurgien', NULL),
(80, 'Neurologue', NULL),
(81, 'Neuropsychologue', NULL),
(82, 'Nutritionniste', NULL),
(83, 'Obstétricien', NULL),
(84, 'Oligothérapie', NULL),
(85, 'Ophtalmologue', NULL),
(86, 'ORL', NULL),
(87, 'Orthèsiste', NULL),
(88, 'Orthodontiste', NULL),
(89, 'Anesthésiste', NULL),
(90, 'Orthopédiste', NULL),
(91, 'Orthophoniste', NULL),
(92, 'Orthoptiste', NULL),
(93, 'Ostéopathe', NULL),
(94, 'Othorinologue', NULL),
(95, 'Pédiatre', NULL),
(96, 'Pédopsychiatre', NULL),
(97, 'Phlebologue', NULL),
(98, 'Phoniatre', NULL),
(99, 'Phytothérapie', NULL),
(100, 'Pneumologue', NULL),
(101, 'Podologue', NULL),
(102, 'Posturologue', NULL),
(103, 'Préadaptation lentilles', NULL),
(104, 'Proctologue', NULL),
(105, 'Prothesiste', NULL),
(106, 'Psychiatre', NULL),
(107, 'Psychiatre de couple', NULL),
(108, 'Psychanalyste', NULL),
(109, 'Psychiatre familliale', NULL),
(110, 'Psychologue', NULL),
(111, 'Psychologue - Neuropsychologue', NULL),
(112, 'Psychothérapeute', NULL),
(113, 'Rééducation vestibulaire', NULL),
(114, 'Réflexologue', NULL),
(115, 'Renouvellement lentilles', NULL),
(116, 'Rhumatologue', NULL),
(117, 'Sage Femme', NULL),
(118, 'Sexologue', NULL),
(119, 'Sophrologue', NULL),
(120, 'Spécialiste perte de cheveux et greffe', NULL),
(121, 'Stomatologue', NULL),
(122, 'Tabacologue', NULL),
(123, 'Thérapeute de couple', NULL),
(124, 'Thérapeute familliale', NULL),
(125, 'Thérapie cognitive et comportementale', NULL),
(126, 'Thérapie EMDR', NULL),
(127, 'Traumatologue', NULL),
(128, 'Urologue', NULL),
(129, 'Vaccination Voyage', NULL),
(130, 'Vénérologue', NULL),
(131, 'Vétérinaire', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `modification`
--

CREATE TABLE `modification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `commentaire` longtext COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `profil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `modification`
--

INSERT INTO `modification` (`id`, `user_id`, `commentaire`, `created`, `modified`, `profil_id`) VALUES
(5, 12, 'Juste valider et tout va bien', '2016-09-30 16:21:21', '2016-09-30 16:21:21', 7);

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `indicatif` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `pays`
--

INSERT INTO `pays` (`id`, `nom`, `code`, `indicatif`) VALUES
(9, 'Bénin', 'BJ', '+229'),
(10, 'Burkina Faso', 'BF', '+226'),
(11, 'Côte d''Ivoire', 'CI', '+225'),
(12, 'Guinée-Bissau', 'GW', '+245'),
(13, 'Mali', 'ML', '+223'),
(14, 'Niger', 'NE', '+227'),
(15, 'Sénégal', 'SN', '+221'),
(16, 'Togo', 'TG', '+228');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `published_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `posts_sub_categories`
--

CREATE TABLE `posts_sub_categories` (
  `post_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professionnel`
--

CREATE TABLE `professionnel` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dure` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ouverture` time NOT NULL,
  `fermeture` time NOT NULL,
  `jour` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `presentation` longtext COLLATE utf8_unicode_ci NOT NULL,
  `tarif` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `localisation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `langue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `fixe` varchar(225) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `professionnel`
--

INSERT INTO `professionnel` (`id`, `user_id`, `nom`, `tel`, `ville`, `dure`, `ouverture`, `fermeture`, `jour`, `presentation`, `tarif`, `localisation`, `url`, `langue`, `created`, `modified`, `fixe`) VALUES
(5, 12, 'Grace', '454651298', 'Abidjan', '40 minutes', '04:03:00', '07:05:00', 'DU LUNDI AU SAMEDI', '<p>En mode test , tout va bien&nbsp;</p>', '3000 F', 'Yopougon', NULL, 'Francais', '2016-09-28 14:48:03', '2016-09-30 17:47:06', '235052787');

-- --------------------------------------------------------

--
-- Structure de la table `profils`
--

CREATE TABLE `profils` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nom` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `dateNaissance` date NOT NULL,
  `lieuNaissance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `groupeSanguin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assurer` tinyint(1) NOT NULL,
  `CompagnieAssurance` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numeroAssurance` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `professionnel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `profils`
--

INSERT INTO `profils` (`id`, `user_id`, `nom`, `tel`, `prenom`, `dateNaissance`, `lieuNaissance`, `ville`, `groupeSanguin`, `assurer`, `CompagnieAssurance`, `numeroAssurance`, `note`, `created`, `modified`, `professionnel_id`) VALUES
(5, 7, 'BATIONO', '08874697', 'Aristide Laurent Fabrice', '1916-01-01', 'Yopougon', 'abidjan', '0+', 1, 'ALIZ', '010101', 'ok', '2016-09-28 12:01:18', '2016-09-28 12:01:18', NULL),
(6, 13, 'BATIONO', '8874697', 'Aristide Laurent Fabrice', '1991-09-27', 'Yopougon', 'abidjan', '0+', 1, 'ALIZ', '010101', 'test', '2016-09-30 12:09:43', '2016-09-30 12:09:43', NULL),
(7, 14, 'BATIONO', '078441025', 'Aristide Laurent Fabrice', '1991-09-27', 'Yopougon', 'abidjan', 'A+', 1, 'ALIZ', '010101', 'Tous va bien l''ami', '2016-09-30 12:19:07', '2016-09-30 16:21:21', 5),
(8, 15, 'BATIONO', '06251258', 'Aristide Laurent Fabrice', '1932-04-19', 'Yopougon', 'abidjan', NULL, 0, NULL, NULL, NULL, '2016-09-30 13:14:26', '2016-09-30 15:38:36', 5);

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `docteur_id` int(11) NOT NULL,
  `profil_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `statut` int(11) NOT NULL,
  `commentaire` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `menu_image_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` longtext COLLATE utf8_unicode_ci,
  `description` longtext COLLATE utf8_unicode_ci,
  `about` longtext COLLATE utf8_unicode_ci,
  `trailer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

CREATE TABLE `specialite` (
  `id` int(11) NOT NULL,
  `professionnel_id` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `libele_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `specialite`
--

INSERT INTO `specialite` (`id`, `professionnel_id`, `prix`, `created`, `modified`, `libele_id`) VALUES
(6, 5, 2000, '2016-09-29 11:42:06', '2016-09-29 11:42:06', 10),
(7, 5, 3000, '2016-09-29 11:42:24', '2016-09-29 11:42:24', 15);

-- --------------------------------------------------------

--
-- Structure de la table `specialite_liste_specialite`
--

CREATE TABLE `specialite_liste_specialite` (
  `specialite_id` int(11) NOT NULL,
  `liste_specialite_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `content_changed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `states`
--

INSERT INTO `states` (`id`, `created_by`, `updated_by`, `name`, `slug`, `created_at`, `updated_at`, `content_changed_at`) VALUES
(5, 2, 2, 'Publié', 'publie', '2016-09-27 15:05:42', '2016-09-27 15:05:42', NULL),
(6, 2, 2, 'En attente de relecture', 'en-attente-de-relecture', '2016-09-27 15:05:42', '2016-09-27 15:05:42', NULL),
(7, 2, 2, 'Brouillon', 'brouillon', '2016-09-27 15:05:42', '2016-09-27 15:05:42', NULL),
(8, 2, 2, 'Corbeille', 'corbeille', '2016-09-27 15:05:42', '2016-09-27 15:05:42', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `content_changed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `titre`
--

CREATE TABLE `titre` (
  `id` int(11) NOT NULL,
  `libele` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `titre`
--

INSERT INTO `titre` (`id`, `libele`, `description`) VALUES
(1, 'Docteur', NULL),
(2, 'Professeur', NULL),
(3, 'Madame', NULL),
(4, 'Mademoiselle', NULL),
(5, 'Monsieur', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `profil_id` int(11) DEFAULT NULL,
  `professionnel_id` int(11) DEFAULT NULL,
  `star_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pays_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `profil_id`, `professionnel_id`, `star_id`, `admin_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `avatar`, `pays_id`) VALUES
(2, NULL, NULL, NULL, 2, 'admin', 'admin', 'aristide.bationo@eweb-solutionn.com', 'aristide.bationo@eweb-solutionn.com', 1, 'ak8462z9d14wswgwkw88oss8ow04k4o', '$2y$13$Ctui5jEQG5GtPW3sN9c.SOGmqN0ATQ81GC9N6nYVp1NCPvoJ/1a0i', '2016-10-02 14:09:58', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'png', NULL),
(7, 5, NULL, NULL, NULL, 'aristide.lazzurent@gmaill.com', 'aristide.lazzurent@gmaill.com', 'aristide.lazzurent@gmaill.com', 'aristide.lazzurent@gmaill.com', 1, '2apwo63imftw8ws4o8w8wo4o8gwcco0', '$2y$13$oCVCw0T06919ckYFeQE.6.MFNIjV0.Q92NahzJIFUEUUum2MFQzoy', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'jpeg', 11),
(12, NULL, 5, NULL, NULL, 'aristide.bationo@eweb-solution.com', 'aristide.bationo@eweb-solution.com', 'aristide.bationo@eweb-solution.com', 'aristide.bationo@eweb-solution.com', 1, 'd7vbr7q0p80sc808wckckksgggsggsw', '$2y$13$rOmR0rLLb6Sjn9wPSZQPI.4wE7rAZfhnWxND3EPivpTfOtw.SjM0u', '2016-10-02 14:14:05', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'png', 11),
(13, 6, NULL, NULL, NULL, 'aristide.laurent@gmaill.com', 'aristide.laurent@gmaill.com', 'aristide.laurent@gmaill.com', 'aristide.laurent@gmaill.com', 1, '2l1jw5foih6o88coswcgos40scgoc44', '$2y$13$AEW.LHOzH6n70B97iryi0ucVdpymmSf.wRaYHDyCFzgFEiEPqmdDe', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'png', 12),
(14, 7, NULL, NULL, NULL, 'aristide.bationo@rdvmedecine.com', 'aristide.bationo@rdvmedecine.com', 'aristide.bationo@rdvmedecine.com', 'aristide.bationo@rdvmedecine.com', 1, 'm2u9ufkyfy84wgcgswc0koow40c8wks', '$2y$13$l3uxWyk5AmlkS4kGjrhOs.4ClmHa8r5fx7meS2oPUzHQwMpZjpC/2', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'jpeg', 11),
(15, 8, NULL, NULL, NULL, 'aristide.laurent@gmail.com', 'aristide.laurent@gmail.com', 'aristide.laurent@gmail.com', 'aristide.laurent@gmail.com', 1, 'jrm9ks7ss9sgks448k0w4sc0cc08kck', '$2y$13$9DFmJWIs4rtYEAiebuX31eW6rvLbLfY26KbS0wWrHuTKw1HzbOOBm', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'png', 10);

-- --------------------------------------------------------

--
-- Structure de la table `users_groups`
--

CREATE TABLE `users_groups` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `users_groups`
--

INSERT INTO `users_groups` (`user_id`, `group_id`) VALUES
(2, 5),
(3, 8),
(4, 8),
(5, 8),
(6, 8),
(7, 8),
(8, 7),
(9, 7),
(10, 7),
(11, 7),
(12, 7),
(13, 8),
(14, 8),
(15, 8);

-- --------------------------------------------------------

--
-- Structure de la table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`, `roles`) VALUES
(5, 'Super Administrateur', 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}'),
(6, 'Administrateur', 'a:1:{i:0;s:10:"ROLE_ADMIN";}'),
(7, 'Pro', 'a:1:{i:0;s:8:"ROLE_PRO";}'),
(8, 'Profil', 'a:1:{i:0;s:9:"ROLE_USER";}');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cast`
--
ALTER TABLE `cast`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_12B8B9F63DA5256D` (`image_id`),
  ADD KEY `IDX_12B8B9F65D83CC1` (`state_id`),
  ADD KEY `IDX_12B8B9F6DE12AB56` (`created_by`),
  ADD KEY `IDX_12B8B9F616FE72E1` (`updated_by`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3AF34668DE12AB56` (`created_by`),
  ADD KEY `IDX_3AF3466816FE72E1` (`updated_by`);

--
-- Index pour la table `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_77153098A76ED395` (`user_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5F9E962A275ED078` (`profil_id`),
  ADD KEY `IDX_5F9E962A8A49CC82` (`professionnel_id`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4C62E6388A49CC82` (`professionnel_id`);

--
-- Index pour la table `disponible`
--
ALTER TABLE `disponible`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23BCDFC3CF22540A` (`docteur_id`),
  ADD KEY `IDX_23BCDFC3220C6AD0` (`jour_id`);

--
-- Index pour la table `docteur`
--
ALTER TABLE `docteur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_83A7A4393DA5256D` (`image_id`),
  ADD UNIQUE KEY `UNIQ_83A7A439F2C56620` (`compte_id`),
  ADD KEY `IDX_83A7A4398A49CC82` (`professionnel_id`),
  ADD KEY `IDX_83A7A439D54FAE5E` (`titre_id`);

--
-- Index pour la table `docteur_liste_specialite`
--
ALTER TABLE `docteur_liste_specialite`
  ADD PRIMARY KEY (`docteur_id`,`liste_specialite_id`),
  ADD KEY `IDX_391BEAB1CF22540A` (`docteur_id`),
  ADD KEY `IDX_391BEAB15C3BDB91` (`liste_specialite_id`);

--
-- Index pour la table `ext_translations`
--
ALTER TABLE `ext_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lookup_unique_idx` (`locale`,`object_class`,`field`,`foreign_key`),
  ADD KEY `translations_lookup_idx` (`locale`,`object_class`,`foreign_key`);

--
-- Index pour la table `galeries`
--
ALTER TABLE `galeries`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `galleryimage`
--
ALTER TABLE `galleryimage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D2F7A8348A49CC82` (`professionnel_id`);

--
-- Index pour la table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_429C52C83DA5256D` (`image_id`),
  ADD KEY `IDX_429C52C84E7AF8F` (`gallery_id`),
  ADD KEY `IDX_429C52C8DE12AB56` (`created_by`),
  ADD KEY `IDX_429C52C816FE72E1` (`updated_by`);

--
-- Index pour la table `gallery_videos`
--
ALTER TABLE `gallery_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8B298890DE12AB56` (`created_by`),
  ADD KEY `IDX_8B29889016FE72E1` (`updated_by`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E01FBE6AEE35BD72` (`setting_id`);

--
-- Index pour la table `jour`
--
ALTER TABLE `jour`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `liste_specialite`
--
ALTER TABLE `liste_specialite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modification`
--
ALTER TABLE `modification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EF6425D2A76ED395` (`user_id`),
  ADD KEY `IDX_EF6425D2275ED078` (`profil_id`);

--
-- Index pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_7E8585C8E7927C74` (`email`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_885DBAFA3DA5256D` (`image_id`),
  ADD KEY `IDX_885DBAFA5D83CC1` (`state_id`),
  ADD KEY `IDX_885DBAFADE12AB56` (`created_by`),
  ADD KEY `IDX_885DBAFA16FE72E1` (`updated_by`);

--
-- Index pour la table `posts_sub_categories`
--
ALTER TABLE `posts_sub_categories`
  ADD PRIMARY KEY (`post_id`,`sub_category_id`),
  ADD KEY `IDX_376AE0F74B89032C` (`post_id`),
  ADD KEY `IDX_376AE0F7F7BFE87C` (`sub_category_id`);

--
-- Index pour la table `professionnel`
--
ALTER TABLE `professionnel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_7A28C10FA76ED395` (`user_id`);

--
-- Index pour la table `profils`
--
ALTER TABLE `profils`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_75831F5EA76ED395` (`user_id`),
  ADD KEY `IDX_75831F5E8A49CC82` (`professionnel_id`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_10C31F86CF22540A` (`docteur_id`),
  ADD KEY `IDX_10C31F86275ED078` (`profil_id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E545A0C511F460FB` (`menu_image_id`);

--
-- Index pour la table `specialite`
--
ALTER TABLE `specialite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E7D6FCC18A49CC82` (`professionnel_id`),
  ADD KEY `IDX_E7D6FCC11ED09FF4` (`libele_id`);

--
-- Index pour la table `specialite_liste_specialite`
--
ALTER TABLE `specialite_liste_specialite`
  ADD PRIMARY KEY (`specialite_id`,`liste_specialite_id`),
  ADD KEY `IDX_90AFF6E92195E0F0` (`specialite_id`),
  ADD KEY `IDX_90AFF6E95C3BDB91` (`liste_specialite_id`);

--
-- Index pour la table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_31C2774DDE12AB56` (`created_by`),
  ADD KEY `IDX_31C2774D16FE72E1` (`updated_by`);

--
-- Index pour la table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1638D5A512469DE2` (`category_id`),
  ADD KEY `IDX_1638D5A5F7BFE87C` (`sub_category_id`),
  ADD KEY `IDX_1638D5A5DE12AB56` (`created_by`),
  ADD KEY `IDX_1638D5A516FE72E1` (`updated_by`);

--
-- Index pour la table `titre`
--
ALTER TABLE `titre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_FF7747B47175FC81` (`libele`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_1483A5E9275ED078` (`profil_id`),
  ADD UNIQUE KEY `UNIQ_1483A5E98A49CC82` (`professionnel_id`),
  ADD UNIQUE KEY `UNIQ_1483A5E92C3B70D7` (`star_id`),
  ADD UNIQUE KEY `UNIQ_1483A5E9642B8210` (`admin_id`),
  ADD KEY `IDX_1483A5E9A6E44244` (`pays_id`);

--
-- Index pour la table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `IDX_FF8AB7E0A76ED395` (`user_id`),
  ADD KEY `IDX_FF8AB7E0FE54D947` (`group_id`);

--
-- Index pour la table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_953F224D5E237E06` (`name`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `cast`
--
ALTER TABLE `cast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `code`
--
ALTER TABLE `code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `disponible`
--
ALTER TABLE `disponible`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `docteur`
--
ALTER TABLE `docteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `ext_translations`
--
ALTER TABLE `ext_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `galeries`
--
ALTER TABLE `galeries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `galleryimage`
--
ALTER TABLE `galleryimage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `gallery_videos`
--
ALTER TABLE `gallery_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `jour`
--
ALTER TABLE `jour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `liste_specialite`
--
ALTER TABLE `liste_specialite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `modification`
--
ALTER TABLE `modification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `professionnel`
--
ALTER TABLE `professionnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `profils`
--
ALTER TABLE `profils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `specialite`
--
ALTER TABLE `specialite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `titre`
--
ALTER TABLE `titre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `cast`
--
ALTER TABLE `cast`
  ADD CONSTRAINT `FK_12B8B9F616FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_12B8B9F63DA5256D` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `FK_12B8B9F65D83CC1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `FK_12B8B9F6DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `FK_3AF3466816FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_3AF34668DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `code`
--
ALTER TABLE `code`
  ADD CONSTRAINT `FK_77153098A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_5F9E962A275ED078` FOREIGN KEY (`profil_id`) REFERENCES `profils` (`id`),
  ADD CONSTRAINT `FK_5F9E962A8A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`);

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `FK_4C62E6388A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`);

--
-- Contraintes pour la table `disponible`
--
ALTER TABLE `disponible`
  ADD CONSTRAINT `FK_23BCDFC3220C6AD0` FOREIGN KEY (`jour_id`) REFERENCES `jour` (`id`),
  ADD CONSTRAINT `FK_23BCDFC3CF22540A` FOREIGN KEY (`docteur_id`) REFERENCES `docteur` (`id`);

--
-- Contraintes pour la table `docteur`
--
ALTER TABLE `docteur`
  ADD CONSTRAINT `FK_83A7A4393DA5256D` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `FK_83A7A4398A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`),
  ADD CONSTRAINT `FK_83A7A439D54FAE5E` FOREIGN KEY (`titre_id`) REFERENCES `titre` (`id`),
  ADD CONSTRAINT `FK_83A7A439F2C56620` FOREIGN KEY (`compte_id`) REFERENCES `compte` (`id`);

--
-- Contraintes pour la table `docteur_liste_specialite`
--
ALTER TABLE `docteur_liste_specialite`
  ADD CONSTRAINT `FK_391BEAB15C3BDB91` FOREIGN KEY (`liste_specialite_id`) REFERENCES `liste_specialite` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_391BEAB1CF22540A` FOREIGN KEY (`docteur_id`) REFERENCES `docteur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `galleryimage`
--
ALTER TABLE `galleryimage`
  ADD CONSTRAINT `FK_D2F7A8348A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`);

--
-- Contraintes pour la table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `FK_429C52C816FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_429C52C83DA5256D` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `FK_429C52C84E7AF8F` FOREIGN KEY (`gallery_id`) REFERENCES `galeries` (`id`),
  ADD CONSTRAINT `FK_429C52C8DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `gallery_videos`
--
ALTER TABLE `gallery_videos`
  ADD CONSTRAINT `FK_8B29889016FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_8B298890DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_E01FBE6AEE35BD72` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`);

--
-- Contraintes pour la table `modification`
--
ALTER TABLE `modification`
  ADD CONSTRAINT `FK_EF6425D2275ED078` FOREIGN KEY (`profil_id`) REFERENCES `profils` (`id`),
  ADD CONSTRAINT `FK_EF6425D2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_885DBAFA16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_885DBAFA3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `FK_885DBAFA5D83CC1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `FK_885DBAFADE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `posts_sub_categories`
--
ALTER TABLE `posts_sub_categories`
  ADD CONSTRAINT `FK_376AE0F74B89032C` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `FK_376AE0F7F7BFE87C` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`);

--
-- Contraintes pour la table `professionnel`
--
ALTER TABLE `professionnel`
  ADD CONSTRAINT `FK_7A28C10FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `profils`
--
ALTER TABLE `profils`
  ADD CONSTRAINT `FK_75831F5E8A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`),
  ADD CONSTRAINT `FK_75831F5EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `FK_10C31F86275ED078` FOREIGN KEY (`profil_id`) REFERENCES `profils` (`id`),
  ADD CONSTRAINT `FK_10C31F86CF22540A` FOREIGN KEY (`docteur_id`) REFERENCES `docteur` (`id`);

--
-- Contraintes pour la table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `FK_E545A0C511F460FB` FOREIGN KEY (`menu_image_id`) REFERENCES `images` (`id`);

--
-- Contraintes pour la table `specialite`
--
ALTER TABLE `specialite`
  ADD CONSTRAINT `FK_E7D6FCC11ED09FF4` FOREIGN KEY (`libele_id`) REFERENCES `liste_specialite` (`id`),
  ADD CONSTRAINT `FK_E7D6FCC18A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`);

--
-- Contraintes pour la table `specialite_liste_specialite`
--
ALTER TABLE `specialite_liste_specialite`
  ADD CONSTRAINT `FK_90AFF6E92195E0F0` FOREIGN KEY (`specialite_id`) REFERENCES `specialite` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_90AFF6E95C3BDB91` FOREIGN KEY (`liste_specialite_id`) REFERENCES `liste_specialite` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `FK_31C2774D16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_31C2774DDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `FK_1638D5A512469DE2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `FK_1638D5A516FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_1638D5A5DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_1638D5A5F7BFE87C` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_1483A5E9275ED078` FOREIGN KEY (`profil_id`) REFERENCES `profils` (`id`),
  ADD CONSTRAINT `FK_1483A5E92C3B70D7` FOREIGN KEY (`star_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `FK_1483A5E9642B8210` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `FK_1483A5E98A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`),
  ADD CONSTRAINT `FK_1483A5E9A6E44244` FOREIGN KEY (`pays_id`) REFERENCES `pays` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
