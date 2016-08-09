<?php 

require_once("vendor/autoload.php");

try {
    \Tinify\setKey("5fSltsFv9N2s46E2H44NPx3GPXtAjVc8");
    \Tinify\validate();
} catch(\Tinify\Exception $e) {

    die("Incorrect API");
}

$compressionsThisMonth = \Tinify\compressionCount();

$dir = 'images/';

$images = scandir($dir);

$images = array_diff($images, array('.', '..'));
 
foreach ($images as $image) {

	echo ('Compressing '.$dir.$image);

	echo PHP_EOL;

    $source = \Tinify\fromFile($dir.$image);

    $source->toFile($dir.$image);
}
 
echo "Compression has been completed";

echo PHP_EOL;

echo ( 'Total images compressed for this month '.$compressionsThisMonth);

?>