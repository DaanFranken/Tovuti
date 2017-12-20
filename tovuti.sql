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

CREATE SCHEMA IF NOT EXISTS `tovuti` DEFAULT CHARACTER SET utf8;
USE `tovuti`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Firstname` varchar(45) NOT NULL,
  `Lastname` varchar(45) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Permission` int NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Standard data for table `users`
--

INSERT INTO `users` (`user_ID`, `Username`, `Firstname`, `Lastname`, `Password`, `Email`) VALUES
(0, 'creator', 'test', 'test', '$2y$10$k.eE6IORn8ODNfpktvzpLu5fnSFV5I5vQler1O.hxkL7bQK2Q5Qoq', 'test@hotmail.com');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `class`
--

CREATE TABLE `class` (
  `class_ID` int NOT NULL,
  `Name` int NOT NULL,
  `Leerjaar` int NOT NULL,
  PRIMARY KEY (`class_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `students`
--

CREATE TABLE `students` (
  `student_ID` int NOT NULL,
  `class_ID` int NOT NULL,
  `user_ID` int NOT NULL,
  PRIMARY KEY (`student_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`),
  FOREIGN KEY (`class_ID`) REFERENCES `class`(`class_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Standard data for table `students`
-- 

-- INSERT INTO `students` (`student_ID`, `user_ID`) VALUES
-- (0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teachers`
--

CREATE TABLE `teachers` (
  `teacher_ID` int NOT NULL,
  `user_ID` int NOT NULL,
  PRIMARY KEY (`teacher_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `upload`
--

CREATE TABLE `upload` (
  `upload_ID` int NOT NULL,
  `user_ID` int NOT NULL,
  `uploadContent` MEDIUMBLOB NOT NULL,
  `uploadDate` varchar(30) NOT NULL,
  PRIMARY KEY (`upload_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `thread`
--

CREATE TABLE `thread` (
  `thread_ID` int NOT NULL,
  `user_ID` int NOT NULL,
  `Titel` varchar(100) NOT NULL,
  `Thread` text NOT NULL,
  `threadDate` varchar(30) NOT NULL,
  `lastChanged` varchar(30),
  PRIMARY KEY (`thread_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reaction`
--

CREATE TABLE `reaction` (
  `reaction_ID` int NOT NULL,
  `thread_ID` int NOT NULL,
  `user_ID` int NOT NULL,
  `Reaction` text NOT NULL,
  `reactionDate` varchar(30) NOT NULL,
  `lastChanged` varchar(30),
  PRIMARY KEY (`reaction_ID`),
  FOREIGN KEY (`thread_ID`) REFERENCES `thread`(`thread_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;