SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` varchar(255) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Firstname` varchar(45) NOT NULL,
  `Lastname` varchar(45) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Permission` int DEFAULT 0,
  `Status` int NOT NULL DEFAULT 1, 
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Standard data for table `users`
--

INSERT INTO `users` (`user_ID`, `Username`, `Firstname`, `Lastname`, `Password`, `Email`,`Permission`) VALUES
('B2022F48-ED35-43F9-BB61-B97A3019E004', 'creator', 'Admin', 'von Adminson', '$2y$10$k.eE6IORn8ODNfpktvzpLu5fnSFV5I5vQler1O.hxkL7bQK2Q5Qoq', 'test@hotmail.com',3);

INSERT INTO `users` (`user_ID`, `Username`, `Firstname`, `Lastname`, `Password`, `Email`,`Permission`) VALUES
('2ac50383-23d0-444c-84c7-6c26d2960609', 'daan', 'Daan', 'Franken', '$2y$10$k.eE6IORn8ODNfpktvzpLu5fnSFV5I5vQler1O.hxkL7bQK2Q5Qoq', 'dgmfranken@gmail.com',1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `email_confirm` (
  `user_ID` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `randNmb` int(8) NOT NULL,
  `insertDate` varchar(20) NOT NULL,
  PRIMARY KEY (`user_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_confirm`
--

CREATE TABLE `password_confirm` (
  `user_ID` varchar(255) NOT NULL,
  `randNmb` int(8) NOT NULL,
  `insertDate` varchar(20) NOT NULL,
  PRIMARY KEY (`user_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `class`
--

CREATE TABLE `class` (
  `class_ID` varchar(255) NOT NULL,
  `Name` varchar(15) NOT NULL,
  `Year` int NOT NULL,
  PRIMARY KEY (`class_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `class` (`class_ID`, `Name`, `Year`) VALUES
('741AD801-EA2B-4585-BD30-5EB97F75C00C', 'TCOC42A', 2);
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `students`
--

CREATE TABLE `students` (
  `student_ID` varchar(255) NOT NULL,
  `class_ID` varchar(255) NOT NULL,
  `user_ID` varchar(255) NOT NULL,
  `studentNumber` int NOT NULL,
  PRIMARY KEY (`student_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`),
  FOREIGN KEY (`class_ID`) REFERENCES `class`(`class_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Standard data for table `students`
-- 

INSERT INTO `students` (`student_ID`, `class_ID`, `user_ID`, `studentNumber`) VALUES
('00000000-0000-0000-0000-0000000000000', '741AD801-EA2B-4585-BD30-5EB97F75C00C', 'B2022F48-ED35-43F9-BB61-B97A3019E004', 1337);


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teachers`
--

CREATE TABLE `teachers` (
  `teacher_ID` varchar(255) NOT NULL,
  `user_ID` varchar(255) NOT NULL,
  PRIMARY KEY (`teacher_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `upload`
--

CREATE TABLE `upload` (
  `upload_ID` varchar(255) NOT NULL,
  `user_ID` varchar(255) NOT NULL,
  `uploadContent` MEDIUMBLOB NOT NULL,
  `uploadDate` DATETIME NOT NULL,
  PRIMARY KEY (`upload_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
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
  `threadDate` DATETIME NOT NULL,
  `Urgency` int DEFAULT 0,
  `lastChanged` DATETIME,
  `Status` int NOT NULL DEFAULT 1, 
  PRIMARY KEY (`thread_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `thread` (`thread_ID`, `user_ID`, `Title`, `Thread`, `threadDate`, `lastChanged`) VALUES
('1A786488-FA73-444A-B1D8-370697F95F96', 'B2022F48-ED35-43F9-BB61-B97A3019E004', 'Test title', 'Lorem ipsum', '2017-12-20 13:16:10', NULL);

INSERT INTO `thread` (`thread_ID`, `user_ID`, `Title`, `Thread`, `threadDate`, `lastChanged`) VALUES
('dda57eed-2731-4315-ba67-fab1160cae7d', '2ac50383-23d0-444c-84c7-6c26d2960609', 'Huiswerk vraag', 'Wat moesten we af hebben voor Engels volgende week?', '2018-01-01 15:28:10', NULL);
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reaction`
--

CREATE TABLE `reaction` (
  `reaction_ID` varchar(255) NOT NULL,
  `thread_ID` varchar(255) NOT NULL,
  `user_ID` varchar(255) NOT NULL,
  `Reaction` text NOT NULL,
  `reactionDate` DATETIME NOT NULL,
  `lastChanged` DATETIME,
  PRIMARY KEY (`reaction_ID`),
  FOREIGN KEY (`thread_ID`) REFERENCES `thread`(`thread_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;