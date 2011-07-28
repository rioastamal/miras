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
-- Dumping data for table 'artikel'
--

INSERT INTO artikel (artikel_id, artikel_judul, artikel_isi, artikel_tgl) VALUES(1, 'Gang Dolly Sepi Ditinggal Penghuni Mudik', 'Surabaya - Pengelola Lokalisasi Dolly, benar-benar mentaati peraturan untuk menutup usahanya selama bulan Ramadan. Menjelang H-2 puasa, suasana Dolly yang biasanya hiruk pikuk mulai terlihat sunyi. Pasalnya, para penghuni lokalisasi mulai mudik ke kampung halamannya masing-masing.\r\n\r\nSuasana sunyi di lokalisasi terbesar se Asia Tenggara itu mulai terlihat, Senin (9/8/2010) malam. Dentuman musik dangdut dan disco yang biasanya menggema, serta suara-suara makelar yang selalu menawarkan servis para PSK tak terlihat lagi.\r\n\r\nGang Dolly yang biasanya gemerlap oleh lampu wisma, menjadi gelap dan tidak terlihat para PSK duduk berjejer di ''aquarium''. Sofa-sofa yang biasanya digunakan duduk para PSK, terlihat kosong melompong dan sebagian di wisma ada sofa yang dibalik, sebagai tanda tidak menerima ''tamu'' pria hidung belang.\r\n\r\nSuasana matinya ''tanda-tanda kehidupan'' Lokalisasi Dolly ini karena, para PSK maupun germonya mudik pulang ke kampung halamannya. Mereka tak bisa  menawarkan servis karena Pemerintah Kota Surabaya dan Muspika Sawahan, meminta menutup dan menghentikan praktek prostitusi di lokalisasi.\r\n\r\n"Tutup pak. Semuanya sudah pulang ke kampung halamannya masing-masing," ujar penjaga Wisma New Barbara, Lokalisasi Dolly, Yasmudi (45) kepada wartawan.\r\n\r\nYasmudi mengatakan, para PSK pulang ke kampung asalnya sejak Senin sekitar pukul 16.00 WIB. Mereka ada yang pulang ke Bandung Jawa Barat, juga beberapa daerah di Jawa Timur. "Kita tutup untuk mentaati peraturan yang dikeluarkan pak camat. Penutupan itu mulai surat edaran dari kecamatan yang ditempelkan sejak, Minggu (8/8/2010)," ujarnya.\r\n\r\nHal yang sama juga dikatakan Asmiani (54) warga Lamongan, penjaga Wisma Jaya Indah. Asmiani mengatakan, sebanyak 7 PSK yang bekerja di wisma tersebut sudah balik sejak Senin pagi. "Sudah pulang semua pak. Ada yang ke Tuban, Malang, Mojokerto juga ada yang dari Bandung," tuturnya.\r\n\r\nRencananya, para PSK tersebut akan kembali melayani pria hidung belang setelah lebaran. "Mungkin baliknya nanti setelah riyoyo kupat (lebaran ketupat)," jelasnya', '2011-07-03 08:52:19');
INSERT INTO artikel (artikel_id, artikel_judul, artikel_isi, artikel_tgl) VALUES(2, 'Google mengeluarkan layanan sosial network bernama: Google+', 'Upaya terbaru Google untuk menjadi lebih sosial dengan Google+ tampaknya sangat berkesan bagi early adopters ditandakan oleh berbagai ulasandan tanggapan positif atas layanan ini.\r\n\r\nBagi mereka yang belum mendapatkan undangan dan menunggu untuk diundang, sayangnya undangan Google+ ditangguhkan kemarin siang karena permintaan yang membludak. Sepertinya ini menjadi cara khas Google dalam menciptakan, memelihara, dan memperpanjang kehebohan setelah peluncuran produk mereka, karena jika ada perusahaan yang sangat mahir tentang scaling, ituadalah Google.\r\n\r\nWalau begitu, masih ada cara untuk mendapatkan undangan Google+ tanpa ‘benar-benar diundang’, yaitu melalui email.\r\n\r\nKetika Anda berbagi posting di Google+ Anda harus menentukan penerima sebelum posting dibagikan. Anda dapat memilih lingkaran tertentu dari kontak yang Anda miliki atau berbagi ke alamat email penerima yang Anda inginkan. Dengan berbagi posting Anda melalui email, penerima dapat melihat apa yang Anda posting di Google+ dan jika mereka mengikuti tautan yang mengatakan, “Pelajari lebih lanjut tentang Google+”, mereka akan dibawa ke Google+ untuk mengaktifkan profil mereka.', '2011-07-03 09:11:33');

--
-- Dumping data for table 'komentar'
--

INSERT INTO komentar (komentar_id, komentar_nama, komentar_email, komentar_isi, komentar_tgl) VALUES(1, 'hastin', 'hastin@susugede.com', 'kok iso'' sih....,gede.... :))', '2011-06-14 17:03:16');
INSERT INTO komentar (komentar_id, komentar_nama, komentar_email, komentar_isi, komentar_tgl) VALUES(2, 'yegi', 'yegi@menenk.com', 'silent rweek...., ojok banter" :))', '2011-07-05 17:04:05');
INSERT INTO komentar (komentar_id, komentar_nama, komentar_email, komentar_isi, komentar_tgl) VALUES(3, 'alfa', 'alfa@ganteng.com', 'saya tidak tau hal itu', '2010-07-21 19:06:58');
INSERT INTO komentar (komentar_id, komentar_nama, komentar_email, komentar_isi, komentar_tgl) VALUES(4, 'agenk', 'agenk@hoax.com', 'saya tidak berbohong', '2011-07-21 19:06:58');

--
-- Dumping data for table 'artikel_komentar'
--

INSERT INTO artikel_komentar (artikel_id, komentar_id) VALUES(1, 1);
INSERT INTO artikel_komentar (artikel_id, komentar_id) VALUES(1, 2);
INSERT INTO artikel_komentar (artikel_id, komentar_id) VALUES(1, 3);
INSERT INTO artikel_komentar (artikel_id, komentar_id) VALUES(2, 4);

