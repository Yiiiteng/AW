-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2019 a las 23:24:16
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ratemypet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `idcomment` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `content` text NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`idcomment`, `idPost`, `idUser`, `content`, `likes`) VALUES
(1, 16, 6, 'lindo perro!  Mis dieses', 0),
(2, 16, 6, '10/10 would pet again', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `followedpets`
--

CREATE TABLE `followedpets` (
  `userId` int(11) NOT NULL,
  `petId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `followedpets`
--

INSERT INTO `followedpets` (`userId`, `petId`) VALUES
(6, 37),
(6, 41),
(7, 29),
(7, 31),
(9, 29),
(9, 38),
(10, 37);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likedcomments`
--

CREATE TABLE `likedcomments` (
  `idComment` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idPost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `likedcomments`
--

INSERT INTO `likedcomments` (`idComment`, `idUser`, `idPost`) VALUES
(1, 6, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likedposts`
--

CREATE TABLE `likedposts` (
  `idUser` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `likedposts`
--

INSERT INTO `likedposts` (`idUser`, `idPost`, `time`) VALUES
(6, 16, '2019-05-14 18:53:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `idmes` varchar(9) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pets`
--

CREATE TABLE `pets` (
  `idPet` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL,
  `breed` text NOT NULL,
  `treats` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pets`
--

INSERT INTO `pets` (`idPet`, `name`, `description`, `type`, `breed`, `treats`, `owner_id`, `verified`) VALUES
(29, 'Kiwi', '              ', 'Cat', 'Siamesse', 0, 6, 0),
(30, 'Mickey', '              ', 'Hamster', 'White', 0, 6, 0),
(31, 'Jeffrey', '             ', 'Rabbit', 'Grey', 0, 6, 0),
(37, 'Josh', '                        ', 'Dog', 'Corgie', 0, 7, 0),
(38, 'Teresa', '                                    ', 'Rabbit', 'Liebre', 0, 6, 0),
(40, 'Nathan', '                                    ', 'Hamster', 'White', 0, 6, 0),
(41, 'Sergio', '                                    ', 'Rabbit', 'Auditor', 0, 9, 0),
(42, 'Blanca', '                                    ', 'Cat', 'Siamesse', 0, 9, 0),
(43, 'Josh', 'I may look fearce, but I\'m actually pretty gentle! I mean... Woof!       ', 'Dog', 'Bulldog', 0, 10, 0),
(44, 'Kenney', 'Boing! Boing!                             ', 'Rabbit', 'English Lop', 0, 10, 0),
(45, 'Tony', 'Hey there! My name is Tony the Parrot. Yes, I like to repeat everyhting I hear, so be careful what you say about my owner...', 'Bird', 'Parrot', 0, 10, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `idpost` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `time` date DEFAULT NULL,
  `likes` int(11) NOT NULL,
  `repets` int(11) NOT NULL,
  `petid` int(11) NOT NULL,
  `description` varchar(140) DEFAULT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`idpost`, `title`, `time`, `likes`, `repets`, `petid`, `description`, `pending`) VALUES
(16, 'No sé que decir auxilio.', '2019-04-12', 0, 0, 29, '      asfasfasfasfas                              ', 0),
(18, 'Volveré', '2019-04-12', 0, 0, 29, 'Holaaaaa                                    ', 1),
(19, 'Prueba', '2019-05-12', 0, 0, 29, 'Prueba                                    ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postvalidation`
--

CREATE TABLE `postvalidation` (
  `idPost` int(11) NOT NULL,
  `idMod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `postvalidation`
--

INSERT INTO `postvalidation` (`idPost`, `idMod`) VALUES
(16, 6),
(18, 6),
(19, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repets`
--

CREATE TABLE `repets` (
  `idUser` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `repets`
--

INSERT INTO `repets` (`idUser`, `idPost`, `time`) VALUES
(6, 16, '2019-05-14 18:52:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos`
--

CREATE TABLE `seguimientos` (
  `userId` int(11) NOT NULL,
  `seguidorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `seguimientos`
--

INSERT INTO `seguimientos` (`userId`, `seguidorId`) VALUES
(6, 7),
(7, 6),
(10, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `timers`
--

CREATE TABLE `timers` (
  `userTreats` int(11) NOT NULL,
  `petTreats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(20) NOT NULL,
  `rol` varchar(10) NOT NULL,
  `moderator` tinyint(1) NOT NULL DEFAULT '0',
  `numFollowers` int(5) NOT NULL,
  `numFollowing` int(5) NOT NULL,
  `treats` tinyint(1) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `email`, `rol`, `moderator`, `numFollowers`, `numFollowing`, `treats`) VALUES
(6, 'aaaaaa', 'aaaaa', '$2y$10$NPVudwkP4mD5Eai4vzwDIudVI3nDpSEB3ccZq2RiLYrQAOtlTxJSW', 'adruiz01@ucm.es', 'user', 1, 0, 0, 3),
(7, 'Nanuk', 'Adrián Ruiz', '$2y$10$1X4kam12YUORObXQAF3JFOa1ahYjCfYNf9XxsBN92MZh5REwFsfJK', 'adruiz01@ucm.es', 'user', 0, 0, 0, 3),
(8, 'Houghton', 'Miguel Houghton', '$2y$10$Oi8MvxWuZM88JYVV41fpP./yipnXijnxihmm33c/xZJTfIW3c.zs2', 'miguelho@ucm.es', 'user', 0, 0, 0, 3),
(9, 'bbbbb', 'bbbbb', '$2y$10$ZH.5pzHeQQn6P/JR5Rhu0eMuas8PaTtTualPyTG8EYS1qFX8pURAC', 'leyendarhu@gmail.com', 'user', 0, 0, 0, 3),
(10, 'a', 'admin', '$2y$10$FlxvitpTVzOU.jh2nWCpe.Ki623KzAiGG20UJEZbsGndQ6/sfGkJy', 'admin@ucm.es', 'admin', 0, 0, 0, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idcomment`,`idPost`,`idUser`),
  ADD UNIQUE KEY `idx` (`idcomment`,`idPost`),
  ADD KEY `idcomment` (`idcomment`,`idPost`),
  ADD KEY `idPost` (`idPost`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idcomment_2` (`idcomment`),
  ADD KEY `idcomment_3` (`idcomment`,`idPost`,`idUser`);

--
-- Indices de la tabla `followedpets`
--
ALTER TABLE `followedpets`
  ADD PRIMARY KEY (`userId`,`petId`),
  ADD KEY `petId` (`petId`);

--
-- Indices de la tabla `likedcomments`
--
ALTER TABLE `likedcomments`
  ADD PRIMARY KEY (`idComment`,`idUser`,`idPost`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `likedposts`
--
ALTER TABLE `likedposts`
  ADD PRIMARY KEY (`idUser`,`idPost`),
  ADD KEY `idPost` (`idPost`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`idmes`);

--
-- Indices de la tabla `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`idPet`,`owner_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`idpost`,`petid`),
  ADD KEY `petid` (`petid`);

--
-- Indices de la tabla `postvalidation`
--
ALTER TABLE `postvalidation`
  ADD PRIMARY KEY (`idPost`,`idMod`),
  ADD KEY `idMod` (`idMod`);

--
-- Indices de la tabla `repets`
--
ALTER TABLE `repets`
  ADD PRIMARY KEY (`idUser`,`idPost`),
  ADD KEY `idPost` (`idPost`);

--
-- Indices de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD PRIMARY KEY (`userId`,`seguidorId`),
  ADD KEY `userId` (`userId`,`seguidorId`),
  ADD KEY `seguidorId` (`seguidorId`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `idcomment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pets`
--
ALTER TABLE `pets`
  MODIFY `idPet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `idpost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `followedpets`
--
ALTER TABLE `followedpets`
  ADD CONSTRAINT `followedpets_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `followedpets_ibfk_2` FOREIGN KEY (`petId`) REFERENCES `pets` (`idPet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `likedcomments`
--
ALTER TABLE `likedcomments`
  ADD CONSTRAINT `likedcomments_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likedcomments_ibfk_2` FOREIGN KEY (`idComment`) REFERENCES `comments` (`idcomment`);

--
-- Filtros para la tabla `likedposts`
--
ALTER TABLE `likedposts`
  ADD CONSTRAINT `likedposts_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likedposts_ibfk_2` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`petid`) REFERENCES `pets` (`idPet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `postvalidation`
--
ALTER TABLE `postvalidation`
  ADD CONSTRAINT `postvalidation_ibfk_1` FOREIGN KEY (`idMod`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `postvalidation_ibfk_2` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `repets`
--
ALTER TABLE `repets`
  ADD CONSTRAINT `repets_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `repets_ibfk_2` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD CONSTRAINT `seguimientos_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `seguimientos_ibfk_2` FOREIGN KEY (`seguidorId`) REFERENCES `users` (`id`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `reset_treats_rank` ON SCHEDULE EVERY 10 MINUTE STARTS '2019-05-14 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE pets SET treats = 0 WHERE treats > 0$$

CREATE DEFINER=`root`@`localhost` EVENT `reset_treats_users` ON SCHEDULE EVERY 10 MINUTE STARTS '2019-05-14 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE users SET treats = 3$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
