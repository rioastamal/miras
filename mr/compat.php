<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi rutin code untuk menjaga kompatibilitas dengan versi
 * PHP yang lebih lama (terutama < 5.3.0)
 * 
 * @package Miras
 * @subpackage Mr
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

// -------------- MAGIC QUOTES GPC COMPAT --------------------------- //

/**
 * Fungsi untuk melakukan un-escape pada setiap data yang ada di
 * COOKIE, POST, atau GET. Pada versi yang lebih lama PHP < 5.3
 * data-data tersebut di-escape otomatis karena setting default
 * dari magic_quotes_gpc = on. Sedangkan konfigurasi magic_quotes
 * DEPRECATED sejak PHP 5.3.
 * 
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.3
 * 
 * @return void;
 */
function mr_nomagic_quotes() {
	// cek konfigurasi dari magic_quotes-gpc jika bernilai true maka
	// magic_quotes_gpc aktif
	if (get_magic_quotes_gpc()) {
		// unescape data
		$_COOKIE = array_map('stripslashes', $_COOKIE);
		$_POST = array_map('stripslashes', $_POST);
		
		// masih perlukah GET jika plugin secure url non-active?
		$_GET = array_map('stripslashes', $_GET);
	}
}

// oke langsung panggil sekarang jadi file boot_strap.php tidak
// perlu melakukan pemanggilan fungsi
mr_nomagic_quotes();
