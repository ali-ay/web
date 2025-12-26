<?php
/**
 * @package Iyzico
 */

error_reporting(0);
define( 'IYZICO_MAIN__LIBRARY_DIR', 'Library/');
define( 'IYZICO_MAIN__CACHE_DIR', 'cache/');
define( 'WP_PATH', '../../..');
$clientSupportsGzip = false;
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) $clientSupportsGzip = true;
define( 'GZIP_SUPPORT', $clientSupportsGzip);

require_once( IYZICO_MAIN__LIBRARY_DIR . 'CSShrink.php' );

use Iyzico\Library\CSSMinifier;

function generateCacheKey(){
	if (is_array($_GET['queue'])) {
		return md5(implode(',',$_GET['queue']));
	} else {
		return md5($_GET['queue']);
	}

}

function createCache($cacheKey) {
	$pathToSave = IYZICO_MAIN__CACHE_DIR.$cacheKey;

	if ( !is_array($_GET['queue']) ) {
		$queue = array($_GET['queue']);
	} else {
		$queue = $_GET['queue'];
	}

	$total = "";
	foreach($queue as $i=>$path) {
		$total .= getSingleCSS($path);
	}

	$calculatedFileName = IYZICO_MAIN__CACHE_DIR.$cacheKey.'.css';
	if ( $_GET['gzip'] == true && GZIP_SUPPORT ) {
		$calculatedFileName .= ".gz";
		$total = gzcompress($total,6);
	}
	$result = file_put_contents ( $calculatedFileName , $total);

	if ( $result ) {
		return $total;
	} else {
		return false;
	}


}

function getSingleCSS($path) {
	if ( file_exists(WP_PATH.$path) ) {
		$css = file_get_contents(WP_PATH.$path);
		$images = array();
		$regex = '/url\(\s*[\'"]?(\S*\.(?:jpe?g|gif|png|svg))[\'"]?\s*\)[^;}]*?/i';
		if (preg_match_all($regex, $css, $matches)) {
			$images = $matches[1];
		}
		$oldPaths = array();
		$newPaths = array();
		$wholePath = explode('/',WP_PATH.$path);

		foreach($images as $index=>$oldPath) {
			$oldPathParts = explode('/',$oldPath);
			$tempWholePath = $wholePath;
			array_pop($tempWholePath);
			for($i = 0;$i < count($oldPathParts); $i++) {
				if ($oldPathParts[$i] == "..") {
					array_pop($tempWholePath);
					unset($oldPathParts[$i]);
				}
			}
			$oldPathParts = array_values($oldPathParts);
			$finalPath = implode('/',$tempWholePath).'/'.implode('/',$oldPathParts);
			array_push($oldPaths,$oldPath);
			array_push($newPaths,$finalPath);
		}
		//var_dump($oldPaths,$newPaths);
		$css = str_replace($oldPaths,$newPaths,$css);
		return CSSMinifier::minify($css);
	}


}

function getFinalCSS(){
	$cacheKey = generateCacheKey();
	$expectedFileName = IYZICO_MAIN__CACHE_DIR.$cacheKey.'.css';
	if ( $_GET['gzip'] == true && GZIP_SUPPORT) {
		$expectedFileName .= ".gz";
		header('Content-Encoding: zlib, deflate, gzip');
	}

	if ( file_exists($expectedFileName) ) {
		$generatedCSS = file_get_contents($expectedFileName);
		$last_modified_time = filemtime($expectedFileName);
		$etag = md5_file($expectedFileName);
		header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
		header("Etag: $etag");
		header('Content-Length: '.strlen($generatedCSS));
		if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time ||
			@trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {
			header("HTTP/1.1 304 Not Modified");
			exit;
		}
	} else {
		$generatedCSS = createCache($cacheKey);
		header('Content-Length: '.strlen($generatedCSS));
	}
	header('Content-Type: text/css');

	return $generatedCSS;
}
echo (getFinalCSS());
die();
