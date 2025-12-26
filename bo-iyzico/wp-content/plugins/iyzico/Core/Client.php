<?php

namespace Iyzico\Core;

use Iyzico\Core\Routing as Router;

class Client {
    private static $initiated = false;

    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    public static function init_hooks(){

        self::$initiated = true;

        add_shortcode('testimonial',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'testimonialsJson' ));
        add_shortcode('headers',                     array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'headersJson' ));
        add_shortcode('header',                    array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleHeaderJson' ));
        add_shortcode('features',                   array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'featuresJson' ));
        add_shortcode('feature',                    array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleFeatureJson' ));
        add_shortcode('process_group',              array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'processesJson' ));
        add_shortcode('process',                    array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleProcessJson' ));
        add_shortcode('downloadkit_group',          array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'downloadkitJson' ));
        add_shortcode('downloadKit',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleDownloadkitJson' ));
        add_shortcode('social_group',               array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'socialGroupJson' ));
        add_shortcode('social',                     array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singlesocialGroupJson' ));
        add_shortcode('integration_choices',        array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'integrationsJson' ));
        add_shortcode('integration',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleIntegrationJson' ));
        add_shortcode('link',                       array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'linkJson' ));
        add_shortcode('box',                        array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'boxJson' ));

        add_shortcode('sss_choices',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'buyerSssJson' ));
        add_shortcode('sss',                        array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleBuyerSssJson' ));

        add_shortcode('page',                       array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'pageJson' ));
        add_shortcode('textSection',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'textSectionJson' ));
        add_shortcode('textSectionThreeColumn',     array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'textSectionThreeColumnJson' ));
        add_shortcode('textSectionTwoColumn',       array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'textSectionTwoColumnJson' ));
        add_shortcode('leftContent',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'leftContentJson' ));
        add_shortcode('rightContent',               array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'rightContentJson' ));
        add_shortcode('textColumn',                 array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'textColumnJson' ));
        add_shortcode('videoColumn',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'videoColumnJson' ));

        add_shortcode('randomTeamMember',           array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'randomTeamMemberJson' ));
        add_shortcode('boardMembers',               array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'boardMembersJson' ));
        add_shortcode('investors',                  array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'investorsJson' ));
        add_shortcode('certificates',               array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'certificatesJson' ));
        add_shortcode('certificate',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleCertificateJson' ));
        add_shortcode('boardMemberSocials',         array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'boardMemberSocialsJson' ));
        add_shortcode('teamMembers',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'teamMembersJson' ));
        add_shortcode('teamMember',                 array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleTeamMemberJson' ));
        add_shortcode('components',                 array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'personalLPJson' ));
        add_shortcode('component',                  array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singlePersonalLPJson' ));


        add_shortcode('references',                 array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'referencesJson' ));
        add_shortcode('reference',                  array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleReferenceJson' ));

        add_shortcode('pressCenter',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'pressCenterJson' ));
        add_shortcode('pressCenterItem',            array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'pressCenterItemJson' ));

        add_shortcode('onPress',                    array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'onPressJson' ));
        add_shortcode('onPressItem',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'onPressItemJson' ));

        add_shortcode('getOpenPositionsJson',       array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'getOpenPositionsJson' ));
        add_shortcode('textSectionWithButton',      array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'textSectionWithButtonJson' ));
        add_shortcode('getCaseStudiesJson',         array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'getCaseStudiesJson' ));

        add_shortcode('partnerList',                array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'partnersJson' ));
        add_shortcode('partner',                    array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'partner' ));

        add_shortcode('addressSection',             array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'addressSectionJson' ));
        add_shortcode('branch',                     array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'branchJson' ));

        add_shortcode('terms',                      array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'termsJson' ));
        add_shortcode('termsSection',               array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleTermJson' ));

        add_shortcode('interviews',                 array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'interviewsJson' ));
        add_shortcode('interview',                  array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleInterviewJson' ));

        add_shortcode('culturePhotos',              array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'culturePhotosJson' ));
        add_shortcode('culturePhoto',               array( 'Iyzico\Application\Services\FrontendShortcodesV2', 'singleCulturePhotoJson' ));

        self::ajaxListener();

    }

    public static function ajaxListener(){
        $router = new Router(true);
    }

}
