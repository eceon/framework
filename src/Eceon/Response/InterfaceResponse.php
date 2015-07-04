<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceResponse.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Response
     */

    namespace Eceon\Response;

    interface InterfaceResponse
    {
     
        /**
         * Sets the current response with the given value
         * 
         * @param string $pValue 
         */        
        public function setResponse( $pValue );
        
        /**
         * Prepend the given value to the current response
         * 
         * @param string $pValue 
         */
        public function prependResponse( $pValue );        
        
        /**
         * Append the given value to the current response
         * 
         * @param string $pValue 
         */
        public function appendResponse( $pValue );
                
        /**
         * Gets the response 
         * 
         * @return string 
         */
        public function getResponse();                
        
                
        /**
         * Sends the output to the client
         */
        public function sendResponse();
    }