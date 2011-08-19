<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang digunakan membangun sebuah unlimited
 * tree dari array untuk diubah ke berbagai format misal plain text atau
 * HTML.
 *
 * @package Miras
 * @subpackage Libraries
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

/**
 * Fungsi Callback untuk melakukan sorting multidimensional array berdasar suatu
 * nilai
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param array $node1 Data array pertama
 * @param array $node2 Data array kedua
 * @return int
 */
function mr_tree_sort($node1, $node2) {
	if ($node1['order'] > $node2['order']) return 1;
	if ($node1['order'] == $node2['order']) return 0;
	if ($node1['order'] < $node2['order']) return -1;
}

/**
 * Fungsi untuk membuat struktur pohon(tree).
 *
 * @credit John <http://stackoverflow.com/users/105641/john>
 * @since Version 1.0
 *
 * @param array $source Data yang akan diubah ke dalam struktur tree
 * @return array
 */
function mr_tree_make($source) {
	// short array terlebih dulu
	uasort($source, 'mr_tree_sort');
	
	$parent = array();
	$all = array();
	$remainder = array();	// non-root node
	
	foreach ($source as $entry) {
		// $entry['children'] = array();
		$id = $entry['id'];
		
		// If this is a top-level node, add it to the output immediately
		if (!$entry['parent']) {
			$all[$id] = $entry;
			$parent[] =& $all[$id];
		
		// If this isn't a top-level node, we have to process it later
		} else {
			$remainder[$id] = $entry; 
		}
	}
	
	// Process all 'remainder' nodes
	while (count($remainder) > 0) {
		foreach($remainder as $id => $entry) {
			$pid = $entry['parent'];
		
			// If the parent has already been added to the output, it's
			// safe to add this node too
			if (isset($all[$pid])) {
				$all[$id] = $entry;
				$all[$pid]['children'][] =& $all[$id]; 
				unset($remainder[$id]);
			}
		}
	}
	
	return $parent;
}

/**
 * Fungsi untuk mencetak tree dalam bentuk plain text
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param array $tree Array tree yang akan diformat
 * @param array $option Opsi untuk menentukan format tree
 * @param int $depth Kedalaman level dari sebuah node
 * @return string
 */
function mr_tree_plain($tree, $option=array(), $depth=0) {
	// temporary variabel untuk menyimpan hasil
	$result = '';
	// default option
	$default = array(
				'padder' => ' ',	// string padder (sebelah kiri object)
				'root_sign' => '',	// string tanda untuk top root
				'normal_sign' => '+',	// string tanda untuk normal node (punya parent dan children)
				'leaf_sign' => '-'	// string tanda untuk node yang tidak memiliki children
	);
	$config = $option + $default;
	$padder = str_repeat($config['padder'], $depth * 2);
	
	foreach ($tree as $node) {
		if (!$node['parent']) {
			$result .= $config['root_sign'] . $node['label'] . "\n";
		} else {
			// punya parent dan punya childer (normal node)
			if ($node['parent'] && $node['children']) {
				$result .= $padder . $config['normal_sign'] . ' ' . $node['label'] . "\n";
			} else {
				// tidak punya children
				$result .= $padder . $config['leaf_sign'] . ' ' . $node['label'] . "\n";
			}
		}
		
		// jika node memiliki children maka lakukan pemanggilan secara rekursif
		// sampai sebuah node tidak memiliki children
		if ($node['children']) {
			$result .= mr_tree_plain($node['children'], $config, $depth + 1);
		}
	}
	return $result;
}

/**
 * Fungsi untuk mencetak tree dalam bentuk HTML List tag <ul> dan <li>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param array $tree Array tree yang akan diformat
 * @param array $option Opsi untuk menentukan format tree
 * @param int $depth Kedalaman level dari sebuah node dalam tree
 * @return string
 */
function mr_tree_html_list($tree, $option=array(), $depth=0) {
	// temporary variabel untuk menyimpan hasil
	$result = '';
	// default option
	$default = array(
				'padder' => ' ',		// string padder (sebelah kiri object)
				'top_root' => FALSE,	// flag untuk menandakan apakah node ini node puncak (tidak memiliki parent) <ul> utama
				'callback_root_tag' => NULL,	// fungsi callback yang akan dipanggil ketika mengisi root tag
				'callback_child_tag' => NULL,	// fungsi callback yang akan dipanggil ketika mengisi child tag
				'callback_content' => NULL // fungsi callback yang akan dipanggil ketika mengisi content tag
	);
	$config = $option + $default;
	
	if ($config['callback_root_tag']) {
		// jika callback_root_tag diisi berarti user yang memanggil fungsi ini
		// akan memanipulasi attribut dari tag <ul> maka panggil fungsi tersebut
		$ul_begin = '<ul' . call_user_func_array($config['callback_root_tag'], array($config['root_tag'], $config['top_root'])) . '>';
	} else {
		// tidak ada pemanggilan callback berarti kembalikan tag standar <ul>
		$ul_begin = '<ul>';
	}
	$result = $ul_begin;
	
	foreach ($tree as $node) {
		if ($config['callback_child_tag']) {
			// jika callback_child_tag diisi berarti user yang memanggil fungsi ini
			// akan memanipulasi attribut dari tag <li> maka panggil fungsi tersebut
			$li_begin = '<li' . call_user_func_array($config['callback_child_tag'], array($node)) . '>';
		} else {
			$li_begin = '<li>';
		}
		if ($config['callback_content']) {
			// jika callback_root_tag diisi berarti user yang memanggil fungsi ini
			// akan memanipulasi content dari <li>CONTENT</li>, maka panggil fungsi
			// tersebut dengan mensupply node saat ini
			$li_content = call_user_func_array($config['callback_content'], array($node));
		} else {
			$li_content = $node['label'];
		}
		$result .= $li_begin . $li_content;

		if ($node['children']) {
			$result .= mr_tree_html_list($node['children'], $config, $depth + 1);
		}
		$li_end = '</li>' . "\n";
		$result .= $li_end;
	}
	
	$result .= '</ul>' . "\n";
	return $result;
}

