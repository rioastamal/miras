<?php

load_library('session');
session_construct();

var_dump(mr_session_get('fuck'));
var_dump(mr_session_get('shit'));
