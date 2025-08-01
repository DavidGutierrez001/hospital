-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-08-2025 a las 07:09:34
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_hospital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_medicas`
--

CREATE TABLE `citas_medicas` (
  `id_cita` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_medico` int(11) DEFAULT NULL,
  `fecha_cita` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `estado_cita` enum('Programada','Asistida','No Asistida','Cancelada') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas_medicas`
--

INSERT INTO `citas_medicas` (`id_cita`, `id_paciente`, `id_medico`, `fecha_cita`, `hora_inicio`, `hora_fin`, `estado_cita`) VALUES
(8, 6, 11, '2025-08-01', '14:00:00', '14:30:00', 'Asistida'),
(9, 3, 11, '2025-07-31', '08:00:00', '08:30:00', 'Asistida'),
(11, 7, 15, '2025-07-30', '07:00:00', '07:30:00', 'Programada'),
(12, 9, 19, '2025-08-01', '15:00:00', '15:30:00', 'Asistida'),
(14, 10, 19, '2025-07-31', '08:30:00', '09:00:00', 'Asistida'),
(15, 4, 19, '2025-07-31', '09:20:00', '09:50:00', 'Programada'),
(16, 9, 20, '2025-07-31', '10:00:00', '10:30:00', 'Asistida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id_detalle_venta` int(11) NOT NULL,
  `id_medicamento` int(11) DEFAULT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad_medicos`
--

CREATE TABLE `disponibilidad_medicos` (
  `id_disponibilidad` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `dia_semana` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `disponibilidad_medicos`
--

INSERT INTO `disponibilidad_medicos` (`id_disponibilidad`, `id_medico`, `dia_semana`, `hora_inicio`, `hora_fin`) VALUES
(1, 11, 'Monday', '08:00:00', '15:00:00'),
(2, 11, 'Thursday', '08:00:00', '15:00:00'),
(3, 12, 'Tuesday', '09:00:00', '16:00:00'),
(4, 12, 'Tuesday', '14:00:00', '21:00:00'),
(5, 15, 'Thursday', '07:30:00', '14:30:00'),
(6, 16, 'Friday', '08:00:00', '15:00:00'),
(7, 17, 'Monday', '10:00:00', '17:00:00'),
(8, 19, 'Saturday', '08:30:00', '15:30:00'),
(9, 19, 'Sunday', '13:30:00', '20:30:00'),
(10, 20, 'Wednesday', '08:00:00', '15:00:00'),
(11, 20, 'Sunday', '14:00:00', '21:00:00'),
(12, 31, 'Tuesday', '09:00:00', '16:00:00'),
(13, 32, 'Wednesday', '07:00:00', '14:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id_entrada` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_entrada` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id_entrada`, `id_producto`, `cantidad`, `fecha_entrada`) VALUES
(1, 1, 5, '2025-07-24 21:11:35'),
(2, 1, 5, '2025-07-24 21:14:11'),
(3, 11, 3, '2025-07-24 21:53:37'),
(4, 16, 5, '2025-07-25 07:32:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id_especialidad` int(11) NOT NULL,
  `nombre_especialidad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id_especialidad`, `nombre_especialidad`) VALUES
