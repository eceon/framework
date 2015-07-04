<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractRequest.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Request
     */

    namespace Eceon\Request;

    abstract class AbstractRequest implements InterfaceRequest
    {
        /**
         * @var array()
         */
        protected $arrParam = array();

        /**
         * @var string 
         */
        protected $strRequestType = '';
         
        /**
         * What does the request except as content type
         * 
         * @var string
         */
        protected $strAcceptContentType = '';

        
        
        /**
         * Adds a value to the parameters of the request object by key
         *
         * @param string $pKey
         * @param string $pValue
         * @return InterfaceRequest
         */
        public function setParam( $pKey, $pValue )
        {
            $this->arrParam[$pKey] = $pValue;

            return $this;
        }

        /**
         * Does this request object has the key parameter?
         *
         * @param string $pKey
         * @return boolean
         */
        public function hasParam( $pKey )
        {
            return isset( $this->arrParam[$pKey] );
        }

        /**
         * Gets a parameter value by key. Returns null or given 
         * default if key is not set
         *
         * @param string $pKey
         * @param string $pDefault [optional]
         * @return string
         */
        public function getParam( $pKey, $pDefault = null )
        {
            if( $this->hasParam( $pKey ) )
            {
                return $this->arrParam[$pKey];
            }

            return $pDefault;
       }        
       
       /**
        * Gets the request type 
        * 
        * @return string
        */
       public function getRequestType()
       {
           return $this->strRequestType;
       }
       
       /**
        * Gets the accept content type
        * 
        * @return string
        */
       public function getAcceptContentType()
       {
           return $this->strAcceptContentType;
       }
       
       
       
    }