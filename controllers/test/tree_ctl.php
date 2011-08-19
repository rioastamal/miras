<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Ini adalah file untuk melakukan test tree library
 *
 * Penggunaan:
 * Arahkan browser ke lokasi file test_ctl.php misal:
 *  -> http://example.com/index.php/test/tree
 *
 * @author Rio Astamal <me@rioastamal.net>
 */

// karena BASE_PATH dipindah ke index maka create konstanta BASE_PATH secara manual
load_library('tree');

echo ('<h1>Tree Library Test</h1>');

// Array data untuk tree
$input = array(
	array( 'label' => 'Mangga', 'order' => 0, 'parent' => 'buah', 'id' => 'mangga', 'children' => array()),
	array( 'label' => 'Jeruk Bali', 'order' => 0, 'parent' => 'jeruk', 'id' => 'jeruk_bali', 'children' => array()),
	array( 'label' => 'Jeruk', 'order' => 0, 'parent' => 'buah', 'id' => 'jeruk', 'children' => array()),
	array( 'label' => 'Buah', 'order' => 6, 'parent' => NULL, 'id' => 'buah', 'children' => array()),
	array( 'label' => 'Hewan', 'order' => 5, 'parent' => NULL, 'id' => 'hewan', 'children' => array()),
	array( 'label' => 'Jeruk Bali Kecil', 'order' => 0, 'parent' => 'jeruk_bali', 'id' => 'jeruk_bali_kecil', 'children' => array()),
	array( 'label' => 'Karnivora', 'order' => 0, 'parent' => 'hewan', 'id' => 'karnivora', 'children' => array()),
	array( 'label' => 'Herbivora', 'order' => 5, 'parent' => 'hewan', 'id' => 'herbivora', 'children' => array()),
	array( 'label' => 'Mangga Gadung', 'order' => 2, 'parent' => 'mangga', 'id' => 'mangga_gadung', 'children' => array()),
	array( 'label' => 'Mangga Manalagi', 'order' => 10, 'parent' => 'mangga', 'id' => 'mangga_manalagi', 'children' => array())
);

// Buat tree
$tree = mr_tree_make($input);

// Test untuk membuat tree bertipe plain text
echo ('<pre>');
// lihat susunan array
print_r($tree);

// cetak tree dalam bentu plain text
echo ('<h3>TREE: PLAIN TEXT</h3>');
echo (mr_tree_plain($tree));
echo ('</pre>');

// Cetak array dalam bentuk HTML list
echo ('<h3>TREE: HTML List</h3>');
echo (mr_tree_html_list($tree, array('top_root' => TRUE)));

// test fungsi callback pada sebuah node tree
// dalam contoh, node yang ber-id 'mangga' akan terpilih
function test_selected($node) {
	$result = ' id="' . $node['id'] . '"';
	
	if ($node['id'] === 'mangga') {
		$result .= ' selected="selected"';
	}
	return $result;
}
echo ('<h3>TREE: HTML SELECT</h3>');
echo (mr_tree_html_select($tree, array('top_root' => TRUE, 'callback_child_tag' => 'test_selected')));
echo ('<br/>');

// --- Test tree dalam bentuk checkbox --

// opsi yang digunakan
$opt = array(
	'top_root' => TRUE,
	'callback_child_tag' => 'test_checked',
	'wrapper_tag_close' => "</label><br/>\n"
);

// test callback pada node tree
// dalam contoh, node yang ber-id 'mangga_gadung', 'jeruk_bali', dan 'hewan'
// akan ter-cententang
function test_checked($node) {
	$checked = array('mangga_gadung', 'jeruk_bali', 'hewan');
	if (in_array($node['id'], $checked)) {
		return ' checked="checked" ';
	}
	return '';
}
// cetak tree dalam bentuk checkbox
echo ('<h3>TREE: HTML CHECKBOX</h3>');
echo mr_tree_html_checkbox($tree, $opt);
