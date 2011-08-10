<?php

echo ('FUCK YEAH!');

load_helper('url');

$cetak = get_argument_by("kualitas");
echo ($cetak);

site_debug(get_current_url(), "CURRENT URL");
