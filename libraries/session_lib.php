<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini menyimpan kumpulan fungsi-fungsi yang berhubungan
 * dengan manajemen session
 *
 * @package libraries
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */

/**
 * Fungsi untuk mengawali penggunaan session. Setiap halaman yang akan menggunakan
 * session harus memanggil fungsi ini dulu.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 * @throw Exception
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
		
		if ($result->num_rows > 0) {
			// masukkan data ke dalam array session saat ini
			$row = $result->fetch_object();
			$session_data = mr_unserialize($row->session_value);
			
			// cek apakah session telah expired atau belum
			$now = time();
			$user_expires = (int)$row->session_last_activity + $_MR['session_expires'];
			
			// apakah strick checking diaktifkan?
			if ($_MR['session_strict_check']) {
				// cek kecocokan IP dan User Agent string
				if ($row->session_user_agent !== $_SERVER['HTTP_USER_AGENT']) {
					mr_session_destroy();
					throw new Exception ("Session Error: User Agent tidak sama");
				}
				
				if ($row->session_ip_addr != $_SERVER['REMOTE_ADDR']) {
					mr_session_destroy();
					throw new Exception ("Session Error: IP Address tidak sama");
				}
			}
			
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
		} else {
			// generate session id baru karena yang lama telah dihapus dari 
			// database (akibat dari cleaning up session yang expire)
			$_MR['sessions']['action'] = 'insert';
			$session_id = mr_session_gen_id();
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

/**
 * Fungsi untuk menghapus data tertentu pada session
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $data_name Nama session key yang akan dihapus
 * @return void
 */
function mr_session_unset($data_name) {
	global $_MR;
	
	// hanya lakukan unset jika data key memang ada
	if (array_key_exists($data_name, $_MR['sessions']['data'])) {
		unset($_MR['sessions']['data'][$data_name]);
	}
}

/**
 * Fungsi untuk membuat data session baru
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string|array $data_name Nama session key atau jika array maka session data (array dalam bentuk associative)
 * @param mixed $data_value Session data yang akan dimasukkan
 * @return void 
 */
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

/**
 * Fungsi untuk mendatakan session data
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $data_name Nama session key
 * @return mixed|boolean FALSE
 */
function mr_session_get($data_name) {
	global $_MR;
	
	if (array_key_exists($data_name, $_MR['sessions']['data'])) {
		return $_MR['sessions']['data'][$data_name];
	}
	
	return FALSE;
}

/**
 * Fungsi untuk menggenerate hash session id yang akan digunakan untuk melakukan
 * tracking user. Fungsi ini mengambil string USER AGENT, alamat IP dan
 * 10 karakter random stirng untuk membuat session ID.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string 32 karakter hash
 */
function mr_session_gen_id() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$rand = mr_random_string(10);
	$session_id = md5($rand . $ip_addr . $user_agent);
	
	return $session_id;
}

/**
 * Fungsi untuk mengambil session id
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string
 */
function mr_session_id() {
	global $_MR;
	
	return $_MR['sessions']['id'];
}

/**
 * Fungsi untuk menghapus seluruh session , penghapusan dilakukan dengan melakukan
 * unset pada variabel global $_MR['sessions']['data'] dengan tidak perlu menghapus
 * session yang ada didatabase. Cukup hilangkan isi session_value dengan update
 * data baru yang kosong.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
function mr_session_destroy() {
	global $_MR;
	
	$_MR['sessions']['data'] = array();
	_mr_session_update();
}

function mr_session_save() {
	global $_MR;
	
	_mr_session_clean();
	
	print_r($_MR['sessions']);
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

/**
 * Fungsi untuk memasukkan data session ke database, fungsi ini dipanggil jika 
 * nilai dari $_MR['sessions']['action'] adalah 'insert'.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
function _mr_session_insert() {
	global $_MR;
	
	$db_name = DB_PREFIX . 'sessions';
	$query = "INSERT INTO {$db_name} (session_id, session_value, session_last_activity, session_user_agent, session_ip_addr) 
			  VALUES (?, ?, ?, ?, ?)";
	$stmt = $_MR['db']->prepare($query);
	
	$stmt->bind_param('ssiss', $session_id, $session_value, $timestamp, $user_agent, $ip_addr);
	
	$session_id = mr_session_id();
	// serialize session agar dapat disimpan pada database
	$session_value = mr_serialize($_MR['sessions']['data']);
	$timestamp = time();
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	
	if ($stmt->execute() === FALSE) {
		site_debug('Error saving session to DB, error mesg: ' . $stmt->error, 'SESSION INSERT');
	} else {
		site_debug('Saving session to DB OK', 'SESSION INSERT');
	}
	
	$stmt->close();
}

/**
 * Fungsi untuk mengupdate data session ke database, fungsi ini dipanggil jika 
 * nilai dari $_MR['sessions']['action'] adalah 'update'.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
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
		site_debug('Error updating session to DB, error mesg: ' . $stmt->error, 'SESSION UPDATE');
	} else {
		site_debug('Updating session to DB OK', 'SESSION UPDATE');
	}
	
	$stmt->close();
}

/**
 * Fungsi untuk menghapus record session yang telah expired pada database. Fungsi
 * ini dijalankan secara acak berdasarkan pencocokan nomor tertentu
 * agar tidak dieksekusi setiap kali halaman diload.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
function _mr_session_clean() {
	global $_MR;
	
	$lucky_numbers = array(7, 9, 10, 21, 27, 33);
	$jackpot = mt_rand(0, 50);	// random number max 50
	
	site_debug($jackpot, 'JACKPOT');
	// jika $jakcpot salah satu diantara $lucky_number lakkan pembersihan
	// session yang expired
	if (in_array($jackpot, $lucky_numbers)) {
		$db_name = DB_PREFIX . 'sessions';
		$query = "DELETE FROM {$db_name} WHERE (session_last_activity + ?) < UNIX_TIMESTAMP()";
		$stmt = $_MR['db']->prepare($query);
		
		$stmt->bind_param('i', $expire);
		$expire = $_MR['session_expires'];
		
		if ($stmt->execute() === FALSE) {
			site_debug('Session clean up error, mesg: ' . $stmt->error, 'SESSION CLEAN UP');
		} else {
			site_debug('Session clean up OK', 'SESSION CLEAN UP');
		}
		
		$stmt->close();
	}
}

// Tempatkan hook pada akhir eksekusi script
add_hook('page_clean_up', 'mr_session_save');
