<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Autoload.php 353 2015-06-01 13:34:48Z ted $
     * $package Eceon
     */

    namespace Eceon;

    class Autoload
    {
        protected $arrNamespace = array();
        

        public function __construct(){}
 
        /**
         * Register the autoloader to the queue
         */
        public function register()
        {
            spl_autoload_register(array($this, 'autoload'), true, true);
        }

        /**
         * Unregister the autoloader from the queue
         */
        public function unregister()
        {
            spl_autoload_unregister(array($this, 'autoload'));
        }
        
        
        public function addNamespace( $pPrefix, $pBasePath )
        {
            // remove trailing dash and append ending dash
            $prefix = trim( $pPrefix, '\\') . '\\';
            
            // replace dashes to directory separators and remove ending
            // directory separator
            $basePath = rtrim( str_replace( array( '\\', '/' ), DIRECTORY_SEPARATOR, $pBasePath ), DIRECTORY_SEPARATOR);

            // create prefix array
            if( isset( $this->arrNamespace[$prefix] ) === false )
            {
                $this->arrNamespace[$prefix] = array();
            }
            
            // add base path to namespace
            $this->arrNamespace[$prefix][] = $basePath;
        }
        
        
        /**
         * Auto loads the class
         * 
         * @param string $pClass
         */
        public function autoload( $pClass )
        {
            // the current namespace prefix
            $classNamespace = $pClass;

            // work backwards through the namespace names of the fully-qualified
            // class name to find a mapped file name
            while (false !== ( $pos = strrpos( $classNamespace, '\\' ) ) ) {

                // retain the trailing namespace separator in the prefix
                $classNamespace = substr($pClass, 0, $pos + 1);

                // the rest is the relative class name
                $className = substr($pClass, $pos + 1);
                
                // try to load a mapped file for the prefix and relative class
                if( false !== ($mappedFile = $this->loadMappedFile( $classNamespace, $className ) ) )
                {
                    return $mappedFile;
                }

                // remove the trailing namespace separator for the next iteration
                // of strrpos()
                $classNamespace = rtrim($classNamespace, '\\');   
            }

            // never found a mapped file
            return false;            
        }
        
        
        public function loadMappedFile( $pPrefix, $pClassName )
        {
            // are there any base directories for this namespace prefix?
            if( isset( $this->arrNamespace[$pPrefix] ) === false ) 
            {
                return false;
            }
            
            $classPath = str_replace( array( '\\', '/' ), DIRECTORY_SEPARATOR, $pClassName );
            
            // look through base directories for this namespace prefix
            foreach ( $this->arrNamespace[$pPrefix] as $basePath ) 
            {
                // create fulle path of base and class path
                $path = $basePath . DIRECTORY_SEPARATOR . $classPath . '.php';
            
                if( file_exists( $path ) === true )
                {
                    require_once $path;
                }
                
            }

            // never found it
            return false;            
        }
        
        
    }