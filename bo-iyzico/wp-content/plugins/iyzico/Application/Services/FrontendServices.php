<?php
/**
 * Created by PhpStorm.
 * User: HarunAkgun
 * Date: 18.12.2014
 * Time: 14:12
 */

namespace Iyzico\Application\Services;

use Iyzico\Library\IyziJs;
use Iyzico\Library\IyziCss;
use Iyzico\Library\DatabaseTools;
use Iyzico\Application\Services\DatabaseApi;
use Iyzico\Library\Utils;
use Iyzico\Library\Messages;
use \WP_Session;

/**
 * Class FrontendServices
 * @package Iyzico\Application\Services
 */
class FrontendServices {
    public static $twitterIncluded = false;
    public $associativeMenu = false;
    public $locations,$slideInMenu,$slideInMenuItems = false;
    public static function iyziQueueJs($val, $attr, $content = null){

        $parsedUrl = parse_url( $content );
        $pathToScript = $parsedUrl['path'];

        IyziJs::addScript($pathToScript,$attr);
    }
    public static function iyziQueueCSS($val, $attr, $content = null){
        $dom = new \domDocument;
        $dom->loadHTML((mb_convert_encoding($val, 'HTML-ENTITIES', 'UTF-8')));
        $dom->preserveWhiteSpace = false;
        $parsedUrl = parse_url($dom->getElementsByTagName('link')->item(0)->getAttribute('href'));
        $parsedMedia = $dom->getElementsByTagName('link')->item(0)->getAttribute('media');
        $extension = pathinfo($parsedUrl['path'], PATHINFO_EXTENSION) ;

        if ( $extension !== "css" )  {
            if ($extension == 'php') return '';
            if ($extension == '') return $val;
        }
        $pathToCss = $parsedUrl['path'];
        IyziCss::addStyle($pathToCss,$parsedMedia,$attr);
    }
    public static function pageBasedScripts(){
        $basePath =get_template_directory_uri()."/js/";
        /*
        if( is_front_page() ) {
            wp_enqueue_script('jquery-marquee', $basePath."jquery.marquee.min.js", array('jquery'), '', true);
        }
        wp_enqueue_script('slide_bars', $basePath."slidebars/slidebars.min.js",array('jquery'), '', false);
        wp_enqueue_script('masonry', $basePath."masonry/masonry.pkgd.min.js",'', '', false);
        wp_enqueue_script('images-loaded-masonry', $basePath."masonry/imagesLoaded.pkgd.min.js",array('masonry'), '', false);
        wp_enqueue_script('jquery-easytabs', $basePath."eaasytabs/jquery.easytabs.min.js",array('jquery'), '', false);
        wp_enqueue_script('udesign-scriptss', $basePath."script.js", array('jquery'), '1.0', false);
        */
    }
    public static function placeMergedHeadJavascript($content = null){
        $headerScripts = IyziJs::getHeaderScripts();
        if ( count($headerScripts) > 0 ) {
            //Generate URL
            $headerParameters = array (
                "gzip"   => false,
                "merged" => true,
                "queue"  => $headerScripts
            );
            echo('<script type="text/javascript" src="'.IYZICO_MAIN__JS_PROCESSOR_PATH.'?'.http_build_query($headerParameters).'"></script>'."\n");
        }
    }
    public static function placeMergedHeadCSS($content = null){

        $headerStyles = IyziCSS::getHeaderStyles();
        $styleIncluder = "";
        foreach($headerStyles as $media=>$hrefArray) {
            $headerParameters = array (
                "gzip"   => false,
                "merged" => true,
                "queue"  => $hrefArray
            );
            $styleIncluder .= '<link rel="stylesheet"  type="text/css" href="'.IYZICO_MAIN__CSS_PROCESSOR_PATH.'?'.http_build_query($headerParameters).'" media="'.$media.'" />'."\n";
        }
        echo($styleIncluder);
    }
    public static function placeHeadCSS($content = null){
        $headerStyles = IyziCSS::getHeaderStyles();
        $styleIncluder = "";
        $toolbox = new DatabaseTools();
        $iyziMinifyDetails = $toolbox->getMinifyDetails();

        if ( count($headerStyles) > 0 ) {
            $compressionEnabled = false;
            if ($iyziMinifyDetails['js_minify_status'] == 2) $compressionEnabled = true;

            $temporaryHtml = "";
            foreach ($headerStyles as $media => $hrefArray) {
                {
                    for ($i = 0; $i < count($hrefArray); $i++) {
                        $headerParameters = array(
                            "gzip" => false,
                            "merged" => false,
                            "queue" => $hrefArray[$i]
                        );
                        $temporaryHtml .= '<link rel="stylesheet"  type="text/css" href="' . IYZICO_MAIN__CSS_PROCESSOR_PATH . '?' . http_build_query($headerParameters) . '" media="' . $media . '" />' . "\n";
                    }
                }
            }
            $temporaryHtml.= '<link rel="stylesheet"  type="text/css" href="'.get_template_directory_uri().'/styles/custom/custom_style.css" media="screen" />'."\n";
            echo($temporaryHtml);
        }

    }
    public static function placeMergedFootJavascript($content = null){
        $footerScripts = IyziJs::getFooterScripts();
        if ( count($footerScripts) > 0 ) {
            //Generate URL
            $footerParameters = array (
                "gzip"   => false,
                "merged" => true,
                "queue"  => $footerScripts
            );
            echo('<script type="text/javascript" src="'.IYZICO_MAIN__JS_PROCESSOR_PATH.'?'.http_build_query($footerParameters).'"></script>'."\n");
        }
    }
    public static function placeHeadJavascript($content = null){
        $headerScripts = IyziJs::getHeaderScripts();
        $toolbox = new DatabaseTools();
        $iyziMinifyDetails = $toolbox->getMinifyDetails();

        if ( count($headerScripts) > 0 ) {
            $compressionEnabled = false;
            if ( $iyziMinifyDetails['js_minify_status'] == 2 ) $compressionEnabled = true;

            $temporaryHtml ="";
            for ($index = 0;$index<count($headerScripts);$index++)
            {
                $headerParameters = array (
                    "gzip"   => false,
                    "merged" => false,
                    "queue"  => $headerScripts[$index]
                );

                $temporaryHtml .= "<script type='text/javascript' src='".IYZICO_MAIN__JS_PROCESSOR_PATH."?".http_build_query($headerParameters)."'></script>"."\n";
            }
            echo($temporaryHtml);

        }

    }
    public static function placeFootJavascript($content = null){
        $footerScripts = IyziJs::getFooterScripts();
        $toolbox = new DatabaseTools();
        $iyziMinifyDetails = $toolbox->getMinifyDetails();

        if ( count($footerScripts) > 0 ) {
            $compressionEnabled = false;
            if ( $iyziMinifyDetails['js_minify_status'] == 2 ) $compressionEnabled = true;

            $temporaryHtml ="";
            for ($index = 0;$index<count($footerScripts);$index++)
            {
                $footerParameters = array (
                    "gzip"   => false,
                    "merged" => false,
                    "queue"  => $footerScripts[$index]
                );

                $temporaryHtml .= "<script type='text/javascript' src='".IYZICO_MAIN__JS_PROCESSOR_PATH."?".http_build_query($footerParameters)."'></script>"."\n";
            }
            echo($temporaryHtml);

        }

    }
    public static function injectTwitterOAuth(){
        if (!self::$twitterIncluded) {
            $twitterOAuthFiles = array(
                "Util/JsonDecoder.php",
                "Config.php",
                "Consumer.php",
                "SignatureMethod.php",
                "HmacSha1.php",
                "Request.php",
                "Response.php",
                "Token.php",
                "TwitterOAuth.php",
                "TwitterOAuthException.php",
                "Util.php"
            );
            foreach($twitterOAuthFiles as $index=>$dependency) {
                require_once( IYZICO_MAIN__TWITTEROAUTH_DIR . $dependency );
            }
            return true;
        } else {
            return true;
        }
    }
    public static function sendContactMail($senderName,$senderEmail,$message,$toSlug){
        $config = Utils::getConfigurations();
        $toAddress = $config['application']['emailAddresses'][$toSlug];

        $headers[] = 'From: '.$senderName.' <'.$senderEmail.'>';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        $messageHtml = "<small>A new contact e-mail recieved. Details are as follows:</small><br>".date('d.m.Y H:i:s')."<br><br><br>";
        $messageHtml .= "<b>Sender :</b> $senderName ( $senderEmail ) <br><br>".$message;
        add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
        $sended = wp_mail( $toAddress, 'New Contact Form Entry Recieved.', $messageHtml, $headers );

        if ( $sended ){
            $_SESSION['contact-response'] = true;
        } else {
            $_SESSION['contact-response'] = false;
        }
    }
    public function sanitizeMenu(){
        if ($this->locations == false) {
            $this->locations = get_nav_menu_locations();
            $this->slideInMenu = wp_get_nav_menu_object( $this->locations[ 'slideInMenu' ] );
            $this->slideInMenu_items = wp_get_nav_menu_items($this->slideInMenu->term_id);

            foreach($this->slideInMenu_items as $index => $menuItem) {
                if ($menuItem->menu_item_parent == 0) {
                    $this->associativeMenu[$menuItem->ID] = array(
                        "item" => $menuItem,
                        "subs" => array()
                    );
                } else {
                    $tempItem = array(
                        'item' => $menuItem,
                        'subs' => array()
                    );
                    if (!isset($this->associativeMenu[$menuItem->menu_item_parent])) {
                        $this->associativeMenu[$menuItem->menu_item_parent]['subs'] = array();
                    }
                    array_push($this->associativeMenu[$menuItem->menu_item_parent]['subs'],$tempItem);
                }

            }
        }
        return $this->associativeMenu;

    }
    public function getMenuByLevel($level = 0){
        $associativeMenu = $this->sanitizeMenu();

        if ($level == 0) {
            $relatedContext = $associativeMenu;
        } else {
            $relatedContext = $associativeMenu[$level];
        }

    }
    public static function getRegisteredMerchantCount(){

        $phpMerchantCount = (int)get_option('iyzico_general_settings_base_merchant_count');
        $registeredMerchantCount = get_transient( 'registeredMerchantCount' );
        if ($registeredMerchantCount === false) {
            $toolbox = new Utils();
            $restResponse = $toolbox->restGet('count',false);
            if ($restResponse->status == "success") {
                $registeredMerchantCount = $restResponse->count + $phpMerchantCount;
                $registeredMerchantCount = number_format($registeredMerchantCount, 0, '', '.');
                set_transient( 'registeredMerchantCount', $registeredMerchantCount, 60*60);
            } else {
                $registeredMerchantCount = "...";
            }
        }
        return $registeredMerchantCount;
    }
    public static function getInstallmentMatrix($price = 100) {

        $price = (int)$price;
        $toolbox = new Utils();
        $payload = array(
            "price" => $price,
            "vatRemoved" => true
        );

        $restResponse = $toolbox->restPost('installment',$payload);
        if ($restResponse->status == "success") {
            return $restResponse->installmentDetails;
        } else {
            return false;
        }

    }
    public static function registerUser($email,$phone,$website,$password,$passwordRepeat){
        $toolbox = new Utils();
        $msg = new Messages();

        $payload = array(
            "email"         => $email,
            "phoneNumber"   => $phone,
            "website"       => $website,
            "password"      => $password,
            "confirmPassword"=> $passwordRepeat
        );
        $restResponse = $toolbox->restPost('register',$payload);

        if ($restResponse->status == "success") {
            $msg->flash('success-register','Vermiş olduğunuz e-posta adresine aktivasyon e-postası gönderildi.','success flash-message');
        } else {
            $msg->flash('error-register',$restResponse->errorMessage,'error flash-message');
        }
    }
    public static function uploadUserGeneratedContent($filesToUpload) {
        $toolbox = new Utils();
        $file = $filesToUpload["upload_attachment"];
        $userUploadsFolder = WP_CONTENT_DIR .'/useruploads/';

        $imageCheck = getimagesize($file["tmp_name"]);
        $path = $file['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $target_file = $userUploadsFolder . time() . '.'.$ext;

        $dh  = opendir($userUploadsFolder);
        while (false !== ($filename = readdir($dh))) {
            $fileNameArr = explode('.',$filename);
            if (count($fileNameArr)>0 && $fileNameArr[0] != "") {
                $expired = time() - (60*60*24);
                if ($expired > (int)$fileNameArr[0]){
                    unlink($userUploadsFolder.implode('.',$fileNameArr));
                }
            }
        }
        $extraMimes = array(
            'application/pdf',
            'image/jpeg',
            'image/png',
            'image/svg'
        );
        $possibleExtensions = array('jpg','png','jpeg','tiff','pdf','svg');

        if ($imageCheck !== false || in_array($file['type'],$extraMimes) !== false ) {
            if (in_array(strtolower($ext),$possibleExtensions) ) {
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    return $target_file;
                }
            } else {
                return false;
            }

        }
        return false;
    }
    public static function getStatusResponse($ruleName) {
        $toolbox = new Utils();
        $payload = array(
            "ruleName" => $ruleName
        );
        $statusResponse = get_transient( 'statusFor'.$ruleName );
        if ($statusResponse) {
            $restResponse = $statusResponse;
        } else {
            $restResponse = $toolbox->restStatusGet('logs',$payload);
            set_transient( 'statusFor'.$ruleName, $restResponse, 60*5);
        }

        if ($restResponse->status == "success") {
            return $restResponse;
        } else {
            return false;
        }

    }
    public static function getDailyAverageResponse($ruleName,$datetime) {
        $toolbox = new Utils();
        $payload = array(
            "ruleName" => $ruleName,
            "datetime" => $datetime
        );
        $statusResponse = get_transient( 'dayStatusFor'.$ruleName.$datetime );
        if ($statusResponse) {
            $restResponse = $statusResponse;
        } else {
            $restResponse = $toolbox->restStatusGet('day',$payload);
            set_transient( 'dayStatusFor'.$ruleName.$datetime , $restResponse, 60*5);
        }

        if ($restResponse->status == "success") {
            return $restResponse;
        } else {
            return false;
        }

    }
}
