<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang digunakan sistem templating, seperti
 * penambahan menu. Kedepan sistem menu akan menggunakan library tree bukan
 * array biasa.
 *
 * @package Miras
 * @subpackage Libraries
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

/**
 * Fungsi untuk menambahkan menu baru ke dalam daftar menu yang akan ditampilkan.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * Format dari parameter yang diterima adalah array dalam bentuk berikut ini
 * <code>
 * $menu = array(
 *   'id' 		=> 'menu_id',
 *   'label' 	=> 'Menu Label',
 *   'url' 		=> 'http://url.dari.menu/',
 *   'title' 	=> 'Title dari Menu',
 *   'order' 	=> 1	// prioritas urutan
 * );
 * </code>
 *
 * @param array $menu data menu yang akan ditambahkan
 * @return void
 */
function tpl_add_menu($menu) {
	global $_MR;
	
	$_MR['menus'][] = $menu;
}

/**
 * Fungsi untuk membangun menu dari array menjadi format lain misal HTML List
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string menu yang akan ditampilkan dalam format HTML
 */
function tpl_build_menu() {
	global $_MR;
	
	$menu_html = '';
	$open = '<li>';
	$close = '</li>';
	
	// default setting untuk menu
	$def_menu = array(
		'url' => '#',
		'title' => '',
		'order' => 0
	);
	
	// loop semua menu untuk disusun
	foreach ($_MR['menus'] as $menu) {
		// Hanya susun menu yang mempunyai format lengkap minimal id dan label
		// selain itu maka tidak akan disusun
		if (isset($menu['id']) && isset($menu['label'])) {
			// kombinasi dengan $def_menu untuk jaga-jaga jika ada index yang tidak diisi
			$_menu = $menu + $def_menu;
			
			// cek apakah menu tersebut termasuk dalam array active menu?
			// jika iya maka tambahkan CSS class active
			// halaman / controller tentu harus memanggil set_active_menu dulu
			// untuk menentukan mana menu yang perlu ditandai aktif (sedang terpilih)
			if (in_array($_menu['id'], $_MR['active_menu'])) {
				$link = '<a href="'. $_menu['url'] . '" class="active" title="' . $_menu['title'] . '">' . $_menu['label'] . '</a>';
			} else {
				$link = '<a href="'. $_menu['url'] . '" title="' . $_menu['title'] . '">' . $_menu['label'] . '</a>';
			}
			 
			$menu_html .= $open . $link . $close . "\n";
		}
	}
	
	// plugin atau theme yang ingin mengubah total menu dapat memanggil hooks ini
	run_hooks('menu_html_return', $menu_html);
	
	return $menu_html;
}

/**
 * Fungsi untuk menambah daftar menu yang termasuk menu aktif (sedang terpilih)
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
function set_active_menu($menu) {
	global $_MR;
	
	$_MR['active_menu'][] = $menu;
}
