<?php
error_reporting(0);
/**
 * @package Iyzico
 */
/*
Plugin Name: Iyzico
Plugin URI: http://iyzico.com/
Description: This is the base plugin for extending Wordpress capabilities to fit our companies needs.
Version: 0.0.1
Author: Harun Akgün
Author URI: http://harunakgun.com/
License: GPLv3 or later
Text Domain: iyzico
*/

// Make sure we don't expose any info if called directly
if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
show_admin_bar(false);
define( 'IYZICO_MAIN__VERSION', '0.0.1' );
define( 'IYZICO_MAIN__MINIMUM_WP_VERSION', '3.1' );
define( 'IYZICO_MAIN__CORE_DIR', plugin_dir_path( __FILE__ ) . 'Core/' );
define( 'IYZICO_MAIN__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'IYZICO_MAIN__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'IYZICO_MAIN__VIEWS_DIR', plugin_dir_path( __FILE__ ) . 'Views/' );
define( 'IYZICO_MAIN__MODEL_DIR', plugin_dir_path( __FILE__ ) . 'Model/' );
define( 'IYZICO_MAIN__CONFIG_PATH', plugin_dir_path( __FILE__ ) .'Config/');
define( 'IYZICO_MAIN__LIBRARY_DIR', plugin_dir_path( __FILE__ ) .'Library/');
define( 'IYZICO_MAIN__CONTROLLER_DIR', plugin_dir_path( __FILE__ ) .'Application/Controllers/');
define( 'IYZICO_MAIN__SERVICES_DIR', plugin_dir_path( __FILE__ ) .'Application/Services/');
define( 'IYZICO_MAIN__TWITTEROAUTH_DIR', plugin_dir_path( __FILE__ ) .'Library/TwitterOAuth/');
define( 'IYZICO_MAIN__WIDGETS_DIR', plugin_dir_path( __FILE__ ) .'Library/Widgets/');
define( 'IYZICO_MAIN__WALKER_DIR', plugin_dir_path( __FILE__ ) .'Library/Widgets/');

register_activation_hook( __FILE__, array( 'Iyzico\Application\Controllers\SettingsController', 'activatePlugin' ) );
$queryDebug = array(); 	//WILL BE USED FOR DEBUGGING;

require_once(IYZICO_MAIN__PLUGIN_DIR . '/vendor' . '/autoload.php');

require_once( IYZICO_MAIN__LIBRARY_DIR . 'Utils.php' );
require_once( IYZICO_MAIN__LIBRARY_DIR . 'DatabaseTools.php' );
require_once( IYZICO_MAIN__LIBRARY_DIR . 'Messages.php' );
require_once( IYZICO_MAIN__SERVICES_DIR . 'DatabaseApi.php' );
// WIDGETS

// new iyzico start

require_once( IYZICO_MAIN__WIDGETS_DIR . 'mainHeaderWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'ReferenceLogosWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'headerWithImageWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalBrandsKitheaderWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'iyideniyiyeheaderWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'iyideniyiyeSocialWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'iyideniyiyeFemaleWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'iyideniyiyeiyzicoStartWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'iyideniyiyeSocialGroupWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'iyideniyiyeSocialGroupVideoWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalBrandsKitDownloadWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalBrandsLogoPackDownloadWidget.php' );


require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalHomeHeaderWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalHomeFeatureListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalHomeMobileAppSliderWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalHomePwiWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalHomeAppDownloadWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalHomeShopListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalHomeCampaignWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'featureCardsWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'pinkWithImageWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'whoIsiyzicoWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'componentWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'customCssWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalPwiSssWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalBPSssWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalDeercaseSssWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalCardSssWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalCardHeaderWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'personalMainHeaderWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'businessPwiSssWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'businessMPOutSssWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'businessFemaleEntSssWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'businessBPBTSssWidget.php' );

// new iyzico end

