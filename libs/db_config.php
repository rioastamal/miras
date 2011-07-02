<?php

/**
 * File konfigurasi untuk koneksi ke database
 */

// database name
define('DB_NAME', 'berita21');
// database user
define('DB_USER', 'berita_user');
// database pass
define('DB_PASS', 'berita123');
// database host
define('DB_HOST', 'localhost');

// koneksi ke mysql
$_db_conn = mysql_connect(DB_HOST, DB_USER, DB_PASS);
if (!$_db_conn) {
	exit('Koneksi dabatase error check kembali konfigurasi');
}

// pilih database
if (!mysql_select_db(DB_NAME)) {
	exit('Error saat milih database');
}

