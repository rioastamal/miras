<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini menyimpan kumpulan fungsi-fungsi yang berhubungan
 * dengan manajemen session
 *
 * @package libraries
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */

function session_construct() {
	global $_MR;
	
	// jika $_MR['sessions'] sudah terisi sebelumnya maka diasumsikan
	// peritnah ini sudah pernah dipanggil sebelumnya
	if ($_MR['sessions']['data']) {
		return FALSE;
	}
	
	$session_name = $_MR['session_name'];
	
	// cek apakah session cookie ada atau tidak
	if (isset($_COOKIE[$session_name])) {
		$session_id = mr_alpha_numeric($_COOKIE[$session_name]);
		
		// karena session ada maka query session_id dari database
		$db_name = DB_PREFIX . 'sessions';
		$query = "SELECT * FROM $db_name WHERE session_id='$session_id' LIMIT 1";
		$result = $_MR['db']->query($query);
		
		if ($result) {
			// masukkan data ke dalam array session saat ini
			$row = $result->fetch_object();
			$session_data = mr_unserialize($row->session_value);
			
			// cek apakah session telah expired atau belum
			$now = time();
			$user_expires = (int)$row->session_last_activity + $_MR['session_expires'];
			
			// expires apabila akivitias terakhir + waktu expires KURANG DARI sekarang
			if ($user_expires < $now) {
				// session telah expired, set action ke DELETE
				$_MR['sessions']['action'] = 'delete';
			} else {
				// session belum expired jadi set action ke UPDATE
				$_MR['sessions']['action'] = 'update';
			}
			mr_session_set($session_data);
			
			// free result
			$result->close();
		}
	} else {
		// session tidak ada, generate session baru
		$_MR['sessions']['action'] = 'insert';
		$session_id = mr_session_gen_id();
	}
	
	$_MR['sessions']['id'] = $session_id;
	
	site_debug($session_id, 'SESSION ID');
	$session_expires = time() + $_MR['session_expires'];
	setcookie($_MR['session_name'], $session_id, $session_expires, $_MR['cookie_path']);
}

function mr_session_unset($data_name) {
	global $_MR;
	
	if (!array_key_exists($data_name, $_MR['sessions']['data'])) {
		return FALSE;
	}
	
	unset($_MR['sessions']['data'][$data_name]);
}

function mr_session_set($data_name, $data_value=NULL) {
	global $_MR;
	
	// jika $data_name merupakan array maka langsung masukkan 
	if (is_array($data_name)) {
		// gabungkan array dengan kondisi jika ada yang sama, maka
		// nilai dari $data_name yang akan digunakan
		$_MR['sessions']['data'] = $data_name + $_MR['sessions']['data'];
	} else {
		// masukkan ke associative array 
		$_MR['sessions']['data'][$data_name] = $data_value;
	}
}

function mr_session_get($data_name) {
	global $_MR;
	
	if (array_key_exists($data_name, $_MR['sessions']['data'])) {
		return $_MR['sessions']['data'][$data_name];
	}
	
	return FALSE;
}

function mr_session_gen_id() {
	// lakukan query database untuk memanggil session
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$rand = mr_random_string(6);
	$session_id = md5($rand . $ip_addr . $user_agent);
	
	return $session_id;
}

function mr_session_id() {
	global $_MR;
	
	return $_MR['sessions']['id'];
}

function mr_session_destroy() {
	global $_MR;
	
	$db_name = DB_PREFIX . 'sessions';
	$query = "DELETE FROM {$db_name} WHERE session_id=?";
	$stmt = $_MR['db']->prepare($query);
	
	$stmt->bind_param('s', $session_id);
	
	$session_id = mr_session_id();
	
	if ($stmt->execute() === FALSE) {
		site_debug('ERROR Deleting, ' . $stmt->error, 'SESSION CLEAN UP');
	} else {
		site_debug('Deletion OK', 'SESSION CLEAN UP');
	}
	
	$stmt->close();
	setcookie($_MR['session_name'], $session_id, time() - 3600, $_MR['cookie_path']);
	$_MR['sessions']['data'] = array();
}

function mr_session_save() {
	global $_MR;
	
	_mr_session_clean();
	
	if ($_MR['sessions']['action'] == 'delete') {
		mr_session_destroy();
	}
	
	if ($_MR['sessions']['action'] == 'insert') {
		_mr_session_insert();
	}
	
	if ($_MR['sessions']['action'] == 'update') {
		_mr_session_update();
	}
}

function _mr_session_insert() {
	global $_MR;
	
	$db_name = DB_PREFIX . 'sessions';
	$query = "INSERT INTO {$db_name} (session_id, session_value, session_last_activity) VALUES (?, ?, ?)";
	$stmt = $_MR['db']->prepare($query);
	
	$stmt->bind_param('ssi', $session_id, $session_value, $timestamp);
	
	$session_id = mr_session_id();
	// serialize session agar dapat disimpan pada database
	$session_value = mr_serialize($_MR['sessions']['data']);
	$timestamp = time();
	
	if ($stmt->execute() === FALSE) {
		site_debug('ERROR Saving to DB, ' . $stmt->error, 'SESSION CLEAN UP');
	} else {
		site_debug('Saving to DB OK', 'SESSION CLEAN UP');
	}
	
	$stmt->close();
}

function _mr_session_update() {
	global $_MR;
	
	$db_name = DB_PREFIX . 'sessions';
	$query = "UPDATE {$db_name} SET session_value=?, session_last_activity=? WHERE session_id=?";
	$stmt = $_MR['db']->prepare($query);
	
	$stmt->bind_param('sis', $session_value, $timestamp, $session_id);
	
	$session_id = mr_session_id();
	// serialize session agar dapat disimpan pada database
	$session_value = mr_serialize($_MR['sessions']['data']);
	$timestamp = time();
	
	if ($stmt->execute() === FALSE) {
		site_debug('ERROR updating to DB, ' . $stmt->error, 'SESSION CLEAN UP');
	} else {
		site_debug('Update to DB OK', 'SESSION CLEAN UP');
	}
	
	$stmt->close();
}

function _mr_session_clean() {
	global $_MR;
	
	$lucky_numbers = array(7, 9, 10, 21, 27, 33);
	$jackpot = mt_rand(0, 50);
	
	site_debug($jackpot, 'JACKPOT');
	if (in_array($jackpot, $lucky_numbers)) {
		// hapus semua session yang expired
		$db_name = DB_PREFIX . 'sessions';
		$query = "DELETE FROM {$db_name} WHERE (session_last_activity + ?) < UNIX_TIMESTAMP()";
		$stmt = $_MR['db']->prepare($query);
		
		$stmt->bind_param('i', $expire);
		$expire = $_MR['session_expires'];
		
		if ($stmt->execute() === FALSE) {
			site_debug('CLEANING UP ERROR, ' . $stmt->error, 'SESSION CLEAN UP');
		} else {
			site_debug('CLEANING UP OK', 'SESSION CLEAN UP');
		}
		
		$stmt->close();
	}
}
// Letakkan fungsi pada hook page_clean_up agar session yang ada
// dimasukkan ke database
add_hook('page_clean_up', 'mr_session_save');
