<?php

// Alamat Base URL dari aplikasi, harus diakhiri dengan '/' SLASH
$_MR['base_url'] = 'http://localhost/berita21/';

// tema yang digunakan
$_MR['theme'] = 'default';

// status debugging diaktifkan atau tidak
// TRUE => Aktif
// FALSE => Tidak Diaktifkan
$_MR['debug_mode'] = TRUE;

// ------------------ AKHIR KONFIGURASI ----------------------------- //

/* TIDAK PERLU MENGGANTI KONFIGURASI DIBAWAH INI KECUALI ANDA TAHU APA YANG
   ANDA LAKUKAN */

// default nama title dari halaman, seharusnya nanti akan di-overwrite 
// oleh controller
$_MR['title'] = '';

// flash message merupakan variabel yang menyimpan pesan sementara untuk 
// ditampilkan kepada user, misal pesan proses telah selesai dan sebagainya
$_MR['flash_message'] = '';

// CSS class dari div pesan flash
$_MR['flash_class'] = 'flash-warning';

// Nama file yang menghandle mapping ke file controller
$_MR['index_page'] = 'index.php';

// nama default controller jika user datang tanpa menyebutkan nama controller
$_MR['default_controller'] = 'main';

// pesan debugging akan disimpan pada variabel ini
$_MR['debug_message'] = '';

// variabel yang menyimpan nama-nama model yang telah diload ke memory
$_MR['loaded_models'] = array();

// variabel yang menyimpan nama-nama library yang telah diload ke memory
$_MR['loaded_libraries'] = array();

// variabel yang menyimpan nama-nama helper yang telah diload ke memory
$_MR['loaded_helpers'] = array();

// variabel yang menyimpan nama-nama plugin yang diload
$_MR['loaded_plugins'] = array();

// variabel yang menyimpan nama-nama plugin yang gagal diload
$_MR['error_plugins'] = array();

// variabel yang menyimpan nama-nama hooks
$_MR['hooks'] = array();

// variabel yang menyimpan banyaknya query yang telah dieksekusi
$_MR['query_number'] = 0;

// variabel yang menyimpan SQL query terakhir yang dijalankan
$_MR['last_query'] = '';

// librari yang diload secara otomatis saat bootstrap
$_MR['autoload_libraries'] = array(
								'controller', 
								'plugin', 
								'template', 
								'query_cache'
							);
							
// variabel yang menyimpan option dari aplikasi
$_MR['options'] = array();

// variabel yang menyimpan daftar menu
$_MR['menus'] = array();

// variabel yang menyimpan daftar menu yang aktif
$_MR['active_menu'] = array();

// menggunakan query cache atau tidak
$_MR['enable_query_cache'] = FALSE;

// variabel yang menyimpan controller arguments
$_MR['controller_arguments'] = array();
