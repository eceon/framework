<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceLoader.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/DI/Loader
     */

    namespace Eceon\DI\Loader;
    
    use Eceon\DI\Container;
    
    interface InterfaceLoader
    {
        
        /**
         * Loads and process a file and build up the di container
         * 
         * @param Container $pContainer
         * @param string $pPath
         */        
        public function importFileIntoContainer( Container $pContainer, $pPath );
    }