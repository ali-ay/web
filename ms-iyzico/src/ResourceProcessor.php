<?php

class ResourceProcessor
{
    private $pathUtils,
            $nonRetinaPath;

    public function __construct(\SourceResolver $pathUtils)
    {
        $this->pathUtils = $pathUtils;
    }

    private function decideContentType(){
        $contentTypes = array(
            'css' => "text/css",
            'js'  => "application/javascript",

            //IMAGES
            'png' => "image/png",
            'jpg' => "image/jpeg",
            'gif' => "image/gif",
            'svg' => "image/svg+xml",
            'ico' => "image/x-icon",

            //FONTS
            'ttf'   => "application/x-font-ttf",
            'otf'   => "application/x-font-opentype",
            'woff'  => "application/font-woff",
            'woff2' => "application/font-woff2",
            'eot'   => "application/vnd.ms-fontobject",
            'sfnt'  => "application/font-sfnt",

            //VIDEOS
            'mp4'   => "video/mp4",
            'webm'  => "video/webm",

            //PDFs
            'pdf'   => "application/pdf",

            //ZIP
            'zip'   => "application/zip"

        );
        if (isset($contentTypes[$this->pathUtils->getFileExtension()])){
            return $contentTypes[$this->pathUtils->getFileExtension()];
        } else {
            throw new Exception('404 - 4 Not Found '.$this->pathUtils->getFileExtension());
        }
    }

    private function resourceIsImage(){
        $contentTypes = array(
            'png' => "image/png",
            'jpg' => "image/jpeg",
            'gif' => "image/gif"
        );
        if (isset($contentTypes[$this->pathUtils->getFileExtension()])){
            return true;
        } else {
            return false;
        }
    }

    private function setHeaders(){
        $lastModified=filemtime($this->pathUtils->getLocalPath());
        $etagFile = md5_file($this->pathUtils->getLocalPath());
        $ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
        $etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);
        $contentType = $this->decideContentType();
        $contentSize = filesize($this->pathUtils->getLocalPath());
        header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
        header("ETag: \"$etagFile\"");
        header('Cache-Control: max-age=604800' );
        header("Content-Type: $contentType");
        header("Content-Size: $contentSize");
        header("Access-Control-Allow-Origin: *");
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + (60*60*24*45)) . ' GMT');


        if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==$lastModified || $etagHeader == $etagFile)
        {
            header("HTTP/1.1 304 Not Modified");
            exit;
        }


    }

    private function serveFile($servePath = false){
        if (!$servePath) $servePath = $this->pathUtils->getLocalPath();
        $this->setHeaders();
        readfile($servePath);
        exit;
    }

    private function createNonRetina(){

        $directoryStructure = $this->pathUtils->getDirectoryStructure();
        $fileName = $this->pathUtils->getFileNameWithoutExtension();
        $fileExtension = $this->pathUtils->getFileExtension();
        $fileNameToResize = $directoryStructure.str_replace('@2x','',$fileName).'@2x.'.$fileExtension;
        $this->nonRetinaPath = str_replace('@2x','',$fileNameToResize);

        list($width, $height) = getimagesize($fileNameToResize);
        $targetWidth = $width/2;
        $targetHeight = $height/2;
        $jpegCompression = $this->pathUtils->getJpgCompression();
        $pngCompression = $this->pathUtils->getPngCompression();

        $size = getimagesize($fileNameToResize);

        $fileToSave = imagecreatetruecolor($targetWidth, $targetHeight);

        switch ($size['mime']) {
            case "image/gif":
                $background = imagecolorallocate($fileToSave , 0, 0, 0);
                imagecolortransparent($fileToSave, $background);
                $source = imagecreatefromgif($fileNameToResize);
                imagecopyresized($fileToSave, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
                imagegif($fileToSave, $this->nonRetinaPath,$jpegCompression);
                break;
            case "image/jpeg":
                $source = imagecreatefromjpeg($fileNameToResize);
                imagecopyresized($fileToSave, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
                imagejpeg($fileToSave, $this->nonRetinaPath,$jpegCompression);
                break;
            case "image/png":
                imagealphablending($fileToSave, false);
                imagesavealpha($fileToSave, true);
                $source = imagecreatefrompng($fileNameToResize);
                imagecopyresampled($fileToSave, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
                imagepng($fileToSave, $this->nonRetinaPath,$pngCompression);
                break;
        }
        imagedestroy($fileToSave);
        imagedestroy($source);
    }

    private function downloadFile(){

        $fileNameToDownload = $this->pathUtils->getSourcePath();

        $isBackOffice = $this->pathUtils->isBackOffice();
        $isRetina = $this->pathUtils->isRetina();
        $isImage = $this->resourceIsImage();
        $fileName = $this->pathUtils->getFileNameWithoutExtension();
        $fileExtension = $this->pathUtils->getFileExtension();

        $directoryStructure = $this->pathUtils->getDirectoryStructure();
        $fileNameToSave = $this->pathUtils->getLocalPath();

        if ($isBackOffice && $isImage) {
            $fileNameToDownload = str_replace('@2x','',$fileNameToDownload);
            if(!$isRetina) {
                $fileNameToSave = $directoryStructure.$fileName.'@2x.'.$fileExtension;
            }
        }

        $curlProcess = curl_init($fileNameToDownload);
        if (!file_exists($directoryStructure)) {
            mkdir($directoryStructure,0777,true);
        }
        $filePointer = fopen($fileNameToSave,'w+');
        curl_setopt($curlProcess, CURLOPT_FILE, $filePointer);
        curl_setopt($curlProcess, CURLOPT_HEADER, 0);
        curl_exec($curlProcess);
        if(!curl_errno($curlProcess)){
            $curlInfo = curl_getinfo($curlProcess);
            if ($curlInfo['http_code'] != 200) {
                //failed.
                curl_close($curlProcess);
                fclose($filePointer);
                unlink($fileNameToSave);
                throw new Exception('404 - 3 Not Found');
            }
        }

        curl_close($curlProcess);
        fclose($filePointer);

        if ($isBackOffice && $isImage) {
            $this->createNonRetina();
            if (!$isRetina) {
                $this->serveFile($this->nonRetinaPath);
                exit;
            }
        }

        $this->serveFile();

    }

    private function fetchFile(){
        $this->downloadFile();
    }
    public function processFile(){
        if (isset($_GET['force_purge']) && $_GET['force_purge']=="true") {
            if (@unlink($this->pathUtils->getLocalPath())) {
                header("HTTP/1.1 202 ACCEPTED");
                exit;
            } else {
                header("HTTP/1.1 404 NOT FOUND");
                exit;
            }
        } else {
            if (!file_exists($this->pathUtils->getLocalPath())) {
                $this->fetchFile();
            } else {
                $this->serveFile();
            }
        }
    }

}
