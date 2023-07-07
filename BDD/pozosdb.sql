-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-07-2023 a las 06:28:34
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pozosdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mediciones`
--

CREATE TABLE `mediciones` (
  `idMedicion` int(20) NOT NULL,
  `psi` float NOT NULL,
  `fecha` date NOT NULL,
  `idPozo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mediciones`
--

INSERT INTO `mediciones` (`idMedicion`, `psi`, `fecha`, `idPozo`) VALUES
(4, 2123, '2023-07-07', 12),
(5, 12, '2023-07-07', 12),
(6, 16, '2023-07-07', 12),
(7, 1, '2023-07-01', 12),
(8, 21, '2023-07-07', 11),
(9, 12, '2023-07-07', 13),
(10, 145, '2023-07-07', 13),
(11, 12312, '2023-07-07', 13),
(12, 123, '2023-07-07', 37),
(13, 1342, '2023-07-07', 37),
(14, 124, '2023-07-07', 38),
(15, 168, '2023-07-07', 38),
(16, 260, '2023-07-07', 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pozos`
--

CREATE TABLE `pozos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pozos`
--

INSERT INTO `pozos` (`id`, `nombre`) VALUES
(12, 'Acarigua'),
(37, 'Zulia'),
(38, 'Puertos'),
(39, 'Pozo petrolero 2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mediciones`
--
ALTER TABLE `mediciones`
  ADD PRIMARY KEY (`idMedicion`);

--
-- Indices de la tabla `pozos`
--
ALTER TABLE `pozos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mediciones`
--
ALTER TABLE `mediciones`
  MODIFY `idMedicion` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `pozos`
--
ALTER TABLE `pozos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
