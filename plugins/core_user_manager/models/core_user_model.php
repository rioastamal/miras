<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang berhubungan dengan manipulasi tabel user
 * yang digunakan oleh plugin core_user_manager
 *
 * @package Miras
 * @subpackage Models
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

/**
 * Hooks untuk melakukan manipulasi pada hasil query user yang dilakukan
 * pada model users_model
 *
 * @param
 */
function core_alter_user(&$user) {
	array_walk($user, '_core_alter_walk');
}

function _core_alter_walk(&$user) {
	global $_MR;
	
	$user->user_fullname = $user->user_first_name . ' ' . $user->user_last_name;
	
	// do something when special user such as Super Admin and Guest
	if ($_MR['super_admin_id'] == $user->user_id) {
		$user->user_type_name = '<em>Super Admin</em>';
	}
	if ($_MR['guest_user_id'] == $user->user_id) {
		$user->user_type_name = '<em>Guest</em>';
	}
	$user->user_status_label = ucfirst(get_user_status_label($user->user_status));
}

// Pasang hook
add_hook('get_user_by', 'core_alter_user');
