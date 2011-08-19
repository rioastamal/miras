<?php
error_reporting(E_ALL);

// deklarasi BASE_PATH
// BASE_PATH adalah lokasi absolute path sampai ke miras
define('BASE_PATH', realpath(dirname( dirname(__FILE__) . '/../..')));
// loading boot-strap file
include_once (BASE_PATH . '/install/boot_strap.php');

set_active_menu('step_1');
set_page_title('Step 1 - Requirements Check');

$data = new stdClass();
$data->next_step = TRUE;
$data->step2_url = get_base_url() . 'install/step2.php';
$requirements = array();

// check PHP version
$requirements[1]->message = 'PHP version at least 5.1.6';
$requirements[1]->yours = 'PHP ' . PHP_VERSION;
$requirements[1]->status = 'ok';
if (version_compare(PHP_VERSION, '5.1.6') < 0) {
	$requirements[1]->status = 'failed';
	$data->next_step = FALSE;
}

// check MySQLi extension
$requirements[2]->message = 'MySQLi Extension';
$requirements[2]->yours = 'Loaded';
$requirements[2]->status = 'ok';
if (extension_loaded('mysqli') === FALSE) {
	$requirements[2]->status = 'failed';
	$requirements[2]->yours = 'Not Loaded';
	$data->next_step = FALSE;
}

// check if db_config.php is writeable or not
clearstatcache();
$config_db_file = BASE_PATH . '/mr/db_config.php';
$requirements[3]->message = 'Is file <em>' . $config_db_file . '</em> writeable?';
$requirements[3]->yours = 'Yes';
$requirements[3]->status = 'ok';
if (is_writable($config_db_file) === FALSE) {
	$requirements[3]->status = 'failed';
	$octal_perm = substr(sprintf('%o', fileperms($config_db_file)), -4);
	$requirements[3]->yours = "No ({$octal_perm})";
	$requirements[3]->message .= '<br/><br/>Solution:<br/>Please chmod the file to 0777, you can revert it back to 0644 after installation';
	$data->next_step = FALSE;
}

$cache_dir = BASE_PATH . '/mr/cache/query';
$requirements[4]->message = 'Is directory <em>' . $cache_dir . '</em> writeable?';
$requirements[4]->yours = 'Yes';
$requirements[4]->status = 'ok';
if (is_writable($config_db_file) === FALSE) {
	$requirements[4]->status = 'failed';
	$octal_perm = substr(sprintf('%o', fileperms($config_db_file)), -4);
	$requirements[4]->yours = "No ({$octal_perm})";
	$requirements[4]->message .= '<br/><br/>Solution:<br/>Please chmod the directory to 0777';
	$data->next_step = FALSE;
}

$cache_dir = BASE_PATH . '/mr/cache/content';
$requirements[5]->message = 'Is directory <em>' . $cache_dir . '</em> writeable?';
$requirements[5]->yours = 'Yes';
$requirements[5]->status = 'ok';
if (is_writable($config_db_file) === FALSE) {
	$requirements[5]->status = 'failed';
	$octal_perm = substr(sprintf('%o', fileperms($config_db_file)), -4);
	$requirements[5]->yours = "No ({$octal_perm})";
	$requirements[5]->message .= '<br/><br/>Solution:<br/>Please chmod the directory to 0777';
	$data->next_step = FALSE;
}

$data->reqs =& $requirements;

load_view('install/header');
load_view('install/requirement_check', $data);
load_view('install/footer');
