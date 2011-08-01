<?php

// Alamat Base URL dari aplikasi, harus diakhiri dengan '/' SLASH
$_B21['base_url'] = 'http://localhost/berita21/';

// tema yang digunakan
$_B21['theme'] = 'default';

// status debugging diaktifkan atau tidak
// TRUE => Aktif
// FALSE => Tidak Diaktifkan
$_B21['debug_mode'] = TRUE;

// ------------------ AKHIR KONFIGURASI ----------------------------- //

/* TIDAK PERLU MENGGANTI KONFIGURASI DIBAWAH INI KECUALI ANDA TAHU APA YANG
   ANDA LAKUKAN */

// default nama title dari halaman, seharusnya nanti akan di-overwrite 
// oleh controller
$_B21['title'] = '';

// flash message merupakan variabel yang menyimpan pesan sementara untuk 
// ditampilkan kepada user, misal pesan proses telah selesai dan sebagainya
$_B21['flash_message'] = '';

// CSS class dari div pesan flash
$_B21['flash_class'] = 'flash-warning';

// Nama file yang menghandle mapping ke file controller
$_B21['index_page'] = 'index.php';

// nama default controller jika user datang tanpa menyebutkan nama controller
$_B21['default_controller'] = 'main';

// pesan debugging akan disimpan pada variabel ini
$_B21['debug_message'] = '';

// variabel yang menyimpan nama-nama model yang telah diload ke memory
$_B21['loaded_models'] = array();

// variabel yang menyimpan nama-nama library yang telah diload ke memory
$_B21['loaded_libraries'] = array();

// variabel yang menyimpan nama-nama helper yang telah diload ke memory
$_B21['loaded_helpers'] = array();

// variabel yang menyimpan nama-nama plugin yang diload
$_B21['loaded_plugins'] = array();

// variabel yang menyimpan nama-nama plugin yang gagal diload
$_B21['error_plugins'] = array();

// variabel yang menyimpan nama-nama hooks
$_B21['hooks'] = array();

// variabel yang menyimpan banyaknya query yang telah dieksekusi
$_B21['query_number'] = 0;

// variabel yang menyimpan SQL query terakhir yang dijalankan
$_B21['last_query'] = '';

// librari yang diload secara otomatis saat bootstrap
$_B21['autoload_libraries'] = array('plugin', 'template');

// variabel yang menyimpan daftar menu
$_B21['menus'] = array();

// variabel yang menyimpan daftar menu yang aktif
$_B21['active_menu'] = array();

// menggunakan query cache atau tidak
$_B21['enable_query_cache'] = FALSE;