/**
 * Fungsi untuk mencetak tree dalam bentuk HTML select, tag <select> dan <option>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param array $tree Array tree yang akan diformat
 * @param array $option Opsi untuk menentukan format tree
 * @param int $depth Kedalaman level dari sebuah node dalam tree
 * @return string
 */
function mr_tree_html_select($tree, $option, $depth=0) {
	// temporary variabel untuk menyimpan hasil
	$result = '';
	// default option
	$default = array(
				'padder' => '--',		// string padder (sebelah kiri object)
				'top_root' => FALSE,	// flag untuk menandakan apakah node ini node puncak (tidak memiliki parent) <ul> utama
				'callback_root_tag' => NULL,	// fungsi callback yang akan dipanggil ketika mengisi root tag
				'callback_child_tag' => NULL,	// fungsi callback yang akan dipanggil ketika mengisi child tag
				'callback_content' => NULL // fungsi callback yang akan dipanggil ketika mengisi content tag
	);
	$config = $option + $default;
	
	if ($config['top_root'] == TRUE) {
		$padder = '';
		if ($config['callback_root_tag']) {
			// panggil fungsi callback jika diisi
			$select = '<select' . call_user_func_array($config['callback_root_tag'], array()) . '>';
		} else {
			$select = '<select>';
		}
		$result = $select;
	} else {
		$result = '';
		$padder = $config['padder'];
	}
	
	foreach ($tree as $node) {
		if ($config['callback_child_tag']) {
			// panggil callback jika diisi
			$option_begin = '<option' . call_user_func_array($config['callback_child_tag'], array($node)) . '>';
		} else {
			$option_begin = '<option value="' . $node['id'] . '">';
		}
		
		if ($config['callback_content']) {
			// panggil callback untuk manipulasi content
			$option_content = call_user_func_array($config['callback_content'], array($node, $config));
		} else {
			$option_content = str_repeat($padder, $depth * 2) . $node['label'];
		}
		$option_end = '</option>';
		$result .= $option_begin . $option_content . $option_end . "\n";
		
		if ($node['children']) {
			// set top_root ke FALSE agar setiap rekursi tidak mencetak <select>
			$config['top_root'] = FALSE;
			$result .= mr_tree_html_select($node['children'], $config, $depth + 1);
		}
	}
	
	if ($option['top_root'] == TRUE) {
		$result .= "</select>\n";
	}
	return $result;
}

/**
 * Fungsi untuk mencetak tree dalam bentuk HTML select, tag <select> dan <option>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param array $tree Array tree yang akan diformat
 * @param array $option Opsi untuk menentukan format tree
 * @param int $depth Kedalaman level dari sebuah node dalam tree
 * @return string
 */			
function mr_tree_html_checkbox($tree, $option, $depth=0) {
	// temporary variabel untuk menyimpan hasil
	$result = '';
	// default option
	$default = array(
				'padder' => '--',		// string padder (sebelah kiri object)
				'top_root' => FALSE,	// flag untuk menandakan apakah node ini node puncak (tidak memiliki parent) <ul> utama
				'wrapper_tag_open'=> '<label>',		// tag pembuka yang digunakan untuk membungkus tag <input /> pada checkbox
				'wrapper_tag_close' => '</label>',	// tag pembuka yang digunakan untuk membungkus tag <input /> pada checkbox
				'callback_root_tag' => NULL,	// fungsi callback yang akan dipanggil ketika mengisi root tag
				'callback_child_tag' => NULL,	// fungsi callback yang akan dipanggil ketika mengisi child tag
				'callback_content' => NULL // fungsi callback yang akan dipanggil ketika mengisi content tag
	);
	$config = $option + $default;
	$padder = $config['padder'];
	
	if ($config['top_root']) {
		$padder = '';
	}
	
	foreach ($tree as $node) {
		// jika callback_child_tag diisi maka, diasumsikan pemanggil akan memanipulasi
		// attribut dari tag input, jadi panggil fungsi callback tersebut
		if ($config['callback_child_tag']) {
			$input_tag = '<input type="checkbox" ' . call_user_func_array($config['callback_child_tag'], array($node)) . '/>';
		} else {
			$input_tag = '<input type="checkbox" id="' . $node['id'] . '" title="' . $node['label'] . '" />';
		}
		$input_tag = str_repeat($padder, $depth * 2) . $input_tag;
		
		if ($config['callback_content']) {
			$content = call_user_func_array($config['callback_content'], array($node));
		} else {
			$content = $node['label'];
		}
		
		$result .= $config['wrapper_tag_open'] . $input_tag . $content . $config['wrapper_tag_close'];
		
		if ($node['children']) {
			$config['top_root'] = FALSE;
			$result .= mr_tree_html_checkbox($node['children'], $config, $depth + 1);
		}
	}
	return $result;
}
