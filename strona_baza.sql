-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Cze 2022, 13:08
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
-- Baza danych: `strona_baza`
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
-- Indeksy dla tabeli `uchwaly`
--
ALTER TABLE `uchwaly`
  ADD PRIMARY KEY (`ID_uchwaly`);

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
-- AUTO_INCREMENT dla tabeli `uchwaly`
--
ALTER TABLE `uchwaly`
  MODIFY `ID_uchwaly` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
