<?php

/**
 * File ini berfungsi untuk meloading semua file library atau
 * konfigurasi yang diperlukan
 */

include_once(BASE_PATH . '/libs/' . 'db_config.php');
include_once(BASE_PATH . '/libs/' . 'function.php');

// site config
include_once(BASE_PATH . '/libs/' . 'site_config.php');
