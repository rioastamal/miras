<?php

load_library('session');
session_construct();

mr_session_set('uh', 'yeah');

// echo ('FUCK YEAH!');
load_helper('url');
$kualitas = get_argument_by("kualitas");
if (!$kualitas) {
	$kualitas = 'murahan';
}

site_debug(get_current_url(), "CURRENT URL");
