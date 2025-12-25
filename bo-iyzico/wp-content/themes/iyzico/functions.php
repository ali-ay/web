<?php
/**
 * Register our sidebars and widgetized areas.
 *
 */
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
// new iyzico start
function personalHomeLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Personal Home LP',
		'id'            => 'personal-home-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function personalPWILPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Personal Pay With iyzico LP',
		'id'            => 'personal-pwi-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function personalBrandsLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Personal Brands Landing Page',
		'id'            => 'personal-brands-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function personalCampaignLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Personal Campaign Landing Page',
		'id'            => 'personal-campaign-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function personalBrandKitLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Personal Brands Kit Landing Page',
		'id'            => 'personal-brands-kit-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function personalBPLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Personal Buyer Protection LP',
		'id'            => 'personal-buyer-protection-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function personalDeercaseLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Personal Deercase LP',
		'id'            => 'personal-deercase-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function personalCardLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Personal Card LP',
		'id'            => 'personal-card-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function partnerSolutionLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Partner Solution LP',
		'id'            => 'partner-solution-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function arasKargoCampaignWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'iyzico Aras Kargo Kampanyası',
		'id'            => 'iyzico-aras-cargo-campaign-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function businessPWILPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Business Pay With iyzico LP',
		'id'            => 'business-pwi-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function businessiyzicoCepPosWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Business iyzico Cep Pos LP',
		'id'            => 'business-iyzico-cep-pos-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function businessBPBTLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Business Buyer Protection Bank Transfer LP',
		'id'            => 'business-buyer-protection-bank-transfer-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function businessMPOutLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Business Mass Pay Out LP',
		'id'            => 'business-mass-pay-out-lp-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function businessFemaleEntrepreneurWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Business Female Entrepreneur Landing Page',
		'id'            => 'business-female-entrepreneur-landing-page-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function iyideniyiyeLPWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'iyiden iyiye Landing Page',
		'id'            => 'iyiden-iyiye-landing-page-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action( 'widgets_init', 'personalHomeLPWidgetAreaInit' );
add_action( 'widgets_init', 'personalPWILPWidgetAreaInit' );
add_action( 'widgets_init', 'personalBrandsLPWidgetAreaInit' );
add_action( 'widgets_init', 'personalCampaignLPWidgetAreaInit' );
add_action( 'widgets_init', 'personalBrandKitLPWidgetAreaInit' );
add_action( 'widgets_init', 'personalBPLPWidgetAreaInit' );
add_action( 'widgets_init', 'personalDeercaseLPWidgetAreaInit' );
add_action( 'widgets_init', 'personalCardLPWidgetAreaInit' );
add_action( 'widgets_init', 'partnerSolutionLPWidgetAreaInit' );
add_action( 'widgets_init', 'arasKargoCampaignWidgetAreaInit' );
add_action( 'widgets_init', 'businessBPBTLPWidgetAreaInit' );
add_action( 'widgets_init', 'businessPWILPWidgetAreaInit' );
add_action( 'widgets_init', 'businessiyzicoCepPosWidgetAreaInit' );
add_action( 'widgets_init', 'businessMPOutLPWidgetAreaInit' );
add_action( 'widgets_init', 'businessFemaleEntrepreneurWidgetAreaInit' );
add_action( 'widgets_init', 'iyideniyiyeLPWidgetAreaInit' );

$customCssWidget = new customCssWidget();
$componentWidget = new componentWidget();
$whoIsiyzicoWidget = new whoIsiyzicoWidget();
$pinkWithImageWidget = new pinkWithImageWidget();
$featureCardsWidget = new featureCardsWidget();
$headerWithImageWidget = new headerWithImageWidget();
$personalBrandsKitheaderWidget = new personalBrandsKitheaderWidget();
$iyideniyiyeheaderWidget = new iyideniyiyeheaderWidget();
$iyideniyiyeSocialWidget = new iyideniyiyeSocialWidget();
$iyideniyiyeFemaleWidget = new iyideniyiyeFemaleWidget();
$iyideniyiyeiyzicoStartWidget = new iyideniyiyeiyzicoStartWidget();
$iyideniyiyeSocialGroupWidget = new iyideniyiyeSocialGroupWidget();
$iyideniyiyeSocialGroupVideoWidget = new iyideniyiyeSocialGroupVideoWidget();
$personalBrandsKitDownloadWidget = new personalBrandsKitDownloadWidget();
$personalBrandsLogoPackDownloadWidget = new personalBrandsLogoPackDownloadWidget();
$mainHeaderWidget = new mainHeaderWidget();
$ReferenceLogosWidget = new ReferenceLogosWidget();

