<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: ServiceReference.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/DI
     */

    namespace Eceon\DI;
    
    class ServiceReference 
    {
        protected $strID = '';
        
        /**
         * Constructor, sets reference id of the service
         * 
         * @param string $pID
         */
        public function __construct( $pID )
        {
            $this->strID = strtolower( $pID );
        }
        
        /**
         * Gets the id
         * 
         * @return string
         */
        public function getID()
        {
            return $this->strID;
        }
    }