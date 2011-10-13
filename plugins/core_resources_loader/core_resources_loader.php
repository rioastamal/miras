<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Plugin untuk meload HTML resources seperti Javascript dan CSS
 *
 * @package Miras
 * @subpackage Plugins
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

function core_resources_loader_on_install() {}
function core_resources_loader_on_uninstall() {}
function core_resources_loader_on_activate() {}
function core_resources_loader_on_deactivate() {}
function core_resources_loader_on_upgrade() {}
function core_resources_loader_role() {}

load_helper('resources_loader', 'core_resources_loader');

/**
 * Fungsi untuk meload setiap resource yang telah dimasukkan ke antrian
 *
 */
function core_resources_loader() {
	global $_MR;
	
	$data = new stdClass();
	$data->javascripts = $_MR['loaded_javascripts'];
	
	site_debug(print_r($_MR['loaded_javascripts'], TRUE), 'LOADED JAVASCRIPT');
	load_view('resources_loader', $data, 'core_resources_loader');
}

// pasang hook pada 'page_head'
add_hook('page_head', 'core_resources_loader');
