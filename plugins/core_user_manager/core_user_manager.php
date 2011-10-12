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
	tpl_add_menu(array(
		'label' => 'User Manager',
		'id' => 'core_user_manager',
		'title' => 'Manage User',
		'url' => get_site_url() . '/core-user-manager/main-backend',
		'order' => 1	
	));
}

function core_user_manager_role() {
	return array(
		'can_add_user'			=> 0,
		'can_edit_user'			=> 0,
		'can_delete_user'		=> 0,
		'can_view_user'			=> 1
	);
}

add_hook('sidebar_view', 'core_user_manager_sidebar');
add_hook('add_more_backend_menu', 'core_user_manager_backend_menu');
