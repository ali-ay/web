<?php
/**
 * Created by PhpStorm.
 * User: HarunAkgun
 * Date: 18.12.2014
 * Time: 13:48
 */

namespace Iyzico\Application\Controllers;

use Iyzico\Library\DatabaseTools;
use Iyzico\Library\Utils;
use \WP_Session;

/**
 * Class SettingsController
 * @package Iyzico\Application\Controllers
 */
class SettingsController {
    public static function activatePlugin(){
        $tools = new Utils();
        $configurations = $tools->getConfigurations();
        $databaseCredentials = $configurations['application']['mysql'];
        $databaseTools = new DatabaseTools();
        $databaseTools->setConnectionDetails($databaseCredentials);
        $databaseTools->createTables();
    }
    public static function changeLanguageAction(){
        if ( $_POST['language'] ) {
            $wp_session = WP_Session::get_instance();
            $wp_session['language'] = $_POST['language'];

            Utils::renderJson(
                array(
                    "success" 	=> "true",
                    "message" 	=> "Language changed to "+$_POST['language']+"."
                )
            );
        } else {
            Utils::renderJson(
                array(
                    "success" 	=> "false",
                    "error" 	=> "No language posted."
                )
            );
        }
    }
    public static function generalAction()
    {
        Utils::renderView(array());
    }
}