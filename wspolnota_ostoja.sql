-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Wrz 2022, 01:49
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
  `tresc_aktualnosci` text NOT NULL,
  `link` text NOT NULL,
  `autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `aktualnosci`
--

INSERT INTO `aktualnosci` (`ID_aktualnosci`, `tresc_aktualnosci`, `link`, `autor`) VALUES
(1, 'Aktualnosc nr 1', '', 0),
(2, 'Aktualnosc nr 2', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ankieta`
--

CREATE TABLE `ankieta` (
  `id` int(11) NOT NULL,
  `nazwa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `ankieta`
--

INSERT INTO `ankieta` (`id`, `nazwa`) VALUES
(1, 'Ankieta dotycząca bezpieczeństwa'),
(2, 'Budżet na rok 2023'),
(3, 'Piknik Dla Rodzin'),
(1, 'Ankieta dotycząca bezpieczeństwa'),
(2, 'Budżet na rok 2023'),
(3, 'Piknik Dla Rodzin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ankieta_odpowiedzi`
--

CREATE TABLE `ankieta_odpowiedzi` (
  `id` int(11) NOT NULL,
  `pytanie_id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `tresc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `ankieta_odpowiedzi`
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
-- Struktura tabeli dla tabeli `ankieta_pytania`
--

CREATE TABLE `ankieta_pytania` (
  `id` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `typ` int(11) NOT NULL COMMENT '0 - tekstowa\r\n1 - liczbowa (0 - 10)\r\n2 - prawda/fałsz\r\n',
  `ankieta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `ankieta_pytania`
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
(12, 'Jakich atrakcji spodziewasz się na tego typu imprezie?', 0, 3),
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
-- Struktura tabeli dla tabeli `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `pytanie` text NOT NULL,
  `odpowiedz` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `faq`
--

INSERT INTO `faq` (`id`, `pytanie`, `odpowiedz`) VALUES
(1, 'Ile mieszkań jest dostępnych?', '2000'),
(3, 'AAAAAAAAAAAAAAAAAA', 'BBBBBBBBBBBBBBBBBB');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `meetingId` int(10) UNSIGNED NOT NULL,
  `meetingDate` varchar(50) NOT NULL,
  `agenda` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`meetingId`, `meetingDate`, `agenda`) VALUES
(2, '2022-02-15 18:00:00', NULL),
(13, '2022-10-05 18:00:00', NULL),
(20, '2022-05-27  18:45:00', '1. Część 1'),
(21, '2022-11-28 15:30:00', NULL),
(23, '2022-08-18 14:15:00', NULL),
(24, '2022-09-15 16:45:00', ' Planowanie przyszłych projektów\r\n                \r\n                \r\n                                                                        '),
(25, '2022-10-24 18:00:00', NULL),
(26, '2022-09-17 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `meetingId` int(10) UNSIGNED NOT NULL,
  `meetingDate` varchar(50) NOT NULL,
  `agenda` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`meetingId`, `meetingDate`, `agenda`) VALUES
(2, '2022-02-15 18:00:00', NULL),
(13, '2022-10-05 18:00:00', NULL),
(20, '2022-05-27  18:45:00', '1. Część 1'),
(21, '2022-11-28 15:30:00', NULL),
(23, '2022-08-18 14:15:00', NULL),
(24, '2022-09-15 16:45:00', ' Planowanie przyszłych projektów\r\n                \r\n                \r\n                                                                        '),
(25, '2022-10-24 18:00:00', NULL),
(26, '2022-09-17 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `meetings`
--

CREATE TABLE `meetings` (
  `meetingId` int(10) UNSIGNED NOT NULL,
  `meetingDate` varchar(50) NOT NULL,
  `agenda` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `meetings`
--

INSERT INTO `meetings` (`meetingId`, `meetingDate`, `agenda`) VALUES
(2, '2022-02-15 18:00:00', NULL),
(13, '2022-10-05 18:00:00', NULL),
(20, '2022-05-27  18:45:00', '1. Część 1'),
(21, '2022-11-28 15:30:00', NULL),
(23, '2022-08-18 14:15:00', NULL),
(24, '2022-09-15 16:45:00', ' Planowanie przyszłych projektów\r\n                \r\n                \r\n                                                                        '),
(25, '2022-10-24 18:00:00', NULL),
(26, '2022-09-17 18:00:00', NULL);

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
(9, 'Edytowanie postów innych użytkowników'),
(10, 'Dodawanie uchwał'),
(11, 'Edytowanie i usuwanie uchwał innych uzytkowników'),
(12, 'Dodawanie aktualności'),
(13, 'Edytowanie i usuwanie aktualności innych'),
(14, 'Dodawanie faq'),
(15, 'Wyświetlanie podsumowania ankiet'),
(17, 'Dodawanie raportów'),
(18, 'Dostęp do wszystkich raportów'),
(33, 'Panel wsparcia technicznego'),
(34, 'Edytowanie detali zgłoszeń'),
(35, 'Edytowanie komentarzy zgłoszeń');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `reportId` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`reportId`, `name`, `userId`, `creationDate`) VALUES
(1, '2022-06-30', 1, '2022-08-25 15:09:52'),
(2, '2022-07-30', 1, '2022-08-25 15:10:04'),
(15, '2022-08-30 mieszkanie 45', 1, '2022-08-26 19:42:58'),
(27, '2022-06-30 Łódź ul. Szkolna 97', 219, '2022-08-27 11:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `report_fees`
--

CREATE TABLE `report_fees` (
  `feeId` int(10) UNSIGNED NOT NULL,
  `reportId` int(10) UNSIGNED NOT NULL,
  `feeName` varchar(30) NOT NULL,
  `amount` float NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_fees`
--

INSERT INTO `report_fees` (`feeId`, `reportId`, `feeName`, `amount`, `category`) VALUES
(1, 1, 'Prąd', 12547.7, 'fixed'),
(2, 1, 'Woda', 7251.4, 'fixed'),
(3, 1, 'Gaz', 5241.78, 'fixed'),
(4, 1, 'Naprawa oświetlenia', 450, 'unplanned'),
(5, 1, 'Wymiana ogrodzenia', 4500, 'long-term'),
(6, 15, 'Prąd', 450, 'fixed'),
(7, 15, 'Woda', 230, 'fixed'),
(8, 15, 'Ogrodzenie', 145, 'unplanned');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reports`
--

CREATE TABLE `reports` (
  `reportId` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `reports`
--

INSERT INTO `reports` (`reportId`, `name`, `userId`, `creationDate`) VALUES
(1, '2022-06-30', 1, '2022-08-25 17:09:52'),
(2, '2022-07-30', 1, '2022-08-25 17:10:04'),
(15, '2022-08-30 mieszkanie 45', 1, '2022-08-26 21:42:58'),
(27, '2022-06-30 Łódź ul. Szkolna 97', 219, '2022-08-27 13:21:34');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `report_fees`
--

CREATE TABLE `report_fees` (
  `feeId` int(10) UNSIGNED NOT NULL,
  `reportId` int(10) UNSIGNED NOT NULL,
  `feeName` varchar(30) NOT NULL,
  `amount` float NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `report_fees`
--

INSERT INTO `report_fees` (`feeId`, `reportId`, `feeName`, `amount`, `category`) VALUES
(1, 1, 'Prąd', 12547.7, 'fixed'),
(2, 1, 'Woda', 7251.4, 'fixed'),
(3, 1, 'Gaz', 5241.78, 'fixed'),
(4, 1, 'Naprawa oświetlenia', 450, 'unplanned'),
(5, 1, 'Wymiana ogrodzenia', 4500, 'long-term'),
(6, 15, 'Prąd', 450, 'fixed'),
(7, 15, 'Woda', 230, 'fixed'),
(8, 15, 'Ogrodzenie', 145, 'unplanned');

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
(4, 'Nikt szczególny v2'),
(5, 'sdsds'),
(10, 'Wsparcie techniczne');

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
(2, 8),
(2, 9),
(2, 1),
(3, 1),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 8),
(2, 9),
(2, 1),
(3, 1),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 17),
(1, 18),
(10, 33),
(10, 34),
(10, 35);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketId` int(6) UNSIGNED NOT NULL,
  `ticketName` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `ticketStatus` enum('OTWARTY','W TRAKCIE','ZAKOŃCZONY','ANULOWANY') DEFAULT NULL,
  `priority` enum('Krytyczny','Wysoki','Średni','Niski') DEFAULT NULL,
  `ticketDateStart` timestamp NOT NULL DEFAULT current_timestamp(),
  `ticketDateEnd` timestamp NULL DEFAULT NULL,
  `userId` int(10) UNSIGNED DEFAULT NULL,
  `ticketType` enum('Awarie','Błąd na stronie','Usprawnienie strony','Konto użytkownika') DEFAULT NULL,
  `assigneeId` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticketId`, `ticketName`, `description`, `ticketStatus`, `priority`, `ticketDateStart`, `ticketDateEnd`, `userId`, `ticketType`, `assigneeId`) VALUES
(1, 'Niedziałające oświetlenie w strefie 5B', 'Cześć,\r\n\r\nOd wczoraj przestało działać oświetlenie w strefie 5B. Nasze podejrzenie to przerwany przewód po pracach wykonywanych dziś rano przez firmę remontową.\r\n\r\nProśba o sprawdzenie i naprawienie usterki.\r\n\r\nPozdrawiam\r\nAnna', 'ZAKOŃCZONY', 'Krytyczny', '2022-09-07 19:08:37', NULL, 1, 'Awarie', 220),
(2, 'Brak połączenia z internetem w strefie 4C', NULL, 'OTWARTY', 'Krytyczny', '2022-09-03 21:24:20', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `ticketCommentId` int(10) UNSIGNED NOT NULL,
  `ticketId` int(10) UNSIGNED DEFAULT NULL,
  `userId` int(10) UNSIGNED DEFAULT NULL,
  `userName` varchar(30) NOT NULL,
  `userSurname` varchar(30) NOT NULL,
  `commentText` text NOT NULL,
  `commentDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_comments`
--

INSERT INTO `ticket_comments` (`ticketCommentId`, `ticketId`, `userId`, `userName`, `userSurname`, `commentText`, `commentDate`) VALUES
(22, 1, 220, 'Mikołaj', 'Stasiak', 'Cześć Anno,\n\nZgłoszenie przyjęte. W przeciągu 2 godzin zespół techniczny powinien być na miejscu. Będziemy Cię informować na bieżaco.\n\nPozdrawiam', '2022-09-07 19:14:46'),
(23, 1, 1, 'Anna', 'Stańczyk', 'Dziękuję ślicznie. Będę oczekiwać na informację :)', '2022-09-07 19:16:14'),
(24, 1, 220, 'Mikołaj', 'Stasiak', 'Niestety naprawa usterki zajmie dłużej niż zakładaliśmy. Prawdopodobnie zostanie ona usunięta dopiero za kilka godzin', '2022-09-07 20:05:48'),
(25, 1, 1, 'Anna', 'Stańczyk', 'Hej,\nI jak tam naprawa? Wszystko ok?', '2022-09-08 16:06:03'),
(26, 1, 220, 'Mikołaj', 'Stasiak', 'W jak najlepszym porzadku. Raport został wysłany do Marzenki z kadr', '2022-09-08 16:06:40');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uchwaly`
--

CREATE TABLE `uchwaly` (
  `ID_uchwaly` int(11) NOT NULL,
  `tresc_uchwaly` text NOT NULL,
  `link` text DEFAULT NULL,
  `autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uchwaly`
--

INSERT INTO `uchwaly` (`ID_uchwaly`, `tresc_uchwaly`, `link`, `autor`) VALUES
(1, 'Uchwała o powstaniu Wspólnoty Mieszkaniowej Ostoja', NULL, 1),
(2, 'Uchwała o powołaniu Prezydenta Wspólnoty Mieszkaniowej Ostoja', NULL, 1),
(3, 'Test', '', 1),
(4, 'Test', '', 1),
(5, 'AAAAAAAAAAAAAAA', '', 1),
(6, 'BBBBBBBBBBBBBBBBBBBBBBBB', '', 1),
(7, 'QQQQQQQQQQQQQQQQQQQ', '', 1),
(8, 'BBBBBBBBBBBBBBBBB', '', 1),
(9, 'WWWWWWWWWWWWWWWWWWw', '', 1),
(11, 'asdasdasda', '', 1),
(20, 'Cos tam sobie', '', 1),
(21, 'Ze zdjęciem', 'assets/logo.png', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uchwaly_pliki`
--

CREATE TABLE `uchwaly_pliki` (
  `id` int(11) NOT NULL,
  `uchwala_id` int(11) NOT NULL,
  `nazwa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uchwaly_pliki`
--

INSERT INTO `uchwaly_pliki` (`id`, `uchwala_id`, `nazwa`) VALUES
(5, 21, 'file1.txt'),
(6, 21, 'main.cpp'),
(8, 22, 'file1.txt'),
(9, 23, 'main.cpp');

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
('Anna', 'Stańczyk', 1, 'anna.s@gmail.com', 'ania_pass', 1),
('Jake', 'Blake', 219, 'jake.b@xyz.com', 'jakey_p', 2),
('Mikołaj', 'Stasiak', 220, 'miki@ostoja.com', 'miki_pass', 10),
('Jake', 'Blake', 219, 'jake.b@xyz.com', 'jakey_p', 2),
('Mikołaj', 'Stasiak', 220, 'miki@ostoja.com', 'miki_pass', 10);

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
(1, 2),
(1, 1),
(1, 2),
(1, 7),
(1, 17),
(1, 1),
(1, 2),
(1, 7),
(1, 17),
(1, 18),
(1, 15),
(1, 7),
(1, 17),
(1, 18);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wynajem`
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
-- Zrzut danych tabeli `wynajem`
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
-- Struktura tabeli dla tabeli `wynajem_typ`
--

CREATE TABLE `wynajem_typ` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wynajem_typ`
--

INSERT INTO `wynajem_typ` (`id`, `text`) VALUES
(1, '1-pokojowe'),
(2, '2-pokojowe'),
(3, '3-pokojowe'),
(1, '1-pokojowe'),
(2, '2-pokojowe'),
(3, '3-pokojowe');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wynajem_zdjecia`
--

CREATE TABLE `wynajem_zdjecia` (
  `id` int(11) NOT NULL,
  `mieszkanie_id` int(11) NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wynajem_zdjecia`
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
(31, 11, '3pok3c.jpg'),
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
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `aktualnosci`
--
ALTER TABLE `aktualnosci`
  ADD PRIMARY KEY (`ID_aktualnosci`);

--
-- Indeksy dla tabeli `ankieta_odpowiedzi`
--
ALTER TABLE `ankieta_odpowiedzi`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`meetingId`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`meetingId`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permissionId`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportId`),
  ADD UNIQUE KEY `UQ_rep_name` (`name`),
  ADD KEY `FK_rep_userIdr` (`userId`);

--
-- Indexes for table `report_fees`
--
ALTER TABLE `report_fees`
  ADD PRIMARY KEY (`feeId`),
  ADD KEY `FK_fee_rep_id` (`reportId`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportId`),
  ADD UNIQUE KEY `UQ_rep_name` (`name`),
  ADD KEY `FK_rep_userIdr` (`userId`);

--
-- Indexes for table `report_fees`
--
ALTER TABLE `report_fees`
  ADD PRIMARY KEY (`feeId`),
  ADD KEY `FK_fee_rep_id` (`reportId`);

--
-- Indexes for table `roles`
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
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticketId`),
  ADD KEY `FK_ticketUserId` (`userId`),
  ADD KEY `FK_assigneeId` (`assigneeId`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`ticketCommentId`),
  ADD KEY `FK_tc_ticketId` (`ticketId`),
  ADD KEY `FK_tc_userId` (`userId`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticketId`),
  ADD KEY `FK_ticketUserId` (`userId`),
  ADD KEY `FK_assigneeId` (`assigneeId`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`ticketCommentId`),
  ADD KEY `FK_tc_ticketId` (`ticketId`),
  ADD KEY `FK_tc_userId` (`userId`);

--
-- Indexes for table `uchwaly`
--
ALTER TABLE `uchwaly`
  ADD PRIMARY KEY (`ID_uchwaly`);

--
-- Indeksy dla tabeli `uchwaly_pliki`
--
ALTER TABLE `uchwaly_pliki`
  ADD PRIMARY KEY (`id`);

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
-- Indeksy dla tabeli `wynajem`
--
ALTER TABLE `wynajem`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `aktualnosci`
--
ALTER TABLE `aktualnosci`
  MODIFY `ID_aktualnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `ankieta_odpowiedzi`
--
ALTER TABLE `ankieta_odpowiedzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT dla tabeli `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `meetingId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT dla tabeli `meetings`
--
ALTER TABLE `meetings`
  MODIFY `meetingId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT dla tabeli `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permissionId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT dla tabeli `reports`
--
ALTER TABLE `reports`
  MODIFY `reportId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT dla tabeli `report_fees`
--
ALTER TABLE `report_fees`
  MODIFY `feeId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT dla tabeli `roles`
--
ALTER TABLE `roles`
  MODIFY `roleId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketId` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `ticketCommentId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT dla tabeli `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `ticketCommentId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT dla tabeli `uchwaly`
--
ALTER TABLE `uchwaly`
  MODIFY `ID_uchwaly` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT dla tabeli `wynajem`
--
ALTER TABLE `wynajem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `FK_rep_userIdr` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `report_fees`
--
ALTER TABLE `report_fees`
  ADD CONSTRAINT `FK_fee_rep_id` FOREIGN KEY (`reportId`) REFERENCES `reports` (`reportId`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `FK_rep_userIdr` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `report_fees`
--
ALTER TABLE `report_fees`
  ADD CONSTRAINT `FK_fee_rep_id` FOREIGN KEY (`reportId`) REFERENCES `reports` (`reportId`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `FK_rep_userIdr` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `report_fees`
--
ALTER TABLE `report_fees`
  ADD CONSTRAINT `FK_fee_rep_id` FOREIGN KEY (`reportId`) REFERENCES `reports` (`reportId`);

--
-- Ograniczenia dla tabeli `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `FK_rep_userIdr` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `report_fees`
--
ALTER TABLE `report_fees`
  ADD CONSTRAINT `FK_fee_rep_id` FOREIGN KEY (`reportId`) REFERENCES `reports` (`reportId`);

--
-- Ograniczenia dla tabeli `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `FK_rp_permissionId` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`permissionId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_rp_roleId` FOREIGN KEY (`roleId`) REFERENCES `roles` (`roleId`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `FK_assigneeId` FOREIGN KEY (`assigneeId`) REFERENCES `users` (`userId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ticketUserId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `FK_tc_ticketId` FOREIGN KEY (`ticketId`) REFERENCES `tickets` (`ticketId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_tc_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `FK_assigneeId` FOREIGN KEY (`assigneeId`) REFERENCES `users` (`userId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ticketUserId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Ograniczenia dla tabeli `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `FK_tc_ticketId` FOREIGN KEY (`ticketId`) REFERENCES `tickets` (`ticketId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_tc_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

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
