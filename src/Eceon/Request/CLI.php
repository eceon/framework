<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: CLI.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Request
     */

    namespace Eceon\Request;

    class CLI extends AbstractRequest
    {
        /**
         * @var string 
         */
        protected $strRequestType = 'CLI';        
        
        /**
         * @var string
         */
        protected $strAcceptContentType = 'text';
        
        
        /**
         * Constructor
         */
        public function __construct()
        {
            foreach( $_SERVER['argv'] as $param )
            {
                if( strpos( $param, '=' ) !== false )
                {
                    $key = substr( $param, 0, strpos( $param, '=' ) );
                    $value = substr( $param, strpos( $param, '=') + 1 );
                    
                    $this->setParam( $key, $value );
                }
            }
        }
        
        
    }