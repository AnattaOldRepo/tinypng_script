<?php
require_once("vendor/autoload.php");

// require the compressor class
require_once("compressor.php");

// get the api key from a file so that it doesn't get added to repo
$apiKey = file_get_contents("apikey");

// create the new compressor
$compressor = new ImageCompressor(
	$apiKey,
	array(
		'jpg',
		'jpeg',
		'png',
	)
);

// compress our directory
$compressor->run('images');

echo 'Total images compressed for this month ' . $compressor->getCompressionCount() . PHP_EOL;