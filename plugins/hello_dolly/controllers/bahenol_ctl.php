<?php

// echo ('FUCK YEAH!');
load_helper('url');
$kualitas = get_argument_by("kualitas");
if (!$kualitas) {
	$kualitas = 'murahan';
}
echo "SELECT * FROM barang WHERE harga='$kualitas'";
