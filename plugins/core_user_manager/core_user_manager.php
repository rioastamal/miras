<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Core plugin 
 *
 * @package Miras
 * @subpackage Plugins
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
 
function core_user_manager_on_install() {}
function core_user_manager_on_uninstall() {}
function core_user_manager_on_activate() {}
function core_user_manager_on_deactivate() {}
function core_user_manager_on_upgrade() {}

function core_user_manager_backend_menu() {
	// cek apakah user memiliki akses untuk melihat daftar user
	if (get_user()->role->can_view_user_core) {
		tpl_add_menu(array(
			'label' => 'Users',
			'id' => 'core_user_manager',
			'title' => 'Manage User',
			'url' => get_site_url() . '/core-user-manager/main-backend',
			'order' => 1	
		));
	}
}

function core_user_manager_role() {
	return array(
		'can_add_user_core'				=> 0,
		'can_edit_user_core'			=> 0,
		'can_delete_user_core'			=> 0,
		'can_view_user_core'			=> 0
	);
}

/**
 * Fungsi untuk menulis sesuatu pada halaman home control panel
 */
function core_write_cp_home() {
	$data = new stdClass();
	$data->create_user_url = get_site_url() . '/core-user-manager/new-backend';
	
	load_view('cp_home', $data, 'core_user_manager');
}

add_hook('sidebar_view', 'core_user_manager_sidebar');
add_hook('add_more_backend_menu', 'core_user_manager_backend_menu');
add_hook('cpanel_home_view', 'core_write_cp_home');
