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

function mr_backend_auth() {
	global $_MR;
	
	if (!mr_session_getdata($_MR['cp_session_name'])) {
		$login_url = get_backend_url();
		$message = 'Silahkan <a href="%s">Login</a> untuk mengakses control panel.';
		$message = sprintf($message, $login_url);
		throw new Exception ($message);
	}
}
