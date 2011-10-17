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

function core_insert_user($data) {
	$table_name = 'users';
	
	$query = mr_query_build_insert($table_name, $data);
	site_debug($query, 'INSERT USER QUERY');
	
	// Coba masukkan data ke database
	mr_query_insert($query);
}

function core_username_check($username) {
	$db_users = DB_PREFIX . 'users';
	
	$select = array('user_name');
	$select = mr_query_select($select, $db_users);
	
	$where = array(
					'user_name' => array(
										'value' => $username,
										'op' => '='
								)
	);
	$where = mr_query_where($where);
	
	$query = $select . ' ' . $where . ' LIMIT 1';
	site_debug($query, 'CORE USERNAME CHECK QUERY');
	
	// 0 artinya tidak melakukan query cache
	$result = mr_query($query, 0);
	
	// jika ada record maka username exists jadi lempar exception
	if ($result) {
		$message = sprintf('Username &quot;%s&quot; is unavailable, please choose something else.', $username);
		throw new Exception($message);
	}
}

function core_email_check($email) {
	$db_users = DB_PREFIX . 'users';
	
	$select = array('user_email');
	$select = mr_query_select($select, $db_users);
	
	$where = array(
					'user_email' => array(
										'value' => $email,
										'op' => '='
								)
	);
	$where = mr_query_where($where);
	
	$query = $select . ' ' . $where . ' LIMIT 1';
	site_debug($query, 'CORE EMAIL CHECK QUERY');
	
	// 0 artinya tidak melakukan query cache
	$result = mr_query($query, 0);
	
	// jika ada record maka username exists jadi lempar exception
	if ($result) {
		$message = sprintf('Email &quot;%s&quot; is already registered, please use another email address.', $email);
		throw new Exception($message);
	}
}

function core_user_update($data, $where) {
	$query = mr_query_build_update('users', $data, $where);
	site_debug($query, 'CORE USER UPDATE QUERY');
	
	// exekusi query
	$result = mr_query_update($query);
	
	if (!$result) {
		$user_id = $where['user_id']['value'];
		$message = sprintf('There\'s some errors while updating user ID %s.', $user_id);
		throw new Exception($message);
	}
}

// Pasang hook
add_hook('get_user_by', 'core_alter_user');
