<?php
/**
 * Created by PhpStorm.
 * User: HarunAkgun
 * Date: 18.12.2014
 * Time: 11:10
 */

namespace Iyzico\Core;

use Iyzico\Library\Utils;

class Routing {

    function __construct($isAjax){
        $this->initRoutes($isAjax);
    }
    private function initRoutes($requestIsAjax = false){

        $toolbox = new Utils();
        $routes = $toolbox->getRoutes();

        foreach($routes as $slug=>$singleRoute) {

            $routeIsAjax = false;

            $singleRoute = (object)$singleRoute;
            $resolvedController = $toolbox->controllerParser($singleRoute->defaults['_controller']);
            if ( isset($singleRoute->defaults['_ajax']) && !is_null($singleRoute->defaults['_ajax'])) $routeIsAjax = true;

            if ($requestIsAjax) {
                if ( $routeIsAjax ) {

                    add_action(
                        'wp_ajax_' . $slug,
                        $resolvedController
                    );

                    add_action(
                        'wp_ajax_nopriv_' . $slug ,
                        $resolvedController
                    );

                }
            } else {

                if ( isset($singleRoute->menu_information) && $singleRoute->menu_information['_page_type'] == "page_without_menu") {
                    $buttonRank = NULL;
                    if ( isset($singleRoute->menu_information['_button_rank']) ) $buttonRank = $singleRoute->menu_information['_button_rank'];

                    add_submenu_page(
                        NULL,
                        $singleRoute->menu_information['_page_title'],
                        NULL,
                        $singleRoute->autorization,
                        $slug,
                        $resolvedController,
                        NULL,
                        $buttonRank
                    );
                } else if ( isset($singleRoute->menu_information['_parent_path']) && !is_null($singleRoute->menu_information['_parent_path'])) {
                    add_submenu_page(
                        $singleRoute->menu_information['_parent_path'],
                        $singleRoute->menu_information['_page_title'],
                        $singleRoute->menu_information['_menu_title'],
                        $singleRoute->autorization,
                        $slug,
                        $resolvedController,
                        NULL,
                        $singleRoute->menu_information['_button_rank']
                    );
                } else if ( !isset($singleRoute->menu_information['_parent_path']) && !isset($singleRoute->defaults['_ajax'])){
                    add_menu_page(
                        $singleRoute->menu_information['_page_title'],
                        $singleRoute->menu_information['_menu_title'],
                        $singleRoute->autorization,
                        $slug,
                        $resolvedController,
                        NULL,
                        $singleRoute->menu_information['_button_rank']
                    );
                }
            }
        }
    }
}