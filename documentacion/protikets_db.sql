-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-04-2022 a las 10:19:01
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `protikets_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestores`
--

CREATE TABLE `gestores` (
  `id_gestor` int(11) NOT NULL COMMENT 'id de gestores',
  `no_empleado` int(11) NOT NULL COMMENT 'numero de empleado',
  `soportes_turnados` int(11) NOT NULL COMMENT 'cuántos ha turnado',
  `log_status` int(11) NOT NULL COMMENT 'estado de log',
  `real_status` int(11) NOT NULL COMMENT 'estado de operación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_area`
--

CREATE TABLE `ref_area` (
  `id_aea` int(11) NOT NULL,
  `rank_area` int(11) NOT NULL,
  `nom_area` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_class_soporte`
--

CREATE TABLE `ref_class_soporte` (
  `id_class_soporte` int(11) NOT NULL,
  `texto_class_soporte` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ref_class_soporte`
--

INSERT INTO `ref_class_soporte` (`id_class_soporte`, `texto_class_soporte`) VALUES
(1, 'Internet'),
(2, 'Impresora'),
(3, 'Componentes'),
(4, 'CPU'),
(5, 'Monitor'),
(6, 'Software');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_rank_usuario`
--

CREATE TABLE `ref_rank_usuario` (
  `id_rank_usuario` int(11) NOT NULL,
  `texto_rank_usuario` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ref_rank_usuario`
--

INSERT INTO `ref_rank_usuario` (`id_rank_usuario`, `texto_rank_usuario`) VALUES
(1, 'maestro'),
(2, 'admin'),
(3, 'gestor'),
(4, 'tecnico'),
(5, 'solicitante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_real_status`
--

CREATE TABLE `ref_real_status` (
  `id_status` int(11) NOT NULL,
  `texto_status` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_status`
--

CREATE TABLE `ref_status` (
  `id_status` int(11) NOT NULL,
  `texto_status` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_status_firma`
--

CREATE TABLE `ref_status_firma` (
  `id_status_firma` int(11) NOT NULL,
  `texto_status_firma` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_tipo_soporte`
--

CREATE TABLE `ref_tipo_soporte` (
  `id_tipo_soporte` int(11) NOT NULL,
  `class_soporte` int(11) NOT NULL,
  `texto_usuario` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `texto_tecnico` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ref_tipo_soporte`
--

INSERT INTO `ref_tipo_soporte` (`id_tipo_soporte`, `class_soporte`, `texto_usuario`, `texto_tecnico`) VALUES
(1, 1, 'No tengo internet', 'El usuario no cuenta con acceso a internet'),
(2, 1, 'No puedo usar el internet adecuadamente', 'El usuario tiene acceso a internet pero falla'),
(3, 2, 'No puedo imprimir', 'El usuario no puede imprimir'),
(4, 2, 'Agregar Impresora', 'El usuario requiere instalación de impresora'),
(5, 3, 'No tengo teclado, mouse u otro dispositivo', 'El usuario no tiene tecladom, mouse u otro'),
(6, 3, 'No sirve mi teclado, mouse u otro dispositivo', 'El usuario tiene problemas con su teclado, mouse u otro'),
(7, 4, 'Mi CPU hace mucho ruido', 'El ventilador del CPU del usuario está fallando'),
(8, 4, 'Mi CPU se calienta demaciado', 'El CPU del usuario se está sobrecalentando'),
(9, 4, 'Mi CPU se apaga', 'El CPU del usuario se apaga'),
(10, 4, 'Mi CPU no enciende', 'El CPU del usuario no enciende'),
(11, 5, 'Mi monitor no enciende', 'El monitor del usuario no enciende'),
(12, 5, 'Mi monitor se ve de un color', 'El monitor del usuario está fallando del cable VGA'),
(13, 5, 'Mi monitor está haciendo cosas raras', 'El monitor del usuario está fallando de alguna forma'),
(14, 6, 'Activación de Office u otro programa', 'activación de Office'),
(15, 6, 'Instalación de Office u otro programa', 'Instalación de Office u otro programa'),
(16, 6, 'Ayuda creo que tengo Virus', 'El usuario cree tener Virus en su PC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicos`
--

CREATE TABLE `tecnicos` (
  `id_tec` int(11) NOT NULL COMMENT 'id de tecnicos',
  `no_empleado` int(11) NOT NULL COMMENT 'numero de empleado',
  `soportes_atendidos` int(11) NOT NULL COMMENT 'soportes atendidos',
  `log_status` int(11) NOT NULL COMMENT 'estado de log',
  `real_status` int(11) NOT NULL COMMENT 'estado de operación',
  `soportes_vivos` int(11) NOT NULL COMMENT 'numero de tikets vivos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tikets`
--

CREATE TABLE `tikets` (
  `id_tiket` int(11) NOT NULL,
  `folio` int(11) NOT NULL,
  `tipo_falla` int(11) NOT NULL,
  `solicitante_id` int(11) NOT NULL,
  `asistente` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `hr_opened` time NOT NULL,
  `hr_clossed` time NOT NULL,
  `date_opened` date NOT NULL,
  `date_clossed` date NOT NULL,
  `solucion` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tikets_archivados`
--

CREATE TABLE `tikets_archivados` (
  `id_tiket` int(11) NOT NULL,
  `folio` int(11) NOT NULL,
  `tipo_falla` int(11) NOT NULL,
  `solicitante_id` int(11) NOT NULL,
  `asistente` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `hr_opened` time NOT NULL,
  `hr_clossed` time NOT NULL,
  `date_opened` date NOT NULL,
  `date_clossed` date NOT NULL,
  `solucion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `status_Firma` int(11) NOT NULL,
  `id_pdf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `no_empleado` int(11) NOT NULL,
  `rank_usuario` int(11) NOT NULL,
  `suports_counter` int(11) NOT NULL,
  `pass` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `no_empleado`, `rank_usuario`, `suports_counter`, `pass`, `usuario`, `area`) VALUES
(1, 1433, 1, 0, '51573m45', 'EEGR', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gestores`
--
ALTER TABLE `gestores`
  ADD PRIMARY KEY (`id_gestor`);

--
-- Indices de la tabla `ref_area`
--
ALTER TABLE `ref_area`
  ADD PRIMARY KEY (`id_aea`);

--
-- Indices de la tabla `ref_class_soporte`
--
ALTER TABLE `ref_class_soporte`
  ADD PRIMARY KEY (`id_class_soporte`);

--
-- Indices de la tabla `ref_rank_usuario`
--
ALTER TABLE `ref_rank_usuario`
  ADD PRIMARY KEY (`id_rank_usuario`);

--
-- Indices de la tabla `ref_real_status`
--
ALTER TABLE `ref_real_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indices de la tabla `ref_status`
--
ALTER TABLE `ref_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indices de la tabla `ref_status_firma`
--
ALTER TABLE `ref_status_firma`
  ADD PRIMARY KEY (`id_status_firma`);

--
-- Indices de la tabla `ref_tipo_soporte`
--
ALTER TABLE `ref_tipo_soporte`
  ADD PRIMARY KEY (`id_tipo_soporte`);

--
-- Indices de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  ADD PRIMARY KEY (`id_tec`);

--
-- Indices de la tabla `tikets`
--
ALTER TABLE `tikets`
  ADD PRIMARY KEY (`id_tiket`);

--
-- Indices de la tabla `tikets_archivados`
--
ALTER TABLE `tikets_archivados`
  ADD PRIMARY KEY (`id_tiket`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gestores`
--
ALTER TABLE `gestores`
  MODIFY `id_gestor` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de gestores';

--
-- AUTO_INCREMENT de la tabla `ref_area`
--
ALTER TABLE `ref_area`
  MODIFY `id_aea` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ref_class_soporte`
--
ALTER TABLE `ref_class_soporte`
  MODIFY `id_class_soporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ref_rank_usuario`
--
ALTER TABLE `ref_rank_usuario`
  MODIFY `id_rank_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ref_real_status`
--
ALTER TABLE `ref_real_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ref_status`
--
ALTER TABLE `ref_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ref_status_firma`
--
ALTER TABLE `ref_status_firma`
  MODIFY `id_status_firma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ref_tipo_soporte`
--
ALTER TABLE `ref_tipo_soporte`
  MODIFY `id_tipo_soporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  MODIFY `id_tec` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de tecnicos';

--
-- AUTO_INCREMENT de la tabla `tikets`
--
ALTER TABLE `tikets`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tikets_archivados`
--
ALTER TABLE `tikets_archivados`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
