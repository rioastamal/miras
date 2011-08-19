<?php 
/**
 * File berisi rutin code untuk menyimpan konfigurasi database yang akan
 * digunakan.
 *
 * @package Miras
 * @subpackage Installer
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
error_reporting(E_ALL);

// deklarasi BASE_PATH
// BASE_PATH adalah lokasi absolute path sampai ke miras
define('BASE_PATH', realpath(dirname( dirname(__FILE__) . '/../..')));
// loading boot-strap file
include_once (BASE_PATH . '/install/boot_strap.php');

set_active_menu('step_2');
set_page_title('Step 2 - Database Configuration');

$data = new stdClass();
$data->next_step = TRUE;
$data->sess->dbhost = 'localhost';
$data->sess->dbprefix = 'mr_';

if (isset($_POST['db-submit'])) {
	$data->sess->dbhost = $_POST['dbhost'];
	$data->sess->dbname = $_POST['dbname'];
	$data->sess->dbuser = $_POST['dbuser'];
	$data->sess->dbpass = $_POST['dbpass'];
	$data->sess->dbprefix = $_POST['dbprefix'];
	
	// check connection
	@$dbconn = new MySQLi($data->sess->dbhost, $data->sess->dbuser, $data->sess->dbpass, $data->sess->dbname);
	if (mysqli_connect_error()) {
		$err = 'Connection Error(%d): %s';
		set_flash_class('flash-error');
		set_flash_message(sprintf($err, mysqli_connect_errno(), mysqli_connect_error()));
	} else {
		// store di cookie agar dapat diambil waktu step terakhir
		$db_session = serialize($data->sess);
		setcookie('miras_db_session', $db_session, time() + 3600);
		header('Location: ' . get_base_url() . 'install/step3.php');
		exit;
	}
}

load_view('install/header');
load_view('install/db_configuration', $data);
load_view('install/footer');
