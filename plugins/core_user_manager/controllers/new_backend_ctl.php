<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Controller untuk menambahkan user baru
 *
 * @package Miras
 * @subpackage Plugins
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
mr_backend_auth();

set_active_menu('core_user_manager');
set_page_title('User Manager');
load_model('core_user', 'core_user_manager');

$data = new stdClass();
$data->user = get_user();
$data->site_url = get_site_url();
$data->plugin_url = $data->site_url . '/core-user-manager/new-backend';

mr_add_js('jquery', '1.6.4');

load_view('backend/header');
load_view('new_user', $data, 'core_user_manager');
load_view('backend/sidebar');
load_view('backend/footer');
