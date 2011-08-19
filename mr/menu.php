<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Berisi default menu untuk aplikasi
 *
 * @package Miras
 * @subpackage Mr
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

// default menu
tpl_add_menu(array(
	'label' => 'Home',
	'id' => 'mr_home',
	'url' => get_site_url(),
	'title' => 'Come to Papa!',
	'order' => 1
));	

// jalankan beberapa hooks yang berhubungan dengan manipulasi menu
run_hooks('add_more_menu');
