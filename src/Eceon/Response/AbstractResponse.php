<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractResponse.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Response
     */

    namespace Eceon\Response;

    abstract class AbstractResponse implements InterfaceResponse
    {
        /**
         * @var string
         */
        protected $strResponse = '';
        
        
        /**
         * @var string
         */
        protected $strContentType = '';
        
        
        
        
        
        
        /**
         * Sets the current response with the given value
         * 
         * @param string $pValue 
         */
        public function setResponse( $pValue )
        {
            $this->strResponse = $pValue;
        }
        
        
        /**
         * Prepend the given value to the current response
         * 
         * @param string $pValue 
         */
        public function prependResponse( $pValue )
        {
            $this->strResponse = $pValue . $this->strResponse;
        }
        
        
        /**
         * Append the given value to the current response
         * 
         * @param string $pValue 
         */
        public function appendResponse( $pValue )
        {
            $this->strResponse = $this->strResponse . $pValue;
        }
        
        /**
         * Gets the response 
         * 
         * @return string 
         */
        public function getResponse()
        {
            return $this->strResponse;
        }
        
        
        
        
        /**
         * Sets the content type for the response
         * 
         * @param string $pValue 
         */
        public function setContentType( $pValue )
        {
            $this->strContentType = $pValue;
        }
        
        /**
         * Gets the content type for the response
         * 
         * @return string
         */
        public function getContentType()
        {
            return $this->strContentType;
        }
    }