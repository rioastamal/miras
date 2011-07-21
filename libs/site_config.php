<?php

// Alamat Base URL dari aplikasi, harus diakhiri dengan '/' SLASH
$_B21['base_url'] = 'http://localhost/berita21/';

// tema yang digunakan
$_B21['theme'] = 'default';

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

// status debugging diaktifkan atau tidak
// TRUE => Aktif
// FALSE => Tidak Diaktifkan
$_B21['debug_mode'] = TRUE;

// pesan debugging akan disimpan pada variabel ini
$_B21['debug_message'] = '';
