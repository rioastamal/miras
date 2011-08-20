<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi utama yang digunakan oleh hampir semua bagian
 * dari aplikasi.
 *
 * @package Miras
 * @subpackage Plugins
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @copyright 2011 Alfa Radito <qwertqwe16@yahoo.co.id>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
 
/**
 * Fungsi untuk men-secure dari URL Attack
 *
 * @author Alfa Radito <qwertqwe16@yahoo.co.id>
 * @since Version 1.0
 *
 * @return void
 */
function secure_url() {
	// lakukan filter URL, jika terdapat karakter yang tidak diinginkan
	// langsung keluar dari script (berhenti total)
	
	// logika.......
	$url = $_SERVER['REQUEST_URI'];
	$ret = preg_match('@^[a-zA-Z0-9:\-\._\/#~]+$@', $url);
	
	if (!$ret) {
		throw new Exception ("Terdapat karakter yang tidak diperboblehkan pada URL");
	}
}

function secure_url_on_install() {}
function secure_url_on_uninstall() {}
function secure_url_on_activate() {}
function secure_url_on_deactivate() {}
function secure_url_on_upgrade() {}
function secure_url_role() {}

add_hook('pre_routing', 'secure_url');
