<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Controller untuk menampilkan halaman modifikasi settings
 *
 * @package Miras
 * @subpackage Plugins
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
mr_backend_auth();
mr_check_privilege('can_view_settings_core');

set_active_menu('core_settings_manager');
set_page_title('Modify Site Settings');

$action = get_argument_by('action');
$data = new stdClass();

switch ($action) {
	case 'index':
	default:
		main_backend_index($data);
	break;
}

function main_backend_index() {
	$data->sess->title = get_option('site_title');
	$data->sess->desc = get_option('site_description');
	
	load_view('backend/header');
	load_view('main', $data, 'core_settings_manager');
	load_view('backend/sidebar');
	load_view('backend/footer');
}
