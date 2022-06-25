-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2022 a las 01:44:59
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `practicaparcial2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criptomonedas`
--

CREATE TABLE `criptomonedas` (
  `id` int(11) NOT NULL,
  `precio` float NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `nacionalidad` varchar(50) NOT NULL,
  `fecha_de_baja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `criptomonedas`
--

INSERT INTO `criptomonedas` (`id`, `precio`, `nombre`, `foto`, `nacionalidad`, `fecha_de_baja`) VALUES
(3, 70, 'PongoCoin', 'FotosMonedas/PongoCoin.jpg', 'Americana', '22-06-25'),
(4, 70, 'PongoCoin', 'FotosMonedas/PongoCoin.jpg', 'Americana', NULL),
(5, 125, 'DaHanZhongCoin', 'FotosMonedas/DaHanZhongCoin.jpg', 'China', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `clave` int(11) NOT NULL,
  `fecha_de_baja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `mail`, `tipo`, `clave`, `fecha_de_baja`) VALUES
(1, 'faron1@gmail.com', 'cliente', 4321, '22-06-25'),
(2, 'tomi@gmail.com', 'admin', 1234, NULL),
(3, 'pedro@gmail.com', 'cliente', 1234, NULL),
(4, 'pedro@gmail.com', 'cliente', 1234, NULL),
(5, 'johnny@gmail.com', 'cliente', 1234, NULL),
(6, 'peralta@gmail.com', 'cliente', 1234, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventascripto`
--

CREATE TABLE `ventascripto` (
  `id` int(11) NOT NULL,
  `criptomoneda_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` varchar(50) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `fecha_de_baja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventascripto`
--

INSERT INTO `ventascripto` (`id`, `criptomoneda_id`, `usuario_id`, `fecha`, `cantidad`, `total`, `foto`, `fecha_de_baja`) VALUES
(10, 4, 2, '2022-06-26', 3, '210', 'FotosCripto/PongoCoin-tomi@gmail.com-22-06-26.jpg', NULL),
(11, 4, 2, '2022-06-21', 3, '210', 'FotosCripto/PongoCoin-tomi@gmail.com-22-06-26.jpg', NULL),
(12, 4, 2, '2022-06-26', 3, '210', 'FotosCripto/PongoCoin-tomi@gmail.com-22-06-26.jpg', NULL),
(13, 4, 2, '2022-06-26', 3, '210', 'FotosCripto/PongoCoin-tomi@gmail.com-22-06-26.jpg', NULL),
(14, 5, 5, '2022-06-26', 3, '375', 'FotosCripto/DaHanZhongCoin-johnny@gmail.com-22-06-', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `criptomonedas`
--
ALTER TABLE `criptomonedas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventascripto`
--
ALTER TABLE `ventascripto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `criptomonedas`
--
ALTER TABLE `criptomonedas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ventascripto`
--
ALTER TABLE `ventascripto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
