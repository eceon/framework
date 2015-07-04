<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceRouter.php 211 2015-02-05 12:31:03Z ted $
     * $package Eceon/Router
     */

    namespace Eceon\Router;

    use Eceon\Request\InterfaceRequest;
    
    
    interface InterfaceRouter
    {
        /**
         * Routes the arguments into controller/method
         * (requires a valid request object)
         * 
         * @param InterfaceRequest $pRequest
         */
        public function route( InterfaceRequest $pRequest );

        
        /**
         * Creates an URL based on the arguments given
         *
         * @param array() $pArgument
         * @return string
         */
        public function reverseRoute( $pArgument = array() );


        /**
         * Adds a route to this router
         *
         * @param Route\InterfaceRoute $pRoute
         * @param integer $pPriority [optional]
         */
        public function addRoute( Route\InterfaceRoute $pRoute, $pPriority = 50 );	        
    }