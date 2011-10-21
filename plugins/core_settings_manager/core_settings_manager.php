<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Plugin untuk melakukan perubahan pada settings utama aplikasi
 *
 * @package Miras
 * @subpackage Plugins
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

function core_settings_manager_on_install() {}
function core_settings_manager_on_uninstall() {}
function core_settings_manager_on_activate() {}
function core_settings_manager_on_deactivate() {}
function core_settings_manager_on_upgrade() {}


function core_settings_manager_role() {
	return array(
				'can_view_settings_core'	=> 0,
				'can_update_settings_core'	=> 0
	);
}

function core_settings_backend_menu() {
	if (get_user()->role->can_view_settings_core) {
		tpl_add_menu(array(
			'label' => 'Settings',
			'id' => 'core_settings_manager',
			'title' => 'Modify Website Settings',
			'url' => get_site_url() . '/core-settings-manager/main-backend',
			'order' => 1	
		));
	}
}

// tambahkan hook
add_hook('add_more_backend_menu', 'core_settings_backend_menu');
