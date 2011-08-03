<?php

set_active_menu('view_komentar');
set_page_title('View Komentar');

// load query cache library
load_library('query_cache');
query_cache_enable();

// ambil argument ke-0
$key_arg = get_argument(0);
$value_arg = get_argument(1);
site_debug("ARG 1: $key_arg, ARG 2: $value_arg", 'TEST ARGUMENT');

// load model komentar dan artikel
load_model('komentar');
load_model('artikel');	

// masukan komentar ke dalam variabel $data_view, sehingga
$data_view['daftar_komentar'] = get_last_commented_article($value_arg);

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
load_view('view_komentar', $data_view);
load_view('sidebar');
load_view('footer');
