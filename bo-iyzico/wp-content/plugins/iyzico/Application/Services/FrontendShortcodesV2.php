<?php
/**
 * Created by PhpStorm.
 * User: HarunAkgun
 * Date: 18.12.2014
 * Time: 14:12
 */

namespace Iyzico\Application\Services;

use Iyzico\Library\Utils;

/**
 * Class FrontendShortcodesV2
 * @package Iyzico\Application\Services
 */
class FrontendShortcodesV2 {
    public static function testimonialsJson($atts,$content="") {
        $contentObject = array(
                'logo'=>$atts['logo'],
                'subtext'=>$atts['subtext'],
                'content'=>trim(preg_replace('/\s\s+/', ' ', $content))
        );
        return json_encode($contentObject);
    }
    public static function headersJson($atts,$content="") {
        $contentString  = "[";
        $contentString .= do_shortcode($content);
        $contentString = rtrim($contentString, ',');
        return rtrim(trim(preg_replace('/\s\s+/', ' ', $contentString)),',')."]";
    }
    public static function singleHeaderJson($atts,$content="") {
        $images = rtrim(trim(preg_replace('/\s\s+/', ' ', do_shortcode($content))),',');
        $images = json_decode('['.$images.']');
        $contentObject = array(
            'class'=>$atts['class'],
            'title'=>$atts['title'],
            'colorTitle'=>$atts['colortitle'],
            'buttonOneText'=>$atts['buttononetext'],
            'buttonOneTitle'=>$atts['buttononetitle'],
            'buttonOneUrl'=>$atts['buttononeurl'],
            'buttonTwoText'=>$atts['buttontwotext'],
            'buttonTwoTitle'=>$atts['buttontwotitle'],
            'buttonTwoUrl'=>$atts['buttontwourl'],
            'subDesc'=>$atts['subdesc'],
            'subTwoDesc'=>$atts['subtwodesc'],
            'bgImage'=>$atts['bgimage'],
            'image'=>utils::generateMediaUrlObject($atts['image']),
            'imgalt'=>$atts['imgalt'],
            'content'=>trim(preg_replace('/\s\s+/', ' ', $content))
        );
        return json_encode($contentObject).',';
    }
    public static function featuresJson($atts,$content=""){
        $contentString  = "[";
        $contentString .= do_shortcode($content);
        $contentString = rtrim($contentString, ',');
        return rtrim(trim(preg_replace('/\s\s+/', ' ', $contentString)),',')."]";
    }
    public static function singleFeatureJson($atts,$content="") {
        $contentObject = array(
            'class'=>$atts['class'],
            'title'=>$atts['title'],
            'colorTitle'=>$atts['colortitle'],
            'content'=>$atts['content'],
            'buttonText'=>$atts['buttontext'],
            'buttonUrl'=>$atts['buttonurl'],
            'image'=>utils::generateMediaUrlObject($atts['image']),
            'content'=>trim(preg_replace('/\s\s+/', ' ', $content))
        );
        return json_encode($contentObject).',';
    }
    public static function socialGroupJson($atts,$content=""){
        $contentString  = "[";
        $contentString .= do_shortcode($content);
        $contentString = rtrim($contentString, ',');
        return rtrim(trim(preg_replace('/\s\s+/', ' ', $contentString)),',')."]";
    }
    public static function singlesocialGroupJson($atts,$content="") {
        $images = rtrim(trim(preg_replace('/\s\s+/', ' ', do_shortcode($content))),',');
        $images = json_decode('['.$images.']');
        $contentObject = array(
            'title'=>$atts['title'],
            'titleTwo'=>$atts['titletwo'],
            'content'=>$atts['content'],
            'buttonText'=>$atts['buttontext'],
            'buttonUrl'=>$atts['buttonurl'],
            'videoUrl'=>$atts['videourl'],
            'socialStatus'=>$atts['socialstatus'],
            'logo'=>utils::generateMediaUrlObject($atts['logo']),
            'image'=>utils::generateMediaUrlObject($atts['image'])
        );
        return json_encode($contentObject,JSON_UNESCAPED_SLASHES).',';
    }
    public static function processesJson($atts,$content=""){

        $contentString  = "{\"title\":\"".$atts['title']."\", \"subTitle\":\"".$atts['subtitle']."\",\"list\":[";
        $contentString .= do_shortcode($content);
        $contentString = rtrim($contentString, ',');
        return rtrim(trim(preg_replace('/\s\s+/', ' ', $contentString)),',')."]}";
    }
    public static function singleProcessJson($atts,$content="") {
        $contentObject = array(
            'class'=>$atts['class'],
            'image'=>utils::generateMediaUrlObject($atts['image']),
            'title'=>$atts['title']
        );
        return json_encode($contentObject).',';
    }
    public static function downloadkitJson($atts,$content=""){
        $contentString  = "[";
        $contentString .= do_shortcode($content);
        $contentString = rtrim($contentString, ',');
        return rtrim(trim(preg_replace('/\s\s+/', ' ', $contentString)),',')."]";

    }
    public static function singleDownloadkitJson($atts,$content="") {
        $images = rtrim(trim(preg_replace('/\s\s+/', ' ', do_shortcode($content))),',');
        $images = json_decode('['.$images.']');
        $contentObject = array(
            'title'=>$atts['title'],
            'content'=>$atts['content'],
            'buttonText'=>$atts['buttontext'],
            'buttonUrl'=>$atts['buttonurl'],
            'logos'=>$images
        );
        return json_encode($contentObject,JSON_UNESCAPED_SLASHES).',';
    }
    public static function integrationsJson($atts,$content=""){
        $contentString  = "[";
        $contentString .= do_shortcode($content);
        $contentString = rtrim($contentString, ',');
        return rtrim(trim(preg_replace('/\s\s+/', ' ', $contentString)),',')."]";

    }
    public static function singleIntegrationJson($atts,$content="") {
        $images = rtrim(trim(preg_replace('/\s\s+/', ' ', do_shortcode($content))),',');
        $images = json_decode('['.$images.']');
        $contentObject = array(
            'title'=>$atts['title'],
            'colorTitle'=>$atts['colortitle'],
            'content'=>$atts['content'],
            'buttonText'=>$atts['buttontext'],
            'buttonUrl'=>$atts['buttonurl'],
            'categoryIcon'=>utils::generateMediaUrlObject($atts['image']),
            'logos'=>$images
        );
        return json_encode($contentObject,JSON_UNESCAPED_SLASHES).',';
    }

