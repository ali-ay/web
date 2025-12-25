<?php
ini_set('gd.jpeg_ignore_warning', 1);
include_once 'src/SourceResolver.php';
include_once 'src/ResourceProcessor.php';

try {
    $pathUtils = new SourceResolver($_SERVER["REQUEST_URI"]);
    $resourceProcessor =  new ResourceProcessor($pathUtils);
    $resourceProcessor->processFile();
} catch (Exception $e) {
    //log here.
    header("HTTP/1.0 404 Not Found");
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
