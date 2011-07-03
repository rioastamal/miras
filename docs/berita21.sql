-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 03, 2011 at 05:38 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `berita21`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE IF NOT EXISTS `artikel` (
  `artikel_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `artikel_judul` varchar(100) NOT NULL,
  `artikel_isi` text NOT NULL,
  `artikel_tgl` datetime NOT NULL,
  PRIMARY KEY (`artikel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `artikel_kategori`
--

CREATE TABLE IF NOT EXISTS `artikel_kategori` (
  `artikel_id` int(8) unsigned NOT NULL,
  `kategori_id` int(2) unsigned NOT NULL,
  PRIMARY KEY (`artikel_id`,`kategori_id`),
  KEY `fk_artikel_has_kategori_kategori1` (`kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `artikel_komentar`
--

CREATE TABLE IF NOT EXISTS `artikel_komentar` (
  `artikel_id` int(8) unsigned NOT NULL,
  `komentar_id` int(8) unsigned NOT NULL,
  PRIMARY KEY (`artikel_id`,`komentar_id`),
  KEY `fk_artikel_has_komentar_komentar1` (`komentar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `kategori_id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `kategori_nama` varchar(30) NOT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE IF NOT EXISTS `komentar` (
  `komentar_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `komentar_nama` varchar(25) NOT NULL,
  `komentar_email` varchar(50) NOT NULL,
  `komentar_isi` text NOT NULL,
  `komentar_tgl` datetime NOT NULL,
  PRIMARY KEY (`komentar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel_kategori`
--
ALTER TABLE `artikel_kategori`
  ADD CONSTRAINT `fk_artikel_has_kategori_artikel1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_artikel_has_kategori_kategori1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `artikel_komentar`
--
ALTER TABLE `artikel_komentar`
  ADD CONSTRAINT `fk_artikel_has_komentar_artikel` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_artikel_has_komentar_komentar1` FOREIGN KEY (`komentar_id`) REFERENCES `komentar` (`komentar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
