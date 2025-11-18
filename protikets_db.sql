-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2022 a las 22:05:16
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

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
-- Estructura de tabla para la tabla `folios`
--

CREATE TABLE `folios` (
  `id_folio` int(11) NOT NULL,
  `soportes_x_folio` int(11) NOT NULL,
  `id_solicitante` int(11) NOT NULL,
  `id_area_solicitante` int(11) NOT NULL,
  `piso_solicitante` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL,
  `status_folio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_area`
--

CREATE TABLE `ref_area` (
  `id_area` int(11) NOT NULL,
  `nom_area` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `piso_area` int(11) NOT NULL,
  `no_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ref_area`
--

INSERT INTO `ref_area` (`id_area`, `nom_area`, `piso_area`, `no_area`) VALUES
(1, 'Procuraduría Social del Distrito Federal	', 10, 0),
(2, 'Coordinación General de Asuntos Jurídicos	', 9, 0),
(3, 'J.U.D. de Consulta	', 9, 0),
(4, 'Subdirección Jurídica	', 9, 0),
(5, 'J.U.D. de lo Contencioso	', 9, 0),
(6, 'J.U.D. de Asuntos Jurídicos	', 9, 0),
(7, 'Coordinación General de Programas Sociales	', 1, 0),
(8, 'Subdirección Técnica	', 1, 0),
(9, 'J.U.D. de Costos y Presupuestos	', 1, 0),
(10, 'J.U.D. de Supervisión	', 1, 0),
(11, 'J.U.D. de Proyectos de Mejora	', 1, 0),
(12, 'Subprocuraduría de Derechos y Obligaciones de Propiedad en Condominio	', 8, 0),
(13, 'J.U.D. de Organización y Registro	', 8, 0),
(14, 'J.U.D. de Certificación, Atención y Orientación	', 5, 0),
(15, 'Subdirección de Sanciones y Medidas de Apremio	', 8, 0),
(16, 'J.U.D. de Procedimientos y Aplicación de Sanciones	', 8, 0),
(17, 'Subdirección de Regiones	', 2, 0),
(18, 'J.U.D. de la Oficina Desconcentrada en Cuauhtémoc	', 0, 0),
(19, 'J.U.D. de la Oficina Desconcentrada en Coyoacán', 2, 0),
(20, 'J.U.D. de la Oficina Desconcentrada en Gustavo A. Madero	', 0, 0),
(21, 'J.U.D. de la Oficina Desconcentrada en Tláhuac	', 0, 0),
(22, 'J.U.D. de la Oficina Desconcentrada en Iztacalco	', 0, 0),
(23, 'J.U.D. de la Oficina Desconcentrada en Iztapalapa	', 0, 0),
(24, 'J.U.D. de la Oficina Desconcentrada en Alvaro Obregón	', 0, 0),
(25, 'J.U.D. de Cultura Condominal	', 0, 0),
(26, 'Subprocuraduría de Defensa y Exigibilidad de Derechos Ciudadanos	', 3, 0),
(27, 'Subdirección de Exigibilidad de los Derechos Ciudadanos	', 3, 0),
(28, 'Subprocuraduría de Promoción de Derechos Económicos, Sociales, Culturales y Ambientales	', 10, 0),
(29, 'Coordinación General Administrativa	', 7, 0),
(30, 'Subdirección de Administración y Finanzas	', 6, 0),
(31, 'J.U.D. de Contabilidad y Registro	', 7, 0),
(32, 'J.U.D. de Control Presupuestal	', 6, 0),
(33, 'J.U.D. de Recursos Financieros	', 6, 0),
(34, 'J.U.D. de Administración de Capital Humano	', 6, 0),
(35, 'J.U.D. de Recursos Materiales, Abastecimiento y Servicios	', 6, 0),
(36, 'J.U.D. de Tecnologías de la Información y Comunicaciones	', 7, 0),
(37, 'Órgano Interno de Control	', 5, 0),
(38, 'J.U.D. de Auditoría	', 5, 0),
(39, 'J.U.D. de Investigación	', 5, 0),
(40, 'J.U.D. de la Oficina Desconcentrada en Benito Juarez	', 2, 0),
(41, 'J.U.D. de la Oficina Desconcentrada en Tlalpan', 0, 0);

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
(6, 'Software'),
(7, 'Asesoría');

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

--
-- Volcado de datos para la tabla `ref_status`
--

INSERT INTO `ref_status` (`id_status`, `texto_status`) VALUES
(1, 'Abierto'),
(2, 'Asignado'),
(3, 'Cerrado'),
(4, 'Impreso para Firma'),
(5, 'Impreso y Firmado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_status_folio`
--

CREATE TABLE `ref_status_folio` (
  `id_status_folio` int(11) NOT NULL,
  `texto_status_folio` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ref_status_folio`
--

INSERT INTO `ref_status_folio` (`id_status_folio`, `texto_status_folio`) VALUES
(1, 'Abierto'),
(2, 'Asignado'),
(3, 'Cerrado');

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
(8, 4, 'Mi CPU se calienta demasiado', 'El CPU del usuario se está sobrecalentando'),
(9, 4, 'Mi CPU se apaga', 'El CPU del usuario se apaga'),
(10, 4, 'Mi CPU no enciende', 'El CPU del usuario no enciende'),
(11, 5, 'Mi monitor no enciende', 'El monitor del usuario no enciende'),
(12, 5, 'Mi monitor se ve de un color', 'El monitor del usuario está fallando del cable VGA'),
(13, 5, 'Mi monitor está haciendo cosas raras', 'El monitor del usuario está fallando de alguna forma'),
(14, 6, 'Activación de Office u otro programa', 'Activación de Office'),
(15, 6, 'Instalación de Office u otro programa', 'Instalación de Office u otro programa'),
(16, 6, 'Ayuda creo que tengo Virus', 'El usuario cree tener Virus en su PC'),
(17, 7, 'Asesoría de Office', 'El usuario quiere una asesoría de Office'),
(18, 7, 'Uso y manejo de Archivos PDF, etc', 'El usuario quiere una asesoría sobre documentos'),
(19, 7, 'Cómo usar la Impresora o Escaner', 'El usuario quiere una asesoría de Impresora o Escaner'),
(20, 7, 'Manejo del Navegador de Internet; Google Chrome, Internet Explorer, etc', 'El usuario quiere una asesoría sobre el navegador de Internet'),
(21, 7, 'Uso de Sistemas Institucionales; Quecom, Multas, Quejas, Almacén, etc', 'El usuario quiere una asesoría sobre algún sistema de Ángel'),
(22, 7, 'Correo electrónico (e-mail)', 'El usuario quiere una asesoría sobre el uso de e-mail');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicos`
--

CREATE TABLE `tecnicos` (
  `id_usuario` int(11) NOT NULL COMMENT 'id de tecnicos',
  `soportes_atendidos` int(11) NOT NULL COMMENT 'soportes atendidos',
  `log_status` int(11) NOT NULL COMMENT 'estado de log',
  `real_status` int(11) NOT NULL COMMENT 'estado de operación',
  `soportes_vivos` int(11) NOT NULL COMMENT 'numero de tikets vivos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tecnicos`
--

INSERT INTO `tecnicos` (`id_usuario`, `soportes_atendidos`, `log_status`, `real_status`, `soportes_vivos`) VALUES
(1, 0, 0, 0, 3),
(2, 0, 0, 0, 0),
(3, 0, 0, 0, 0),
(4, 0, 0, 0, 0),
(7, 0, 0, 0, 0),
(8, 0, 0, 0, 0),
(9, 3, 0, 0, 5),
(10, 0, 0, 0, 0),
(11, 0, 0, 0, 0),
(12, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tikets`
--

CREATE TABLE `tikets` (
  `id_folio` int(11) NOT NULL,
  `tipo_falla` int(11) NOT NULL,
  `solicitante_id` int(11) NOT NULL,
  `asistente` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_opened` datetime NOT NULL,
  `date_clossed` datetime NOT NULL,
  `solucion` text COLLATE utf8mb4_spanish_ci NOT NULL
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
  `nom_usuario` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `no_empleado`, `rank_usuario`, `suports_counter`, `pass`, `usuario`, `nom_usuario`, `area`) VALUES
(1, 1433, 3, 0, '51573845', 'EDI', 'Edgar Emmanuel García Rodríguez', 36),
(2, 2042, 3, 0, '51573845', 'PATILU', 'Patricia Martínez Martínez', 36),
(3, 2190, 4, 0, '51573845', 'LIZ', 'Lizbeth Gutierrez Rosas', 36),
(4, 2018, 3, 0, '51573845', 'JOSECHULA', 'Josefina Torales Suaste', 36),
(5, 10, 5, 6, '51573845', 'TIKET', 'USUARIO PROXY', 36),
(6, 11, 4, 0, '51573845', 'JUDTIC', 'NOMBRE DEL JUD DE TIC', 36),
(7, 2475, 3, 0, '51573845', 'PAU', 'Paula Irais Vega García', 36),
(8, 1520, 4, 0, '51573845', 'GERRY', 'Gerardo Ramirez Ramirez', 36),
(9, 2092, 4, 0, '51573845', 'MISA', 'Misael Rosales Cruz', 36),
(10, 2093, 4, 0, '51573845', 'FRANK', 'José Francisco Arriaga Mejia', 36),
(11, 2229, 4, 0, '51573845', 'MOY', 'Miguel Moises Escobar Torres', 36),
(12, 2234, 4, 0, '51573845', 'ANGEL', 'Angel Gustavo González Reyes', 36),
(13, 2030, 5, 0, '21', '2030', 'Isabel Primero Arriaga', 7),
(14, 2115, 5, 0, '60', '2115', 'Victor Manuel Morales Ramírez', 7),
(15, 2215, 5, 0, '109', '2215', 'María Cruz Plata Mejia', 7),
(16, 2245, 5, 0, '120', '2245', 'Ricardo Rodríguez Aramburo', 7),
(17, 2418, 5, 0, '153', '2418', 'Elsa Oliva Alfaro', 7),
(18, 2424, 5, 0, '155', '2424', 'Karla Ivonne Jimenez Torres', 7),
(19, 2446, 5, 0, '160', '2446', 'Porfirio Roberto Barrios Bautista', 7),
(20, 2471, 5, 0, '177', '2471', 'Myriam Dallana Fonseca Camacho', 7),
(21, 2478, 5, 0, '182', '2478', 'Delia Sánchez Domínguez', 7),
(22, 1875, 5, 0, '15', '1875', 'Edson Ayuso Rul', 29),
(23, 2028, 5, 0, '20', '2028', 'Marcela Pérez Marin', 29),
(24, 2037, 5, 0, '25', '2037', 'Norma Evelin Alvarez Solis', 29),
(25, 2182, 5, 0, '90', '2182', 'Ana Guadalupe Suárez Ramírez', 29),
(26, 1513, 5, 0, '3', '1513', 'Octaviano Cornejo Dueñas', 2),
(27, 2125, 5, 0, '64', '2125', 'Marcela Sandoval Martínez', 2),
(28, 2277, 5, 0, '132', '2277', 'Brenda Luna Carmona', 2),
(29, 2359, 5, 0, '147', '2359', 'Armando González Ortiz', 2),
(30, 2300, 5, 0, '138', '2300', 'Aide Suárez Ossio', 6),
(31, 2209, 5, 0, '105', '2209', 'Úrsula Cecilia Juan Sanabria', 32),
(32, 2057, 5, 0, '33', '2057', 'Josefina Melendez Mendoza', 14),
(33, 2211, 5, 0, '106', '2211', 'María Yolanda Valle Rea', 14),
(34, 1204, 5, 0, '1', '1204', 'Maria de Lourdes Nuñez Calderon', 34),
(35, 2081, 5, 0, '36', '2081', 'Adrian Sustaita Cordero', 34),
(36, 2084, 5, 0, '38', '2084', 'Claudia Rosario Romero Sierra', 34),
(37, 2086, 5, 0, '39', '2086', 'Alberto Martínez Mijangos', 34),
(38, 2147, 5, 0, '73', '2147', 'Rocio Ramírez Lara', 34),
(39, 2449, 5, 0, '161', '2449', 'Diana Lilia De la Cruz Arciniega', 34),
(40, 2451, 5, 0, '162', '2451', 'Manuel Andres Rojas Pérez', 34),
(41, 2453, 5, 0, '164', '2453', 'Rosa Fuentes Castellanos', 34),
(42, 2470, 5, 0, '176', '2470', 'Guillermo Sánchez Silva', 34),
(43, 2174, 5, 0, '87', '2174', 'Arnulfo Nogal Ceron', 31),
(44, 2183, 5, 0, '91', '2183', 'Rolando Jorge Pérez Lazcano', 31),
(45, 2456, 5, 0, '167', '2456', 'María Antonieta Martínez Aguilera', 31),
(46, 1548, 5, 0, '8', '1548', 'Rocio Ortega Rico', 25),
(47, 2462, 5, 0, '170', '2462', 'Matsaa Edith Bautista Ortíz', 25),
(48, 2023, 5, 0, '19', '2023', 'Ana Gabriela Ramírez López', 24),
(49, 2096, 5, 0, '46', '2096', 'Rafaela Manzano Carlon', 24),
(50, 2102, 5, 0, '50', '2102', 'Gloria delos Angeles Flores Vizcarra', 24),
(51, 2108, 5, 0, '55', '2108', 'Claudia Narvaez Mendoza', 24),
(52, 2145, 5, 0, '72', '2145', 'Elba Alejandra Yañez Lozano', 24),
(53, 2186, 5, 0, '93', '2186', 'Ana Laura Zarate Herrera', 24),
(54, 2265, 5, 0, '130', '2265', 'Anele Morales Ledesma', 24),
(55, 2283, 5, 0, '134', '2283', 'Karina Ledezma Martínez', 24),
(56, 2479, 5, 0, '183', '2479', 'Jesús Antonio Lara López', 24),
(57, 2091, 5, 0, '42', '2091', 'Bruna Concepción Cedillo y Vargas Maria', 18),
(58, 2133, 5, 0, '66', '2133', 'Favio Arnoldo Rodelo Gastelum', 18),
(59, 2140, 5, 0, '71', '2140', 'Hortencia Becerril Mundo', 18),
(60, 2159, 5, 0, '78', '2159', 'Antonio Hernández Ávila', 18),
(61, 2171, 5, 0, '86', '2171', 'Marcela Navarrete Nieto', 18),
(62, 2185, 5, 0, '92', '2185', 'Carmen Elizabeth Espinosa López', 18),
(63, 2187, 5, 0, '94', '2187', 'Ivett Guadalupe Vázquez Dominguez', 18),
(64, 2218, 5, 0, '110', '2218', 'Olga Maricela Chaine Lopez', 18),
(65, 2225, 5, 0, '115', '2225', 'José Arturo Cardoso Santiago', 18),
(66, 2240, 5, 0, '119', '2240', 'Pedro Contreras Pedro', 18),
(67, 2249, 5, 0, '122', '2249', 'Araceli Becerra Vazquez', 18),
(68, 2273, 5, 0, '131', '2273', 'Claudia Valles Damian', 18),
(69, 2321, 5, 0, '143', '2321', 'Esequiel Velázquez Aragon', 18),
(70, 2088, 5, 0, '40', '2088', 'Julia Enriquez Velasco', 20),
(71, 2090, 5, 0, '41', '2090', 'Yadira Esmeralda Cortez González', 20),
(72, 2104, 5, 0, '52', '2104', 'Miguel Angel Sánchez Hernández', 20),
(73, 2136, 5, 0, '68', '2136', 'Arturo Colin Martínez', 20),
(74, 2151, 5, 0, '75', '2151', 'Erika Camacho Rivera', 20),
(75, 2166, 5, 0, '82', '2166', 'Frinee Africa Osornio Pichardo', 20),
(76, 2170, 5, 0, '85', '2170', 'Librado Mendoza Monroy', 20),
(77, 2198, 5, 0, '100', '2198', 'Claudia Guadalupe García Lazcano', 20),
(78, 2204, 5, 0, '101', '2204', 'Ivis Rafael Navarrete García', 20),
(79, 2232, 5, 0, '117', '2232', 'Ricardo Rodriguez Arreola', 20),
(80, 2246, 5, 0, '121', '2246', 'Carmina Gomez Hernández', 20),
(81, 2285, 5, 0, '135', '2285', 'Carlos Pacheco Arpaez', 20),
(82, 2301, 5, 0, '139', '2301', 'Rocio Téllez Jaimes', 20),
(83, 2364, 5, 0, '149', '2364', 'Juan Manuel Cruz Chavez', 20),
(84, 2454, 5, 0, '165', '2454', 'Emiliano Rangel Hernández', 20),
(85, 2477, 5, 0, '181', '2477', 'Daniel Sebastian Soto Escamilla', 20),
(86, 2083, 5, 0, '37', '2083', 'Rubi Edith Castellanos Rodríguez', 41),
(87, 2107, 5, 0, '54', '2107', 'Miguel Angel Hernández Martínez', 41),
(88, 2167, 5, 0, '83', '2167', 'Marisol Vera Garrido', 41),
(89, 2169, 5, 0, '84', '2169', 'María del Carmen Moscoso Lara', 41),
(90, 2444, 5, 0, '158', '2444', 'Marco Antonio Martinez Arellano', 41),
(91, 2467, 5, 0, '174', '2467', 'Lorena Cedillo Amador', 41),
(92, 1648, 5, 0, '13', '1648', 'Daniel Alejandro Vargas Uribe', 16),
(93, 2040, 5, 0, '27', '2040', 'José Luis Segura Carral', 16),
(94, 2259, 5, 0, '128', '2259', 'Oscar Sereno Castañeda', 16),
(95, 2355, 5, 0, '146', '2355', 'María Irma Angélica Méndez Rodríguez', 16),
(96, 2443, 5, 0, '157', '2443', 'Guillermo Martinez Solis', 16),
(97, 1564, 5, 0, '9', '1564', 'Roberto Carlos Romero Salgado', 33),
(98, 2452, 5, 0, '163', '2452', 'Raúl Laurencio Zavala', 33),
(99, 2474, 5, 0, '179', '2474', 'Mónica Elizabeth Silva Bandala', 33),
(100, 1475, 5, 0, '2', '1475', 'Gustavo Hernandez Ortiz', 35),
(101, 1517, 5, 0, '4', '1517', 'Juan Carlos Velazquez Vega', 35),
(102, 2034, 5, 0, '22', '2034', 'Azucena Verónica Moreno Hernández', 35),
(103, 2095, 5, 0, '45', '2095', 'José Hugo Juárez Cortes', 35),
(104, 2105, 5, 0, '53', '2105', 'Juan Miguel Nuñez Zarco', 35),
(105, 2127, 5, 0, '65', '2127', 'Rodrigo Osorio Rios', 35),
(106, 2251, 5, 0, '124', '2251', 'Ignacio Bernal Hernández', 35),
(107, 2263, 5, 0, '129', '2263', 'José Ernesto Martin Martínez', 35),
(108, 2305, 5, 0, '141', '2305', 'Emmanuel Matlalcoatl Mora', 35),
(109, 2351, 5, 0, '145', '2351', 'Arturo Ramírez Mora', 35),
(110, 2375, 5, 0, '151', '2375', 'Carlos Roberto Cortez Pedraza', 35),
(111, 2441, 5, 0, '156', '2441', 'Maribel Silva Hernández', 35),
(112, 2461, 5, 0, '169', '2461', 'Jonathan Rosendo Lunar Diaz', 35),
(113, 2463, 5, 0, '171', '2463', 'Rosa María Cuadros Escobar', 35),
(114, 2472, 5, 0, '178', '2472', 'Ana Guadalupe Guido Bautista', 35),
(115, 2152, 5, 0, '76', '2152', 'Jorge Ramon Estala Estevez', 10),
(116, 2476, 5, 0, '180', '2476', 'Jesús González Sánchez', 10),
(117, 1900, 5, 0, '16', '1900', 'Aurelio Leopoldo Velasco Ortíz', 1),
(118, 2039, 5, 0, '26', '2039', 'Lizbeth Evangelina Espinosa de los Monteros Hdez', 1),
(119, 2049, 5, 0, '30', '2049', 'María Esmeralda Medina Castañeda', 1),
(120, 2103, 5, 0, '51', '2103', 'Maria Teresa Lucia Ramírez Cortes', 1),
(121, 2112, 5, 0, '58', '2112', 'Ricardo Osorio Carrillo', 1),
(122, 2134, 5, 0, '67', '2134', 'Diana Silva Gonzalez', 1),
(123, 2303, 5, 0, '140', '2303', 'Maria Elizabeth Martinez Sanchez', 1),
(124, 2371, 5, 0, '150', '2371', 'Erika Paola Muñoz Morales', 1),
(125, 2409, 5, 0, '152', '2409', 'Yerika Antonieta Copca Gutierrez', 1),
(126, 2457, 5, 0, '168', '2457', 'Norma Angélica Nava Sandoval', 1),
(127, 2208, 5, 0, '104', '2208', 'Angélica Becerril Mundo', 37),
(128, 2253, 5, 0, '126', '2253', 'Jorge Vega Prado', 37),
(129, 2079, 5, 0, '35', '2079', 'Martha Virginia Ravelo Cuevas', 15),
(130, 2207, 5, 0, '103', '2207', 'Felipe García Contreras', 15),
(131, 2117, 5, 0, '61', '2117', 'Lilia Avila Loya', 30),
(132, 2317, 5, 0, '142', '2317', 'Claudia Galan Chávez', 30),
(133, 2124, 5, 0, '63', '2124', 'Leonor Martínez Torres', 17),
(134, 1746, 5, 0, '14', '1746', 'Juan López Mondragon', 27),
(135, 2035, 5, 0, '23', '2035', 'Rogelio Roque Sánchez', 27),
(136, 2046, 5, 0, '29   ', '2046', 'Esperanza Gonzalez Ortiz', 27),
(137, 2220, 5, 0, '111', '2220', 'Edilberto Bautista Diaz', 27),
(138, 2250, 5, 0, '123', '2250', 'Sara Elena López Vega', 27),
(139, 2252, 5, 0, '125', '2252', 'Leticia Hernández Macias', 27),
(140, 2299, 5, 0, '137', '2299', 'Karla Lorena Martinez Ramos', 27),
(141, 2213, 5, 0, '107', '2213', 'Laura Veronica Pacheco Cruz', 4),
(142, 2001, 5, 0, '17', '2001', 'Luz María Castillo Cabrera', 12),
(143, 2036, 5, 0, '24', '2036', 'Ana Ingrid Hagembeck Cortes', 12),
(144, 2158, 5, 0, '77', '2158', 'Claudia Ruth Anguiano Ibarra', 12),
(145, 2195, 5, 0, '97', '2195', 'María Cristina Sánchez Ramírez', 12),
(146, 2223, 5, 0, '113', '2223', 'José Espinosa Martínez', 12),
(147, 2445, 5, 0, '159', '2445', 'Ilse Lorena Hernandez Gonzalez', 12),
(148, 2469, 5, 0, '175', '2469', 'Martha Laura Romero Becerril', 12),
(149, 2043, 5, 0, '28', '2043', 'Olga Leticia Padilla Gaytan', 26),
(150, 2051, 5, 0, '31', '2051', 'Adriana Pedroza Chaine', 26),
(151, 2114, 5, 0, '59', '2114', 'Jaime Sánchez Sánchez', 26),
(152, 2056, 5, 0, 'michell', 'camaro1954', 'Carlos Mario Rodríguez Ibarra', 28),
(153, 2206, 5, 0, '102', '2206', 'Paulina de Guadalupe Rivera Osorio', 28),
(154, 1528, 5, 0, '5630', '1528', 'María Angelica Trejo Guerrero', 40),
(155, 12, 5, 0, '1111', 'camaleon', 'Edgar Emmanuel García Rodríguez', 29);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `folios`
--
ALTER TABLE `folios`
  ADD PRIMARY KEY (`id_folio`);

--
-- Indices de la tabla `ref_area`
--
ALTER TABLE `ref_area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `ref_class_soporte`
--
ALTER TABLE `ref_class_soporte`
  ADD PRIMARY KEY (`id_class_soporte`);

--
-- Indices de la tabla `ref_tipo_soporte`
--
ALTER TABLE `ref_tipo_soporte`
  ADD PRIMARY KEY (`id_tipo_soporte`);

--
-- Indices de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `tikets`
--
ALTER TABLE `tikets`
  ADD KEY `id_folio` (`id_folio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `folios`
--
ALTER TABLE `folios`
  MODIFY `id_folio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ref_area`
--
ALTER TABLE `ref_area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `ref_class_soporte`
--
ALTER TABLE `ref_class_soporte`
  MODIFY `id_class_soporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ref_tipo_soporte`
--
ALTER TABLE `ref_tipo_soporte`
  MODIFY `id_tipo_soporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tikets`
--
ALTER TABLE `tikets`
  ADD CONSTRAINT `tikets_ibfk_1` FOREIGN KEY (`id_folio`) REFERENCES `folios` (`id_folio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