require_once( IYZICO_MAIN__WIDGETS_DIR . 'MainLPHeadWidgetWithProducts.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'PosLPHeadWidgetWithProducts.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BuyerProtectionLPHeadWidgetWithProducts.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BazaarLPHeadWidgetWithProducts.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkLPHeadWidgetWithProducts.php' );


require_once( IYZICO_MAIN__WIDGETS_DIR . 'MainPricingAndOfferWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'PosPricingAndOfferWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BazaarPricingAndOfferWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkPricingAndOfferWidget.php' );


require_once( IYZICO_MAIN__WIDGETS_DIR . 'MainWhyIyzicoWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'IntWhyIyzicoWidget.php' );

require_once( IYZICO_MAIN__WIDGETS_DIR . 'MainIntegrationWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BuyerProtectionWhyIyzicoWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'WhyBuyerProtectionWidget.php' );

require_once( IYZICO_MAIN__WIDGETS_DIR . 'MainTestimonialsWidget.php' );

require_once( IYZICO_MAIN__WIDGETS_DIR . 'PosFeatureListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BazaarFeatureListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'CardFeatureListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'PartnerSolutionFeatureListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkFeatureListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BuyerProtectionFeatureListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'CardFeatureListScreenWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'CardFeatureListScreenTwoWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'CardPriceListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BuyerProtectionTrustSurveyBlogWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BuyerProtectionReferencesWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BuyerProtectionNewReferencesWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BuyerProtectionShopsWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BuyerProtectionHowToWidget.php' );

require_once( IYZICO_MAIN__WIDGETS_DIR . 'PosMonitorAnywhereWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BazaarMonitorAnywhereWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkMonitorAnywhereWidget.php' );


require_once( IYZICO_MAIN__WIDGETS_DIR . 'PosProcessWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BazaarProcessWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkProcessWidget.php' );


require_once( IYZICO_MAIN__WIDGETS_DIR . 'PosIntegrationWithoutTabsWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BazaarIntegrationWithoutTabsWidget.php' );


require_once( IYZICO_MAIN__WIDGETS_DIR . 'MainReferenceLogosWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'PosReferenceLogosWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BazaarReferenceLogosWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkReferenceLogosWidget.php' );


require_once( IYZICO_MAIN__WIDGETS_DIR . 'MainProductsWidget.php' );

require_once( IYZICO_MAIN__WIDGETS_DIR . 'InternationalPageHeadWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'InternationalPartnersWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'InternationalMerchantLogosWidget.php' );

require_once( IYZICO_MAIN__WIDGETS_DIR . 'APMWidget.php' );

require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkEtsyWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkVideosWidget.php' );

require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkTestimonialsWidget.php' );

require_once( IYZICO_MAIN__WIDGETS_DIR . 'Europe/EuropeAPMWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'Europe/EuropeFeatureListWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'Europe/EuropeIntegrationWithoutTabsWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'Europe/EuropeLPHeadWidgetWithProducts.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'Europe/EuropeMonitorAnywhereWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'Europe/EuropePricingAndOfferWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'Europe/EuropeProcessWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'Europe/EuropeReferenceLogosWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'LinkWhyIyzicoWidget.php' );
require_once( IYZICO_MAIN__WIDGETS_DIR . 'BuyerProtectionSssWidget.php' );

require_once( IYZICO_MAIN__CONTROLLER_DIR . 'QnaController.php' );
require_once( IYZICO_MAIN__CONTROLLER_DIR . 'RestController.php' );
require_once( IYZICO_MAIN__SERVICES_DIR . 'RestServices.php' );
require_once( IYZICO_MAIN__CORE_DIR . 'Routing.php' );
if ( is_admin() ) {
	require_once( IYZICO_MAIN__CORE_DIR . 'Admin.php' );
	require_once( IYZICO_MAIN__CONTROLLER_DIR . 'SettingsController.php' );
    require_once( IYZICO_MAIN__SERVICES_DIR . 'FrontendServices.php' );
    require_once( IYZICO_MAIN__LIBRARY_DIR . 'AES128Encryptor.php' );
	add_action( 'init', array( 'Iyzico\Core\Admin', 'init' ) );
} else {
    require_once( IYZICO_MAIN__SERVICES_DIR . 'FrontendServices.php' );
    require_once( IYZICO_MAIN__SERVICES_DIR . 'FrontendFilters.php' );
    require_once( IYZICO_MAIN__SERVICES_DIR . 'FrontendShortcodesV2.php' );
	require_once( IYZICO_MAIN__CORE_DIR . 'Client.php' );
	add_action( 'init', array( 'Iyzico\Core\Client', 'init' ) );
}
function eps_enabler($mimes) {
    $mimes = array(
        'eps' => 'application/eps',
        'pdf' => 'application/pdf',
        'jpe' => 'image/jpeg',
        'jpeg'=> 'image/jpeg',
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'svg' => 'image/svg'
    );
    return $mimes;
}
add_filter('upload_mimes','eps_enabler');
add_action( 'init',  array( 'Iyzico\Application\Controllers\RestController', 'registerRestMenusAction' ) );
