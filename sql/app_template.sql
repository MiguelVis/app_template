-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2019 a las 19:04:26
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `app_template`
--
CREATE DATABASE IF NOT EXISTS `app_template` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `app_template`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` varchar(64) DEFAULT NULL,
  `email` varchar(32) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by_user_id` int(10) UNSIGNED NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by_user_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `contacts`:
--

--
-- Truncar tablas antes de insertar `contacts`
--

TRUNCATE TABLE `contacts`;
--
-- Volcado de datos para la tabla `contacts`
--

INSERT INTO `contacts` (`id`, `fullname`, `email`, `created_on`, `created_by_user_id`, `updated_on`, `updated_by_user_id`) VALUES
(1, 'Mercadona, S.A.', 'info@mercadona.es', '2019-06-23 20:47:40', 1, '2019-06-23 21:05:16', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` int(10) UNSIGNED NOT NULL,
  `node_id` int(10) UNSIGNED DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by_user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by_user_id` (`created_by_user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `logs`:
--   `created_by_user_id`
--       `users` -> `id`
--   `created_by_user_id`
--       `users` -> `id`
--

--
-- Truncar tablas antes de insertar `logs`
--

TRUNCATE TABLE `logs`;
--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`id`, `type`, `node_id`, `created_on`, `created_by_user_id`) VALUES
(1, 1, NULL, '2017-12-05 11:22:44', 1),
(2, 3, 1, '2017-12-05 11:25:41', 1),
(3, 1, NULL, '2017-12-05 11:35:11', 1),
(4, 2, NULL, '2017-12-05 11:36:56', 1),
(5, 1, NULL, '2017-12-05 18:23:19', 1),
(6, 2, NULL, '2017-12-05 18:44:29', 1),
(7, 1, NULL, '2017-12-05 18:44:34', 1),
(8, 2, NULL, '2017-12-05 20:13:52', 1),
(9, 1, NULL, '2017-12-21 20:06:41', 1),
(10, 1, NULL, '2018-05-29 20:58:13', 1),
(11, 1, NULL, '2018-05-29 21:05:21', 1),
(12, 1, NULL, '2018-05-29 21:07:13', 1),
(13, 1, NULL, '2018-05-29 21:09:31', 1),
(14, 1, NULL, '2018-05-29 21:16:35', 1),
(15, 1, NULL, '2018-05-29 21:19:34', 1),
(16, 1, NULL, '2018-05-29 21:20:13', 1),
(17, 1, NULL, '2018-05-29 21:21:55', 1),
(18, 1, NULL, '2018-05-29 21:23:57', 1),
(19, 1, NULL, '2018-05-29 21:25:04', 1),
(20, 1, NULL, '2018-11-28 20:43:43', 1),
(21, 2, NULL, '2018-11-28 21:30:42', 1),
(22, 1, NULL, '2019-06-23 19:21:35', 1),
(23, 2, NULL, '2019-06-23 19:34:29', 1),
(24, 1, NULL, '2019-06-23 19:34:34', 1),
(25, 2, NULL, '2019-06-23 21:25:10', 1),
(26, 1, NULL, '2019-06-23 21:36:46', 1),
(27, 2, NULL, '2019-06-23 21:36:55', 1),
(28, 1, NULL, '2019-06-23 21:38:13', 1),
(29, 2, NULL, '2019-06-23 21:38:57', 1),
(30, 1, NULL, '2019-06-23 21:40:57', 1),
(31, 2, NULL, '2019-06-23 21:41:29', 1),
(32, 1, NULL, '2019-06-23 21:42:13', 1),
(33, 1, NULL, '2019-07-18 18:53:11', 1),
(34, 1, NULL, '2019-07-19 17:42:45', 1),
(35, 1, NULL, '2019-07-26 17:41:41', 1),
(36, 2, NULL, '2019-07-26 18:05:12', 1),
(37, 1, NULL, '2019-07-26 18:05:17', 1),
(38, 2, NULL, '2019-07-26 18:08:20', 1),
(39, 1, NULL, '2019-07-26 18:08:35', 1),
(40, 2, NULL, '2019-07-26 18:18:17', 1),
(41, 1, NULL, '2019-07-26 18:18:23', 1),
(42, 1, NULL, '2019-11-03 18:36:38', 1),
(43, 2, NULL, '2019-11-03 18:56:51', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nodes`
--

DROP TABLE IF EXISTS `nodes`;
CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `url` varchar(256) NOT NULL,
  `enabled` tinyint(3) UNSIGNED NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by_user_id` int(10) UNSIGNED NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by_user_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `nodes`:
--

--
-- Truncar tablas antes de insertar `nodes`
--

TRUNCATE TABLE `nodes`;
--
-- Volcado de datos para la tabla `nodes`
--

INSERT INTO `nodes` (`id`, `name`, `url`, `enabled`, `created_on`, `created_by_user_id`, `updated_on`, `updated_by_user_id`) VALUES
(1, 'LUXE HOTELS', 'http://www.google.es', 1, '2017-12-03 20:34:53', 1, '2017-12-04 20:53:13', 1),
(3, 'PARADOR EL SOL', 'http://www.google.com', 1, '2017-12-04 00:29:48', 1, NULL, NULL),
(4, 'BARES MANOLO', 'http://www.google.es', 0, '2017-12-04 00:30:12', 1, '2019-07-18 18:59:58', 1),
(5, 'UNIVERSIDAD VALENCIA', 'http://www.google.cat', 1, '2017-12-04 00:30:32', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `permissions`:
--

--
-- Truncar tablas antes de insertar `permissions`
--

TRUNCATE TABLE `permissions`;
--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'all');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `roles`:
--

--
-- Truncar tablas antes de insertar `roles`
--

TRUNCATE TABLE `roles`;
--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permissions`
--

DROP TABLE IF EXISTS `roles_permissions`;
CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  KEY `role_id` (`role_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `roles_permissions`:
--   `permission_id`
--       `permissions` -> `id`
--   `role_id`
--       `roles` -> `id`
--   `permission_id`
--       `permissions` -> `id`
--   `role_id`
--       `roles` -> `id`
--

--
-- Truncar tablas antes de insertar `roles_permissions`
--

TRUNCATE TABLE `roles_permissions`;
--
-- Volcado de datos para la tabla `roles_permissions`
--

INSERT INTO `roles_permissions` (`role_id`, `permission_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `fullname` varchar(64) DEFAULT NULL,
  `enabled` tinyint(3) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `login_session` char(32) DEFAULT NULL,
  `login_expiration` datetime DEFAULT NULL,
  `logged_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by_user_id` int(10) UNSIGNED NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by_user_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `users`:
--   `role_id`
--       `roles` -> `id`
--   `role_id`
--       `roles` -> `id`
--

--
-- Truncar tablas antes de insertar `users`
--

TRUNCATE TABLE `users`;
--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `enabled`, `role_id`, `login_session`, `login_expiration`, `logged_on`, `created_on`, `created_by_user_id`, `updated_on`, `updated_by_user_id`) VALUES
(1, 'admin', 'admin', 'Administrator', 1, 1, '', '0000-00-00 00:00:00', '2019-11-03 18:36:38', '2017-09-28 23:24:10', 1, '2017-12-04 20:38:38', 1),
(2, 'Julito', 'Julito', 'Julito Catedrales', 0, 1, NULL, NULL, NULL, '2017-10-12 22:46:16', 1, '2017-12-04 20:55:15', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_nodes`
--

DROP TABLE IF EXISTS `users_nodes`;
CREATE TABLE IF NOT EXISTS `users_nodes` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `node_id` int(10) UNSIGNED NOT NULL,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `node_id` (`node_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `users_nodes`:
--   `node_id`
--       `nodes` -> `id`
--   `user_id`
--       `users` -> `id`
--   `node_id`
--       `nodes` -> `id`
--   `user_id`
--       `users` -> `id`
--

--
-- Truncar tablas antes de insertar `users_nodes`
--

TRUNCATE TABLE `users_nodes`;
--
-- Volcado de datos para la tabla `users_nodes`
--

INSERT INTO `users_nodes` (`user_id`, `node_id`) VALUES
(1, 4),
(1, 1),
(2, 1),
(1, 3),
(2, 3),
(1, 5),
(2, 4);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_logs_created_by_user_id` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD CONSTRAINT `fk_rp_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `fk_rp_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `users_nodes`
--
ALTER TABLE `users_nodes`
  ADD CONSTRAINT `fk_un_node_id` FOREIGN KEY (`node_id`) REFERENCES `nodes` (`id`),
  ADD CONSTRAINT `fk_un_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
