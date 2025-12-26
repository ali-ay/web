<?php
/**
 * Created by PhpStorm.
 * User: HarunAkgun
 * Date: 18.12.2014
 * Time: 11:08
 */

namespace Iyzico\Library;

use Iyzico\Application\Services\DatabaseApi;
use \WP_Session;
use Iyzico\Library\AES128Encryptor;
use Symfony\Component\Yaml\Parser;
/**
 * Class Utils
 * @package Iyzico\Library
 */
class Utils {
    public static $routesObject = false;
    public static $configurationObject = false;
    /**
     *	A quick shortcut to create a View layer.
     *	@param $model(array)		Model layer, has every data that the View needs
     *  @return null Or false;
     */
    public static function renderView($model)
    {
        global $queryDebug;
        $headerPath = IYZICO_MAIN__VIEWS_DIR.'/Templates/header.php';
        $footerPath = IYZICO_MAIN__VIEWS_DIR.'/Templates/footer.php';
        $debugPath = IYZICO_MAIN__VIEWS_DIR.'/Templates/debug.php';

        if (file_exists($headerPath)) {
            require_once($headerPath);
        }

        $view = self::resolveView();

        if (file_exists($view)) {
            require_once($view);
            self::attachJavascript();
        } else {
            die('can not find view. ('.$view.')');
            return false;
        }
        if (file_exists($debugPath)) {
            require_once($debugPath);
        }
        if (file_exists($footerPath)) {
            require_once($footerPath);
        }
    }

    public static function attachJavascript(){
        wp_enqueue_script(
            'core-javascript',
            plugins_url( '../Assets/js/iyzico-core.min.js', __FILE__ ),
            array( 'jquery' )
        );
        wp_localize_script(
            'core-javascript',
            'global_variables',
            array (
                'ajax_url' => admin_url( 'admin-ajax.php' )
            )
        );
        add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
    }

    public static function renderJson($responseData){
        echo(json_encode($responseData));
        die();
    }

    /**
     * @param $controllerName
     * @return string
     */
    public static function controllerResolver($controllerName){
        return "Iyzico\\Application\\Controllers\\".$controllerName."Controller";
    }

    /**
     * @param $actionName
     * @return string
     */
    public static function actionResolver($actionName){
        return $actionName."Action";
    }

    public static function getRoutes(){
        if ( !self::$routesObject ) {


            $routePath = IYZICO_MAIN__CONFIG_PATH.'routes.yml';
            if (function_exists(yaml_parse_file)) {
                self::$routesObject = yaml_parse_file($routePath);
            } else {
                $yaml = new Parser();
                self::$routesObject = $yaml->parse(file_get_contents($routePath));
            }

        }
        return self::$routesObject;
    }


    public static function getConfigurations(){
        if ( !self::$configurationObject ) {
            $configPath = IYZICO_MAIN__CONFIG_PATH.'config.yml';
            if (function_exists(yaml_parse_file)) {
                self::$configurationObject = yaml_parse_file($configPath);
            } else {
                $yaml = new Parser();
                self::$configurationObject = $yaml->parse(file_get_contents($configPath));
            }


        }
        return self::$configurationObject;
    }
    public static function getIyzicoAPIDetails(){
        $config = self::getConfigurations();
        return $config['application']['iyzicoAPIDetails'];
    }
    public static function getIyzicoStatusAPIDetails(){
        $config = self::getConfigurations();
        return $config['application']['iyzicoStatusAPIDetails'];
    }
    public static function getIyzicoMediaServerDetails(){
        $config = self::getConfigurations();
        return $config['application']['iyzicoMediaServerDetails'];
    }

    public static function generateMediaUrlObject($url) {
        $mediaServer = self::getIyzicoMediaServerDetails();
        $mediaUrl = $mediaServer['url'];
        $selfUrl = get_option( 'siteurl' ).'/wp-content/uploads/';
        $finalUrl = str_replace($selfUrl,$mediaUrl,$url);
        $finalUrl = str_replace('http://','//',$finalUrl);
        $rawUrl = explode('.',$finalUrl);
        $extension = array_pop($rawUrl);
        return array(
            'file' => implode('.', $rawUrl),
            'extension' => $extension
        );
    }



