<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }

// session cek
if (!mr_session_getdata('is_logged_in')) {
	$login_url = get_site_url() . '/tugu-pahlawan/login';
	$message = 'Silahkan <a href="%s">Login</a> untuk mengganti site description.';
	$message = sprintf($message, $login_url);
	throw new Exception ($message);
}

set_active_menu('tugu_pahlawan');
set_page_title('Ganti Deskripsi Website');

$action = get_argument_by('action');
// data view
$data = new stdClass();
// form session (digunakan untuk repopulating data)
$data->sess->desc = get_option('site_description');

switch ($action) {
	case 'save-description':
		tugu_pahlawan_save_desc($data);
	break;
	default:
		tugu_pahlawan_index($data);
	break;
}

function tugu_pahlawan_index($data_view=NULL) {
	load_view('header');
	load_view('ganti_deskripsi', $data_view, 'tugu_pahlawan');
	load_view('sidebar');
	load_view('footer');
}

function tugu_pahlawan_save_desc($data) {
	if (isset($_POST['desc-submit'])) {
		try {
			$data->sess->desc = $_POST['deskripsi'];
			update_option('site_description', $data->sess->desc);
			set_flash_message('Deskripsi berhasil diganti');
		} catch (Exception $e) {
			set_flash_message($e->getMessage());
			set_flash_class('flash-error');
		}
	}
	tugu_pahlawan_index($data);
}
