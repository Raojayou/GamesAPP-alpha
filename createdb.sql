-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 13, 2017 at 09:48 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `distroadadb`
--
CREATE DATABASE IF NOT EXISTS `distroadadb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `distroadadb`;

-- --------------------------------------------------------

--
-- Table structure for table `distro`
--

DROP TABLE IF EXISTS `distro`;
CREATE TABLE `distro` (
  `id` int(11) NOT NULL,
  `image` tinytext,
  `name` tinytext NOT NULL,
  `ostype` tinytext NOT NULL,
  `basedon` tinytext NOT NULL,
  `origin` tinytext NOT NULL,
  `arch` tinytext NOT NULL,
  `desktop` tinytext NOT NULL,
  `category` tinytext NOT NULL,
  `status` tinytext NOT NULL,
  `version` tinytext,
  `web` tinytext NOT NULL,
  `doc` tinytext,
  `forums` tinytext,
  `error_tracker` tinytext,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `distro`
--

INSERT INTO `distro` (`id`, `image`, `name`, `ostype`, `basedon`, `origin`, `arch`, `desktop`, `category`, `status`, `version`, `web`, `doc`, `forums`, `error_tracker`, `description`, `created_at`, `updated_at`) VALUES
(2, 'http://distrowatch.com/images/yvzhuwbpy/opensuse.png', 'OpenSUSE', 'Linux', 'Android, Independent', 'Germany', 'acorn32, alpha', 'AfterStep, Android, Cinnamon, GNOME, IceWM, KDE, LXDE, WMaker, Xfce', 'Disk Management', 'Active', '42.3', 'http://www.opensuse.org/', 'http://en.opensuse.org/Portal:Documentation', '', 'http://bugs.opensuse.org/', 'El proyecto openSUSE es un programa comunitario patrocinado por Novell. Promoviendo el uso de Línux en todas partes, este programa provee de acceso libre y sencillo a openSUSE, una distribución completa de Línux. El proyecto openSUSE tiene tres metas principales: Hacer de openSUSE el Línux más fácil de obtener para cualquiera y que sea la distribución de Línux más ampliamente usada; aprovechar la colaboración del código abierto para hacer de openSUSE la distribución de Línux más usable del mundo y a su ambiente de escritorio para usuarios nuevos y experimentados; simplificar drásticamente el desarrollo y los procesos de empaquetamiento y abrirlos para hacer a openSUSE la plataforma por excelencia de los desarrolladores de Línux y vendedores de software.', '0000-00-00 00:00:00', '2017-11-03 20:04:16'),
(13, 'http://distrowatch.com/images/yvzhuwbpy/mint.png', 'Linux Mint', 'Linux', 'Debian, Ubuntu (LTS)', 'Ireland', 'i386, x86_64', 'Cinnamon, GNOME, KDE, MATE, Xfce', 'Beginners, Desktop, Live Medium', 'Active', '18.2', 'http://linuxmint.com/', 'http://community.linuxmint.com/', 'http://linuxmint.com/forum/', 'https://bugs.launchpad.net/linuxmint', 'Linux Mint es una distribución basada en Ubuntu cuya meta es proveer una experiencia más completa lista para usarse mediante la inclusión de complementos del navegador, códecs multimedia, soporte de reproducción de DVD, Java y otros componentes. También agrega un escritorio y menús a la medida, varias herramientas de configuración únicas y una interface de instalación de paquetes basada en red. Linux Mint es compatible con los repositorios de programas de Ubuntu.', '2017-11-03 20:09:20', '2017-11-13 16:52:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `distro`
--
ALTER TABLE `distro`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `distro`
--
ALTER TABLE `distro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;