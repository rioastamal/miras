<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang digunakan untuk melakukan manipulasi
 * session pada database. Kedepan selain database mungkin akan dibahkan
 * storage lain seperti APC, memcache, dll.
 *
 * @package Miras
 * @subpackage Libraries
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

// load model yang dibutuhkan
load_model('sessions');

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
function mr_session_construct() {
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
		$row = mr_session_get($session_id);
		if ($row) {
			$session_data = mr_unserialize($row->session_value);
			
			// cek apakah session telah expired atau belum
			$now = time();
			$user_expires = (int)$row->session_last_activity + $_MR['session_expires'];
			
			// apakah strick checking diaktifkan?
			if ($_MR['session_strict_check']) {
				// cek kecocokan IP dan User Agent string
				if ($row->session_user_agent !== $_SERVER['HTTP_USER_AGENT']) {
					mr_session_destroy(TRUE);
					throw new Exception ("Session Error: User Agent tidak sama");
				}
				
				if ($row->session_ip_addr != $_SERVER['REMOTE_ADDR']) {
					mr_session_destroy(TRUE);
					throw new Exception ("Session Error: IP Address tidak sama");
				}
			}
			
			// expires apabila akivitias terakhir + waktu expires KURANG DARI sekarang
			if ($user_expires < $now) {
				// session telah expired, set action ke DELETE
				$_MR['sessions']['action'] = 'delete';
			} else {
				// cek apakah last_activity dari user masih berada dalam toleransi
				// session_time_to_update atau tidak
				$diff = $now - (int)$row->session_last_activity;
				// jika selisih waktu aktifitas melebihi time_to_update maka
				// last_activity perlu diupdate
				if ($diff > $_MR['session_time_to_update']) {
					// update session
					$_MR['sessions']['action'] = 'update';
				}
			}
			
			// jangan melakukan force_update karena akan mempengaruhi cara kerja
			// session_time_to_update, biarkan logika diatas yang menentukan
			// apakah akan diupdate atau tidak.
			mr_session_setdata($session_data, NULL, FALSE);
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
 * @changelog: 2012-02-01 => Menambahkan parameter ketiga yaitu $force_update
 *
 * @param string|array $data_name Nama session key atau jika array maka session data (array dalam bentuk associative)
 * @param mixed $data_value Session data yang akan dimasukkan
 * @param boolean $force_update apakah perlu dilakukan query update saat akhir script atau tidak.
 * @return void 
 */
function mr_session_setdata($data_name, $data_value=NULL, $force_update=TRUE) {
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
	
	// force untuk melakukan query update pada akhir script jika diperlukan
	if ($force_update) {
		if ($_MR['sessions']['action'] !== 'insert') {
			$_MR['sessions']['action'] = 'update';
		}
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
function mr_session_getdata($data_name) {
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
 * @changelog:
 *   7 January 2012 (v1.0.7) => Menambahkan parameter $full_destroy
 *
 * @param boolean $full_destroy - Apakah cookie juga akan dihapus.
 * @return void
 */
function mr_session_destroy($full_destroy=FALSE) {
	global $_MR;
	
	// paksa untuk menghapus cookie, sehingga cookie lama tidak digunakan.
	if ($full_destroy === TRUE) {
		$sess_name = $_MR['session_name'];
		site_debug($sess_name, 'DESTROY COOKIE');
		setcookie($sess_name, 'foo', time() - 3600, $_MR['cookie_path']);
		
		// langsung hapus session yang ada pada database
		mr_session_delete_id($_COOKIE[$sess_name]);
	} else {
		// cukup update session datanya dengan data kosong
		$_MR['sessions']['data'] = array();
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
	
	$session_id = mr_session_id();
	// serialize session agar dapat disimpan pada database
	$session_value = mr_serialize($_MR['sessions']['data']);
	$timestamp = time();
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	
	// panggil fungsi dari model
	try {
		$result = mr_session_insert($session_id, $session_value, $timestamp, $user_agent, $ip_addr);
		site_debug('Saving session to DB OK', 'SESSION INSERT');
	} catch (Exception $e) {
		site_debug('Error saving session to DB, error mesg: ' . $e->getMessage(), 'SESSION INSERT');
	}
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
	
	$session_id = mr_session_id();
	// serialize session agar dapat disimpan pada database
	$session_value = mr_serialize($_MR['sessions']['data']);
	$timestamp = time();
	
	// panggil fungsi dari model
	try {
		$result = mr_session_update($session_id, $session_value, $timestamp);
		site_debug('Updating session to DB OK', 'SESSION UPDATE');
	} catch (Exception $e) {
		site_debug('Error updating session to DB, error mesg: ' . $e->getMessage(), 'SESSION UPDATE');
	}
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
	
	$lucky_numbers = array(7, 9, 10, 21, 27, 99);
	$jackpot = mt_rand(0, 100);	// random number max 100
	
	site_debug($jackpot, 'JACKPOT');
	// jika $jakcpot salah satu diantara $lucky_number lakukan pembersihan
	// session yang expired
	if (in_array($jackpot, $lucky_numbers)) {
		$expire = $_MR['session_expires'];
		
		try {
			mr_session_delete($expire);
			site_debug('Session clean up OK', 'SESSION CLEAN UP');
		}  catch (Exception $e) {
			site_debug('Session clean up error, mesg: ' . $e->getMessage(), 'SESSION CLEAN UP');
		}
	}
}

/**
 * Fungsi yang dipanggil untuk proses manipulasi session pada akhir script
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void;
 */ 
function mr_session_destruct() {
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

// Tempatkan hook pada akhir eksekusi script
add_hook('page_clean_up', 'mr_session_destruct');

