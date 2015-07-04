<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceRoute.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Router/Route
     */

    namespace Eceon\Router\Route;

    interface InterfaceRoute
    {
        /**
          * Setter for RouteMap
          *
          * @param string $pMap
          */
        public function setRouteMap( $pMap );

        /**
          * Getter for RouteMap
          *
          * @return string
          */
        public function getRouteMap();


        /**
         * Try to match an uri with the routemap
         *
         * @param string $pURI
         * @return array|false returns an array with parameters back if match, returns
         *                     false if the uri doesnt match
         */			
        public function match( $pURI );


        /**
         * Try to match arguments with the routemap and create an uri out of it
         *
         * @param array() $pArgument
         * @return string|boolean
         */				
        public function reverseMatch( $pArgument = array() );
        
    }
		