<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceRequest.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Request
     */

    namespace Eceon\Request;

    interface InterfaceRequest
    {
        

        /**
         * Adds a value to the parameters of the request object by key
         *
         * @param string $pKey
         * @param string $pValue
         * @return InterfaceRequest
         */
        public function setParam( $pKey, $pValue );        
        
        /**
         * Does this request object has the key parameter?
         *
         * @param string $pKey
         * @return boolean
         */
        public function hasParam( $pKey );        
        
        /**
         * Gets a parameter value by key. Returns null or given 
         * default if key is not set
         *
         * @param string $pKey
         * @param string $pDefault [optional]
         * @return string|null
         */
        public function getParam( $pKey, $pDefault = null );        
        
        
        /**
         * Gets the request type: http, cli etc 
         */
        public function getRequestType();
        
        
        /**
         * Gets the accept content type 
         */
        public function getAcceptContentType();
    }