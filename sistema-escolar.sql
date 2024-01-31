CREATE DATABASE sistema_escolar;
USE sistema_escolar;
-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2020 a las 05:38:36
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema-escolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `activities`
(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `students`
(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `age` INT(11) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `identification` VARCHAR(20) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone` BIGINT(20) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `birthdate` DATE NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

CREATE TABLE `classrooms` (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados`
--

CREATE TABLE `degrees` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE `periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `grades` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `student_id` INT(11) NOT NULL,
  `course_id` INT(11) NOT NULL,
  `period_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX `idx_student_id` (`student_id`) USING BTREE,
  INDEX `idx_course_id` (`course_id`) USING BTREE,
  INDEX `idx_period_id` (`period_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `teachers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `identification` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `phone` BIGINT(20) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `level` VARCHAR(100) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesoprofesor`
--

CREATE TABLE `teacher_courses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `degree_id` INT(11) NOT NULL,
  `classroom_id` INT(11) NOT NULL,
  `teacher_id` INT(11) NOT NULL,
  `course_id` INT(11) NOT NULL,
  `period_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  FOREIGN KEY (`degree_id`) REFERENCES `degrees` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX `idx_degree_id` (`degree_id`) USING BTREE,
  INDEX `idx_classroom_id` (`classroom_id`) USING BTREE,
  INDEX `idx_teacher_id` (`teacher_id`) USING BTREE,
  INDEX `idx_course_id` (`course_id`) USING BTREE,
  INDEX `idx_period_id` (`period_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesoalumno`
--

CREATE TABLE `student_teachers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_id` INT(11) NOT NULL,
  `teacher_course_id` INT(11) NOT NULL,
  `period_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`teacher_course_id`) REFERENCES `teacher_courses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX `idx_student_id` (`student_id`) USING BTREE,
  INDEX `idx_teacher_course_id` (`teacher_course_id`) USING BTREE,
  INDEX `idx_period_id` (`period_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos`
--

CREATE TABLE `contents`
(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `material` VARCHAR(255) NOT NULL,
  `teacher_course_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  FOREIGN KEY (`teacher_course_id`) REFERENCES `teacher_courses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX `idx_teacher_course_id` (`teacher_course_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE `assessments`
(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `date` DATE NOT NULL,
  `percentage` VARCHAR(100) NOT NULL,
  `content_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX `idx_content_id` (`content_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE `submitted_assessments`
(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `material` VARCHAR(255) NOT NULL,
  `observation` VARCHAR(255) NOT NULL,
  `assessment_id` INT(11) NOT NULL,
  `student_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX `idx_assessment_id` (`assessment_id`) USING BTREE,
  INDEX `idx_student_id` (`student_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `marks` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `assessment_id` INT(11) NOT NULL,
  `mark_value` INT(11) NOT NULL,
  `date` DATETIME NOT NULL,
  `period_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX `idx_assessment_id` (`assessment_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `roles` (`name`, `created`) VALUES
('Administrador', '2024-11-01'),
('Asistente', '2024-11-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `user` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` TIMESTAMP NOT NULL,
  `is_active` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX `idx_role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `users` (`name`, `user`, `password_hash`, `role_id`, `created`) VALUES
('Luis Noguera', 'admin', '$2y$10$0R6PdfuRSnsORi1WtYlTAuxZcEHS2t0b97OuhmTBDbf2c6zNphFhC', 1, "2024-11-01"),
('Jesus Mireles', 'jesus1', '$2y$10$jCtsfOfFwiKBwKvESViukuA0YSg4W3MbZIJTQNmDx.au2EqDXBtv.', 2, "2024-11-01"),
('Andres', 'andres1', '$2y$10$NRNhbzPgwxb8TKqrVqZopu7Pwe.9eJVtK7srAcJWSSAtGXKv03nx.', 1, "2024-11-01");

INSERT INTO `teachers` (`name`, `address`, `identification`, `password`, `phone`, `email`, `level`, `created`) VALUES
('Diego Mendez', 'Cra 9 11 - 10', '1001310783', '$2y$10$0R6PdfuRSnsORi1WtYlTAuxZcEHS2t0b97OuhmTBDbf2c6zNphFhC', 3138127195, 'dieguinquip@gmail.com', '10', "2024-11-01");

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
