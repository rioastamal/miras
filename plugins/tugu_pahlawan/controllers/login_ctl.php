<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }

set_active_menu('tugu_pahlawan');
set_page_title('Login');

$action = get_argument_by('action');
// data view
$data = new stdClass();
// form session (digunakan untuk repopulating data)
$data->sess = NULL;

switch ($action) {
	case 'proses-login':
		tugu_pahlawan_proses_login();
	break;
	case 'logout':
		tugu_pahlawan_logout();
	break;
	default:
		tugu_pahlawan_index();
	break;
}

function tugu_pahlawan_index($data_view=NULL) {
	load_view('header');
	load_view('login', $data_view, 'tugu_pahlawan');
	load_view('sidebar');
	load_view('footer');
}

function tugu_pahlawan_proses_login() {
	try {
		$data->sess->username = trim($_POST['username']);
		
		if (empty($data->sess->username)) {
			throw new Exception('Mohon username diisi.');
		}
		
		$user = get_user_login($_POST['username'], $_POST['password']);
		
		// jika sampai disini berarti tidak ada error (proses autentikasi berhasil)
		mr_session_setdata('user_id', $user->user_id);
		mr_session_setdata('is_logged_in', TRUE);
		
		// redirect user kembali ke halaman utama
		_tugu_pahlawan_redirect();
		
		// stop
		return TRUE;
	} catch (Exception $e) {
		set_flash_message($e->getMessage());
		set_flash_class('flash-error');
	}
	tugu_pahlawan_index($data);
}

function tugu_pahlawan_logout() {
	mr_session_destroy();
	_tugu_pahlawan_redirect();
}

function _tugu_pahlawan_redirect() {
	header('Location: ' . get_site_url() . '/tugu-pahlawan');
}
