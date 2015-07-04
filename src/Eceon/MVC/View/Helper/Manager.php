<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Manager.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/MVC/View/Helper
     */

    namespace Eceon\MVC\View\Helper;

    class Manager
    {
        /**
         * @var InterfaceHelper[] 
         */
        protected $arrHelper = array();
        
        
        /**
         * Adds a helper object to the manager
         * 
         * @param string $pName
         * @param InterfaceHelper $pHelper 
         */
        public function addHelper( $pName, InterfaceHelper $pHelper)
        {
            $this->arrHelper[$pName] = $pHelper;
        }
        
        
        /**
         * Gets the helper by name
         * 
         * @param string $pName
         * @return InterfaceHelper
         */
        public function getHelper( $pName )
        {
            if( isset( $this->arrHelper[$pName] ) )
            {
                return $this->arrHelper[$pName];
            }
            
            return null;
        }
        
 
    }