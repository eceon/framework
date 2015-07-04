<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Xml.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Config
     */

    namespace Eceon\Config;
    
    class Xml extends AbstractConfig
    {
        public function parseFile($pConfigFile) 
        {
            // open the config file
            // @todo: exception for not finding config file?
            $contents = simplexml_load_file( $pConfigFile );

            // loop through all lines of the config file
            foreach ( $contents as $key => $line )
            {
                print_r($key);
                print_r($line);
            }	            
        }
    }