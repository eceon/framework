<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Response.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Service/oAuth
     */

    namespace Eceon\Service\oAuth;

    class Response
    {
        protected $arrData = array();
        
        /**
         * Constructor
         * 
         * @param string $pData
         */
        public function __construct( $pData, $pJson = true ) 
        {
            if($pJson == true)
            {
                $this->arrData = json_decode( $pData, true );
            } else {
                parse_str( $pData, $this->arrData );
            }
        }
        
        /**
         * Magic function to get the returned data as stdClass, returns null if no data was found
         * 
         * @param string $pName
         * @return string
         */
        public function __get( $pName )
        {
            if( isset( $this->arrData[$pName] ) == true )
            {
                return $this->arrData[$pName];
            }
            
            return null;
        }        
        
        /**
         * Gets the array of data
         * 
         * @return array()
         */
        
        public function getData()
        {
            return $this->arrData;
        }
    }