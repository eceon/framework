<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: CLI.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Response
     */

    namespace Eceon\Response;

    class CLI extends AbstractResponse
    {
        /**
         * @var string 
         */
        protected $strContentType = 'text';

        /**
         * Dont let the CLI set the content type, its always text
         * 
         * @param string $pValue 
         */
        public function setContentType( $pValue )
        {
            return;
        }
        
        
        /**
         * Sends the output to the command line
         */
        public function sendResponse()
        {
            echo $this->getResponse();
        }
    }