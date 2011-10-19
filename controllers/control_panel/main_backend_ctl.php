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

$action = get_argument_by('action');

$data = new stdClass();
$data->action_url = get_backend_url() . '/main-backend/action/login';

switch ($action) {
	case 'login':
		if (isset($_POST['login-submit'])) {
			$username = trim($_POST['username']);
			$password = $_POST['password'];
			
			$data->sess->username = $username;
			try {
				$user = get_user_login($username, $password);
				
				$session_data = array(
					$_MR['cp_session_name'] => TRUE,
					'user_id' => $user->user_id
				);
				// mr_session_setdata($_MR['cp_session_name'], TRUE);
				mr_session_setdata($session_data);
				set_flash_message('Login sucsessful, redirecting...');
				
				$redirect = get_backend_url() . '/main-backend/action/index';
				header('Location: ' . $redirect);
			} catch (Exception $e) {
				set_flash_message($e->getMessage());
				set_flash_class('flash-error');
				
				main_backend_index($data);
			}
		}
	break;
	
	case 'logout':
		mr_session_unset($_MR['cp_session_name']);
		mr_session_unset('user_id');
		
		$redirect = get_backend_url() . '/main-backend/action/index';
		header('Location: ' . $redirect);
	break;
	
	case 'index':
	default:
		main_backend_index($data);
	break;
}

function main_backend_index($data=NULL) {
	global $_MR;
	
	if (mr_session_getdata($_MR['cp_session_name'])) {
		set_page_title('Home - Miras Control Panel');
		
		load_view('backend/header');
		load_view('backend/cpanel_home', $data);
	} else {
		set_page_title('Login - Miras Control Panel');
		
		load_view('backend/header');
		load_view('backend/cpanel_login', $data);
	}
	load_view('backend/sidebar');
	load_view('backend/footer');
}
