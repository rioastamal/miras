<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }

set_active_menu('tugu_pahlawan');
set_page_title('Bung Tomo');

$data_view = new stdClass();

load_view('header');
load_view('bung_tomo', $data_view, 'tugu_pahlawan');
load_view('sidebar');
load_view('footer');
