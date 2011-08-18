<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }

tpl_add_menu(array(
	'label' => 'Tugu Pahlawan',
	'id' => 'tugu_pahlawan',
	'title' => 'Sejarah Tugu Pahlawan',
	'url' => get_site_url() . '/tugu-pahlawan',
	'order' => 1	
));

add_hook('sidebar_view', 'tugu_pahlawan_sidebar');

function tugu_pahlawan_on_install() {}
function tugu_pahlawan_on_uninstall() {}
function tugu_pahlawan_on_activate() {}
function tugu_pahlawan_on_deactivate() {}
function tugu_pahlawan_on_upgrade() {}
function tugu_pahlawan_role() {}

function tugu_pahlawan_sidebar() {
	$data = NULL;
	$data->nama_user = get_user()->user_first_name;
	$data->nama_role = get_user()->role->rolename;
	load_view('sidebar', $data, 'tugu_pahlawan');
}
