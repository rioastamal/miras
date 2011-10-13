<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Fle ini menghandle proses control panel login 
 *
 * @package Miras
 * @subpackage Controllers
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

set_active_menu('mr_home');
set_page_title('Login - Miras Control Panel');

$data = new stdClass();
if (isset($_POST['login-submit'])) {
	$username = trim($_POST['username']);
	$password = $_POST['password'];
	
	$data->sess->username = $username;
	try {
		get_user_login($username, $password);
		
		mr_session_setdata($_MR['cp_session_name'], TRUE);
		set_flash_message('Login sucsessful, redirecting...');
	} catch (Exception $e) {
		set_flash_message($e->getMessage());
		set_flash_class('flash-error');
	}
}

load_view('backend/header');
load_view('backend/cpanel_login', $data);
load_view('backend/sidebar');
load_view('backend/footer');
