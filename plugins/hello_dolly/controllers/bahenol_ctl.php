<?php

load_library('session');
session_construct();

mr_session_setdata('user_id', 1);

// echo ('FUCK YEAH!');
load_helper('url');
$user = get_argument_by("userid");

site_debug(get_current_url(), "CURRENT URL");
site_debug(get_last_query(), "LAST_QUERY");
