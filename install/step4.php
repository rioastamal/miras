<?php
/**
 * File berisi rutin code melakukan eksekusi dari semua step yang dilakukan
 * sebelumnya yaitu konfigurasi database dan user.
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

if (!isset($_COOKIE['miras_user_session']) || !isset($_COOKIE['miras_db_session'])) {
	$mesg = 'Session expired, please try again from <a href="%s">STEP 2</a>';
	exit(sprintf($mesg, get_base_url() . 'install/step2.php'));
}

set_active_menu('step_4');
set_page_title('Step 4 - Write Settings');

$data = new stdClass();
$data->next_step = TRUE;
$data->file_content = '';
$data->finish_url = get_base_url() . 'install/finish.php';
$data->sql_query = '';
$data->config_file = BASE_PATH . '/mr/db_config.php';

$user_session = unserialize($_COOKIE['miras_user_session']);
$db_session = unserialize($_COOKIE['miras_db_session']);

// try to connect to mysql server
@$dbconn = new MySQLi($db_session->dbhost, $db_session->dbuser, $db_session->dbpass, $db_session->dbname);
if (mysqli_connect_error()) {
	$err = 'Connection Error(%d): %s';
	set_flash_class('flash-error');
	set_flash_message(sprintf($err, mysqli_connect_errno(), mysqli_connect_error()));
}

// get the database engine support
$innodb_support = mr_innodb_support();
// attach to $db_session so we can use it inside the function
$db_session->innodb_support = $innodb_support;

$file_config_content = mr_create_db_config($db_session);
$sql_query_content = mr_create_tables($db_session, $user_session);

$error_mesg = array();

// write the config file
if (file_put_contents($data->config_file, $file_config_content) === FALSE) {
	$error_mesg[] = 'Error writing to file ' . $data->config_file;
}

// execute the query
$result = $dbconn->multi_query($sql_query_content);
if ($result === FALSE) {
	$error_mesg[] = 'QUERY ERROR: ' . $dbconn->error;
} else {
	while($dbconn->next_result());
}

$data->file_content = htmlentities($file_config_content);
$data->sql_query = htmlentities($sql_query_content);

function mr_create_tables($db, $user) {
	global $dbconn;
	
	$query_tables = @file_get_contents(BASE_PATH . '/install/data/miras.sql');
	if (!$query_tables) {
		@$dbconn->close();
		exit('File miras.sql kosong atau tidak ada!');
	}

	$query_foreign = @file_get_contents(BASE_PATH . '/install/data/constraints.sql');
	if (!$query_foreign) {
		@$dbconn->close();
		exit('File constraint.sql kosong atau tidak ada!');
	}
	
	$query_tables = str_replace('MR_PREFIX_', $db->dbprefix, $query_tables);
	
	// check for InnoDB Support
	if ($db->innodb_support) {
		// replace the engine with InnoDB string
		$query_tables = str_replace('MR_ENGINE_DB', 'InnoDB', $query_tables);
		
		// include Foreign Keys constraint too
		$query_foreign = str_replace('MR_PREFIX_', $db->dbprefix, $query_foreign);
		$query_tables .= $query_foreign;
	} else {
		// replace the engine with MyISAM string
		$query_tables = str_replace('MR_ENGINE_DB', 'MyISAM');
	}
	
	$salt = mr_random_string(8);
	$password = md5($salt . $user->pass1);
	
	$search = array('MR_USERNAME', 'MR_FIRST_NAME', 'MR_LAST_NAME', 'MR_PASSWORD', 'MR_SALT', 'MR_EMAIL');
	$replace = array($user->username, $user->firstname, $user->lastname, $password, $dbconn->real_escape_string($salt), $user->email);
	$query_tables = str_replace($search, $replace, $query_tables);
	
	return $query_tables;
}

function mr_create_db_config($data) {
	$config = file_get_contents(BASE_PATH . '/install/data/db_config.txt');
	if (!$config) {
		exit('File data/db_config.txt tidak ada atau kosong!');
	}
	$config = trim($config);
	$config = sprintf($config, $data->dbname, $data->dbuser, $data->dbpass, $data->dbhost, $data->dbprefix);
	
	return $config;
}

function mr_innodb_support() {
	global $dbconn;
	$innodb = FALSE;
	
	if ($result = $dbconn->query('SHOW ENGINES')) {
		while ($row = $result->fetch_object()) {
			$engine = strtolower($row->Engine);
			if ($engine === 'innodb') {
				$support = strtolower($row->Support);
				if ($support === 'default' || $support === 'yes') {
					$innodb = TRUE;
					break;
				}
			}
		}
		$result->close();
	}
	
	return $innodb;
}

set_flash_message('All commands has been successfully executed');
if (count($error_mesg) > 0) {
	$error_mesg = implode('<br/>', $error_mesg);
	set_flash_class('flash-error');
	set_flash_message($error_mesg);
	$data->next_step = FALSE;
} 

load_view('install/header');
load_view('install/write_settings', $data);
load_view('install/footer');
