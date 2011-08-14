<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File konfigurasi untuk koneksi ke database
 *
 * @package mr
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */
 */

// database name
define('DB_NAME', 'berita21');
// database user
define('DB_USER', 'berita_user');
// database pass
define('DB_PASS', 'berita123');
// database host
define('DB_HOST', 'localhost');
// database prefix
define('DB_PREFIX', '');

/**
 * Global variabel untuk menampung resource database
 */

// menyimpan koneksi database
$_MR['db'] = NULL;

// menyimpan query terakhir
$_MR['db_query'] = '';

// menyimpan query error
$_MR['db_error_msg'] = '';
$_MR['db_error_no'] = '';
