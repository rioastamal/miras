<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang berhubungan dengan manipulasi tabel 
 * user_type
 *
 * @package Miras
 * @subpackage Models
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

/**
 * Fungsi untuk mengambil record pada tabel user_type
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.3
 *
 * @param string $order_by - Kolom yang akan diurutkan (disertai prefix ut. misal ut.user_typename)
 * @return array
 */
function get_user_type($order_by='') {
	global $_MR;
	
	$db_user_type = DB_PREFIX . 'user_type ut';
	$guest_id = $_MR['guest_user_id'];
	$query = "SELECT ut.* FROM {$db_user_type} WHERE user_type_id != {$guest_id} ";
	if ($order_by) {
		$query .= "ORDER BY {$order_by}";
	}
	$result = mr_query($query);
	
	if (!$result) {
		throw new Exception ('Tidak ditemukan record pada tabel User Type');
	}
	
	return $result;
}

/**
 * Fungsi untuk mendapatkan role default dari sebuah tipe user
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @param array $where - Query where
 * @return array
 */
function get_user_type_acl($where) {
	$db_user_type = DB_PREFIX . 'user_type ut';
	$query = mr_query_select(array('ut.acl_key', 'ut.acl_value'));
	$query .= mr_query_where($where);
	
	try {
		$result = mr_query($query);
		if (!$result) {
			throw new Exception ('Tidak ditemukan record untuk role yang dicari');
		}
		
		return $result;
	} catch (Exception $e) {
		throw new Exception($e->getMessage());
	}
}
