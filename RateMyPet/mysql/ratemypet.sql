-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2019 a las 14:11:21
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
  `content` text NOT NULL,
  `likes` int(11) NOT NULL,
  `idcomment` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(6, 36),
(6, 37),
(9, 29),
(9, 38);

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
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pets`
--

INSERT INTO `pets` (`idPet`, `name`, `description`, `type`, `breed`, `treats`, `owner_id`) VALUES
(29, 'Kiwi', '							', 'Cat', 'Siamesse', 0, 6),
(30, 'Mickey', '							', 'Hamster', 'White', 0, 6),
(31, 'Jeffrey', '							', 'Rabbit', 'Grey', 0, 6),
(35, 'Mickey', '                        ', 'Hamster', 'Yellow', 0, 7),
(36, 'Kiwi', '                        ', 'Cat', 'Siamesse', 0, 7),
(37, 'Josh', '                        ', 'Dog', 'Corgie', 0, 7),
(38, 'Teresa', '                                    ', 'Rabbit', 'Liebre', 0, 6),
(39, 'Mickey', '                                    ', 'Hamster', 'Siamesse', 0, 6),
(40, 'Nathan', '                                    ', 'Hamster', 'White', 0, 6),
(41, 'Sergio', '                                    ', 'Rabbit', 'Auditor', 0, 9),
(42, 'Blanca', '                                    ', 'Cat', 'Siamesse', 0, 9),
(43, 'Mishell', '                                    ', 'Hamster', 'Estudiante', 0, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `idpost` varchar(10) NOT NULL,
  `tiempo` date NOT NULL,
  `likes` int(11) NOT NULL,
  `repets` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `petid` int(11) NOT NULL,
  `content` varchar(140) NOT NULL,
  `petname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`idpost`, `tiempo`, `likes`, `repets`, `userid`, `petid`, `content`, `petname`) VALUES
('1', '2019-04-08', 13, 5, 6, 29, 'hola soy un post y kiwi es genial!', 'Kiwi'),
('2', '2019-04-10', 5, 2, 6, 29, 'i like fish', 'kiwi');

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
(9, 6);

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
  `numFollowers` int(5) NOT NULL,
  `numFollowing` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `email`, `rol`, `numFollowers`, `numFollowing`) VALUES
(6, 'aaaaa', 'aaaaa', '$2y$10$NPVudwkP4mD5Eai4vzwDIudVI3nDpSEB3ccZq2RiLYrQAOtlTxJSW', 'adruiz01@ucm.es', 'user', 0, 0),
(7, 'Nanuk', 'Adrián Ruiz', '$2y$10$1X4kam12YUORObXQAF3JFOa1ahYjCfYNf9XxsBN92MZh5REwFsfJK', 'adruiz01@ucm.es', 'user', 0, 0),
(8, 'Houghton', 'Miguel Houghton', '$2y$10$Oi8MvxWuZM88JYVV41fpP./yipnXijnxihmm33c/xZJTfIW3c.zs2', 'miguelho@ucm.es', 'user', 0, 0),
(9, 'bbbbb', 'bbbbb', '$2y$10$ZH.5pzHeQQn6P/JR5Rhu0eMuas8PaTtTualPyTG8EYS1qFX8pURAC', 'leyendarhu@gmail.com', 'user', 0, 0),
(10, 'admin', 'admin', '$2y$10$FlxvitpTVzOU.jh2nWCpe.Ki623KzAiGG20UJEZbsGndQ6/sfGkJy', 'admin@ucm.es', 'admin', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idcomment`);

--
-- Indices de la tabla `followedpets`
--
ALTER TABLE `followedpets`
  ADD PRIMARY KEY (`userId`,`petId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `petId` (`petId`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`idmes`);

--
-- Indices de la tabla `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`idPet`),
  ADD KEY `pets_ibfk_1` (`owner_id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`idpost`),
  ADD UNIQUE KEY `index` (`idpost`);

--
-- Indices de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD PRIMARY KEY (`userId`,`seguidorId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `seguimientos_ibfk_1` (`seguidorId`);

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
-- AUTO_INCREMENT de la tabla `pets`
--
ALTER TABLE `pets`
  MODIFY `idPet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `followedpets`
--
ALTER TABLE `followedpets`
  ADD CONSTRAINT `followedpets_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `followedpets_ibfk_2` FOREIGN KEY (`petId`) REFERENCES `pets` (`idPet`);

--
-- Filtros para la tabla `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD CONSTRAINT `seguimientos_ibfk_1` FOREIGN KEY (`seguidorId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `seguimientos_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
