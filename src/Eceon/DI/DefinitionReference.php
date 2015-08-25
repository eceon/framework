<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * $package Eceon/DI
     */

    namespace Eceon\DI;
    
    class DefinitionReference 
    {
        protected $strID = '';
        
        /**
         * Constructor, sets reference id of the definition
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