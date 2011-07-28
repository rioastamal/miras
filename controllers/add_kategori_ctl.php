<?php

set_active_menu('add_kategori');
set_page_title('Test Kategori View');

// load query cache library
load_library('query_cache');
query_cache_enable();

// load model kategori
load_model('kategori');

// jika isi variabel $_POST['submit-kat'] tidak kosong maka lalukan simpan
if (isset($_POST['submit-kat']) && strlen($_POST['nama_kat']) > 0) {
	$nama_kat = $_POST['nama_kat'];
	
	$new_kat = new stdClass();
	$new_kat->kategori_nama = $_POST['nama_kat'];
	if (!insert_kategori($new_kat)) {
		set_flash_class('flash-error');
		set_flash_message("Gagal menyimpan kategori '{$nama_kat}'.");
	} else {
		set_flash_message("Kategori '{$nama_kat}' berhasil disimpan.");
	}
}

// masukan kategori ke dalam variabel $data_view, sehingga
$data_view['daftar_kategori'] = get_all_kategori(FALSE);

// beberapa informasi debug yang mungkin berguna
site_debug(get_last_query(), 'QUERY TERAKHIR');
site_debug(get_query_number(), 'JUMLAH QUERY');
// lihat PHP Manual untuk keterangan seputar fungsi print_r
$loaded_models = print_r($_B21['loaded_models'], TRUE);
site_debug($loaded_models, 'MODEL YANG DILOAD');

$loaded_libs = print_r($_B21['loaded_libraries'], TRUE);
site_debug($loaded_libs, 'LIBRARY YANG DILOAD');

// Load view dengan urutan 1. header 2. content utama 3. sidebar 4. footer
load_view('header');
load_view('add_kategori', $data_view);
load_view('sidebar');
load_view('footer');
