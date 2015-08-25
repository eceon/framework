<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * $package Eceon/DI/Loader
     */

    namespace Eceon\DI\Loader;

    
    interface InterfaceLoader
    {
        
        /**
         * Parses a file and gets the contents as an array
         * 
         * @param string $pPath
         * @return array
         */        
        public function parse( $pPath );
        
                
    }