    /**
     * @return string
     */
    public static function resolveView()
    {
        $viewsDir = IYZICO_MAIN__VIEWS_DIR;

        $trace=debug_backtrace();
        $caller=$trace[2];
        $folderName = explode("\\",$caller['class']);
        $folderName = str_replace('Controller','',$folderName[count($folderName)-1]);
        $fileName = str_replace('Action','',$caller['function']);

        return $viewsDir.''.$folderName.'/'.$fileName.'.php';


    }
    public static function generatePaginationUrl($toPage = false){
        $parsedUrl = parse_url( $_SERVER['REQUEST_URI'] );
        parse_str($parsedUrl['query'],$parsedArguments);
        if ( $toPage ) {
            $parsedArguments['paged'] = $toPage;
        }
        return $parsedUrl['path'].'?'.http_build_query($parsedArguments);
    }
    public static function generateFilterUrl($filterBy = false){
        $parsedUrl = parse_url( $_SERVER['REQUEST_URI'] );
        parse_str($parsedUrl['query'],$parsedArguments);
        if ( $filterBy ) {
            $parsedArguments['parent'] = $filterBy;
        } else {
            unset($parsedArguments['parent']);
        }
        return $parsedUrl['path'].'?'.http_build_query($parsedArguments);
    }
    public static function getCategoryJson($categoryObject){
        return json_encode(
            array(
                "name"=>array(
                    "title"=>"Name",
                    "type"=>"standard,text",
                    "value"=>$categoryObject['Name']
                ),
                "parent"=>array(
                    "title"=>"Parent",
                    "type"=>"template,parentSelectorTemplate",
                    "value"=>$categoryObject['ParentId']
                ),
                "rank"=>array(
                    "title"=>"Rank",
                    "type"=>"standard,number",
                    "value"=>$categoryObject['Rank']
                )
            )
        );
    }
    public static function getQuestionJson($questionObject){
        return json_encode(
            array(
                "question"=>array(
                    "title"=>"Question",
                    "type"=>"large,text",
                    "value"=>stripslashes($questionObject['Question'])
                ),
                "answer"=>array(
                    "title"=>"Answer",
                    "type"=>"large,text",
                    "value"=>stripslashes($questionObject['Answer'])
                ),
                "parent"=>array(
                    "title"=>"Parent",
                    "type"=>"template,parentSelectorTemplate",
                    "value"=>$questionObject['ParentId']
                ),
                "rank"=>array(
                    "title"=>"Rank",
                    "type"=>"standard,number",
                    "value"=>$questionObject['Rank']
                )
            )
        );
    }
    public function getQnAJson($qnaObject){
        return json_encode(
            array(
                "question"=>array(
                    "title"=>"Question",
                    "type"=>"standard,text",
                    "value"=>$qnaObject['question']
                ),
                "answer"=>array(
                    "title"=>"Answer",
                    "type"=>"large,text",
                    "value"=>$qnaObject['answer']
                ),
                "parent"=>array(
                    "title"=>"Parent",
                    "type"=>"template,parentSelectorTemplate",
                    "value"=>$qnaObject['parentId']
                ),
                "rank"=>array(
                    "title"=>"Rank",
                    "type"=>"standard,number",
                    "value"=>$qnaObject['rank']
                )
            )
        );
    }
    public static function getPageRoute($routeName,$queryStringParameters = false) {
        $parsedUrl = parse_url( $_SERVER['REQUEST_URI'] );
        $routes = self::getRoutes();
        if ($routes[$routeName]) {
            $queryStringParameters['page'] = $routeName;
            return $parsedUrl['path'] . '?' . http_build_query($queryStringParameters);
        }

    }
    public static function controllerParser($controllerString) {
        $controllerArray = explode('>',$controllerString);
        return array(
            self::controllerResolver($controllerArray[0]),
            self::actionResolver($controllerArray[1])
        );
    }

    public static function redirect($routeName) {
        if ( headers_sent() === false ) {
            header("Location: ".self::getPageRoute($routeName));
        } else {
            echo "
            <script type='text/javascript'>
                window.location = '".self::getPageRoute($routeName)."';
            </script>
            ";
        }
        die();
    }

    public function getCSRFToken(){
        $wp_session = WP_Session::get_instance();
        if (!isset($wp_session['csrf'])){
            $wp_session['csrf'] = md5(uniqid(mt_rand(), true));
        }
        return $wp_session['csrf'];
    }

