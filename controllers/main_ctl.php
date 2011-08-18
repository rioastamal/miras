<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }

set_active_menu('mr_home');
set_page_title('Selamat Datang');

load_view('header');
load_view('welcome');
load_view('sidebar');
load_view('footer');
