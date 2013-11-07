<?php

/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys (dovy)
 * @author      Lee Mason (leemason)
 * @version     4.0.0
 */


/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Framework' ) ) {
    class Redux_Framework{
        
        public static $version = '1.0.0';
        
        public static $url = '';
        
        public static $dir = '';
        
        private $loader = array();
        
        protected static $instance = null;
        
        protected function __construct(){}
        protected function __clone(){}
    
        public static function get_instance(){
            if (!isset(static::$instance)) {
                static::$instance = new static;
                static::$instance->init();
            }
            return static::$instance;
        }
        
        public function init(){
            
            // Windows-proof constants: replace backward by forward slashes
            // Thanks to: @peterbouwmeester
            /** @noinspection PhpUndefinedFunctionInspection */
            $fslashed_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
            $fslashed_abs = trailingslashit( str_replace( '\\', '/', ABSPATH ) );
            // Fix for when Wordpress is not in the wp-content directory
            if (strpos($fslashed_dir,$fslashed_abs) === false) {
                $parts = explode('/', $fslashed_abs);
                $test = str_replace('/'.max($parts), '', $fslashed_abs);
                if (strpos($fslashed_dir,$test) !== false) {
                    $fslashed_abs = $test;
                }
            }

            static::$dir = $fslashed_dir;
            static::$url = site_url( str_replace( $fslashed_abs, '', $fslashed_dir ) );
            
            require( static::$dir . 'classes/class.redux-loader.php' );
            
            $this->loader['core'] = new Redux_loader( static::$dir . 'classes/' );
            
            //custom locations loaders
            $this->loader['field_templates'] = new Redux_loader( static::$dir . 'classes/field_templates/', 'field_templates' );
            $this->loader['sanitization'] = new Redux_loader( static::$dir . 'classes/sanitization/', 'sanitization' );
            $this->loader['validation'] = new Redux_loader( static::$dir . 'classes/validation/', 'validation' );
            
            add_action( 'wp_loaded', array( &$this, 'setup_textdomain' ) );
            
        }
        
        // shouldnt use plugin text domain as it may not be a plugin
        public function setup_textdomain(){
            load_textdomain( 'redux-framework', trailingslashit( WP_LANG_DIR ) . 'redux-framework/redux-framework-' . get_locale() . '.mo' );
            load_textdomain( 'redux-framework' , static::$dir . 'languages/redux-framework-' . get_locale() . '.mo' );
        }
        
        public static function parse_args( &$a, $b ) {
            $a = (array) $a;
            $b = (array) $b;
            $r = $b;
     
            foreach ( $a as $k => &$v ) {
                if ( is_array( $v ) && isset( $r[ $k ] ) ) {
                    $r[ $k ] = self::parse_args( $v, $r[ $k ] );
                } else {
                    $r[ $k ] = $v;
                }
            }
     
            return $r;
        }
        
        /**
         * converts an array into a html data string
         *
         * @param array $data example input: array('id'=>'true')
         * @return string $data_string example output: data-id='true'
         */
        public static function create_data_string($data = array()){
            $data_string = "";
            
            foreach($data as $key=>$value){
                if(is_array($value)) $value = implode("|",$value);
                $data_string .= " data-$key='$value' ";
            }
        
            return $data_string;
        }
        
        public static function compare_value( $value, $operator, $value2 ){
            
        }
        
    }
    
    //fire instance to setup args and autoloader
    Redux_Framework::get_instance();
}