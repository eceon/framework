<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Manager.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/MVC/Controller/Helper
     */

    namespace Eceon\MVC\Controller\Helper;

    class Manager 
    {
        protected $arrHelpers = array();
        
        
        /**
         * 
         * Adds a helper to the manager
         * 
         * @param string $pName
         * @param InterfaceHelper $pHelper
         */
        public function addHelper( $pName, InterfaceHelper $pHelper )
        {
            $this->arrHelpers[$pName] = $pHelper;
        }
        
        /**
         * Gets the helper
         * 
         * @param string $pName
         * @return InterfaceHelper
         */
        public function getHelper( $pName )
        {
            if( isset( $this->arrHelpers[$pName] ) == true )
            {
                return $this->arrHelpers[$pName];
            }
            
            // @todo: throw exception
            return null;
        }
        
    }