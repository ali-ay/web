<?php

namespace Iyzico\Core;

use Iyzico\Core\Routing as Router;

class Admin {
    private static $initiated = false;

    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    public static function init_hooks(){
        self::$initiated = true;
        self::ajaxListener();
        add_action( 'admin_menu', array( 'Iyzico\Core\Admin', 'adminMenuListener' ) );
    }

    public static function ajaxListener(){
        $router = new Router(true);
    }

    public static function adminMenuListener(){
        $router = new Router(false);
    }
}