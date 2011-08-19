<?php
error_reporting(E_ALL);

// deklarasi BASE_PATH
// BASE_PATH adalah lokasi absolute path sampai ke miras
define('BASE_PATH', realpath(dirname( dirname(__FILE__) . '/../..')));
// loading boot-strap file
include_once (BASE_PATH . '/install/boot_strap.php');

set_active_menu('step_3');
set_page_title('Step 3 - User Settings');

$data = new stdClass();
$data->next_step = TRUE;

if (isset($_POST['user-submit'])) {
	$data->sess->username = $_POST['username'];
	$data->sess->firstname = $_POST['firstname'];
	$data->sess->lastname = $_POST['lastname'];
	$data->sess->pass1 = $_POST['pass1'];
	$data->sess->pass2 = $_POST['pass2'];
	$data->sess->email = $_POST['email'];
	
	// all field MUST be filled
	$error = array();
	foreach ($data->sess as $field=>$val) {
		if (trim($val) == '') {
			$error[] = 'All field MUST be filled';
			break;
		}
	}
	
	// cek password
	if ($data->sess->pass1 !== $data->sess->pass2) {
		$error[] = 'Password does not match';
	}
	
	// cek email
	if (!valid_email($data->sess->email)) {
		$error[] = 'Email format is not valid';
	}
	
	if (count($error) > 0) {
		set_flash_class('flash-error');
		$message = implode('<br/>', $error);
		set_flash_message($message);
	} else {
		// no error, save the data to cookie for the last step
		$user_session = serialize($data->sess);
		setcookie('miras_user_session', $user_session, time() + 3600);
		header('Location: ' . get_base_url() . 'install/step4.php');
		exit;
	}
}


load_view('install/header');
load_view('install/user_settings', $data);
load_view('install/footer');
