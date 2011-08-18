<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }

set_active_menu('tugu_pahlawan');
set_page_title('Tugu Pahlawan Surabaya');
$data = NULL;

load_view('header');
load_view('main', $data, 'tugu_pahlawan');
load_view('sidebar');
load_view('footer');
