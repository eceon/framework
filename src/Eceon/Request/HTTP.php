<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: HTTP.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Request
     */

    namespace Eceon\Request;

    class HTTP extends AbstractRequest
    {
        /**
         * @var string 
         */
        protected $strRequestType = 'HTTP';        
        
        /**
         * @var string
         */
        protected $strRequestMethod = 'get';
        
        /**
         * @var string
         */
        protected $strAcceptContentType = 'html';
        
        
        /**
         * Constructor 
         */
        public function __construct()
        {
            if( $_SERVER['REQUEST_METHOD'] == 'GET' )
            {
                // sets the request method to get
                $this->strRequestMethod = 'get';
                
                // store all get method's to this request object
                foreach( $_GET as $key => $value )
                {
                    $this->setParam( $key, $value );
                }
                
            } elseif( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
                
                // sets the request method to post
                $this->strRequestMethod = 'post';
                
                // store all post method's to this request object
                foreach( $_POST as $key => $value )
                {
                    $this->setParam( $key, $value );
                }
                
            }
        }
        
        
        public function getGetData()
        {
            return $_GET;
        }
        
        public function getPostData()
        {
            return $_POST;
        }
        
        
        
        
        /**
         * Gets the request method
         * 
         * @return string
         */
        public function getRequestMethod()
        {
            return $this->strRequestMethod;
        }
        
        
       /**
        * Gets the accept content type
        * 
        * @return string
        */
       public function getAcceptContentType()
       {
           if( $this->hasParam( 'format' ) )
           {
               return $this->getParam( 'format' );
           }
           
           return $this->strAcceptContentType;
       }
               
    }