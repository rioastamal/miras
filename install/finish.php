<?php 
/**
 * File berisi rutin code untuk pemberitahuan bahwa proses installasi telah
 * selesai.
 *
 * @package Miras
 * @subpackage Installer
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
error_reporting(E_ALL);

// deklarasi BASE_PATH
// BASE_PATH adalah lokasi absolute path sampai ke miras
define('BASE_PATH', realpath(dirname( dirname(__FILE__) . '/../..')));
// loading boot-strap file
include_once (BASE_PATH . '/install/boot_strap.php');

set_active_menu('finish');
set_page_title('Finish - Installation Completed');
$data = new stdClass();
$data->config_file = BASE_PATH . '/mr/db_config.php';
$data->dir_to_delete = BASE_PATH . '/install/<br/> ' . BASE_PATH . '/views/default/install/';

load_view('install/header');
load_view('install/finish', $data);
load_view('install/footer');
