<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Loader' ) ) {
    class Redux_Loader{
        
        public static $version = '1.0.0';
        
        private $path;
        
        // alias classes that dont conform
        private $aliases = array();
        
        public function __construct( $path = null, $instance = 'core', $filterable = true ){
        
            $this->path = $path;
            
            //used to allow use of the loader from other paths
            if( $filterable ){
                // filter aliases to allow overwritting
                $this->aliases = apply_filters( 'redux/loader/'.$instance.'/aliases', $this->aliases );
            }
            
            spl_autoload_register( array( &$this, 'loader' ) );
        
        }
        
        private function loader($class){
            
            //lets first load any classes which have been added via an alias above ( could be custom classes, or overridden ones )
            //use require without is_file check because if its aliased IT SHOULD EXIST!
            if( isset( $this->aliases[$class] ) ){
                require( $this->aliases[$class] );
                return;
            }
            
            //lets try some core files - might seem overkill, but as we add more it would be better.
            //real shame wordpress wont move to 5.3 as namespaces would really help here.
            $parts = explode( '_', $class );
            // not one of our classes
            if( count( $parts ) < 2 ){
                return;
            }
            
            //try to load file
            $file = $this->path . 'class.' . strtolower( implode( '-', $parts ) ) . '.php';
            if( is_file( $file ) ){
                require( $file );
                return;
            }
            
            //lets return
            return; 
        }
        
    }
}