$personalHomeHeaderWidget = new personalHomeHeaderWidget();
$personalHomeFeatureListWidget = new personalHomeFeatureListWidget();
$personalHomeMobileAppSliderWidget = new personalHomeMobileAppSliderWidget();
$personalHomePwiWidget = new personalHomePwiWidget();
$personalHomeAppDownloadWidget = new personalHomeAppDownloadWidget();
$personalHomeShopListWidget = new personalHomeShopListWidget();
$personalHomeCampaignWidget = new personalHomeCampaignWidget();
$personalPwiSssWidget = new personalPwiSssWidget();
$personalDeercaseSssWidget = new personalDeercaseSssWidget();
$personalBPSssWidget = new personalBPSssWidget();
$personalCardHeaderWidget = new personalCardHeaderWidget();
$personalCardSssWidget = new personalCardSssWidget();
$personalMainHeaderWidget = new personalMainHeaderWidget();
$businessPwiSssWidget = new businessPwiSssWidget();
$businessMPOutSssWidget = new businessMPOutSssWidget();
$businessFemaleEntSssWidget = new businessFemaleEntSssWidget();
$businessBPBTSssWidget = new businessBPBTSssWidget();

add_action('widgets_init', array($personalHomeHeaderWidget,'load_widget'));
add_action('widgets_init', array($personalHomeFeatureListWidget,'load_widget'));
add_action('widgets_init', array($personalHomeMobileAppSliderWidget,'load_widget'));
add_action('widgets_init', array($personalHomePwiWidget,'load_widget'));
add_action('widgets_init', array($personalHomeAppDownloadWidget,'load_widget'));
add_action('widgets_init', array($personalHomeShopListWidget,'load_widget'));
add_action('widgets_init', array($personalHomeCampaignWidget,'load_widget'));
add_action('widgets_init', array($personalPwiSssWidget,'load_widget'));
add_action('widgets_init', array($personalDeercaseSssWidget,'load_widget'));
add_action('widgets_init', array($personalBPSssWidget,'load_widget'));
add_action('widgets_init', array($personalCardHeaderWidget,'load_widget'));
add_action('widgets_init', array($personalCardSssWidget,'load_widget'));
add_action('widgets_init', array($personalMainHeaderWidget,'load_widget'));
add_action('widgets_init', array($businessPwiSssWidget,'load_widget'));
add_action('widgets_init', array($businessMPOutSssWidget,'load_widget'));
add_action('widgets_init', array($businessFemaleEntSssWidget,'load_widget'));
add_action('widgets_init', array($businessBPBTSssWidget,'load_widget'));
add_action('widgets_init', array($customCssWidget,'load_widget'));
add_action('widgets_init', array($componentWidget,'load_widget'));
add_action('widgets_init', array($whoIsiyzicoWidget,'load_widget'));
add_action('widgets_init', array($pinkWithImageWidget,'load_widget'));
add_action('widgets_init', array($featureCardsWidget,'load_widget'));
add_action('widgets_init', array($headerWithImageWidget,'load_widget'));
add_action('widgets_init', array($personalBrandsKitheaderWidget,'load_widget'));
add_action('widgets_init', array($iyideniyiyeheaderWidget, 'load_widget'));
add_action('widgets_init', array($iyideniyiyeSocialWidget, 'load_widget'));
add_action('widgets_init', array($iyideniyiyeFemaleWidget, 'load_widget'));
add_action('widgets_init', array($iyideniyiyeiyzicoStartWidget, 'load_widget'));
add_action('widgets_init', array($iyideniyiyeSocialGroupWidget, 'load_widget'));
add_action('widgets_init', array($iyideniyiyeSocialGroupVideoWidget, 'load_widget'));
add_action('widgets_init', array($personalBrandsKitDownloadWidget,'load_widget'));
add_action('widgets_init', array($personalBrandsLogoPackDownloadWidget,'load_widget'));
add_action('widgets_init', array($mainHeaderWidget,'load_widget'));
add_action('widgets_init', array($ReferenceLogosWidget,'load_widget'));
add_action('widgets_init', array($personalPwiSss,'load_widget'));

// new iyzico end
function iyzicoMainLandingPageWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'Main Landing Page Widgets',
		'id'            => 'main-landing-page-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
function iyzicoCrossborderLandingPageWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'iyziGlobe Landing Page Widgets',
		'id'            => 'iyziglobe-landing-page-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );

}
function iyzicoIyziPosLandingPageWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'iyziPos Landing Page Widgets',
		'id'            => 'iyzipos-landing-page-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );

}
function iyzicoMarketplaceLandingPageWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'iyziBazaar Landing Page Widgets',
		'id'            => 'iyzibazaar-landing-page-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );

}
function iyzicoLinkLandingPageWidgetAreaInit() {

	register_sidebar( array(
		'name'          => 'iyziLink Landing Page Widgets',
		'id'            => 'iyzilink-landing-page-widgets',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );

}
function buyerProtectionLandingPageWidgetAreaInit() {

        register_sidebar( array(
            'name'          => 'Buyer Protection Landing Page Widgets',
            'id'            => 'buyer-protection-landing-page-widgets',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        ) );

    }
function iyzicoInternationalPageWidgetAreaInit() {

    register_sidebar( array(
        'name'          => 'International Page Widgets',
        'id'            => 'international-page-widgets',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

}

function iyzicoEuropePageWidgetAreaInit() {

    register_sidebar( array(
        'name'          => 'Europe Page Widgets',
        'id'            => 'europe-page-widgets',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

}

add_theme_support( 'post-thumbnails' );

function customPostSort( $post ){
    add_meta_box(
        'custom_post_sort_box',
        'Position in List of Posts',
        'custom_post_order',
        'post' ,
        'side'
    );
}
function custom_post_order( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'custom_post_order_nonce' );
    $current_pos = get_post_meta( $post->ID, '_custom_post_order', true); ?>
    <p>Enter the position at which you would like the post to appear. For exampe, post "1" will appear first, post "2" second, and so forth.</p>
    <p><input type="number" name="pos" value="<?php echo $current_pos; ?>" /></p>
    <?php
}

function save_custom_post_order( $post_id ){
    if ( !isset( $_POST['custom_post_order_nonce'] ) || !wp_verify_nonce( $_POST['custom_post_order_nonce'], basename( __FILE__ ) ) ){
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ){
        return;
    }
    if ( isset( $_REQUEST['pos'] ) ) {
        update_post_meta( $post_id, '_custom_post_order', sanitize_text_field( $_POST['pos'] ) );
    }
}
function add_custom_post_order_column( $columns ){
    return array_merge ( $columns,
        array( 'pos' => 'Position', ));
}
function custom_post_order_value( $column, $post_id ){
    if ($column == 'pos' ){
        echo '<p>' . get_post_meta( $post_id, '_custom_post_order', true) . '</p>';
    }
}
function unregister_default_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Nav_Menu_Widget');
    unregister_widget('Twenty_Eleven_Ephemera_Widget');
}
function custom_upload_mimes ( $existing_mimes=array() ) {

    $existing_mimes['mp4'] = 'video/mp4';
    $existing_mimes['webm'] = 'video/webm';
    $existing_mimes['gif'] = 'image/gif';
    return $existing_mimes;
}

add_filter('upload_mimes', 'custom_upload_mimes');
add_action('widgets_init', 'unregister_default_widgets', 11);
add_action( 'manage_posts_custom_column' , 'custom_post_order_value' , 10 , 2 );
add_filter('manage_posts_columns' , 'add_custom_post_order_column');
add_action( 'save_post', 'save_custom_post_order' );
add_action( 'add_meta_boxes', 'customPostSort' );
add_filter('upload_mimes', 'svg_yukleme_func'); function svg_yukleme_func($mimes = array()) { $mimes['svg'] = 'image/svg+xml'; return $mimes; }

add_action( 'widgets_init', 'iyzicoMainLandingPageWidgetAreaInit' );
add_action( 'widgets_init', 'iyzicoIyziPosLandingPageWidgetAreaInit' );
add_action( 'widgets_init', 'iyzicoMarketplaceLandingPageWidgetAreaInit' );
add_action( 'widgets_init', 'iyzicoCrossborderLandingPageWidgetAreaInit' );
add_action( 'widgets_init', 'iyzicoLinkLandingPageWidgetAreaInit' );
add_action( 'widgets_init', 'iyzicoInternationalPageWidgetAreaInit' );
add_action( 'widgets_init', 'buyerProtectionLandingPageWidgetAreaInit' );
add_action( 'widgets_init', 'iyzicoEuropePageWidgetAreaInit' );
$mainHeadWidgetWithVideo = new MainLPHeadWidgetWithVideo();
$posHeadWidgetWithVideo = new PosLPHeadWidgetWithVideo();
$bazaarHeadWidgetWithVideo = new BazaarLPHeadWidgetWithVideo();
$linkHeadWidgetWithVideo = new LinkLPHeadWidgetWithVideo();
$buyerProtectionLPHeadWidgetWithVideo = new BuyerProtectionLPHeadWidgetWithVideo();

$MainPricingAndOfferWidget = new MainPricingAndOfferWidget();
$PosPricingAndOfferWidget = new PosPricingAndOfferWidget();
$BazaarPricingAndOfferWidget = new BazaarPricingAndOfferWidget();
$LinkPricingAndOfferWidget = new LinkPricingAndOfferWidget();

$MainWhyIyzicoWidget = new MainWhyIyzicoWidget();
$IntWhyIyzicoWidget = new IntWhyIyzicoWidget();
$BuyerProtectionWhyIyzicoWidget = new BuyerProtectionWhyIyzicoWidget();
$WhyBuyerProtectionWidget = new WhyBuyerProtectionWidget();

$MainIntegrationWidget = new MainIntegrationWidget();
$MainTestimonialsWidget = new MainTestimonialsWidget();

$PosFeatureListWidget = new PosFeatureListWidget();
$BazaarFeatureListWidget = new BazaarFeatureListWidget();
$CardFeatureListWidget = new CardFeatureListWidget();
$PartnerSolutionFeatureListWidget = new PartnerSolutionFeatureListWidget();
$LinkFeatureListWidget = new LinkFeatureListWidget();
$BuyerProtectionFeatureListWidget = new BuyerProtectionFeatureListWidget();
$CardFeatureListScreenWidget = new CardFeatureListScreenWidget();
$CardFeatureListScreenTwoWidget = new CardFeatureListScreenTwoWidget();
$CardPriceListWidget = new CardPriceListWidget();
$BuyerProtectionTrustSurveyBlogWidget = new BuyerProtectionTrustSurveyBlogWidget();
$BuyerProtectionReferencesWidget = new BuyerProtectionReferencesWidget();
$BuyerProtectionNewReferencesWidget = new BuyerProtectionNewReferencesWidget();
$BuyerProtectionShopsWidget = new BuyerProtectionShopsWidget();
$BuyerProtectionHowToWidget = new BuyerProtectionHowToWidget();

$PosMonitorAnywhereWidget = new PosMonitorAnywhereWidget();
$BazaarMonitorAnywhereWidget = new BazaarMonitorAnywhereWidget();
$LinkMonitorAnywhereWidget = new LinkMonitorAnywhereWidget();

$PosProcessWidget = new PosProcessWidget();
$BazaarProcessWidget = new BazaarProcessWidget();
$LinkProcessWidget = new LinkProcessWidget();

$PosIntegrationWithoutTabsWidget = new PosIntegrationWithoutTabsWidget();
$BazaarIntegrationWithoutTabsWidget = new BazaarIntegrationWithoutTabsWidget();

$MainReferenceLogosWidget = new MainReferenceLogosWidget();
$PosReferenceLogosWidget = new PosReferenceLogosWidget();
$BazaarReferenceLogosWidget = new BazaarReferenceLogosWidget();
$LinkReferenceLogosWidget = new LinkReferenceLogosWidget();

$MainProductsWidget = new MainProductsWidget();

$internationalPageHeadWidget = new InternationalPageHeadWidget();
$internationalPartnersWidget = new InternationalPartnersWidget();
$internationalMerchantLogosWidget = new InternationalMerchantLogosWidget();
$apmWidget = new APMWidget();

$LinkEtsyWidget = new LinkEtsyWidget();
$LinkVideosWidget = new LinkVideosWidget();
$LinkTestimonialsWidget = new LinkTestimonialsWidget();

$EuropeAPMWidget = new EuropeAPMWidget();
$EuropeFeatureListWidget = new EuropeFeatureListWidget();
$EuropeIntegrationWithoutTabsWidget = new EuropeIntegrationWithoutTabsWidget();
$EuropeLPHeadWidgetWithVideo = new EuropeLPHeadWidgetWithVideo();
$EuropeMonitorAnywhereWidget = new EuropeMonitorAnywhereWidget();
$EuropePricingAndOfferWidget = new EuropePricingAndOfferWidget();
$EuropeProcessWidget = new EuropeProcessWidget();
$EuropeReferenceLogosWidget = new EuropeReferenceLogosWidget();
$WhyiyziLinkWidget = new WhyiyziLinkWidget();
$BuyerProtectionSssWidget = new BuyerProtectionSssWidget();
add_action('widgets_init', array($EuropeAPMWidget,'load_widget'));
add_action('widgets_init', array($EuropeFeatureListWidget,'load_widget'));
add_action('widgets_init', array($EuropeIntegrationWithoutTabsWidget,'load_widget'));
add_action('widgets_init', array($EuropeLPHeadWidgetWithVideo,'load_widget'));
add_action('widgets_init', array($EuropeMonitorAnywhereWidget,'load_widget'));
add_action('widgets_init', array($EuropePricingAndOfferWidget,'load_widget'));
add_action('widgets_init', array($EuropeProcessWidget,'load_widget'));
add_action('widgets_init', array($EuropeReferenceLogosWidget,'load_widget'));

add_action('widgets_init', array($mainHeadWidgetWithVideo,'load_widget'));
add_action('widgets_init', array($posHeadWidgetWithVideo,'load_widget'));
add_action('widgets_init', array($bazaarHeadWidgetWithVideo,'load_widget'));
add_action('widgets_init', array($linkHeadWidgetWithVideo,'load_widget'));
add_action('widgets_init', array($buyerProtectionLPHeadWidgetWithVideo,'load_widget'));

add_action('widgets_init', array($MainPricingAndOfferWidget,'load_widget'));
add_action('widgets_init', array($PosPricingAndOfferWidget,'load_widget'));
add_action('widgets_init', array($BazaarPricingAndOfferWidget,'load_widget'));
add_action('widgets_init', array($LinkPricingAndOfferWidget,'load_widget'));

add_action('widgets_init', array($MainWhyIyzicoWidget,'load_widget'));
add_action('widgets_init', array($BuyerProtectionWhyIyzicoWidget,'load_widget'));
add_action('widgets_init', array($WhyBuyerProtectionWidget,'load_widget'));
add_action('widgets_init', array($IntWhyIyzicoWidget,'load_widget'));

add_action('widgets_init', array($MainIntegrationWidget,'load_widget'));
add_action('widgets_init', array($MainTestimonialsWidget,'load_widget'));

add_action('widgets_init', array($PosFeatureListWidget,'load_widget'));
add_action('widgets_init', array($CardFeatureListWidget,'load_widget'));
add_action('widgets_init', array($PartnerSolutionFeatureListWidget,'load_widget'));
add_action('widgets_init', array($BazaarFeatureListWidget,'load_widget'));
add_action('widgets_init', array($LinkFeatureListWidget,'load_widget'));
add_action('widgets_init', array($BuyerProtectionFeatureListWidget,'load_widget'));
add_action('widgets_init', array($CardFeatureListScreenWidget,'load_widget'));
add_action('widgets_init', array($CardFeatureListScreenTwoWidget,'load_widget'));
add_action('widgets_init', array($CardPriceListWidget,'load_widget'));
add_action('widgets_init', array($BuyerProtectionTrustSurveyBlogWidget,'load_widget'));
add_action('widgets_init', array($BuyerProtectionReferencesWidget,'load_widget'));
add_action('widgets_init', array($BuyerProtectionNewReferencesWidget,'load_widget'));
add_action('widgets_init', array($BuyerProtectionHowToWidget,'load_widget'));
add_action('widgets_init', array($BuyerProtectionShopsWidget,'load_widget'));

add_action('widgets_init', array($PosMonitorAnywhereWidget,'load_widget'));
add_action('widgets_init', array($BazaarMonitorAnywhereWidget,'load_widget'));
add_action('widgets_init', array($LinkMonitorAnywhereWidget,'load_widget'));

add_action('widgets_init', array($PosProcessWidget,'load_widget'));
add_action('widgets_init', array($BazaarProcessWidget,'load_widget'));
add_action('widgets_init', array($LinkProcessWidget,'load_widget'));

add_action('widgets_init', array($PosIntegrationWithoutTabsWidget,'load_widget'));
add_action('widgets_init', array($BazaarIntegrationWithoutTabsWidget,'load_widget'));

add_action('widgets_init', array($MainReferenceLogosWidget,'load_widget'));
add_action('widgets_init', array($PosReferenceLogosWidget,'load_widget'));
add_action('widgets_init', array($BazaarReferenceLogosWidget,'load_widget'));
add_action('widgets_init', array($LinkReferenceLogosWidget,'load_widget'));

add_action('widgets_init', array($MainProductsWidget,'load_widget'));

add_action('widgets_init', array($internationalPageHeadWidget,'load_widget'));
add_action('widgets_init', array($internationalPartnersWidget,'load_widget'));
add_action('widgets_init', array($internationalMerchantLogosWidget,'load_widget'));
add_action('widgets_init', array($apmWidget,'load_widget'));
add_action('widgets_init', array($LinkEtsyWidget,'load_widget'));
add_action('widgets_init', array($LinkVideosWidget,'load_widget'));
add_action('widgets_init', array($LinkTestimonialsWidget,'load_widget'));
add_action('widgets_init', array($WhyiyziLinkWidget,'load_widget'));
add_action('widgets_init', array($BuyerProtectionSssWidget,'load_widget'));

?>
