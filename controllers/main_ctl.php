<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini adalah contoh halaman default dari sebuah controller bernama 'main'
 *
 * @package Miras
 * @subpackage Controllers
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

set_active_menu('mr_home');
set_page_title('Selamat Datang');

load_view('header');
load_view('welcome');
load_view('sidebar');
load_view('footer');
