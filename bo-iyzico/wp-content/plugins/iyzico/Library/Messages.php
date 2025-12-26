<?php
namespace Iyzico\Library;

use \WP_Session;


class Messages {

    public $session;

    /**
     * Constructor
     */
    public function __construct() {
        $this->session = WP_Session::get_instance();
    }

    /**
     * Function to create and display error and success messages
     * @access public
     * @param string session name
     * @param string message
     * @param string display class
     * @return string message
     */
    function flash( $name = '', $message = '', $class = 'success fadeout-message' )
    {
        //We can only do something if the name isn't empty
        if( !empty( $name ) ) {
            //No message, create it
            if( !empty( $message ) && empty( $this->session[$name] ) ){
                if( !empty( $this->session[$name] ) ) {
                    unset( $this->session[$name] );
                }
                if( !empty( $this->session[$name.'_class'] ) ) {
                    unset( $this->session[$name.'_class'] );
                }

                $this->session[$name] = $message;
                $this->session[$name.'_class'] = $class;
            } elseif( !empty( $this->session[$name] ) && empty( $message ) ) {
                $class = !empty( $this->session[$name.'_class'] ) ? $this->session[$name.'_class'] : 'success';
                $response = $this->session[$name];
                unset($this->session[$name]);
                unset($this->session[$name.'_class']);
                return $response;
            }
        }
    }
} // end class
?>