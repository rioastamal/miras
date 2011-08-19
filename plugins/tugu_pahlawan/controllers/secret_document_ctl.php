<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }

// session cek
if (!mr_session_getdata('is_logged_in')) {
	$login_url = get_site_url() . '/tugu-pahlawan/login';
	$message = 'Silahkan <a href="%s">Login</a> untuk melihat isi dokumen.';
	$message = sprintf($message, $login_url);
	throw new Exception ($message);
}

set_active_menu('tugu_pahlawan');
set_page_title('Secret Document for Mankind');

$data_view = new stdClass();

load_view('header');
load_view('secret_document', $data_view, 'tugu_pahlawan');
load_view('sidebar');
load_view('footer');
