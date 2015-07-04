<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Simple.php 223 2015-02-13 00:27:54Z ted $
     * $package Eceon/Router/Route
     */

    namespace Eceon\Router\Route;

    class Simple extends AbstractRoute
    {
        
        /**
          * Setter for RouteMap
          *
          * @param string $pMap
          */
        public function setRouteMap( $pMap )
        {
            // remove starting slash
            $map = $pMap;
            
            // replace {<name>}, {<name>:\d}, {<name>:\w}
            $map = preg_replace( '/{([a-zA-Z]+)}/i', '(?P<$1>[a-zA-Z0-9-_]+)', $map );
            $map = preg_replace( '/{([a-zA-Z]+):int}/i', '(?P<$1>[0-9]+)', $map );

            // set map
            $this->strRouteMap = $map;
        }        
        
        
        /**
         * Match a URI against this route. Returns false if it didnt match,
         * returns an array with parameters
         *
         * @param string $pURI
         * @return false|array()
         */		
        public function match( $pURI )
        {
            // create a uri without a starting/ending slash
            $uri = $pURI;

            if( $uri == '' )
            {
                return false;
            }
            
            if( preg_match( "|^". $this->getRouteMap() . "$|", $uri, $matches ) == true )
            {
                return array_merge( $this->getDefaultParams(), $matches );
            }
            
            return false;
        }        
        
        /**
         * Creates an url string in route format based on the given arguments
         * 
         * @param array() $pArgument
         * @return string
         */
        public function reverseMatch( $pArgument = array() ) 
        {
            return '';
        }
    }