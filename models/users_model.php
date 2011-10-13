<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang berhubungan dengan manipulasi tabel users
 *
 * @package Miras
 * @subpackage Models
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
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
	
	$role->is_super_admin = 0;
	$role->is_guest = 1;
	
	// set user sebagai super admin jika ID user tersebut sesuai dengan
	// yang ada pada konfigurasi
	if ($_MR['super_admin_id'] == $profile->user_id) {
		$role->is_super_admin = 1;
		$role->rolename = 'Super Admin';
	}
	
	// tambahkan role baru bernama is_guest jika user merupakan guest
	if ($_MR['guest_user_id'] != $profile->user_id) {
		$role->is_guest = 0;
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

function get_user_by($where=array(), $order_by='') {
	$db_user = DB_PREFIX . 'users u';
	$db_user_type = DB_PREFIX . 'user_type ut';
	$query = "SELECT u.*, ut.* FROM {$db_user} 
			  LEFT JOIN {$db_user_type} ON ut.user_type_id=u.user_type_id";
	$query .= mr_query_where($where);
	$query .= "\n" . $order_by;
	
	$result = mr_query($query);
	if (!$result) {
		throw new Exception ('Tidak ada user yang ditemukan.');
	}
	
	run_hooks('get_user_by', $result);
	
	return $result;
}

function get_user_login($username, $password) {
	$db_user = DB_PREFIX . 'users u';
	$username = mr_escape_string($username);
	$password = mr_escape_string($password);
	
	$query = "SELECT u.* FROM {$db_user} WHERE u.user_name='%s' LIMIT 1";
	$query = sprintf($query, $username);
	$result = mr_query($query);
	
	if (!$result) {
		$message = 'Username "%s" tidak ditemukan, mohon cek kembali';
		throw new Exception(sprintf($message, $username));
	}
	
	// ambil result dan tempatkan pada variabel pembantu
	$user = $result[0];
	
	// jika user status tidak sama dengan aktif pada 
	$active_status_id = get_user_status_number('active');
	if ($user->user_status != $active_status_id) {
		$message = 'Status user "%s" tidak aktif';
		throw new Exception(sprintf($message, $username));
	}
	
	// cocokkan password
	$given_password = md5($user->user_salt . $password);
	if ($given_password !== $user->user_pass) {
		throw new Exception('Username atau password salah!');
	}
	
	return $user;
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

/**
 * Fungsi untuk mendapatkan object user yang disimpan pada global variabel
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return object
 */
function get_user() {
	global $_MR;
	
	return $_MR['user'];
}

/**
 * Fungsi untuk melakukan mapping dari user status berupa string ke
 * user status angka
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $status - String status yang ingin didapatkan angkanya
 * @return int
 */
function get_user_status_number($status) {
	$status = strtolower($status);
	switch ($status) {
		case 'deleted': return 0; break;
		case 'pending': return 1; break;
		case 'blocked': return 2; break;
		case 'active':	return 3; break;
		default:
			return -1;
		break;
	}
}

/**
 * Fungsi untuk melakukan mapping dari user status berupa string ke
 * user status angka
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param int $status - Integer status yang ingin didapatkan namanya
 * @return string
 */
function get_user_status_label($status) {
	switch ($status) {
		case 0: return 'deleted'; break;
		case 1: return 'pending'; break;
		case 2: return 'blocked'; break;
		case 3: return 'active'; break;
		default:
			return 'unknown';
		break;
	}
}
