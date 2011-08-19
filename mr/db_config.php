<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File konfigurasi untuk koneksi ke database
 *
 * @package mr
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */

// database name
define('DB_NAME', 'test');
// database user
define('DB_USER', 'root');
// database pass
define('DB_PASS', 'b3nsql');
// database host
define('DB_HOST', 'localhost');
// database prefix
define('DB_PREFIX', 'mr_');

/**
 * Global variabel untuk menampung resource database
 */

// menyimpan koneksi database
$_MR['db'] = NULL;