<?php

/**
 * File ini berisi fungsi-fungsi (query) yang berhubungan manipulasi template
 * (views)
 *
 * @package libraries
 * @copyright 2011 Bajol Startup Team
 */

/**
 * Fungsi ini untuk meload daftar kategori
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @param array $user_config parameter untuk menentukan output dari daftar kategori
 * @return string
 */
function tpl_get_kategori($user_config=array()) {
	// konfigurasi default yang disediakan untuk output daftar kategori
	$default_config = array(
		'article_count' => FALSE,
		'tag_open' => '<li>',
		'tag_close' => '</li>'
	);
	
	// gabungkan kedua configurasi
	// jika keys dari $user_config ada maka nilai dari key tersebut yang akan digunakan
	// bukan dari $defaul_config
	$config = $default_config + $user_config;
	
	$result = '';
	
	// load kategori model
	load_model('kategori');
	$kategori = get_all_kategori();
	
	// hasil kosong atau terjadi error
	if (!$kategori) {
		return $result;
	}
	
	// jika sampai disini maka terdapat item pada $kategori
	foreach ($kategori as $kat) {		
		$menu_object = new stdClass();
		$menu_object->link_tag_open = '<a>';
		$menu_object->link_label = $kat->kategori_nama;
		$menu_object->link_tag_close = '</a>';
		$menu_object->object = $kat;
		
		run_hooks('build_kategori_tpl', $menu_object);
		
		$result .= $config['tag_open'] . $menu_object->link_tag_open . $menu_object->link_label . $menu_object->link_tag_close . $config['tag_close'] . "\n";
	}
	
	return $result;
}

/**
 * Fungsi untuk menambahkan menu baru ke dalam daftar menu yang akan ditampilkan.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
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
	global $_B21;
	
	$_B21['menus'][] = $menu;
}

/**
 * Fungsi untuk membangun menu dari array menjadi format lain misal HTML List
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @return string menu yang akan ditampilkan dalam format HTML
 */
function tpl_build_menu() {
	global $_B21;
	
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
	foreach ($_B21['menus'] as $menu) {
		// Hanya susun menu yang mempunyai format lengkap minimal id dan label
		// selain itu maka tidak akan disusun
		if (isset($menu['id']) && isset($menu['label'])) {
			// kombinasi dengan $def_menu untuk jaga-jaga jika ada index yang tidak diisi
			$_menu = $menu + $def_menu;
			
			// cek apakah menu tersebut termasuk dalam array active menu?
			// jika iya maka tambahkan CSS class active
			// halaman / controller tentu harus memanggil set_active_menu dulu
			// untuk menentukan mana menu yang perlu ditandai aktif (sedang terpilih)
			if (in_array($_menu['id'], $_B21['active_menu'])) {
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
 * @since Version 1.1
 *
 * @return void
 */
function set_active_menu($menu) {
	global $_B21;
	
	$_B21['active_menu'][] = $menu;
}
