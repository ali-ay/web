<?php
/**
 * Created by PhpStorm.
 * User: HarunAkgun
 * Date: 18.12.2014
 * Time: 14:12
 */

namespace Iyzico\Application\Services;
use Iyzico\Library\DatabaseTools;
use Iyzico\Library\Utils;

/**
 * Class DatabaseApi
 * @package Iyzico\Application\Services
 */
class RestServices {
    public static function get_api_namespace() {
        return 'wp/v2';
    }
    public static function get_plugin_namespace() {
        return 'iyzico/v1';
    }
    public function register_routes() {

        register_rest_route( self::get_plugin_namespace(), '/question-categories', array(
            array(
                'methods'  => \WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_question_categories' ),
            )
        ) );
        register_rest_route( self::get_plugin_namespace(), '/question-category/(?P<slug>[a-zA-Z0-9-]+)', array(
            array(
                'methods'  => \WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_questions_by_category_slug' ),
            )
        ) );
        register_rest_route( self::get_plugin_namespace(), '/question-search', array(
            array(
                'methods'  => \WP_REST_Server::CREATABLE,
                'callback' => array( $this, 'search_question' ),
            )
        ) );
        register_rest_route( self::get_plugin_namespace(), '/get-page-by-slug/(?P<slug>[a-zA-Z0-9-]+)', array(
            array(
                'methods'  => \WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_page_by_slug' ),
            )
        ) );
        register_rest_route( self::get_plugin_namespace(), '/get-translation', array(
            array(
                'methods'  => \WP_REST_Server::CREATABLE,
                'callback' => array( $this, 'get_translations' ),
            )
        ) );
    }
    public static function get_translations(\WP_REST_Request $request){


        $language = $request->get_param('lang');
        if ($language == null) $language = 'tr';

        $translations = array();
        $requestedStrings = $request->get_body_params();

        if (count($requestedStrings)>0 && function_exists ( 'icl_translate' )){
            foreach ($requestedStrings as $nameSpace=>$originalValue) {
                $nameSpace = explode('#',$nameSpace);
                $context = $nameSpace[0];
                $name = $nameSpace[1];
                if ($originalValue == "") {
                    $originalValue = false;
                }

                if (!isset($translations[$context])) {
                    $translations[$context] = array();
                }
                $translations[$context][$name] = icl_translate($context, $name, $originalValue);
            }
        }
        return $translations;
    }
    public static function get_page_by_slug(\WP_REST_Request $request){
        $language = $request->get_param('lang');
        if ($language == null) $language = 'tr';
        $query = $request->get_param('slug');
        $attributes = array(
            'post_name' => $query,
            'posts_per_page' => 1,
            'post_status' => 'publish'
        );
        $page = get_page_by_path($query);
        $pageID = null;
        if ($page) {
            $pageID = $page->ID;
            $pageID = icl_object_id($pageID, 'page', true, $language);
        }

        if ($pageID != $page->ID) {
            $page = get_post($pageID);
        }
        $jsonData = json_decode(do_shortcode($page->post_content));


        $pageMeta = get_post_meta($page->ID);
        $pageTitle = $pageMeta['_yoast_wpseo_title'][0];
        $pageDescription = $pageMeta['_yoast_wpseo_metadesc'][0];
        $focusKeyword = $pageMeta['_yoast_wpseo_focuskw'][0];
        $ogTitle = $pageMeta['_yoast_wpseo_opengraph-title'][0];
        $ogDescription = $pageMeta['_yoast_wpseo_opengraph-description'][0];
        $ogImage = $pageMeta['_yoast_wpseo_opengraph-image'][0];
        if ($pageTitle == "") $pageTitle = $page->post_title.' - '.get_bloginfo('name');

        $jsonData->seo = array(
            'title'=>$pageTitle,
            'description' => $pageDescription,
            'keyword' => $focusKeyword,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription,
            'ogImage' => $ogImage
        );

        return apply_filters( 'rest_questions_format_categories', $jsonData );

    }
    /**
     * @param \WP_REST_Request $request
     */
    public static function get_question_categories(\WP_REST_Request $request){
        $rest_url = trailingslashit( get_rest_url() . self::get_plugin_namespace() . '/question-categories/' );
        $databaseApi= new DatabaseApi();
        $language = $request->get_param('lang');
        if ($language == null) $language = 'tr';
        $order = array('orderBy'=>'parent,rank','order'=>'ASC');
        $allCategories = $databaseApi->getCategories(false,$order,false,true,$language);
        $categoryThree = array();
        $indexKeeper = array();
        foreach($allCategories['allCategories'] as $key=>$category){
            if ($category['Parent'] == 0) {
                $indexKeeper[$category['ID']] = count($categoryThree);
                array_push($categoryThree,$category);

            } else {
                if (!isset($categoryThree[$indexKeeper[$category['Parent']]]['children'])) {
                    $categoryThree[$indexKeeper[$category['Parent']]]['children'] = array();
                }
                array_push($categoryThree[$indexKeeper[$category['Parent']]]['children'],$category);
            }
        }
        return apply_filters( 'rest_questions_format_categories', $categoryThree );

    }
    /**
     * @param \WP_REST_Request $request
     */
    public static function get_questions_by_category_slug(\WP_REST_Request $request){
        $rest_url = trailingslashit( get_rest_url() . self::get_plugin_namespace() . '/question-category/(?P<slug>[a-zA-Z0-9-]+)' );
        $databaseApi= new DatabaseApi();
        $language = $request->get_param('lang');
        if ($language == null) $language = 'tr';
        $categorySlug = $request->get_param('slug');
        $categoryDetails = $databaseApi->getSingleCategoryDetailsBySlug($categorySlug);

        $categoryStructure = array();
        if ($categoryDetails) {
            if ($categoryDetails['Parent'] == 0) {
                $allSubCategories = $databaseApi->getAllSubCategoriesOfCategoryById($categoryDetails['ID']);
                foreach ($allSubCategories as $key=>$subCategory) {
                    $tempArrForCategory = array(
                        'ID'=>$subCategory['ID'],
                        'Parent'=>$subCategory['Parent'],
                        'Children'=>array()
                    );
                    $questions = $databaseApi->getQuestionsByCategoryId($subCategory['ID'],$language);
                    foreach($questions as $questionKey=>$question) {
                        array_push($tempArrForCategory['Children'],array(
                            'ID'=> $question['ID'],
                            'Question'=> str_replace('\\','',$question['Question']),
                            'Answer'=> str_replace('\\','',$question['Answer']),
                        ));
                    }
                    array_push($categoryStructure,$tempArrForCategory);
                }
            } else {
                $tempArrForCategory = array(
                    'ID'=>$categoryDetails['ID'],
                    'Parent'=>$categoryDetails['Parent'],
                    'Children'=>array()
                );
                $questions = $databaseApi->getQuestionsByCategoryId($categoryDetails['ID'],$language);
                foreach($questions as $questionKey=>$question) {
                    array_push($tempArrForCategory['Children'],array(
                        'ID'=> $question['ID'],
                        'Question'=> str_replace('\\','',$question['Question']),
                        'Answer'=> str_replace('\\','',$question['Answer']),
                    ));
                }
                array_push($categoryStructure,$tempArrForCategory);
            }
        }

        return apply_filters( 'rest_questions_format_questions', $categoryStructure );
    }
    /**
     * @param \WP_REST_Request $request
     */
    public static function search_question(\WP_REST_Request $request){
        $rest_url = trailingslashit( get_rest_url() . self::get_plugin_namespace() . '/question-search' );

        $databaseApi= new DatabaseApi();
        $utils = new Utils();

        $language = $request->get_param('lang');
        if ($language == null) $language = 'tr';
        $query = $request->get_param('query');

        $formattedResults = array();
        $explodedQuery = explode(' ',$query);
        $searchResult = $databaseApi->searchQuestion($explodedQuery,$language);
        if (count($searchResult) > 0) {
            foreach ($searchResult as $key=>$question) {
                $formattedResults[] = array(
                    'id'=>$question['ID'],
                    'categoryId'=>$question['CategoryId'],
                    'rootId'=>$question['RootCategoryId'],
                    'question'=>str_replace('\\','',$question['Question']),
                    'answer'=>str_replace('\\','',$question['Answer']),
                    'relevance'=>$question['relevance']
                );
            }
        }

        return apply_filters( 'rest_questions_format_questions', $formattedResults );
    }
    public static function question_sanitize(){
        $databaseApi= new DatabaseApi();
        $allQuestions = $databaseApi->getAllQuestions();
        $databaseTools = new DatabaseTools();
        $utils = new Utils();
        $update = "";
        foreach ($allQuestions as $key=>$question) {

            $staticPayload = array (
                "searchField" => $utils->slugify($question['Question'].$question['Answer'],array(),'')
            );
            $where = array (
                "ID" 		=> $question['ID'],
            );

            $baseUpdate = $databaseTools->updateData($staticPayload,'SupportQuestionTranslation',$where);
            $update .= '-- '.$baseUpdate;

        }
        die();
    }

}