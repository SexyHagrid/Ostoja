-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Sie 2022, 22:37
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wspolnota_ostoja`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aktualnosci`
--

CREATE TABLE `aktualnosci` (
  `ID_aktualnosci` int(11) NOT NULL,
  `tresc_aktualnosci` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `aktualnosci`
--

INSERT INTO `aktualnosci` (`ID_aktualnosci`, `tresc_aktualnosci`) VALUES
(1, 'Aktualnosc nr 1'),
(2, 'Aktualnosc nr 2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ankiety`
--

CREATE TABLE `ankiety` (
  `ID_ankiety` int(11) NOT NULL,
  `pseudonim` text NOT NULL,
  `pytanie_1` text NOT NULL,
  `pytanie_2` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `ankiety`
--

INSERT INTO `ankiety` (`ID_ankiety`, `pseudonim`, `pytanie_1`, `pytanie_2`) VALUES
(1, 'pawel', 'ok', 'nic'),
(2, 'pawel2', 'fajna', 'nic'),
(3, 'pawel3', 'ok..', 'nie'),
(4, 'paw4', 'ok', 'nic..'),
(5, 'aneta', 'super', 'nic'),
(6, 'wiktor', 'git', 'nic'),
(7, 'wojtek', 'eccw', 'nic'),
(8, 'pawel', 'wspaniala', 'nic');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `permissions`
--

CREATE TABLE `permissions` (
  `permissionId` int(10) UNSIGNED NOT NULL,
  `permissionDesc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `permissions`
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
(9, 'Edytowanie postów innych użytkowników');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE `roles` (
  `roleId` int(10) UNSIGNED NOT NULL,
  `roleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `roles`
--

INSERT INTO `roles` (`roleId`, `roleName`) VALUES
(1, 'admin'),
(2, 'Edytor'),
(3, 'Użytkownik'),
(4, 'Nikt szczególny'),
(5, 'sdsds');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role_permissions`
--

CREATE TABLE `role_permissions` (
  `roleId` int(10) UNSIGNED NOT NULL,
  `permissionId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `role_permissions`
--

INSERT INTO `role_permissions` (`roleId`, `permissionId`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uchwaly`
--

CREATE TABLE `uchwaly` (
  `ID_uchwaly` int(11) NOT NULL,
  `tresc_uchwaly` text NOT NULL,
  `link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uchwaly`
--

INSERT INTO `uchwaly` (`ID_uchwaly`, `tresc_uchwaly`, `link`) VALUES
(1, 'Uchwała o powstaniu Wspólnoty Mieszkaniowej Ostoja', NULL),
(2, 'Uchwała o powołaniu Prezydenta Wspólnoty Mieszkaniowej Ostoja', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
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
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`name`, `surname`, `userId`, `email`, `password`, `roleId`) VALUES
('', '', 1, 'anna.s@gmail.com', 'ania_pass', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_permissions`
--

CREATE TABLE `user_permissions` (
  `userId` int(10) UNSIGNED NOT NULL,
  `permissionId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user_permissions`
--

INSERT INTO `user_permissions` (`userId`, `permissionId`) VALUES
(1, 1),
(1, 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `aktualnosci`
--
ALTER TABLE `aktualnosci`
  ADD PRIMARY KEY (`ID_aktualnosci`);

--
-- Indeksy dla tabeli `ankiety`
--
ALTER TABLE `ankiety`
  ADD PRIMARY KEY (`ID_ankiety`);

--
-- Indeksy dla tabeli `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permissionId`);

--
-- Indeksy dla tabeli `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleId`);

--
-- Indeksy dla tabeli `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD KEY `FK_rp_roleId` (`roleId`),
  ADD KEY `FK_rp_permissionId` (`permissionId`);

--
-- Indeksy dla tabeli `uchwaly`
--
ALTER TABLE `uchwaly`
  ADD PRIMARY KEY (`ID_uchwaly`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `roleId` (`roleId`);

--
-- Indeksy dla tabeli `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD KEY `FK_up_userId` (`userId`),
  ADD KEY `FK_up_permissionId` (`permissionId`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `aktualnosci`
--
ALTER TABLE `aktualnosci`
  MODIFY `ID_aktualnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `ankiety`
--
ALTER TABLE `ankiety`
  MODIFY `ID_ankiety` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permissionId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `roles`
--
ALTER TABLE `roles`
  MODIFY `roleId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `uchwaly`
--
ALTER TABLE `uchwaly`
  MODIFY `ID_uchwaly` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `FK_rp_permissionId` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`permissionId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_rp_roleId` FOREIGN KEY (`roleId`) REFERENCES `roles` (`roleId`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `FK_up_permissionId` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`permissionId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_up_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