    public static function buyerSssJson($atts,$content=""){
        $contentString  = "[";
        $contentString .= do_shortcode($content);
        $contentString = rtrim($contentString, ',');
        return rtrim(trim(preg_replace('/\s\s+/', ' ', $contentString)),',')."]";
    }
    public static function singleBuyerSssJson($atts,$content="") {
        $contentObject = array(
            'title'=>$atts['title'],
            'content'=>$content,
        );
        return json_encode($contentObject,JSON_UNESCAPED_SLASHES).',';
    }

    public static function linkJson($atts,$content="") {
        $contentObject = array(
            'url'=>$atts['url'],
            'alt'=>$atts['alt'],
            'title'=>$atts['title'],
            'desktopimg'=>utils::generateMediaUrlObject($atts['desktopimg']),
            'desktopimgalt'=>'desktopimgalt',
            'mobileimg'=>utils::generateMediaUrlObject($atts['mobileimg']),
            'mobileimgalt'=>'mobileimgalt',
            'content'=>$atts['content'],
            'appdownload'=>$atts['appdownload'],
            'buttononetext'=>$atts['buttononetext'],
            'buttononeurl'=>$atts['buttononeurl'],
            'buttononeclass'=>$atts['buttononeclass'],
            'buttontwotext'=>$atts['buttontwotext'],
            'buttontwourl'=>$atts['buttontwourl'],
            'buttontwoclass'=>$atts['buttontwoclass'],
            'class'=>$atts['class'],
            'id'=>$atts['id'],
            'buttontext'=>$atts['buttontext'],
            'logo'=>utils::generateMediaUrlObject($atts['logo']),
            'image'=>utils::generateMediaUrlObject($atts['image']),
        );
        return json_encode($contentObject,JSON_UNESCAPED_SLASHES).',';
    }
    public static function boxJson($atts,$content="") {
        $contentObject = array(
            'image'=>utils::generateMediaUrlObject($atts['image']),
            'titlename'=>$atts['titlename'],
            'classname'=>$atts['classname'],
            'desc'=>$atts['desc'],
            'buttontext'=>$atts['buttontext'],
            'url'=>$atts['url'],

        );
        return json_encode($contentObject,JSON_UNESCAPED_SLASHES).',';
    }
    public static function pageJson($atts,$content="") {
        $string = '{ "menuSlug":"'.$atts['slug'].'", "contents":{';
        $string .= do_shortcode($content);
        $string .= '}}';
        return rtrim(trim(preg_replace('/\s\s+/', ' ',$string)));

    }
    public static function textSectionJson($atts,$content="") {
        $string = '"textSection":{ "title":"'.$atts['title'].'", "subTitle":"'.$atts['subtitle'].'","contents":{';
        $string .= do_shortcode($content);
        $string .= '}},';
        return $string;
    }
    public static function textSectionThreeColumnJson($atts,$content="") {
        $string = '"textSectionThreeColumn":{ "title":"'.$atts['title'].'", "subTitle":"'.$atts['subtitle'].'","contents":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ', do_shortcode($content))),',');
        if (isset($atts['incenter'])){
            $string .= ']},';
        } else {
            $string .= ']}';
        }
        return $string;
    }
    public static function textSectionTwoColumnJson($atts,$content="") {
        $string = '"textSectionTwoColumn":{ "title":"'.$atts['title'].'", "subTitle":"'.$atts['subtitle'].'","contents":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ', do_shortcode($content))),',');
        if (isset($atts['incenter'])){
            $string .= ']},';
        } else {
            $string .= ']}';
        }
        return $string;
    }
    public static function textSectionWithButtonJson($atts,$content="") {
        $string = '"textSectionWithButton":{ "title":"'.$atts['title'].'", "subTitle":"'.$atts['subtitle'].'","buttonText":"'.$atts['buttontext'].'","buttonUrl":"'.$atts['buttonurl'].'","contents":[';
        $string .= do_shortcode($content);
        if (isset($atts['incenter'])) {
            $string .= ']},';
        } else {
            $string .= ']}';
        }
        return $string;
    }
    public static function leftContentJson($atts,$content="") {
        $string = '"left":"'.$content.'",';
        return $string;
    }
    public static function rightContentJson($atts,$content="") {
        $string = '"right":"'.$content.'"';
        return $string;
    }
    public static function randomTeamMemberJson($atts,$content="") {
        $utils = new Utils();
        $categorySlug = "team-member-with-quote";
        if (ICL_LANGUAGE_CODE == "en") $categorySlug = "team-member-with-quote-en";

        $args = array(
            'posts_per_page'   => 10,
            'offset'           => 0,
            'category_name'    => $categorySlug,
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = get_posts( $args );

        $teamMembers = array();
        foreach ($posts_array as $key=>$post) {
            array_push($teamMembers,array(
                'name'=>$post->post_title,
                'content'=>$post->post_content,
                'image'=>$utils->generateMediaUrlObject(wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full')[0])
            ));
        }

        $string = '"randomTeamMember":{ "buttonText":"'.$atts['buttontext'].'", "teamMembers":'.json_encode($teamMembers).'},';
        return $string;
    }
    public static function boardMembersJson($atts,$content="") {
        $utils = new Utils();
        $categorySlug = "board-members";

        $args = array(
            'posts_per_page'   => 10,
            'offset'           => 0,
            'category_name'    => $categorySlug,
            'orderby'          => 'meta_value',
            'order'            => 'ASC',
            'meta_key'         => '_custom_post_order',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = get_posts( $args );

        $boardMembers = array();
        foreach ($posts_array as $key=>$post) {
            $socials = json_decode(do_shortcode($post->post_content));
            array_push($boardMembers,array(
                'name'=>$post->post_title,
                'twitter'=>$socials->twitter,
                'linkedin'=>$socials->linkedin,
                'image'=>$utils->generateMediaUrlObject(wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full')[0])
            ));
        }
        $string = '"boardMembers":{ "title":"'.$atts['title'].'", "subTitle":"'.$atts['subtitle'].'", "boardMembers":'.json_encode($boardMembers).'},';
        return $string;
    }
    public static function investorsJson($atts,$content="") {
        $utils = new Utils();
        $categorySlug = "investors";

        $args = array(
            'posts_per_page'   => 10,
            'offset'           => 0,
            'category_name'    => $categorySlug,
            'orderby'          => 'meta_value',
            'order'            => 'ASC',
            'meta_key'         => '_custom_post_order',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = get_posts( $args );

        $investors = array();
        foreach ($posts_array as $key=>$post) {
            array_push($investors,array(
                'name'=>$post->post_title,
                'image'=>$utils->generateMediaUrlObject(wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full')[0]),
                'link'=>$post->post_content
            ));
        }
        $string = '"investors":{ "title":"'.$atts['title'].'", "subTitle":"'.$atts['subtitle'].'","investors":'.json_encode($investors).'},';
        return $string;
    }
    public static function certificatesJson($atts,$content="") {
        $string = '"certificates":{ "title":"'.$atts['title'].'", "subTitle":"'.$atts['subtitle'].'","contents":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= ']}';

        return $string;
    }
    public static function singleCertificateJson($atts,$content="") {
        $utils = new Utils();
        $imageArr = $utils->generateMediaUrlObject($atts['image']);
        $certificateFileUrlArr = $utils->generateMediaUrlObject($atts['buttonurl']);
        $string = '{"title":"'.$atts['title'].'", "subTitle":"'.$atts['subtitle'].'", "buttonText":"'.$atts['buttontext'].'", "buttonUrl":'.json_encode($certificateFileUrlArr).', "image":'.json_encode($imageArr).'},';
        return $string;
    }
    public static function boardMemberSocialsJson($atts,$content="") {
        return json_encode(array(
            'linkedin'=>$atts['linkedin'],
            'twitter'=>$atts['twitter']
        ));
    }
    public static function teamMembersJson($atts,$content="") {

        $string = '"teamMembers":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= ']';
        return $string;
    }
    public static function singleTeamMemberJson($atts,$content="") {
        $utils = new Utils();
        return json_encode(array(
            'name'=>$atts['name'],
            'surname'=>$atts['surname'],
            'team'=>$atts['team'],
            'image'=>$utils->generateMediaUrlObject($atts['image'])
        )).',';
    }
    public static function personalLPJson($atts,$content=""){
        $string = '"components":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= ']';
        return $string;
    }
    public static function singlePersonalLPJson($atts,$content="") {
        $utils = new Utils();
        return json_encode(array(
            'type'=>$atts['type'],
            'name'=>$atts['name'],

        )).',';
    }
    public static function culturePhotosJson($atts,$content="") {

        $string = '"culturePhotos":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= '],';
        return $string;
    }
    public static function singleCulturePhotoJson($atts,$content="") {
        $utils = new Utils();
        return json_encode(array(
            'image'=>$utils->generateMediaUrlObject($atts['image'])
        )).',';
    }
    public static function referencesJson($atts,$content="") {

        $string = '"references":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= ']';
        return $string;
    }
    public static function singleReferenceJson($atts,$content="") {
        $utils = new Utils();
        if ($content == "") {
            if (isset($atts['videomp4'])) {
                return json_encode(array(
                        'personName'=>$atts['personname'],
                        'logo'=>$utils->generateMediaUrlObject($atts['logo']),
                        'portrait'=>$utils->generateMediaUrlObject($atts['portrait']),
                        'videowebm'=>$utils->generateMediaUrlObject($atts['videowebm']),
                        'videomp4'=>$utils->generateMediaUrlObject($atts['videomp4']),
                    )).',';
            } else {
                return json_encode(array(
                        'logo'=>$utils->generateMediaUrlObject($atts['logo'])
                    )).',';
            }
        } else {
            return json_encode(array(
                    'personName'=>$atts['personname'],
                    'logo'=>$utils->generateMediaUrlObject($atts['logo']),
                    'portrait'=>$utils->generateMediaUrlObject($atts['portrait']),
                    'content'=>trim($content)
                )).',';
        }

    }

    public static function pressCenterJson($atts,$content="") {

        $string = '"pressCenter":{"title":"'.$atts['title'].'","subtitle":"'.$atts['subtitle'].'","items":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= ']},';
        return $string;
    }
    public static function pressCenterItemJson($atts,$content="") {
        $utils = new Utils();

            return json_encode(array(
                    'title'=>$atts['title'],
                    'date'=>$atts['date'],
                    'tag'=>$atts['tag'],
                    'buttonLink'=>$atts['buttonlink'],
                    'link'=>$utils->generateMediaUrlObject($atts['link']),
                    'content'=>trim($content)
            )).',';
    }
    public static function onPressJson($atts,$content="") {

        $string = '"onPress":{"title":"'.$atts['title'].'","subtitle":"'.$atts['subtitle'].'","items":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= ']}';
        return $string;
    }
    public static function onPressItemJson($atts,$content="") {
        $utils = new Utils();

        return json_encode(array(
                'url'=>$atts['url'],
                'logo'=>$utils->generateMediaUrlObject($atts['logo']),
                'image'=>$utils->generateMediaUrlObject($atts['image']),
                'content'=>trim($content)
            )).',';
    }
    public static function getOpenPositionsJson($atts,$content=""){
        $args = array(
            'posts_per_page'   => 50,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => 'open positions',
            'orderby'          => 'date',
            'order'            => 'ASC',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = get_posts( $args );
        $string = '"positions":';
        $positions= array();
        foreach($posts_array as $position) {
            $linkedinUrl = false;
            $post_content = $position->post_content;
            $post_content = explode('--details--', $post_content);
            $summary = trim($post_content[0]);
            $linkedinUrlRaw = explode('linkedin:',$position->post_content);
            if (count($linkedinUrlRaw)>1) $linkedinUrl = $linkedinUrlRaw[1];
            if (strlen($summary) > 185) {
                $summary = substr($summary, 0,185).'...';
            }
            $summary = str_replace('<br>','',$summary);
            $summary = str_replace('<br','',$summary);
            array_push($positions,array(
               'title'=> $position->post_title,
                'summary'=> $summary,
                'linkedinUrl'=>$linkedinUrl,
                'id'=>$position->ID
            ));
        }
        $string .= json_encode($positions);
        $string .= ',';
        return $string;
    }
    public static function getCaseStudiesJson($atts,$content="") {
        $utils = new Utils();
        $categorySlug = "case-studies";
        $args = array(
            'posts_per_page'   => 50,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => $categorySlug,
            'orderby'          => 'meta_value',
            'order'            => 'ASC',
            'meta_key'         => '_custom_post_order',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = get_posts( $args );
        $studies = array();
        foreach ($posts_array as $key=>$post) {
            array_push($studies,array(
                'summary'=>$post->post_title,
                'image'=>$utils->generateMediaUrlObject(wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full')[0]),
                'link'=>$utils->generateMediaUrlObject($post->post_content),
            ));
        }
        $string = '"caseStudies":'.json_encode($studies).'';
        return $string;
    }
    public static function partnersJson($atts,$content="") {

        $string = '"partners":{ "title":"'.$atts['title'].'","subTitle":"'.$atts['subtitle'].'","buttonText":"'.$atts['buttontext'].'","buttonUrl":"'.$atts['buttonurl'].'","list":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= ']}';
        return $string;
    }
    public static function partner($atts,$content="") {
        $utils = new Utils();
        return json_encode(array(
            'image'=>$utils->generateMediaUrlObject($atts['image']),
            'sliderdesktopimage'=>$utils->generateMediaUrlObject($atts['sliderdesktopimage']),
            'sliderbgcolor'=>$atts['sliderbgcolor'],
            'content'=>$content,
            'title'=>$atts['title'],
            'link'=>$atts['link'],
            'endDate'=>$atts['enddate'],
            'campaignStatus'=>$atts['campaignstatus'],
            'linkTitle'=>$atts['linktitle']
        )).',';

    }
    public static function textColumnJson($atts,$content="") {
        $contentObject = array(
            'image'=>utils::generateMediaUrlObject($atts['image']),
            'title'=>$atts['title'],
            'subTitle'=>$atts['subtitle'],
            'content'=>$content
        );
        return json_encode($contentObject,JSON_UNESCAPED_SLASHES).',';
    }
    public static function videoColumnJson($atts,$content="") {
        $contentObject = array(
            'videowebm'=>utils::generateMediaUrlObject($atts['videowebm']),
            'videomp4'=>utils::generateMediaUrlObject($atts['videomp4']),
            'title'=>$atts['title'],
            'content'=>$content
        );
        return json_encode($contentObject,JSON_UNESCAPED_SLASHES).',';
    }
    public static function addressSectionJson($atts,$content="") {
        $string = '"addressSection":{ "title":"'.$atts['title'].'", "subTitle":"'.$atts['subtitle'].'","location":"'.$atts['location'].'","workhours":"'.$atts['workhours'].'","contents":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ', do_shortcode($content))),',');
        if (isset($atts['incenter'])){
            $string .= ']},';
        } else {
            $string .= ']}';
        }
        return $string;
    }
    public static function branchJson($atts,$content="") {
        $contentObject = array(
            'title'=>$atts['title'],
            'subTitle'=>$atts['subtitle'],
            'address'=>$atts['address'],
            'tel'=>$atts['tel'],
            'email'=>$atts['email'],
            'content'=>$content
        );
        return json_encode($contentObject,JSON_UNESCAPED_SLASHES).',';
    }

    public static function termsJson($atts,$content="") {
        $string = '"terms":{ "title":"'.$atts['title'].'","ptitle":"'.$atts['ptitle'].'","desc":"'.$atts['desc'].'","list":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= ']}';
        return $string;
    }
    public static function singleTermJson($atts,$content="") {
        return json_encode(array(
                'title'=>$atts['title'],
                'url'=>$atts['url'],
                'content'=>$content
            )).',';
    }

    public static function interviewsJson($atts,$content="") {
        $string = '"interviews":{ "title":"'.$atts['title'].'","list":[';
        $string .= rtrim(trim(preg_replace('/\s\s+/', ' ',do_shortcode($content))),',');
        $string .= ']},';
        return $string;
    }
    public static function singleInterviewJson($atts,$content="") {
        return json_encode(array(
                'title'=>$atts['title'],
                'videoId'=>$atts['videoid']
            )).',';
    }
}
