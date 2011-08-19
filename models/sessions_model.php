<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang berhubungan dengan manipulasi tabel sessions
 *
 * @package Miras
 * @subpackage Models
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
 
/**
 * Fungsi untuk mendapatkan session data
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $sid Hash string dari ID session
 * @return object|FALSE
 */
function mr_session_get($sid) {
	$db_name = DB_PREFIX . 'sessions';
	$query = "SELECT * FROM $db_name WHERE session_id='%s' LIMIT 1";
	$sid = mr_escape_string($sid);
	$query = sprintf($query, $sid);
	
	$result = mr_query($query);
	if (count($result) === 0) {
		return FALSE;
	}
	
	return $result[0];
}

/**
 * Fungsi untuk melakukan insert pada tabel sessions
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $sid Session ID
 * @param string $sval Session Value
 * @param int $sactivity Session last activity dengan format UNIX TIMESTAMP
 * @param string $sua User Agent String (Web Browser)
 * @param string $sip Alamat IP User (IPv4)
 * @return void
 * @throw Exception
 */
function mr_session_insert($sid, $sval, $sactivity, $sua, $sip) {
	$db_name = DB_PREFIX . 'sessions';
	$query = "INSERT INTO {$db_name} (session_id, session_value, session_last_activity, session_user_agent, session_ip_addr) 
			  VALUES ('%s', '%s', %d, '%s', '%s')";
			  
	$sid = mr_escape_string($sid);
	$sval = mr_escape_string($sval);
	$sua = mr_escape_string($sua);
	$sip = mr_escape_string($sip);
	$query = sprintf($query, $sid, $sval, $sactivity, $sua, $sip);
	
	mr_query_insert($query);
}

/**
 * Fungsi untuk melakukan SQL Update pada tabel sessions
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $sid Session ID
 * @param string $sval Session Value
 * @param int $sactivity Session last activity dengan format UNIX TIMESTAMP
 * @return void
 * @throw Exception
 */
function mr_session_update($sid, $sval, $sactivity) {
	$db_name = DB_PREFIX . 'sessions';
	$query = "UPDATE {$db_name} SET session_value='%s', session_last_activity=%d WHERE session_id='%s'";
	
	$sid = mr_escape_string($sid);
	$sval = mr_escape_string($sval);
	$query = sprintf($query, $sval, $sactivity, $sid);
	
	mr_query_update($query);
}

/**
 * Fungsi untuk melakukan SQL Delete pada tabel sessions. Semua record yang 
 * expired akan dihapus dari tabel.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param int $expired TIMESTAMP (saat ini)
 * @return void
 * @throw Exception
 */
function mr_session_delete($expire) {
	$db_name = DB_PREFIX . 'sessions';
	$query = "DELETE FROM {$db_name} WHERE (session_last_activity + %d) < UNIX_TIMESTAMP()";
	$query = sprintf($query, $expire);
	
	mr_query_delete($query);
}
