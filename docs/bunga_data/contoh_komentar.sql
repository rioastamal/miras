-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
INSERT INTO `komentar` (`komentar_id`, `komentar_nama`, `komentar_email`, `komentar_isi`, `komentar_tgl`) VALUES
(1, 'hastin', 'hastin@susugede.com', 'kok iso'' sih....,gede.... :))', '2011-06-14 17:03:16'),
(2, 'yegi', 'yegi@menenk.com', 'silent rweek...., ojok banter" :))', '2011-07-05 17:04:05');# 2 row(s) affected.


INSERT INTO `artikel_komentar` (`artikel_id`, `komentar_id`) VALUES
(1, 1),
(1, 2);# 2 row(s) affected.
