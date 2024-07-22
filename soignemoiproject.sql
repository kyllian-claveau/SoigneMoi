-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : lun. 22 juil. 2024 à 19:04
-- Version du serveur : 8.0.38
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `soignemoiproject`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240720003245', '2024-07-20 00:32:48', 416),
('DoctrineMigrations\\Version20240720074604', '2024-07-20 07:46:33', 42);

-- --------------------------------------------------------

--
-- Structure de la table `prescription`
--

CREATE TABLE `prescription` (
  `id` int NOT NULL,
  `stay_id` int NOT NULL,
  `date` date NOT NULL,
  `medications` json NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `prescription`
--

INSERT INTO `prescription` (`id`, `stay_id`, `date`, `medications`, `start_date`, `end_date`) VALUES
(1, 1, '2024-07-21', '[{\"name\": \"doliprane\", \"dosage\": \"120g\"}, {\"name\": \"spasfon\", \"dosage\": \"20g\"}]', '2024-07-21', '2024-07-25'),
(2, 1, '2024-07-22', '[{\"name\": \"Doliprane\", \"dosage\": \"120g\"}]', '2024-07-22', '2024-07-26');

-- --------------------------------------------------------

--
-- Structure de la table `refresh_tokens`
--

CREATE TABLE `refresh_tokens` (
  `id` int NOT NULL,
  `refresh_token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `refresh_tokens`
--

INSERT INTO `refresh_tokens` (`id`, `refresh_token`, `username`, `valid`) VALUES
(10, '7b39d6dea0610eb8c4a6e49697de9400cdac742bfefb41e9b3cb9cc43bdbb804f19b6749709129cfbfb986b976d236f3a15ed45c0e87bda1bd30a64f7d457f5c', 'user@soignemoi.com', '2024-08-19 21:21:32'),
(11, '0fe59adccdf2f3c9052ea3e58400bb5d2fe6989cffb360e4e606504b5be7dce02ad652fdb7064ec0f944de65bbab4e41cf8c227d088a6dc58763ee52afc01137', 'admin@soignemoi.com', '2024-08-19 21:31:39'),
(12, '5e7d92e08b8394d491e71595c68e1a6a41937dbe5fee6b7c76a2aaf92840754429d12e2b8c4a9dff126c7f2b4a914fbb1581208160ba44739397e6d159009a35', 'admin@soignemoi.com', '2024-08-19 22:22:22'),
(13, '803f857d379c1a660cc7fc52dcb680af23af5eefa34c5394d61792a712ce6e76a0c2a8ba8e7c3fa869902c9f2398ff6762a09e5649184335e62e9cef20840b2e', 'user@soignemoi.com', '2024-08-19 22:29:14'),
(14, 'bc69e4056c8b8f5af15a08e37de227825ae4b33310828c5b012dc63610ff2db71bbd32a383a1111b4859c861341febe476336432ddaa76c281a31917b99216e1', 'user@soignemoi.com', '2024-08-19 22:29:50'),
(15, 'e70aafeb0dcbabc2cebcbcca38bd270b919f9bbc106ee6060ad06a5aba7ca839f2c44dcbc36676817678dd8418ee9d3b1c3d010d75b9ae5274066b85ff11b473', 'secretary@soignemoi.com', '2024-08-19 23:04:20'),
(16, '31b2a9d36be277dd0bbffff4ceb0acdddf9884d319f233fd5002ab0faa0c6df61e739bb39c5fa872cc72f1ab37d23f832096a5ec0ce9a633756877ac3a659466', 'secretary@soignemoi.com', '2024-08-19 23:05:36'),
(17, 'bdab1bfbf39b5a059684532cf60b3bdd966b31ba9edaa8bdbdbfbd29e07153ab35bb7839b43bedd3abb64ba372faad239055403f1e3398940379b94b1b5d0f8c', 'secretary@soignemoi.com', '2024-08-19 23:07:38'),
(18, 'ab2e56cb7d11898b08bdb0395e21dd7586bc4f6e82218a77abac434c437bc22f41da8eaeed81faabfb7317f2c3b51ba05a5070be75a2390168c0c6d26278066d', 'secretary@soignemoi.com', '2024-08-19 23:13:21'),
(19, '3fd41f2a2bd6cb6238ea785980b537ee1daa139a01793c573735ab69328e3d1c70536276fd7e3fb87ef9602e3bf6cbe37633b33cfe6e93790ff206a404514445', 'secretary@soignemoi.com', '2024-08-19 23:14:49'),
(20, '58b60447141b2c47edb12b48965dd94a6b269484b707bdaa0f59812c3b6da215f21f0260a4036bb76d60087e335fa6f72f3f9a500bb99bdb2dc54c7c43b9d17d', 'secretary@soignemoi.com', '2024-08-19 23:16:36'),
(21, 'b8e2d688f81768d7260c5261d01f429d95dacdf3b977132ac029af5a66be4286e37b7b700dfeb91c64e54e528cdcc5daeb1572075a29673d4e188458767c8cca', 'secretary@soignemoi.com', '2024-08-19 23:22:27'),
(22, '2c3ec41d3e1738e86cbefc49bddbe87c499ee263d3be5f9e3b58a0d5cb2153f580600c5eb7eb3b8916259a594b118fb4cd78380c18e9edb8008e182ad1111941', 'secretary@soignemoi.com', '2024-08-19 23:23:26'),
(23, 'aba2844a5659743a953bc55a23aaeafa15a6ecbc93d6109cfa731853bcba146155fcffb981cfbec40220812a013cffdb05d3fcfa4eceb85d86ed0af877db6f28', 'secretary@soignemoi.com', '2024-08-19 23:25:20'),
(24, '762fe155344907e92ba1f2bccaedee912d08c16d906252bc93879ffa385a1cecbe292181797abf13b516a3e9c6eb1999f83fe3bf5fc178b2b4fe34d9673b927f', 'secretary@soignemoi.com', '2024-08-20 11:20:20'),
(25, 'befefc9e1a22e91fda79682e93c5ba07c8012d24bc2b9e57d22b116af9785f298d127b73b4957e5fa47234cb120118bbd755cb8be66de0c49a9707c6dc5e9c92', 'secretary@soignemoi.com', '2024-08-20 11:23:47'),
(26, 'ac6f1d82894e582780c972f328b13a937f24f604422db63de07c4816f1b1b0887e6bd53bee5f2b6eb419daeb062cf0e54cf4eb3496b1278ef362d46a7c672dd7', 'secretary@soignemoi.com', '2024-08-20 11:28:42'),
(27, '2f1b8facce1257ff0c0ec34f7cda7d1a36851781f096dcc58bcd49553516f53951299a668aabfc591e40124cf289441e5f19a2a2395daa54dd3f0fb321d2b9fb', 'secretary@soignemoi.com', '2024-08-20 11:34:00'),
(28, '32cc88bb563e025fac09166a005c768db1ab8931beb9476362620d45556f2ff292713430de62a6131365eeeb62faa06dfefc15039e99394ba62b4491c9bb1293', 'secretary@soignemoi.com', '2024-08-20 11:35:47'),
(29, '8b91be7b17ce1717069e42a1773a628031b9578f0f56fba78a2f9ba2919befcf2b706b101c58f8c1f7c21ea14e86901fc1ad8daf84c0210afa3dad314515dcc2', 'secretary@soignemoi.com', '2024-08-20 11:45:56'),
(30, 'e42abd281d6435c559915659caa29d1edc506733fad14605b3280fa5fb1bbd4f5979bb21b1f5bbc053f4c99b06d8faacc1014ffe155bd5aa12e09e5a4de11112', 'secretary@soignemoi.com', '2024-08-20 11:48:12'),
(31, '825ee7d6ecfd52497746272449c7018582fac99630061f1aedb9bd5ceb4bb1f27cbe19403c1bc95320082fb0c86e95489c1465bee06a51331ecaf32ca9d276b6', 'secretary@soignemoi.com', '2024-08-20 11:58:03'),
(32, '88c487a39dcfe70d70c744f4968d2e4168a1fda3b25dceaa93d4fde66b83893a4d9bbfd74d8d5a79d011c2c8cf0ce88d6a89145bcc2c8669756113f5e8ef8744', 'secretary@soignemoi.com', '2024-08-20 12:04:03'),
(33, '90ac162eb4086d8b79c5d089a52875732e127c44486cfcfdacab812ffa95f4356dd1369997a8a5acbe62482b046b51de1c70e7f38a6ff751ee1f504ac21c2310', 'secretary@soignemoi.com', '2024-08-20 12:07:30'),
(34, '9c88e154d252807f90c621dfd6ba37d06d2cf59a09b82b4a1da0ee83f361a01e37996fc5866795e715832f9c0ca032514e8055ff78efd5f9bc27f7601214feae', 'secretary@soignemoi.com', '2024-08-20 12:12:33'),
(35, '511e0bcc879c8bf3c41dfeb4d852ccebf02f70dd7f86bb3b263639e7be4c2659903380463b98d2ad7afd68b158bf028bb1446d64d7c6a28ab2e73bc2e7cd2047', 'secretary@soignemoi.com', '2024-08-20 12:15:51'),
(36, '74791b147a26bc58616013f96478f1752d05934c7724971bf32885a6ee4f0730c53d267c148893a6c6d4f7fa550658293e8956c050e188e3d8b010bc2d046252', 'secretary@soignemoi.com', '2024-08-20 12:32:31'),
(37, '16d5dcda0b71ed1eceae7a6f7e56e470fa3c65aeabde189ae43e98e7c649656cf7c3fa19ed53dbee5084991d54144b51282b7e5cc5c3a4cf6491459d79499e51', 'secretary@soignemoi.com', '2024-08-20 12:45:59'),
(38, '34e8cd0de193788b714f90e2ef8303ae5fc571ea139bae2d4b9288be06cc2db871ccde63e2d3016949021c62dfbf36af1318466639157e8279512f8cc08c8ce7', 'secretary@soignemoi.com', '2024-08-20 12:51:02'),
(39, '2a656c1bbf6b4c07b0cc62f82916be9b0c741658b2bf398bbb156ea6a29681bd375af87096ec090a423ae013b3fccc28aa4e3cb53adf6f5b33d412fb43fafeea', 'secretary@soignemoi.com', '2024-08-20 12:58:26'),
(40, '51453bcf723517591d8501de5500dde28b31587b21cb58073111da9bc3b240008ad56c778078babea8e517aa29be8fd828687d1ecc0e35d80b4e9e74fd9dfae9', 'secretary@soignemoi.com', '2024-08-20 12:59:25'),
(41, '63f02382ae2a5275967750d4840c34e91d685e274e9d729c1a132a55c7c621fe2fe75e4c0d4cb79df65498209edc4e1e7070b50d67b28c78dd89363068d3c2fd', 'secretary@soignemoi.com', '2024-08-20 13:03:08'),
(42, 'fdfe5ff48a09da245b2bc10916ec344a1ca3ca19b2f863541dabaf953e118ed730c50cd70578bf58e4ab399be4f7b16d3fc1bff663c7d1407b13ea99ffd55003', 'secretary@soignemoi.com', '2024-08-20 13:04:18'),
(43, '3968158dfeb7277ee88b6d09a91b41c4dbe323cf681234f3a989f0b69ebc3b6e68ba27cd49a29903f2169d576c84fcbf94a2149a664efddef8d57e7b7ab359cf', 'secretary@soignemoi.com', '2024-08-20 13:06:04'),
(44, 'e5873c5bdf0d658e328dfb33189caa91f946ad4f9ef1a4059a4cfc46c77bfa6b224d8a6e4f65819a439530128b3a5d26620726c4227aa3d439b6ec2a8dac2539', 'secretary@soignemoi.com', '2024-08-20 13:10:19'),
(45, '2d7b0911b8590d614f465af3d89a006a156d888ef16ca47efeb0017e84510cc000b564da032cc50b066e4d7be4285f23a73c4111b43796f9163c39e1aca9a0ef', 'secretary@soignemoi.com', '2024-08-20 13:11:45'),
(46, 'de84419724c992dcd7001823da75cd448aabf5e6e1857b060c4027a1d25aebf428f94951e94cb01b71a67e802276a748b44836b671f4600ccb757812a1acdf3a', 'secretary@soignemoi.com', '2024-08-20 13:13:09'),
(47, '5498db503d08a04d272539e5ad1546a293d5512761b57769ca04b751b47446bfd2ad67a7f3026d9d78cd1473d537f1545294750164fc7708b782b7b362643b41', 'secretary@soignemoi.com', '2024-08-20 13:14:14'),
(48, 'f8998a3cda3d55b2c01d056c891348331b522dc893abcce63db302663c1bac26be032d7cb41e5664b6144d752ddd8b2091c85607ca47db3e4f5e62d7a6d2e9fd', 'secretary@soignemoi.com', '2024-08-20 13:16:35'),
(49, '2263acd38d739724e2fa988ae389cb104750dfdb2cf34f3a8b46871a12215f09185fb3a2b6b0f42b5edbd1ebbdd79363b66547d6fa66ef3307575e2c066b8293', 'secretary@soignemoi.com', '2024-08-20 13:21:10'),
(50, 'b9cde0dd8ebe1b81696757a8eacfbf8d473995a3ff6a11a702ece87c6c79606a6c5806dfacde00c3ca57a5fce36c70e5e5b806248e70e2bf7cbb9fd7ad14d4db', 'secretary@soignemoi.com', '2024-08-20 13:23:17'),
(51, '6068b1d41803647748e53ef8c7592a00f3e4152c7706a8195b3688633855ffbc9d31b07ac12e46deca5ae4ee0a892aaa7eb30bf0f1c40c60e3cbdfaf8f7a4086', 'secretary@soignemoi.com', '2024-08-20 13:24:37'),
(52, 'b54b6052be8deee30e36c3fcbe5a0756eac7a003f994fa52b4ba43ed452099fbe586a3327adadd2cf8e752270f2917dcf6ed53fe54a39a2068f8e12ed4bd3cb8', 'secretary@soignemoi.com', '2024-08-20 13:26:36'),
(53, '907a84954a243a4128fcf248cf84d236287d6d40877d58ca33bc4f822d0814bee96e97eaf9313d0ae0ec7fb4a85067c619dcd23653721bd878337b86d16f3305', 'secretary@soignemoi.com', '2024-08-20 13:35:51'),
(54, '575cc825353b30e20ca88c72d9c78ff6935e846d9890f31841c9e0b008f51befe45c0ce771c743d011e8f34e6a2a1e5431be8b0ca782bd2377eba54273dc9563', 'secretary@soignemoi.com', '2024-08-20 13:37:07'),
(55, 'f703f1b99f50ddb37a72f393f9afe40db18ca4ae308a23addb99029424238afe6d9d063aacb94598df4948bb8ee7e312ffd3132dd51292a414ff92d2c08dcb48', 'secretary@soignemoi.com', '2024-08-20 13:39:17'),
(56, 'cecac09e5b2ef52043a1a053ac7e3f07f7d1c97a7c826ebd0ac6c18ba3fcd8904d3acc63318ab70d67960ce1ea59120172e486dcb0667b5df0099c8fd5c6c0ca', 'secretary@soignemoi.com', '2024-08-20 13:42:38'),
(57, '257d9b0bc0d10ea5ac0bc587e4b49f390e9ff10fb9992a4c4470b89416c29beb0d11fff0700e8ac9b0a1ce91df38847ddb7f757812845ae7a7a232105d327c91', 'secretary@soignemoi.com', '2024-08-20 13:50:19'),
(58, 'b7bf171434df0f03e17eecfcc97a4aafd171cf5229edfba56e21e62f103ba3d44d690431ddb0d03c40f38da1be1a74105d68975e59169e10c9d2970928984bbe', 'doctor1@soignemoi.com', '2024-08-20 13:58:01'),
(59, '5f2193c78ee4ac9c46af74c66f44a708c05aaeed457294588f92c90e3f683b462686c36a4b97e9fd770376c6f3559bd02364618f8a9205f19e6a95605ec23f6b', 'doctor1@soignemoi.com', '2024-08-20 14:04:26'),
(60, '0f313866e739d39ac731a69f2b4a23e2627bf829b8ee8f11fc4ebd731a21588de597b9c7fc01b2b3b67cdd568235f1cf830d996042f28a9b3ef138fa5e0a3250', 'doctor1@soignemoi.com', '2024-08-20 14:08:04'),
(61, 'c589ded39202c9465b31ce634a645e16796fc6d4fdf9c26a682b6b6f17d8be56ac49864b48bd2f182c55b4015352226be79836d0e42864619a065ccc6cff061b', 'secretary@soignemoi.com', '2024-08-20 14:09:31'),
(62, '13d4329a40f982e80c8c5cb877b9dfe40b089e4fbdb9f5f60c087b149b31124f616be71231fdaadd3604c86fff8dff6815734162b8c57766d60aec2c92241962', 'secretary@soignemoi.com', '2024-08-20 14:25:44'),
(63, 'c3e5b4079300dc544c578708284c09e4c0e92b8a51da9d8fa91096fb329f3b6b0a774ac75fd1c064188f8b107ab88a5b90663a549f3e8b5016608c97ddb971f2', 'admin@soignemoi.com', '2024-08-20 14:45:36'),
(64, 'd6311b190d50c193d59522fa590ae14916fb6a516ca5b71cd70774bd48d04316e24250c0d491e86923b1a2ce6b7e1976be1aa04c4552ea6a072b7a10188f0120', 'secretary@soignemoi.com', '2024-08-20 14:45:53'),
(65, '8648dd21682e2e6583eb1a7b06b4eb68e3f910b252861145b03666392c2c758e44e6f1b2edabaf909158bc340c51721285d798e556efb2e7829822fecf736ca1', 'doctor2@soignemoi.com', '2024-08-20 15:28:33'),
(66, '2789ffecbe6f2811bcc6ace3a66d72d5e68a911f90199eec5d79158ba166f12144a7a141db31a9a720c26d9806fe43bc36edfb257614ce1014a8e0f5221d41a9', 'doctor2@soignemoi.com', '2024-08-20 15:30:16'),
(67, '3da650a6f4e6260f2ca87493acc4c3e14704bcc41905d4fdf4119f6183349f62c93048cc992561ab4f7e8f08ea94a053c2c602f5a5fc619e46e706ee29202572', 'doctor2@soignemoi.com', '2024-08-20 15:33:20'),
(68, 'affbe54d13f5e22e769cc0962e47c5cf917be71785d12de4b72c8a24e71eafc17a555dc3cfd0a7907eabc1699ed27b68afee6cf3248da35fc0e2d365b578e4e9', 'doctor2@soignemoi.com', '2024-08-20 15:37:50'),
(69, '5cce173645c08cd41392e17896baed3ee1695502a7f1344870b40bf487e49792a1d2be95cbb36bd6f11b6ad4841c759d9e7cf376b50b0f3a7e0094331524399d', 'doctor2@soignemoi.com', '2024-08-20 15:43:45'),
(70, '79e4ba9dc83cc16c40a8d758dba4d5eece8842a7144554df46e1de2ac18d6af83967364d2e7259d1ec34addc2c4f45ab03870e1cf298d0b6818108cf280d4cd2', 'doctor2@soignemoi.com', '2024-08-20 15:49:47'),
(71, '60e062ce7d8904232b421fd3222bf23f6c720dd79957274cb031337e56224ab890960f0972271e87f669272d39261c45bdbbaf9be0e4e27633bcc03ef06333fb', 'doctor2@soignemoi.com', '2024-08-20 15:53:04'),
(72, '80062b9637700809549a34f956641132f809c6f960d2e7b5b9df12251e7da7c4e08b1ca6d69ec4390d7927615b5819938a0c9c01cdc63b0a85dda202723970fc', 'doctor2@soignemoi.com', '2024-08-20 15:54:31'),
(73, '18ff7049ed856bb2e52177bc50631292fc679262cada138b545cff0bc9fedafc13421c148bcd60e2e695788fa27b77da48136b0b1204ccd9f027804afc4e8774', 'doctor2@soignemoi.com', '2024-08-20 15:56:11'),
(74, 'e534d2ee96405e6a73ba2a276334ba3ec3892374ee7a0e1b0a70e5920b3fe434aa7af02776ef29f654d5da04d6dcbadb4e553a9f27ea113edd721318ab542bc9', 'doctor2@soignemoi.com', '2024-08-20 16:04:24'),
(75, '3ed102610bc4fb653a1ebdd555152ce6f7c546ccbf10ec0a20283fe4cebdab8b288cbaca2ce220aca607f8806608ed2594958d000bf1390f4496dc09d37a2202', 'admin@soignemoi.com', '2024-08-20 18:01:06'),
(76, 'b714ea7434b0640bf103191187a50b65ca9782ae85aa6df951661c9d7ff3c4c160fba5d02cda89a0cc7df794616037d686c9d1c3ed65122671836f738168804e', 'admin@soignemoi.com', '2024-08-20 18:01:07'),
(77, '68222001fd2c043103f049c95557d88df090016b6b547550012a67eae05c04249143a910a666fb6a97614ce87605357d7539965a585b3781c98a2e117f96c26a', 'admin@soignemoi.com', '2024-08-20 18:13:06'),
(78, 'bdf916333a668088f308275ca8c37a0473e1623b1893b7129d1d0c8f77b4d85a39f87ac4925fe54e7a2d76eb4187cde9af8927e9e792eb264d12af73f25ad979', 'admin@soignemoi.com', '2024-08-20 19:48:07'),
(79, 'a06f7473869d0b0d8c71d64a3cb447e382950de04eb4d1216eddfea1d36caae95faba89586d5b7c1c27887a1f5cec89bea09757d20ad18d8257cd41b45b681ea', 'admin@soignemoi.com', '2024-08-20 20:00:10'),
(80, '785712ee60a59a8f8de2fb541c172fb68db282fe281afa7712f1273345b49abb4ad9bdf404b3c3550faa434d278336895005f025291c634968f83170da607b37', 'user@soignemoi.com', '2024-08-20 20:00:23'),
(81, '03ff7818d138011dc760267daf1da415d3863c4b3ccb234a2e8c9c9db6ae09bb7009fba4f6ade07e72028cf4477d76f7216087017eec3873c2f317c2dfa94477', 'admin@soignemoi.com', '2024-08-20 20:23:16'),
(82, '65d5f14dccbee04a7633a2d3812ddcbb166c7be1a93759039989b6d19a18024616067672526177e435c186aa21c6ee4e4784f7c3d8009a15d734ba0ae5efdeab', 'lea.cerveaux@gmail.com', '2024-08-20 20:30:04'),
(83, 'c0d54bfb4b65fa099c5b1ded0e1d84ea693c40755e382b154e1aa538a8251ab07f906e93543d1e3043aa45c81498c465919bb7faa3fec1f10e9ad15118c4090f', 'admin@soignemoi.com', '2024-08-20 20:51:25'),
(84, 'e6d9a01fbd0cbf753f0d28ef9124ab405ed5a85a266f11240abfa306d363b416c345571e073c8a4a39fe823ce29d28e6dafbc617b38be593f5353411cd2000e5', 'admin@soignemoi.com', '2024-08-20 22:08:14'),
(85, '728216648b71d151a4a9a3bd82d2b57012cf90e447637e964618e08ef6014808fee1320c30e90a273b267348cf7c32c179fc4960aabf75b17117dafc99566af4', 'admin@soignemoi.com', '2024-08-20 22:35:24'),
(86, '3297eb769728dc4e6da41e5e0da0786fbfa765d17581bf0a71383352e1dfd2a191e213c52eb7d70642d741139294637f1406cd15577e90eabd8b83fcf7cea782', 'user@soignemoi.com', '2024-08-20 23:15:59'),
(87, 'f85bea4fff3649eaa9c1d1fc86022f781fbe862d6413cc1d50a9b2fa7bf5a6798889d59b304bad7d19652d94d1d2d073b8fde202ed530c1c578fbff7c70e4e4b', 'admin@soignemoi.com', '2024-08-20 23:44:11'),
(88, '5304444e370afad0463b5d6bfc6a032620a19924abc7bb742e957dc1484d4595f245f2c111d632dd3d488b3ff18357c10561d58009acea5eb707c314c7e08ffe', 'admin@soignemoi.com', '2024-08-20 23:49:18'),
(89, 'fabd87a32b2d201a7d924d201c928bed8d66ef59de901a209bb9f8af326c4783efa6297e578bf479452b9153f52f4970c923df4624b01db02df5f5badea94984', 'doctor2@soignemoi.com', '2024-08-21 15:56:38'),
(90, 'b9d8bee579cbbb39175743f1db527c7795c26b199771f895de9057c7eed87e3ffc3f44c42b93061b0bffd8afbf630b498612d279f758f84b3a300b0244551274', 'secretary@soignemoi.com', '2024-08-21 16:22:06'),
(91, '237c7a74773905af8d87931216495c480099fd65d3c53b31895ba9c6b507101bb7c5c4c59835ca3dd2e771d9005fc7e97171be7b1794f5ce7f580ffd1680fc3b', 'admin@soignemoi.com', '2024-08-21 18:01:56'),
(92, '0156f7554a8f94abd35e6eca817437110b8759e774c55e678b5e197675d107e84dd1f5b3d52b74d9bcc6d783eb47ffd62ea67bbf82caa36810eef9aae970f4c7', 'user@soignemoi.com', '2024-08-21 18:19:36'),
(93, 'ab746cbc595d056ad99d4f5bf9656f909f1b92dc187b3eb1fe899b947fed8f7907d72347ce1c56a7510084107c67179fded0638c38c96b497865cb7b96077bd1', 'secretary@soignemoi.com', '2024-08-21 18:52:20');

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

CREATE TABLE `review` (
  `id` int NOT NULL,
  `stay_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `review`
--

INSERT INTO `review` (`id`, `stay_id`, `title`, `description`, `date`) VALUES
(1, 1, 'aaa', 'aaaa', '2024-07-21'),
(2, 1, 'Test', 'Test', '2024-07-22');

-- --------------------------------------------------------

--
-- Structure de la table `schedule`
--

CREATE TABLE `schedule` (
  `id` int NOT NULL,
  `doctor_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `schedule`
--

INSERT INTO `schedule` (`id`, `doctor_id`) VALUES
(1, 7),
(2, 8),
(3, 10);

-- --------------------------------------------------------

--
-- Structure de la table `specialty`
--

CREATE TABLE `specialty` (
  `id` int NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `specialty`
--

INSERT INTO `specialty` (`id`, `name`) VALUES
(1, 'Dentiste'),
(2, 'Généraliste');

-- --------------------------------------------------------

--
-- Structure de la table `stay`
--

CREATE TABLE `stay` (
  `id` int NOT NULL,
  `specialty_id` int NOT NULL,
  `doctor_id` int NOT NULL,
  `user_id` int NOT NULL,
  `schedule_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stay`
--

INSERT INTO `stay` (`id`, `specialty_id`, `doctor_id`, `user_id`, `schedule_id`, `start_date`, `end_date`, `reason`) VALUES
(1, 1, 8, 5, 1, '2024-07-20', '2024-07-21', 'Mal de tête');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `specialty_id` int DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` int NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `specialty_id`, `email`, `firstname`, `lastname`, `address`, `city`, `postal_code`, `roles`, `password`, `matricule`) VALUES
(5, NULL, 'user@soignemoi.com', 'Jane', 'Doe', '1 rue de la paix', 'Paris', 75000, '[\"ROLE_USER\"]', '$2y$13$NSyTIGnTha7YjPRIFoqJs.d1siC0obo5wFLoVydt3j5dqtWuOvwwK', NULL),
(6, NULL, 'admin@soignemoi.com', 'John', 'Doe', '1 rue de la paix', 'Paris', 75000, '[\"ROLE_ADMIN\"]', '$2y$13$3kG/Xmu1XkFMQEYTcR4zgeLvHeXDVVnzUGzRtqC8Qk6tQuR0ILxry', NULL),
(7, 2, 'doctor1@soignemoi.com', 'Jean', 'Dupont', '1 rue de la paix', 'Paris', 75000, '[\"ROLE_DOCTOR\"]', '$2y$13$kIDQksnvSBFc2uIBPmnQIOnMu90o50Y8yiNI6ceypuRdNYqDT72JG', '654321'),
(8, 1, 'doctor2@soignemoi.com', 'Janette', 'Martin', '1 rue de la paix', 'Paris', 75000, '[\"ROLE_DOCTOR\"]', '$2y$13$LeWwN6vMge7G.5dvny89z.nojew7AvKczIVvStbjWTiFrucyS93ga', '123456'),
(9, NULL, 'secretary@soignemoi.com', 'Jane', 'Dupont', '1 rue de la paix', 'Paris', 75000, '[\"ROLE_SECRETARY\"]', '$2y$13$0LyWMCKNRVGby22Wmc0RzeP8LeeZNgvWlPcRhxEX/m2uN6tXYrVM.', NULL),
(10, 1, 'doctor3@soignemoi.com', 'Jean', 'Martin', '58 rue de paris', 'Paris', 75000, '[\"ROLE_DOCTOR\"]', '$2y$13$ye.MjvdUrrJ1t739WD0i/OJRsDsXtzEW7QzAoSLVGmOhqp5ekoWc2', '1651300'),
(11, NULL, 'secretary2@soignemoi.com', 'tom', 'durand', '78 rue de nantes', 'nantes', 44000, '[\"ROLE_SECRETARY\"]', '$2y$13$OgsJGKb.NchEt4fbawjxfeEJtgLEzP8WAE7tmhmgOwMgp9qjub7ie', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1FBFB8D9FB3AF7D6` (`stay_id`);

--
-- Index pour la table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9BACE7E1C74F2195` (`refresh_token`);

--
-- Index pour la table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_794381C6FB3AF7D6` (`stay_id`);

--
-- Index pour la table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_5A3811FB87F4FB17` (`doctor_id`);

--
-- Index pour la table `specialty`
--
ALTER TABLE `specialty`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stay`
--
ALTER TABLE `stay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5E09839C9A353316` (`specialty_id`),
  ADD KEY `IDX_5E09839C87F4FB17` (`doctor_id`),
  ADD KEY `IDX_5E09839CA76ED395` (`user_id`),
  ADD KEY `IDX_5E09839CA40BC2D5` (`schedule_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  ADD KEY `IDX_8D93D6499A353316` (`specialty_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `specialty`
--
ALTER TABLE `specialty`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `stay`
--
ALTER TABLE `stay`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `FK_1FBFB8D9FB3AF7D6` FOREIGN KEY (`stay_id`) REFERENCES `stay` (`id`);

--
-- Contraintes pour la table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `FK_794381C6FB3AF7D6` FOREIGN KEY (`stay_id`) REFERENCES `stay` (`id`);

--
-- Contraintes pour la table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `FK_5A3811FB87F4FB17` FOREIGN KEY (`doctor_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `stay`
--
ALTER TABLE `stay`
  ADD CONSTRAINT `FK_5E09839C87F4FB17` FOREIGN KEY (`doctor_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_5E09839C9A353316` FOREIGN KEY (`specialty_id`) REFERENCES `specialty` (`id`),
  ADD CONSTRAINT `FK_5E09839CA40BC2D5` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`),
  ADD CONSTRAINT `FK_5E09839CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6499A353316` FOREIGN KEY (`specialty_id`) REFERENCES `specialty` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
