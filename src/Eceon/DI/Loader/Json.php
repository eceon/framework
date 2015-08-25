<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: XML.php 354 2015-06-01 13:44:53Z ted $
     * $package Eceon/DI/Loader
     */

    namespace Eceon\DI\Loader;
    
    class Json implements InterfaceLoader
    {

        
        
        
        /**
         * Parses a file and gets the contents as an array
         * 
         * @param string $pPath
         * @return array
         */        
        public function parse( $pPath )
        {
            // return the data array
            return json_decode( file_get_contents( $pPath ), true );
        }
            
        
        
        /**
         * Retusn an array of supported extensions for this loader
         * 
         * @return array
         */
        public function getSupportedExtensions()
        {
            return array('json');
        }
 
        
    }