-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 09 jan 2018 om 21:34
-- Serverversie: 5.7.14
-- PHP-versie: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tovuti`
--
DROP DATABASE IF EXISTS `tovuti`;
CREATE SCHEMA IF NOT EXISTS `tovuti` DEFAULT CHARACTER SET utf8;
USE `tovuti`;
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `class`
--

CREATE TABLE `class` (
  `class_ID` varchar(255) NOT NULL,
  `Name` varchar(15) NOT NULL,
  `Year` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `class`
--

INSERT INTO `class` (`class_ID`, `Name`, `Year`) VALUES
('741AD801-EA2B-4585-BD30-5EB97F75C00C', 'TCOC42A', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `email_confirm`
--

CREATE TABLE `email_confirm` (
  `user_ID` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `randNmb` int NOT NULL,
  `insertDate` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `password_confirm`
--

CREATE TABLE `password_confirm` (
  `user_ID` varchar(255) NOT NULL,
  `randNmb` int NOT NULL,
  `insertDate` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reaction`
--

CREATE TABLE `reaction` (
  `reaction_ID` varchar(255) NOT NULL,
  `thread_ID` varchar(255) NOT NULL,
  `user_ID` varchar(255) NOT NULL,
  `Reaction` text NOT NULL,
  `reactionDate` datetime NOT NULL,
  `lastChanged` datetime DEFAULT NULL,
  `Status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `students`
--

CREATE TABLE `students` (
  `student_ID` varchar(255) NOT NULL,
  `class_ID` varchar(255) NOT NULL DEFAULT 0,
  `user_ID` varchar(255) NOT NULL,
  `studentNumber` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `students`
--

INSERT INTO `students` (`student_ID`, `class_ID`, `user_ID`, `studentNumber`) VALUES
('00000000-0000-0000-0000-0000000000000', '741AD801-EA2B-4585-BD30-5EB97F75C00C', 'B2022F48-ED35-43F9-BB61-B97A3019E004', 1337),
('00000000-0000-0000-0000-0000000000001', '741AD801-EA2B-4585-BD30-5EB97F75C00C', '2ac50383-23d0-444c-84c7-6c26d2960609', 1234);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teachers`
--

CREATE TABLE `teachers` (
  `teacher_ID` varchar(255) NOT NULL,
  `user_ID` varchar(255) NOT NULL,
  `class_ID` varchar(255)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `thread`
--

CREATE TABLE `thread` (
  `thread_ID` varchar(255) NOT NULL,
  `user_ID` varchar(255) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Thread` text NOT NULL,
  `threadDate` datetime NOT NULL,
  `Urgency` int DEFAULT '0',
  `lastChanged` datetime DEFAULT NULL,
  `Status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `thread`
--

INSERT INTO `thread` (`thread_ID`, `user_ID`, `Title`, `Thread`, `threadDate`, `Urgency`, `lastChanged`, `Status`) VALUES
('1A786488-FA73-444A-B1D8-370697F95F96', 'B2022F48-ED35-43F9-BB61-B97A3019E004', 'Roosterwijziging', 'Aanstaande donderdag vind er een roosterwijziging plaats.', '2017-12-20 13:16:10', 1, NULL, 1),
('dda57eed-2731-4315-ba67-fab1160cae7d', '2ac50383-23d0-444c-84c7-6c26d2960609', 'Huiswerk vraag', 'Wat moesten we af hebben voor Engels volgende week?', '2018-01-01 15:28:10', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `upload`
--

CREATE TABLE `upload` (
  `upload_ID` varchar(255) NOT NULL,
  `user_ID` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(25) NOT NULL,
  `status` int NOT NULL DEFAULT 0,
  `grade` int,
  `uploadContent` mediumblob NOT NULL,
  `uploadDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `activities`
--

CREATE TABLE `activities` (
  `user_ID` varchar(255) NOT NULL,
  `Content` longtext NOT NULL,
  `editDate` datetime 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `user_ID` varchar(255) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Firstname` varchar(45) NOT NULL,
  `Lastname` varchar(45) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Permission` int DEFAULT '0',
  `Status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`user_ID`, `Username`, `Firstname`, `Lastname`, `Password`, `Email`, `Permission`, `Status`) VALUES
('2ac50383-23d0-444c-84c7-6c26d2960609', 'daan', 'Daan', 'Franken', '$2y$10$k.eE6IORn8ODNfpktvzpLu5fnSFV5I5vQler1O.hxkL7bQK2Q5Qoq', 'dgmfranken@gmail.com', 1, 1),
('B2022F48-ED35-43F9-BB61-B97A3019E004', 'creator', 'Admin', 'von Adminson', '$2y$10$k.eE6IORn8ODNfpktvzpLu5fnSFV5I5vQler1O.hxkL7bQK2Q5Qoq', 'admin@admin.com', 3, 1);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_ID`);

--
-- Indexen voor tabel `email_confirm`
--
ALTER TABLE `email_confirm`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexen voor tabel `password_confirm`
--
ALTER TABLE `password_confirm`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexen voor tabel `reaction`
--
ALTER TABLE `reaction`
  ADD PRIMARY KEY (`reaction_ID`),
  ADD KEY `thread_ID` (`thread_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexen voor tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_ID`),
  ADD KEY `user_ID` (`user_ID`),
  ADD KEY `class_ID` (`class_ID`);

--
-- Indexen voor tabel `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexen voor tabel `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`thread_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexen voor tabel `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`upload_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexen voor tabel `acitivities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `email_confirm`
--
ALTER TABLE `email_confirm`
  ADD CONSTRAINT `email_confirm_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Beperkingen voor tabel `password_confirm`
--
ALTER TABLE `password_confirm`
  ADD CONSTRAINT `password_confirm_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Beperkingen voor tabel `reaction`
--
ALTER TABLE `reaction`
  ADD CONSTRAINT `reaction_ibfk_1` FOREIGN KEY (`thread_ID`) REFERENCES `thread` (`thread_ID`),
  ADD CONSTRAINT `reaction_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Beperkingen voor tabel `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`class_ID`) REFERENCES `class` (`class_ID`);

--
-- Beperkingen voor tabel `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Beperkingen voor tabel `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Beperkingen voor tabel `upload`
--
ALTER TABLE `upload`
  ADD CONSTRAINT `upload_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);  

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
