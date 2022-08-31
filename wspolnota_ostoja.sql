-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 31, 2022 at 10:48 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wspolnota_ostoja`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktualnosci`
--

CREATE TABLE `aktualnosci` (
  `ID_aktualnosci` int(11) NOT NULL,
  `tresc_aktualnosci` text NOT NULL,
  `link` text NOT NULL,
  `autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aktualnosci`
--

INSERT INTO `aktualnosci` (`ID_aktualnosci`, `tresc_aktualnosci`, `link`, `autor`) VALUES
(1, 'Aktualnosc nr 1000', '', 0),
(2, 'Aktualnosc nr 2', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ankieta`
--

CREATE TABLE `ankieta` (
  `id` int(11) NOT NULL,
  `nazwa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ankieta`
--

INSERT INTO `ankieta` (`id`, `nazwa`) VALUES
(1, 'Ankieta dotycząca bezpieczeństwa'),
(2, 'Budżet na rok 2023'),
(3, 'Piknik Dla Rodzin');

-- --------------------------------------------------------

--
-- Table structure for table `ankieta_odpowiedzi`
--

CREATE TABLE `ankieta_odpowiedzi` (
  `id` int(11) NOT NULL,
  `pytanie_id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `tresc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ankieta_odpowiedzi`
--

INSERT INTO `ankieta_odpowiedzi` (`id`, `pytanie_id`, `uzytkownik_id`, `tresc`) VALUES
(60, 9, 3, 'true'),
(61, 10, 3, 'AAAAAAAAAAA'),
(62, 11, 3, 'false'),
(63, 12, 3, 'VVVVVVVVVVVVV'),
(76, 5, 3, 'true'),
(77, 6, 3, '5'),
(78, 7, 3, '2'),
(79, 8, 3, '1'),
(80, 1, 3, '6'),
(81, 2, 3, '4'),
(82, 3, 3, 'true'),
(83, 4, 3, 'true'),
(84, 1, 2, '6'),
(85, 2, 2, '6'),
(86, 3, 2, 'true'),
(87, 4, 2, 'true'),
(88, 5, 2, 'false'),
(89, 6, 2, '3'),
(90, 7, 2, '7'),
(91, 8, 2, '9'),
(92, 9, 2, 'true'),
(93, 10, 2, 'asdasdas'),
(94, 11, 2, 'true'),
(95, 12, 2, 'zxczxczxc'),
(96, 1, 1, '0'),
(97, 2, 1, '0'),
(98, 3, 1, 'true'),
(99, 4, 1, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `ankieta_pytania`
--

CREATE TABLE `ankieta_pytania` (
  `id` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `typ` int(11) NOT NULL COMMENT '0 - tekstowa\r\n1 - liczbowa (0 - 10)\r\n2 - prawda/fałsz\r\n',
  `ankieta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ankieta_pytania`
--

INSERT INTO `ankieta_pytania` (`id`, `tresc`, `typ`, `ankieta_id`) VALUES
(1, 'W skali od 0 do 10, jak oceniasz ogólny poziom bezpieczeństwa na naszym osiedlu?', 1, 1),
(2, 'W skali od 0 do 10, jak oceniasz firmę ochroniarską \"GUARDIANS\"?', 1, 1),
(3, 'Czy uważasz, że na osiedlach powinniśmy zwiększyć monitoring?', 2, 1),
(4, 'Czy sądzisz, że powinniśmy zainstalowć brameki otwierane na kod lub chip? ', 2, 1),
(5, 'Czy posiadasz samochód/korzystasz rególarnie z osiedlowego parkingu?', 2, 2),
(6, 'W skali od 0 do 10, ile budżetu powinniśmy poświęcić na poprawę infrastruktury/osiedlowych dróg i chodników?', 1, 2),
(7, 'W skali od 0 do 10, ile budżetu powinniśmy poświęcić na place zabaw?', 1, 2),
(8, 'W skali od 0 do 10, ile budżetu powinniśmy poświęcić na \"siłownie na powietrzu\"?', 1, 2),
(9, 'Czy brałeś udział w zeszłorocznym pikniku?', 2, 3),
(10, 'Co sądzisz o naszej inicjatywie (piknik dla rodzin)?', 0, 3),
(11, 'Czy wybierasz się na piknik w przyszłym roku?', 2, 3),
(12, 'Jakich atrakcji spodziewasz się na tego typu imprezie?', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permissionId` int(10) UNSIGNED NOT NULL,
  `permissionDesc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permissionId`, `permissionDesc`) VALUES
(1, 'Panel administracyjny'),
(2, 'Dodawanie użytkowników'),
(3, 'Usuwanie użytkowników'),
(4, 'Edytowanie roli'),
(5, 'Dodawanie roli'),
(6, 'Usuwanie roli'),
(7, 'Edytowanie użytkowników'),
(8, 'Dodawanie i usuwanie postów'),
(9, 'Edytowanie postów innych użytkowników'),
(10, 'Dodawanie uchwał'),
(11, 'Edytowanie i usuwanie uchwał innych uzytkowników'),
(12, 'Dodawanie aktualności'),
(13, 'Edytowanie i usuwanie aktualności innych');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleId` int(10) UNSIGNED NOT NULL,
  `roleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleId`, `roleName`) VALUES
(1, 'admin'),
(2, 'Edytor'),
(3, 'Użytkownik'),
(4, 'Nikt szczególny'),
(5, 'sdsds');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `roleId` int(10) UNSIGNED NOT NULL,
  `permissionId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`roleId`, `permissionId`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `uchwaly`
--

CREATE TABLE `uchwaly` (
  `ID_uchwaly` int(11) NOT NULL,
  `tresc_uchwaly` text NOT NULL,
  `link` text DEFAULT NULL,
  `autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uchwaly`
--

INSERT INTO `uchwaly` (`ID_uchwaly`, `tresc_uchwaly`, `link`, `autor`) VALUES
(1, 'Uchwała o powstaniu Wspólnoty Mieszkaniowej Ostoja', NULL, 2),
(2, 'Uchwała o powołaniu Prezydenta Wspólnoty Mieszkaniowej Ostoja', NULL, 1),
(3, 'Test', '', 1),
(4, 'Testttttttttttttttttt', '', 1),
(5, 'AAAAAAAAAAAAAAA', '', 1),
(6, 'BBBBBBBBBBBBBBBBBBBBBBBB', '', 1),
(7, 'QQQQQQQQQQQQQQQQQQQ', '', 1),
(8, 'BBBBBBBBBBBBBBBBB', '', 1),
(9, 'WWWWWWWWWWWWWWWWWWw', '', 1),
(11, 'asdasdasda', '', 1),
(20, 'Cos tam sobie', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `roleId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `surname`, `userId`, `email`, `password`, `roleId`) VALUES
('', '', 1, 'anna.s@gmail.com', 'ania_pass', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `userId` int(10) UNSIGNED NOT NULL,
  `permissionId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`userId`, `permissionId`) VALUES
(1, 1),
(1, 2),
(1, 10),
(1, 11),
(1, 12),
(1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `wynajem`
--

CREATE TABLE `wynajem` (
  `id` int(11) NOT NULL,
  `typ` int(11) NOT NULL,
  `czynsz` int(11) NOT NULL,
  `adres` text NOT NULL,
  `okres_wynajmu` text NOT NULL,
  `telefon` text NOT NULL,
  `dodatkowe_informacje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wynajem`
--

INSERT INTO `wynajem` (`id`, `typ`, `czynsz`, `adres`, `okres_wynajmu`, `telefon`, `dodatkowe_informacje`) VALUES
(1, 1, 1000, 'ul. Ostoja 11', '3 miesiące', '123-456-789', ''),
(2, 1, 1100, 'ul. Ostoja 12', '6 miesiący', '123-456-790', ''),
(3, 1, 1200, 'ul. Ostoja 13', '1 rok', '123-456-791', ''),
(4, 1, 1300, 'ul. Ostoja 14', '9 miesiący', '123-456-792', ''),
(5, 2, 1500, 'ul. Ostoja 15', '2 lata', '123-456-793', ''),
(6, 2, 1600, 'ul. Ostoja 16', '1 rok', '123-456-794', ''),
(7, 2, 1700, 'ul. Ostoja 17', '6 miesięcy', '123-456-795', ''),
(8, 2, 1800, 'ul. Ostoja 18', '1 miesiąc', '123-456-796', ''),
(9, 3, 2000, 'ul. Ostoja 19', '2 miesiące', '123-456-797', ''),
(10, 3, 2100, 'ul. Ostoja 20', '4 miesiące', '123-456-798', ''),
(11, 3, 2200, 'ul. Ostoja 21', '6 miesięcy', '123-456-799', ''),
(12, 3, 2300, 'ul. Ostoja 22', '1 rok', '123-456-800', '');

-- --------------------------------------------------------

--
-- Table structure for table `wynajem_typ`
--

CREATE TABLE `wynajem_typ` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wynajem_typ`
--

INSERT INTO `wynajem_typ` (`id`, `text`) VALUES
(1, '1-pokojowe'),
(2, '2-pokojowe'),
(3, '3-pokojowe');

-- --------------------------------------------------------

--
-- Table structure for table `wynajem_zdjecia`
--

CREATE TABLE `wynajem_zdjecia` (
  `id` int(11) NOT NULL,
  `mieszkanie_id` int(11) NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wynajem_zdjecia`
--

INSERT INTO `wynajem_zdjecia` (`id`, `mieszkanie_id`, `link`) VALUES
(14, 1, '1pok1a.jpg'),
(15, 2, '1pok2a.jpg'),
(16, 3, '1pok3a.jpg'),
(17, 5, '2pok1a.jpg'),
(18, 5, '2pok1b.jpg'),
(19, 6, '2pok2a.jpg'),
(20, 6, '2pok2b.jpg'),
(21, 7, '2pok3a.jpg'),
(22, 7, '2pok3b.jpg'),
(23, 9, '3pok1a.jpg'),
(24, 9, '3pok1b.jpg'),
(25, 9, '3pok1c.jpg'),
(26, 10, '3pok2a.jpg'),
(27, 10, '3pok2b.jpg'),
(28, 10, '3pok2c.jpg'),
(29, 11, '3pok3a.jpg'),
(30, 11, '3pok3b.jpg'),
(31, 11, '3pok3c.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktualnosci`
--
ALTER TABLE `aktualnosci`
  ADD PRIMARY KEY (`ID_aktualnosci`);

--
-- Indexes for table `ankieta_odpowiedzi`
--
ALTER TABLE `ankieta_odpowiedzi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permissionId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD KEY `FK_rp_roleId` (`roleId`),
  ADD KEY `FK_rp_permissionId` (`permissionId`);

--
-- Indexes for table `uchwaly`
--
ALTER TABLE `uchwaly`
  ADD PRIMARY KEY (`ID_uchwaly`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `roleId` (`roleId`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD KEY `FK_up_userId` (`userId`),
  ADD KEY `FK_up_permissionId` (`permissionId`);

--
-- Indexes for table `wynajem`
--
ALTER TABLE `wynajem`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktualnosci`
--
ALTER TABLE `aktualnosci`
  MODIFY `ID_aktualnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ankieta_odpowiedzi`
--
ALTER TABLE `ankieta_odpowiedzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permissionId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `roleId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uchwaly`
--
ALTER TABLE `uchwaly`
  MODIFY `ID_uchwaly` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `wynajem`
--
ALTER TABLE `wynajem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `FK_rp_permissionId` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`permissionId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_rp_roleId` FOREIGN KEY (`roleId`) REFERENCES `roles` (`roleId`) ON DELETE CASCADE;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `FK_up_permissionId` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`permissionId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_up_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
