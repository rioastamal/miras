<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang tabel users
 * 
 * @package libraries
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */

/**
 * Fungsi untuk mendapatkan profile dari sebuah user lengkap dengan rolenya
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param int $uid - ID dari user yang ingin didapatkan profilena
 * @return object
 */
function get_user_by_id($uid) {
	global $_MR;
	$db_user = DB_PREFIX . 'users u';
	$db_user_type = DB_PREFIX . 'user_type ut';
	$uid = mr_escape_string($uid);
	$query = "SELECT u.*, ut.user_type_name FROM {$db_user} 
			  LEFT JOIN {$db_user_type} ON ut.user_type_id=u.user_type_id
			  WHERE u.user_id=$uid LIMIT 1";
	$result = mr_query($query);
	$profile = $result[0];
	
	// dapatkan daftar role dengan memanggil fungsi get_user_role
	$role = get_acl_role($uid, $profile->user_type_id);
	$profile->role = $role;
	$profile->role->rolename = $profile->user_type_name;
	
	// unset beberapa atribut yang kurang diperlukan
	unset($profile->user_salt, $profile->user_pass, $profile->user_type_name);
	
	// pasang hooks agar plugin atau bagian kode yang lain mungkin berminat
	// untuk melakukan modifkasi
	run_hooks('user_set_profile', $profile);
	
	// set user sebagai super admin jika ID user tersebut sesuai dengan
	// yang ada pada konfigurasi
	$role->is_super_admin = 0;
	if ($_MR['super_admin_id'] == $profile->user_id) {
		$role->is_super_admin = 1;
		$role->rolename = 'Super Admin';
	}
	
	// dapatkan role dari setiap plugin untuk dimasukkan ke role utama user ini
	assign_plugin_role($role);
	
	// pasang hooks agar plugin atau bagian kode yang lain mungkin berminat
	// untuk melakukan modifkasi
	run_hooks('user_set_role', $role);
	
	return $profile;
}

/**
 * Fungsi untuk mendapatkan daftar user role
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param int $uid - ID dari User
 * @param int $user_type_id - Type ID (Role ID) dari User
 * @return object
 */
function get_acl_role($uid, $user_type_id) {
	$user_type_id = mr_escape_string($user_type_id);
	$db_acl = DB_PREFIX . 'acl a';
	$db_user_meta = DB_PREFIX . 'user_meta um';
	$query = "SELECT a.acl_key, a.acl_value 
			FROM {$db_acl}
			WHERE user_type_id=$user_type_id
			UNION
			SELECT SUBSTR(um.user_meta_name, 5), um.user_meta_value 
			FROM {$db_user_meta} WHERE um.user_meta_name LIKE 'acl_%'
			AND um.user_id=$uid";	
	$result = mr_query($query);
	$role = new stdClass();
	foreach ($result as $row) {
		$role->{$row->acl_key} = (int)$row->acl_value;
	}
	
	return $role;
}

/**
 * Fungsi untuk melakukan inisialisasi awal role dari user, jika tidak ada proses
 * login maka default user role yang diberikan adalah Guest
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
function init_user_role() {
	global $_MR;
	
	// dapatkan session user_id, jika tidak ada maka asumsikan dia adalah 
	// user Guest
	$uid = mr_session_getdata('user_id');
	if ($uid === FALSE) {
		$uid = $_MR['guest_user_id'];
	}
	
	$_MR['user'] = get_user_by_id($uid);
}

function get_user() {
	global $_MR;
	
	return $_MR['user'];
}