(1, 'General'),
(2, 'Pediatra'),
(3, 'Optometrista'),
(4, 'Dentista'),
(5, 'Cardiologo'),
(6, 'Dermatologo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmaceuticos`
--

CREATE TABLE `farmaceuticos` (
  `id_farmaceutico` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `farmaceuticos`
--

INSERT INTO `farmaceuticos` (`id_farmaceutico`, `id_usuario`) VALUES
(1, 7),
(2, 17),
(3, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_medico`
--

CREATE TABLE `historial_medico` (
  `id_historial` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_medico` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `motivo_consulta` text DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `examen_fisico` text DEFAULT NULL,
  `resultados_pruebas` text DEFAULT NULL,
  `antecedentes_personales` text DEFAULT NULL,
  `antecedentes_familiares` text DEFAULT NULL,
  `estilo_vida` text DEFAULT NULL,
  `notas_generales` text DEFAULT NULL,
  `proxima_cita` date DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `historial_medico`
--

INSERT INTO `historial_medico` (`id_historial`, `id_paciente`, `id_medico`, `fecha_creacion`, `motivo_consulta`, `diagnostico`, `tratamiento`, `examen_fisico`, `resultados_pruebas`, `antecedentes_personales`, `antecedentes_familiares`, `estilo_vida`, `notas_generales`, `proxima_cita`, `eliminado`) VALUES
(1, 8, 11, '2025-07-14 09:07:06', 'Dolor de cabeza', 'Cefalea tensional. Se descarta migraña por falta de síntomas asociados.', 'Paracetamol 500 mg cada 8 horas por 3 días. Hidratación y descanso recomendados.', 'Tensión arterial 120/80, temperatura 36.7°C, sin signos neurológicos.', 'No se solicitaron exámenes en esta consulta inicial.', 'Alergia al ibuprofeno. No enfermedades crónicas.', 'Madre con antecedentes de migraña. Padre sano.', 'Estudiante universitario. Duerme menos de 6 horas por día. Consume café frecuentemente.', 'Se recomienda mejorar hábitos de sueño y reducir consumo de cafeína. Seguimiento en caso de recurrencia.', '2025-07-21', 0),
(2, 9, 12, '2025-07-16 10:45:00', 'Dolor abdominal persistente', 'Posible gastritis. Se descarta apendicitis tras examen físico.', 'Omeprazol 20 mg una vez al día durante 14 días. Dieta blanda recomendada.', 'Abdomen blando, dolor a la palpación en epigastrio. Temperatura 37.2°C.', 'Se solicitó ecografía abdominal. Resultados pendientes.', 'Historial de acidez estomacal. Sin enfermedades crónicas conocidas.', 'Padre con antecedentes de úlceras gástricas.', 'Come fuera de casa frecuentemente. Consumo moderado de café.', 'Se recomienda control en 7 días con resultados. Evitar automedicación.', NULL, 0),
(4, 8, 11, '2025-07-16 19:22:28', 'Fractura de pierna derecha', 'Fractura de tibia derecha, tercio medio, con leve desplazamiento.', 'Reducción cerrada e inmovilización con yeso. Analgesia con AINEs. Controles radiográficos y fisioterapia posterior.', 'Deformidad, dolor, e hinchazón en pierna derecha. Pulsos distales presentes, sensibilidad conservada.', 'Radiografía confirma fractura espiroidea de tibia derecha.', 'Sin alergias ni enfermedades crónicas.\r\nNo fumador.', 'Padre hipertenso. \r\nMadre diabética.', 'Oficinista, sedentario.', 'Fractura por caída de patineta. Se le indicó no apoyar el pie.', NULL, 0),
(5, 8, 16, '2025-07-18 09:03:00', 'Dolor abdominal persistente.', 'Gastritis crónica.', 'Omeprazol 20 mg cada 12 horas por 4 semanas.', ' Abdomen blando, dolor en epigastrio a la palpación, sin masa palpable.\r\n', 'Endoscopia revela inflamación gástrica leve.', 'Alergia a la amoxicilina.', 'Madre con antecedentes de úlcera gástrica.\r\n', 'Consume café y comidas irritantes con frecuencia, no fuma ni bebe alcohol.', 'Se recomienda modificar la dieta, evitar alimentos irritantes y realizar seguimiento en 1 mes.', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id_medico` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_especialidad` int(11) DEFAULT NULL,
  `tipo_documento` varchar(10) DEFAULT 'CC',
  `documento` varchar(15) DEFAULT NULL,
  `contacto` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id_medico`, `id_usuario`, `id_especialidad`, `tipo_documento`, `documento`, `contacto`, `activo`) VALUES
(11, 14, 6, 'CC', '72033862', 5698887, 1),
(12, 25, 4, 'CE', '84107734', 4554477, 1),
(15, 51, 1, 'CC', '49742211', 8185877, 1),
(16, 56, 1, 'CC', '98132434', 39218779, 1),
(17, 59, 3, 'CC', '66836384', 585669, 1),
(19, 61, 2, 'CC', '26699407', 2589954, 1),
(20, 62, 4, 'CE', '85761305', 89978413, 1),
(31, 78, 5, 'CC', '39170164', 6584713, 1),
(32, 79, 4, 'CC', '62381407', 54254878, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `controlador` varchar(100) NOT NULL,
  `ruta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `controlador`, `ruta`) VALUES
(1, 'PacientesController', 'dashboard/pacientes'),
(2, 'MedicosController', 'dashboard/medicos'),
(3, 'CitasController', 'dashboard/citas'),
(4, 'HistorialController', 'dashboard/historial'),
(5, 'Farmacia', 'dashboard/farmacia'),
(6, 'ReportesController', 'dashboard/reportes'),
(7, 'HomeController', 'dashboard/home');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `leido` tinyint(1) DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `documento` int(11) DEFAULT NULL,
  `tipo_documento` enum('Cedula de Ciudadania','Cedula de extranjeria') DEFAULT NULL,
  `genero` enum('Masculino','Femenino','No binario') DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado_civil` enum('Soltero','Casado','Viudo','Divorciado','Soltero') DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `id_usuario`, `fecha_nacimiento`, `documento`, `tipo_documento`, `genero`, `direccion`, `estado_civil`, `telefono`) VALUES
(1, 1, '2002-09-02', 123456789, 'Cedula de Ciudadania', 'Masculino', 'Calle 26', 'Soltero', 2147483647),
(3, 24, '2002-09-02', 214748364, 'Cedula de Ciudadania', 'Femenino', 'Calle 22', 'Soltero', 654624676),
(4, 26, '2007-05-19', 124578987, 'Cedula de Ciudadania', 'Masculino', 'Calle x', 'Soltero', 2147483647),
(5, 27, '1993-12-12', 214799965, 'Cedula de Ciudadania', 'Masculino', 'Avenida A # 5-6', 'Soltero', 3269987),
(6, 31, '1999-09-05', 215748364, 'Cedula de Ciudadania', 'Masculino', 'Calle Alfonso', 'Soltero', 2147483647),
(7, 32, '2002-09-02', 247483647, 'Cedula de Ciudadania', 'Masculino', 'Calle', 'Soltero', 252155454),
(8, 33, '2005-07-05', 200507058, 'Cedula de Ciudadania', 'Femenino', 'Calle 52', 'Soltero', 52525252),
(9, 34, '2002-09-02', 102092002, 'Cedula de Ciudadania', 'Femenino', 'Calle 29', 'Casado', 32154789),
(10, 47, '2002-06-20', 245469752, 'Cedula de Ciudadania', 'Masculino', 'Calle 24c', 'Soltero', 6896323);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `id_rol`, `id_modulo`) VALUES
(1, 2, 2),
(3, 2, 3),
(4, 2, 4),
(6, 3, 1),
(5, 3, 5),
(7, 4, 5),
(8, 4, 6),
(12, 5, 1),
(13, 5, 2),
(14, 5, 3),
(15, 5, 4),
(16, 5, 5),
(17, 5, 6),
(18, 5, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_comercial` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `receta_especial` tinyint(1) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `existencias` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `eliminado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_comercial`, `descripcion`, `receta_especial`, `activo`, `fecha_registro`, `existencias`, `precio`, `eliminado`) VALUES
(1, 'Acetamonifén Dolex 500mg x10', 'Analgéstico y antipirético', 0, 1, '2025-07-24', 30, '3600.00', 0),
(10, 'Ibuprofeno 500mg Caja x60', 'Antiinflamatorio no esteroideo, utilizado frecuentemente como antipirético, analgésico y antiinflamatorio', 0, 1, '2025-07-23', 7, '22500.00', 0),
(11, 'Amoxicilina 500mg 50 Cápsulas', 'Antibiótico semisintético derivado de la penicilina', 0, 1, '2025-07-23', 5, '7300.00', 0),
(12, 'Paracetamol BAYER 500mg x30', 'Analgésicas y antipiréticas​​ utilizado principalmente para tratar la fiebre y el dolor leve y moderado', 0, 1, '2025-07-23', 12, '10600.00', 0),
(15, 'aa', 'aa', 0, 1, '2025-07-24', 0, '12345678.00', 1),
(16, 'prueba 2', 'prueba', 0, 1, '2025-07-25', 5, '2500.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcionistas`
--

CREATE TABLE `recepcionistas` (
  `id_recepcionista` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recepcionistas`
--

INSERT INTO `recepcionistas` (`id_recepcionista`, `id_usuario`) VALUES
(1, 11),
(2, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_medicas`
--

CREATE TABLE `recetas_medicas` (
  `id_receta` int(11) DEFAULT NULL,
  `id_medicamento` int(11) DEFAULT NULL,
  `dosis` varchar(255) DEFAULT NULL,
  `frecuencia` varchar(255) DEFAULT NULL,
  `via_administracion` enum('Nasal','Oral','Oftalmica','Topica') DEFAULT NULL,
  `duracion_tratamiento` varchar(255) DEFAULT NULL,
  `instrucciones_adicionales` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` enum('Paciente','Medico','Recepcionista','Farmaceutico','Administrador') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Paciente'),
(2, 'Medico'),
(3, 'Recepcionista'),
(4, 'Farmaceutico'),
(5, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id_salida` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_salida` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `salidas`
--

INSERT INTO `salidas` (`id_salida`, `id_producto`, `cantidad`, `fecha_salida`) VALUES
(3, 12, 1, '2025-07-24 20:40:09'),
(4, 11, 3, '2025-07-24 21:51:43'),
(5, 16, 1, '2025-07-25 07:33:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `primer_nombre` varchar(255) NOT NULL,
  `segundo_nombre` varchar(255) DEFAULT NULL,
  `primer_apellido` varchar(255) NOT NULL,
  `segundo_apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_rol`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `email`, `password`, `fecha_registro`, `activo`) VALUES
(1, 5, 'Jose', 'David', 'Nuñez', 'Gutierrez', 'JoseDavid@gmail.com', '$2y$10$fWeJohOvAKJtlitBeI8aWu/AMk0n.ENI4Aoo6YftZ9Cc8Wez3Pzp.', '2025-06-19 13:49:28', 1),
(3, 1, 'Juan', 'Camilo', 'Sanchez', '', 'JuanCamilo@gmail.com', '$2y$10$.HLm1Zq.UzmxqZg99W72lOcCZ22Wo5sSdEJZ7GnHl81qE4.o2VWem', '2025-06-19 05:43:57', 1),
(7, 4, 'Edwin', '', 'Contreras', '', 'EdwinContreras@gmail.com', '$2y$10$kiPOlPn0asgzooVWZPHRcOuDGlPJCn/G2M6wbBJtqZVVA8lCKn4OG', '2025-06-20 12:17:25', 1),
(11, 3, 'Sofia', '', 'Gonzalez', '', 'SofiaGonzalez@gmail.com', '$2y$10$4UZQNE6ZVy6gfnpQL6dCP.19Xitv8zAOV0s/kM6tyyM.dS2oOXEVu', '2025-06-20 12:45:31', 1),
(14, 2, 'Alejandro', '', 'Perez', '', 'AlejandroPerez@gmail.com', '$2y$10$LZA0bcY7lnAp56erzJzOLOavGcdUHQmi1zQfj0D95vYzREBUxdku6', '2025-06-20 00:56:28', 1),
(17, 4, 'Luis', '', 'Mendez', '', 'LuisMendez@gmail.com', '$2y$10$w17crrCeNW4uOAsTvr5I1ud/SmmPd46d3WMYvcY0HfOpJFcclPaw2', '2025-06-20 00:57:17', 1),
(22, 4, 'Brayan', '', 'Suarez', '', 'BrayanSuarez@gmail.com', '$2y$10$mXcNoLO3HhSMIv.1MVQHoesOpR9ihKhXp9OSyBV/FvMKMbTGvs8bu', '2025-06-20 00:59:07', 1),
(23, 3, 'Maria', 'Camila', 'Sanchez', '', 'MariaCamila@gmail.com', '$2y$10$Ko0BMkZFQ5sGYzH00vT0bOuR/rPrcKscIfMGWZ5Zr35STjzskf1Bm', '2025-06-20 08:15:54', 1),
(24, 1, 'Maria', 'Juliana', 'Jimenez', 'Castaño', 'MariaJimenez@gmail.com', '$2y$10$zYTNbBqIzV8zH.6XWFAqXOxu7CmxXRbVkjtJkKYeuw4wxR6A/6266', '2025-06-24 20:03:04', 1),
(25, 2, 'Felipe', '', 'Fonseca', '', 'FelipePerez@gmail.com', '$2y$10$VzsQj0f1MWz/G5JcRapB8u8g3Jeav2huthhCCyO7.oO6cRmMeWStm', '2025-06-25 11:00:00', 1),
(26, 1, 'Mario', '', 'Hernandez', '', 'MarioHernandez@gmail.com', '$2y$10$0PhxZSEB82qZnOwqBLFBze0s.QCacXWP2ELVIzznI9dnZusiKuKNK', '2025-06-25 01:40:13', 1),
(27, 1, 'Camilo', 'Andres', 'Sanchez', 'Fonseca', 'CamiloSanchez@gmail.com', '$2y$10$9/sBITzz7cxTBdIFCp1nM.pt70UiJKUBOuqw2AeNQGotg0zrcdzzG', '2025-06-25 09:25:47', 1),
(31, 1, 'Luis', 'Alfonso', 'Perez', 'Rodriguez', 'LuisAlfonso@gmail.com', '$2y$10$MO7DgovDaFfbwpPhSzCSyuMUI7PYmlL/eyqMy63orL5KLtXj/HJ7m', '2025-06-26 08:02:58', 1),
(32, 1, 'Pepito', 'Andres', 'Perez', 'Sanchez', 'PepitoPerez@gmail.com', '$2y$10$uDNgVQy42gv1N3WaXj5bdex1NCtBUS0JaNQlOAfv5o7Y0dBpAyL36', '2025-06-26 08:15:06', 1),
(33, 1, 'Maria', 'Jose', 'Sanchez', 'Garzon', 'MariaJose@gmail.com', '$2y$10$oCqKjQQPJPEkkLbuS2oDCujioCNXVSblhAfr5GP313FCvpvxmDd8S', '2025-06-26 08:28:01', 1),
(34, 1, 'Sofia', '', 'Alvarez', 'Mora', 'SofiaAlvarez@gmail.com', '$2y$10$lm6z5OzCR2GVmuA5uw8zcOCXyN8tH8gmVtx.7u3vpLAYwN5ryPe8S', '2025-06-26 08:30:54', 1),
(47, 1, 'Felipe', '', 'Mendez', '', 'MarioMendez@gmail.com', '$2y$10$gje1T2zV6qUyqF8XfaB3BeqWbjwCxzmnrthC04Uv9ogSG65x17MAe', '2025-06-26 10:02:51', 1),
(51, 2, 'Felipe', 'Andres', 'Sanchez', 'Gonzalez', 'FelipeSanchez@gmail.com', '$2y$10$r.q0KPU4ToZDqsF46fECI.s4H5KA.l/0myl/3BlHq/Y22LGFCRcZG', '2025-07-02 07:38:16', 1),
(56, 2, 'Maria', 'Camila', 'Sanchez', 'Bautista', 'MariaBautista@gmail.com', '$2y$10$XBLnx2rugSY2IxMSdW031u.TCoOUbPp0tkA2LC0L3T33IlKVix2De', '2025-07-02 07:41:23', 1),
(59, 2, 'Simon', 'Alfredo', 'Neiza', '', 'SimonNeiza@gmail.com', '$2y$10$17EOlU1Tpm406qgoe6HeveIP4P.vPNt3kQJFOkJiJNgqmbgi958Fy', '2025-07-02 08:01:15', 1),
(61, 2, 'Laura', 'Sofia', 'Mendez', '', 'LauraMendez@gmail.com', '$2y$10$GRdgdQQByi93SLxQ9cyRqekdEN/1vse1hk1GTDpYdkBCKFCDGhdBa', '2025-07-02 08:04:25', 1),
(62, 2, 'Edison', 'Andres', 'Ortiz', '', 'EdisonOrtiz@gmail.com', '$2y$10$0lZzgHdLk.ezd/uoCIr2DexhfctVHaw3lGICrHR3uyrhWU6bAQ73a', '2025-07-03 11:13:17', 1),
(78, 2, 'Maria', '', 'Gomez', '', 'MariaGomez@gmail.com', '$2y$10$G3p.RxWDDjHvMnSZeO4ZD.ll.7MhpaPgzGNUnSMmOyo7/nbmc4dTy', '2025-07-03 08:47:58', 1),
(79, 2, 'Juan', 'David', 'Molina', '', 'JuanMolina@gmail.com', '$2y$10$gR7KobOT0VdhqluZhybK7uOO06qNNtuh517n0wn3m6nOeB/pyQoDe', '2025-07-03 08:48:21', 0),
(82, 1, 'Carlos', '', 'Castro', '', 'Carlos.castro@gmail.com', '$2y$10$qLD7.MJ3vCjmuRV4f5RmWuQqkJDX1S1cwP0SZo1php0mDDCMTmu6m', '2025-07-28 09:43:57', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `fecha_venta` datetime DEFAULT NULL,
  `total_venta` decimal(10,0) DEFAULT NULL,
  `estado_venta` enum('Comprado','Cancelado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_producto`, `id_paciente`, `fecha_venta`, `total_venta`, `estado_venta`) VALUES
(23, 1, 1, '2025-07-23 08:35:27', '3600', 'Comprado'),
(24, 1, 3, '2025-07-22 08:37:35', '7200', 'Comprado'),
(25, 12, 4, '2025-07-21 08:37:35', '18500', 'Comprado'),
(26, 12, 5, '2025-07-20 10:06:32', '18500', 'Comprado'),
(27, 12, 7, '2025-07-19 10:11:14', '37000', 'Comprado'),
(28, 10, 8, '2025-07-18 10:11:14', '45000', 'Comprado'),
(33, 12, 9, '2025-08-01 20:37:35', '10600', 'Comprado'),
(34, 12, 1, '2025-08-01 20:40:09', '10600', 'Comprado'),
(35, 11, 8, '2025-08-01 21:51:43', '21900', 'Comprado'),
(36, 16, 4, '2025-07-01 07:33:22', '2500', 'Comprado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_medico` (`id_medico`),
  ADD KEY `citas_medicas_ibfk_1` (`id_paciente`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id_detalle_venta`),
  ADD KEY `id_medicamento` (`id_medicamento`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `disponibilidad_medicos`
--
ALTER TABLE `disponibilidad_medicos`
  ADD PRIMARY KEY (`id_disponibilidad`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id_entrada`),
  ADD KEY `id_medicamento` (`id_producto`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indices de la tabla `farmaceuticos`
--
ALTER TABLE `farmaceuticos`
  ADD PRIMARY KEY (`id_farmaceutico`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `fk_paciente` (`id_paciente`),
  ADD KEY `fk_medico` (`id_medico`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id_medico`),
  ADD KEY `especialidad_ibfk_3` (`id_especialidad`),
  ADD KEY `fk_medicos_usuario` (`id_usuario`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`),
  ADD UNIQUE KEY `ruta` (`ruta`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`),
  ADD KEY `pacientes_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`),
  ADD UNIQUE KEY `unique_permiso` (`id_rol`,`id_modulo`),
  ADD KEY `id_modulo` (`id_modulo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `recepcionistas`
--
ALTER TABLE `recepcionistas`
  ADD PRIMARY KEY (`id_recepcionista`),
  ADD KEY `recepcionistas_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `recetas_medicas`
--
ALTER TABLE `recetas_medicas`
  ADD KEY `id_receta` (`id_receta`),
  ADD KEY `id_medicamento` (`id_medicamento`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id_salida`),
  ADD KEY `id_medicamento` (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`email`),
  ADD KEY `usuarios_ibfk_1` (`id_rol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `ventas_ibfk_1` (`id_paciente`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `disponibilidad_medicos`
--
ALTER TABLE `disponibilidad_medicos`
  MODIFY `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `farmaceuticos`
--
ALTER TABLE `farmaceuticos`
  MODIFY `id_farmaceutico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id_medico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `recepcionistas`
--
ALTER TABLE `recepcionistas`
  MODIFY `id_recepcionista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id_salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD CONSTRAINT `citas_medicas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_medicas_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`);

--
-- Filtros para la tabla `disponibilidad_medicos`
--
ALTER TABLE `disponibilidad_medicos`
  ADD CONSTRAINT `disponibilidad_medicos_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`) ON DELETE CASCADE;

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `farmaceuticos`
--
ALTER TABLE `farmaceuticos`
  ADD CONSTRAINT `farmaceuticos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  ADD CONSTRAINT `fk_medico` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_paciente` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD CONSTRAINT `especialidad_ibfk_3` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_medicos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recepcionistas`
--
ALTER TABLE `recepcionistas`
  ADD CONSTRAINT `recepcionistas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD CONSTRAINT `salidas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
