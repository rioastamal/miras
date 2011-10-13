<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }

mr_backend_auth();

set_active_menu('core_user_manager');
set_page_title('User Manager');

load_model('core_user', 'core_user_manager');

$data = new stdClass();
$data->user = get_user();
$data->site_url = get_site_url();

$users = get_user_by();
$data->users = $users;

load_view('backend/header');
load_view('main', $data, 'core_user_manager');
load_view('backend/sidebar');
load_view('backend/footer');
