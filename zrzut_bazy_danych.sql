-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Sty 2017, 16:07
-- Wersja serwera: 5.7.11
-- Wersja PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sh_books`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forChange` tinyint(1) DEFAULT NULL,
  `keyWords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addedAt` date DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `books`
--

INSERT INTO `books` (`id`, `name`, `author`, `description`, `forChange`, `keyWords`, `addedAt`, `categoryId`, `userId`, `price`) VALUES
(1, 'Książka 1', 'Autor 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, 'planeta', '2016-10-31', 1, 1, 22.33),
(2, 'Książka 2', 'Autor 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dol.', 1, 'mars', '2016-10-31', 2, 1, 10.55),
(3, 'Książka 3', 'Autor 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim laboris nisi.', NULL, 'wenus', '2016-10-31', 4, 2, 33.33),
(4, 'Książka 4', 'Autor 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim laboris nisi.', 1, 'węgiel', '2016-10-31', 12, 2, 14.99),
(5, 'Książka 6', 'Autor 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.', 1, 'urban', '2016-10-31', 10, 3, 60.99),
(6, 'Książka 1', 'Autor 5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.', NULL, 'ziemia', '2016-10-31', 9, 2, 40.87),
(7, 'Tytuł książki 7', 'Nazwa Autora', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.', 1, 'tata', '2016-10-31', 28, 2, 30),
(8, 'Tytuł książki 9', 'Nazwa autora 7', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.', NULL, NULL, '2016-10-31', 16, 1, 20),
(9, 'Tytuł książki 90', 'Nazwa autora 44', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.', 1, NULL, '2016-10-31', 13, 2, 30),
(10, 'Książka 78', 'Autor 45', 'Lorem ipsum dolor sit amet.', NULL, NULL, '2016-10-31', 15, 2, 20);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Albumy'),
(2, 'Biografie'),
(3, 'Biznes, ekonomia, marketing'),
(4, 'Dla dzieci'),
(5, 'Dla młodzieży'),
(6, 'Encyklopedie, leksykony'),
(7, 'Fantastyka'),
(8, 'Filozofia'),
(9, 'Historia'),
(10, 'Informatyka'),
(11, 'Językoznawstwo, język polski'),
(12, 'Kalendarze'),
(13, 'Komiks'),
(14, 'Kuchnia i diety'),
(15, 'Literatura'),
(16, 'Literatura faktu'),
(17, 'Literatura obyczajowa'),
(18, 'Nauka języków'),
(19, 'Nauki ścisłe, medycyna'),
(20, 'Podręczniki szkolne, edukacja'),
(21, 'Poradniki'),
(22, 'Prawo'),
(23, 'Psychologia i pedagogika'),
(24, 'Religie i wyznania'),
(25, 'Romans'),
(26, 'Rozwój osobisty, motywacja'),
(27, 'Sensacja, kryminał'),
(28, 'Socjologia'),
(29, 'Sport i wypoczynek'),
(30, 'Sztuka'),
(31, 'Thriller, horror'),
(32, 'Turystyka i podróże'),
(33, 'Zdrowie, rodzina, związki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `bookId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` smallint(6) NOT NULL,
  `bookId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `images`
--

INSERT INTO `images` (`id`, `name`, `sequence`, `bookId`) VALUES
(1, 'book1.jpg', 1, 1),
(2, 'book2.png', 2, 1),
(3, 'book3.jpg', 3, 1),
(4, 'book4.jpg', 1, 2),
(5, 'book5.png', 2, 2),
(6, 'book6.jpg', 1, 3),
(7, 'book7.jpg', 1, 4),
(8, 'book8.jpg', 1, 5),
(9, 'book9.jpg', 1, 6),
(10, 'book10.jpg', 1, 7),
(12, 'book12.png', 1, 8),
(13, 'book13.jpg', 1, 9),
(14, 'book14.jpg', 2, 9),
(15, 'book15.jpg', 1, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `phone`, `isActive`) VALUES
(1, 'Damian', 'Nowak', 'damian@gmail.com', '$2y$13$UcStZc.x7szxwm32JykjCOjzr./9Qh0VOVbln8rC/.fxV7NI8pEfW', '111 111 111', 1),
(2, 'Marcin', NULL, 'marcin@poczta.pl', '$2y$13$UcStZc.x7szxwm32JykjCOjzr./9Qh0VOVbln8rC/.fxV7NI8pEfW', NULL, 1),
(3, 'Karolina', NULL, 'karolina@poczta.pl', '$2y$13$UcStZc.x7szxwm32JykjCOjzr./9Qh0VOVbln8rC/.fxV7NI8pEfW', NULL, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4A1B2A929C370B71` (`categoryId`),
  ADD KEY `IDX_4A1B2A9264B64DCC` (`userId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E46960F5A33F7DF7` (`bookId`),
  ADD KEY `IDX_E46960F564B64DCC` (`userId`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E01FBE6AA33F7DF7` (`bookId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT dla tabeli `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT dla tabeli `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `FK_4A1B2A9264B64DCC` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_4A1B2A929C370B71` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`);

--
-- Ograniczenia dla tabeli `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `FK_E46960F564B64DCC` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_E46960F5A33F7DF7` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`);

--
-- Ograniczenia dla tabeli `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_E01FBE6AA33F7DF7` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
