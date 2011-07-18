<?php

/**
 * Ini adalah file untuk melakukan test view/
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_kategori.php misal:
 *    http://localhost/berita21/test/test_view_kategori.php
 *
 * @author Rio Astamal <me@rioastamal.net>
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

$_site_title = 'Google';

include_once ($current_path . '/../views/' . $_theme . '/header_view.php');
include_once ($current_path . '/../views/' . $_theme . '/footer_view.php');
