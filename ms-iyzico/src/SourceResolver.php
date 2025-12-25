<?php
class SourceResolver
{
    const   FRONT_OFFICE_INDICATOR  = "f",
            FRONT_OFFICE_DOMAIN     = "http://localhost:8000",
            FRONT_OFFICE_PATH       = "/assets",

            BACK_OFFICE_INDICATOR   = "b",
            BACK_OFFICE_DOMAIN      = "http://localhost:8081",
            BACK_OFFICE_PATH        = "/wp-content/uploads";

    private $realURI,
            $localRoot,
            $sourceDomain,
            $sourceRoot,
            $requestUri,
            $localPath,
            $pathParts,
            $fileExtension,
            $directoryStructure,
            $fileNameWithoutExtension,
            $sourcePath,
            $sanitizedPath,
            $retina             = false,
            $backOffice         = false,
            $pngCompression     = 0.1,
            $jpgCompression     = 100;

    public function __construct($requestUri){
        $this->realURI = $requestUri;
        $this->requestUri = strtok($requestUri,'?');
        $this->decidePaths();
    }

    private function decidePaths(){
        $pathParts = explode('/',$this->requestUri);
        $this->pathParts = $pathParts;
        if (count($pathParts) > 1) {
            $decideIndicator = $pathParts[1];
            switch ($decideIndicator) {
                case self::BACK_OFFICE_INDICATOR:
                    $this->setBackOfficeInformation();
                    break;
                case self::FRONT_OFFICE_INDICATOR:
                    $this->setFrontOfficeInformation();
                    break;
                default:
                    throw new Exception('404 - 1 Not Found');
                    break;
            }
        } else {
            throw new Exception('404 - 2 Not Found');
        }
    }

    private function finalizePaths(){

        $this->localPath = $this->localRoot.$this->sanitizedPath;
        $pathParts = explode('/',$this->localPath);
        $fileName = array_pop($pathParts);
        $rawFileName = explode('.',$fileName);
        $this->fileExtension = array_pop($rawFileName);
        $this->fileNameWithoutExtension = implode('.',$rawFileName);
        $directoryWithoutFileName = implode('/',$pathParts);
        $this->directoryStructure = $directoryWithoutFileName.'/';
        if (strpos($this->fileNameWithoutExtension,'@2x') > 0 ) {
            $this->retina = true;
        }
    }

    private function setFrontOfficeInformation(){
        $this->localRoot = self::FRONT_OFFICE_INDICATOR.'/';
        $this->sourceDomain = self::FRONT_OFFICE_DOMAIN;
        $this->sanitizedPath = str_replace('/'.self::FRONT_OFFICE_INDICATOR.'/','',$this->requestUri);
        $this->sourcePath = $this->sourceDomain.'/'.$this->sanitizedPath;
        $this->finalizePaths();
    }
    private function setBackOfficeInformation(){
        $this->backOffice = true;
        $this->localRoot = self::BACK_OFFICE_INDICATOR;
        $this->sourceDomain = self::BACK_OFFICE_DOMAIN;
        $this->sanitizedPath = str_replace('/'.self::BACK_OFFICE_INDICATOR.'/','/',$this->requestUri);
        $this->sourcePath = $this->sourceDomain.self::BACK_OFFICE_PATH.$this->sanitizedPath;
        $this->finalizePaths();
    }

    public function getRequestUri(){
        return $this->requestUri;
    }

    /**
     * @return mixed
     */
    public function getLocalRoot()
    {
        return $this->localRoot;
    }

    /**
     * @return mixed
     */
    public function getSourceDomain()
    {
        return $this->sourceDomain;
    }

    /**
     * @return mixed
     */
    public function getSourceRoot()
    {
        return $this->sourceRoot;
    }

    /**
     * @return mixed
     */
    public function getLocalPath()
    {
        return $this->localPath;
    }

    /**
     * @return mixed
     */
    public function getSourcePath()
    {
        return $this->sourcePath;
    }

    /**
     * @return mixed
     */
    public function getRealURI()
    {
        return $this->realURI;
    }

    /**
     * @return mixed
     */
    public function getPathParts()
    {
        return $this->pathParts;
    }

    /**
     * @return mixed
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * @return mixed
     */
    public function getDirectoryStructure()
    {
        return $this->directoryStructure;
    }

    /**
     * @return mixed
     */
    public function getFileNameWithoutExtension()
    {
        return $this->fileNameWithoutExtension;
    }

    /**
     * @return bool
     */
    public function isRetina()
    {
        return $this->retina;
    }

    /**
     * @return bool
     */
    public function isBackOffice()
    {
        return $this->backOffice;
    }

    /**
     * @return int
     */
    public function getPngCompression()
    {
        return $this->pngCompression;
    }

    /**
     * @return int
     */
    public function getJpgCompression()
    {
        return $this->jpgCompression;
    }

}