<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: HTTP.php 234 2015-02-17 10:03:04Z ted $
     * $package Eceon/Response
     */

    namespace Eceon\Response;

    class HTTP extends AbstractResponse
    {
        /**
         * @var string
         */
        protected $strContentType = 'html';

        /**
         * @var string
         */
        protected $strEncoding = 'utf-8';
        
        /**
         * @var int 
         */
        protected $intStatus = 200;

        /**
         * @var array
         */
        protected $arrHeader = array();
        
        /**
         * @var boolean
         */
        protected $boolOutputSend = false;
        
        
        
        
        /**
         * Sets the encoding 
         * 
         * @param string $pValue 
         */
        public function setEncoding( $pValue )
        {
            $this->strEncoding = $pValue;
        }

        /**
         * Gets the encoding 
         * 
         * @return string
         */
        public function getEncoding()
        {
            return $this->strEncoding;
        }
        
        
        /**
         * Sets the HTTP status 
         * 
         * @param int $pValue 
         */
        public function setStatus( $pValue )
        {
            $this->intStatus = $pValue;
        }
        
        /**
         * Gets the HTTP status
         * 
         * @return int 
         */
        public function getStatus()
        {
            return $this->intStatus;
        }
        
        
        
        /**
         * Adds a header value to the response
         * 
         * @param string $pName
         * @param string $pValue
         * @param boolean $pOverwrite 
         */
        public function addHeader( $pName, $pValue, $pOverwrite = true )
        {
            if( $pOverwrite == false && $this->hasHeader( $pName ) )
            {
                return;
            }
            
            $this->arrHeader[$pName] = $pValue;
        }
        
        /**
         * Checks if a header value is set
         * 
         * @param string $pName
         * @return boolean 
         */
        public function hasHeader( $pName )
        {
            return isset( $this->arrHeader[$pName] );
        }
        
        /**
         * Gets a header value, returns null if header is nog set
         * 
         * @param string $pName
         * @return string|null 
         */
        public function getHeader( $pName )
        {
            if( $this->hasHeader( $pName ) )
            {
                return $this->arrHeader[$pName];
            }
            
            return null;
        }
        
        
        
        /**
         * Sends the repsonse to the clients browser
         * 
         */
        public function sendResponse()
        {
            if( $this->boolOutputSend === true)
            {
                return;
            }
            
            
            $arrStatus = array(
                200 => 'OK',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                307 => 'Temporary Redirect',
                400 => 'Bad Request',
                401 => 'Unauthorized',
                403 => 'Forbidden',
                404 => 'Not Found',
                500 => 'Internal Server Error',
                501 => 'Not Implemented'
             );
            
            
            // send headers
            if( headers_sent() === false )
            {
                // send http status
                if( isset( $arrStatus[$this->getStatus()] ) === true)
                {
                    header( sprintf( 'HTTP/1.0 %s %s', $this->getStatus(), $arrStatus[$this->getStatus()] ) );
                }
                
                // add content type + encoding if not is set
                $this->addHeader( 'Content-Type', 'text/'. $this->getContentType() .'; charset=' . $this->getEncoding(), false );

                // send other headers
                foreach( $this->arrHeader as $headerKey => $headerValue )
                {
                    header( $headerKey . ': ' . $headerValue );
                }
            }
            
            // send output
            echo $this->getResponse();
            
            // dont resend output
            $this->boolOutputSend = true;
        }
        
    }