    public static function getGlobalLanguages(){
        $dbTools = new DatabaseApi();
        $allLanguages = $dbTools->getAllLanguages();
        $wp_session = WP_Session::get_instance();
        if ( !isset($wp_session['language']) ) {
            if ($allLanguages) {
                foreach($allLanguages as $index=>$language) {
                    if ( $language['IsDefault'] ) {
                        $wp_session['language'] = $language['Language'];
                    }
                }
            }
        }
        $currentLanguage = $wp_session['language'];
        return array(
            'currentLanguage'   => $currentLanguage,
            'allLanguages'      => $allLanguages
        );
    }

    public static function getCurrentLanguage($isFrontend = false){
        if ( $isFrontend ) {

            return $currentLanguage = icl_get_current_language();

        } else {

            $wp_session = WP_Session::get_instance();
            return  $wp_session['language'];
        }
    }

    public static function sanitizer($txt) {
        $search = array('Ä±','ÅŸ','Ã–','Ã‡','Ã¶','Ã¼','ÄŸ','Ã§','â€™','Ä°','Åž','â€‹','Ãœ','&rsquo;');
        $replace = array ('ı','ş','ö','Ç','ö','ü','ğ','ç','\'','İ','Ş','','Ü',"'",);
        if ( $txt ) {
            return str_replace($search,$replace,$txt);
        }

    }

    public static function DOMinnerHTML(\DOMNode $element)
    {
        $innerHTML = "";
        $children = $element->childNodes;
        foreach ($children as $child)
        {
            $tmp_dom = new \DOMDocument();
            $tmp_dom->appendChild($tmp_dom->importNode($child, true));
            $innerHTML.=trim($tmp_dom->saveHTML());
        }
        return $innerHTML;
    }

    public static function  generateRandomString($length = 10,$onlyLetters = false) {
        if ($onlyLetters) {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function restHeaders($extraHeaders=false){
        $apiConfiguration = self::getIyzicoAPIDetails();
        $encryptor = new AES128Encryptor($apiConfiguration['salt']);


        $encryptedDeveloperKey = $encryptor->encrypt($apiConfiguration['developerKey']);
        $result = array(
            'x-iyzi-developer-key: '.$encryptedDeveloperKey,
            'x-iyzi-app-name: iyzico-website',
            'Content-Type: application/json'
        );
        if ($extraHeaders) $result = array_merge($result,$extraHeaders);
        return $result;
    }
    public static function restGet($endpoint){
        $apiConfiguration = self::getIyzicoAPIDetails();
        $headers = self::restHeaders();
        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $apiConfiguration['url'].$endpoint);
        curl_setopt($rest, CURLINFO_HEADER_OUT, true);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
        $restResponse = curl_exec($rest);
        curl_close($rest);

        return json_decode($restResponse);
    }
    public static function restPost($endpoint,$payload){
        $apiConfiguration = self::getIyzicoAPIDetails();
        $encryptor = new AES128Encryptor($apiConfiguration['salt']);
        $rawBody = json_encode($payload);
        $requestBody = json_encode(array(
            'hash'=>$encryptor->encrypt($rawBody)
        ),true);

        $requestHeaders = self::restHeaders(array(
            'Content-Length:'.strlen($requestBody)
        ));

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $apiConfiguration['url'].$endpoint);
        curl_setopt($rest, CURLINFO_HEADER_OUT, true);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rest, CURLOPT_POST, 1);
        curl_setopt($rest, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($rest, CURLOPT_HTTPHEADER, $requestHeaders);
        $restResponse = curl_exec($rest);

        curl_close($rest);
        return json_decode($restResponse);
    }

    public static function restStatusGet($endpoint,$parameters){
        $apiConfiguration = self::getIyzicoStatusAPIDetails();
        $parameters['developerKey'] = $apiConfiguration['developerKey'];
        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $apiConfiguration['url'].$endpoint.'?'.http_build_query($parameters));
        curl_setopt($rest, CURLINFO_HEADER_OUT, true);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        $restResponse = curl_exec($rest);
        curl_close($rest);
        return json_decode($restResponse);
    }
    public static function slugify($string, $replace = array(), $delimiter = '-') {
        if (!extension_loaded('iconv')) {
            throw new Exception('iconv module not loaded');
        }
        // Save the old locale and set the new locale to UTF-8
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        if (!empty($replace)) {
            $clean = str_replace((array) $replace, ' ', $clean);
        }
        $clean = preg_replace('/[^a-zA-Z0-9\/_|+ -]/', '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace('/[\/_|+ -]+/', $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        // Revert back to the old locale
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }

}