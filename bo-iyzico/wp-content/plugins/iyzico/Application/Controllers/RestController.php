<?php

namespace Iyzico\Application\Controllers;

use Iyzico\Library\DatabaseTools;
use Iyzico\Application\Services\DatabaseApi;
use Iyzico\Library\Utils;
use Iyzico\Application\Services\RestServices;

/**
 * Class RestController
 * @package Iyzico\Application\Controllers
 */
class RestController {

    public function registerRestMenusAction(){

        $class = new RestServices();
        add_filter( 'rest_api_init', array( $class, 'register_routes' ) );

    }
}