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
  `Permission` int NOT NULL,
  `Status` int NOT NULL DEFAULT 1, 
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Standard data for table `users`
--

INSERT INTO `users` (`user_ID`, `Username`, `Firstname`, `Lastname`, `Password`, `Email`) VALUES
('B2022F48-ED35-43F9-BB61-B97A3019E004', 'creator', 'test', 'test', '$2y$10$k.eE6IORn8ODNfpktvzpLu5fnSFV5I5vQler1O.hxkL7bQK2Q5Qoq', 'test@hotmail.com');

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
  PRIMARY KEY (`thread_ID`),
  FOREIGN KEY (`user_ID`) REFERENCES `users`(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `thread` (`thread_ID`, `user_ID`, `Title`, `Thread`, `threadDate`, `lastChanged`) VALUES
('1A786488-FA73-444A-B1D8-370697F95F96', 'B2022F48-ED35-43F9-BB61-B97A3019E004', 'Test title', 'Lorem ipsum', '2017-12-20 13:16:10', NULL);
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