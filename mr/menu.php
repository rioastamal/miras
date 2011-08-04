<?php

// default menu
tpl_add_menu(array(
	'label' => 'Home',
	'id' => 'mr_home',
	'url' => get_site_url(),
	'title' => 'Come to Papa!',
	'order' => 1
));	

tpl_add_menu(array(
	'label' => 'Add Kategori',
	'id' => 'add_kategori',
	'url' => get_site_url() . '/admin/add-kategori',
	'title' => 'Tambah Kategori Baru',
	'order' => 1
));	

tpl_add_menu(array(
	'label' => 'Add Artikel',
	'id' => 'add_artikel',
	'url' => get_site_url() . '/admin/add-artikel',
	'title' => 'Tambah Artikel Baru',
	'order' => 1
));	

tpl_add_menu(array(
	'label' => 'View Artikel',
	'id' => 'view_artikel',
	'url' => get_site_url() . '/admin/view-artikel',
	'title' => 'Lihat Artikel',
	'order' => 1
));	

// jalankan beberapa hooks yang berhubungan dengan manipulasi menu
run_hooks('add_more_menu');
