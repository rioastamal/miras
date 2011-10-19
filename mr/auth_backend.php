<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Pengecekan autentikasi untuk session backend (control panel)
 *
 * @package Miras
 * @subpackage Mr
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 * @since Version 1.0.3
 */

/**
 * Fungsi untuk melakukan pengecekan session control panel
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @return void
 */
function mr_backend_auth() {
	global $_MR;
	
	if (!mr_session_getdata($_MR['cp_session_name'])) {
		$login_url = get_backend_url();
		$message = 'Silahkan <a href="%s">Login</a> untuk mengakses control panel.';
		$message = sprintf($message, $login_url);
		throw new Exception ($message);
	}
}

/**
 * Fungsi untuk melakukan pengecekan session control panel
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @param string $privilege_name - Nama privilege yang akan dicheck
 * @return void
 */
function mr_check_privilege($privilege_name, $message='Anda tidak memiliki hak untuk mengakses halaman ini.') {
	global $_MR;
	
	// cek dari user yang aktif pada session sekarang
	if (isset($_MR['user']->role->$privilege_name)) {
		$privilege = (int)$_MR['user']->role->$privilege_name;
		if ($privilege == 0) {
			throw new Exception ($message);
		}
	} else {
		throw new Exception ($message);
	}
}
