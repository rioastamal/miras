<?php

tpl_add_menu(array(
	'label' => 'View Artikel',
	'id' => 'view_artikel',
	'url' => get_site_url() . '/admin/view-artikel',
	'title' => 'Lihat Artikel',
	'order' => 1
));	

set_active_menu('view_artikel');
set_page_title('View Artikel');

// load query cache library
load_library('query_cache');
query_cache_enable();

// ambil argument ke-0
$key_arg = get_argument(0);
$value_arg = get_argument(1);
site_debug("ARG 1: $key_arg, ARG 2: $value_arg", 'TEST ARGUMENT');

// load model kategori
load_model('artikel');

// load model kategori
load_model('kategori');

if($key_arg == "id") {
	$data_view['daftar_artikel'] = get_article_by_id($value_arg);
	$load = "view_artikel";
}
else {
	$data_view['daftar_artikel'] = get_article_by_category($value_arg);
	$load = "view_artikel_by_kategori";
}
// masukan artikel dan daftar kategori ke dalam variabel $data_view, sehingga

//$data_view['daftar_kategori'] = get_all_kategori(FALSE);

// beberapa informasi debug yang mungkin berguna
site_debug(get_last_query(), 'QUERY TERAKHIR');
site_debug(get_query_number(), 'JUMLAH QUERY');
// lihat PHP Manual untuk keterangan seputar fungsi print_r
$loaded_models = print_r($_B21['loaded_models'], TRUE);
site_debug($loaded_models, 'MODEL YANG DILOAD');

$loaded_libs = print_r($_B21['loaded_libraries'], TRUE);
site_debug($loaded_libs, 'LIBRARY YANG DILOAD');


// beberapa informasi debug yang mungkin berguna
site_debug(get_last_query(), 'QUERY TERAKHIR');
site_debug(get_query_number(), 'JUMLAH QUERY');

// Load view dengan urutan 1. header 2. content utama 3. sidebar 4. footer
load_view('header');
load_view($load, $data_view);
load_view('sidebar');
load_view('footer');

