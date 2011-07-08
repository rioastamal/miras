-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2011 at 02:18 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: 'berita21'
--

--
-- Dumping data for table 'komentar'
--

INSERT INTO komentar (komentar_id, komentar_nama, komentar_email, komentar_isi, komentar_tgl) VALUES(3, 'alfa', 'alfa@ganteng.com', 'saya tidak tau hal itu', '2010-07-21 19:06:58');
INSERT INTO komentar (komentar_id, komentar_nama, komentar_email, komentar_isi, komentar_tgl) VALUES(4, 'agenk', 'agenk@hoax.com', 'saya tidak berbohong', '2011-07-21 19:06:58');

--
-- Dumping data for table 'artikel_komentar'
--

INSERT INTO artikel_komentar (artikel_id, komentar_id) VALUES(1, 3);
INSERT INTO artikel_komentar (artikel_id, komentar_id) VALUES(2, 4);

