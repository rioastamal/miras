<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi configurasi dasar untuk database
 *
 * @package Miras
 * @subpackage Mr
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

// database name
define('DB_NAME', 'miras');
// database user
define('DB_USER', 'miras_admin');
// database pass
define('DB_PASS', 'lima-persen');
// database host
define('DB_HOST', 'localhost');
// database prefix
define('DB_PREFIX', 'mr_');

$_MR['db_trans'] = TRUE;

/**
 * Global variabel untuk menampung resource database
 */

// menyimpan koneksi database
$_MR['db'] = NULL;
