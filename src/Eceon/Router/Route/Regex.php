<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Regex.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Router/Route
     */

    namespace Eceon\Router\Route;

    class Regex extends AbstractRoute
    {

        /**
         * Match a URI against this route. Returns false if it didnt match,
         * returns an array with parameters
         *
         * @param string $pURI
         * @return false|array()
         */		
        public function match( $pURI )
        {
            $uri = '/' . ltrim( $pURI, '/' );

            $matches = array();
            if( preg_match( $this->getRouteMap(), $uri, $matches ) != 0 )
            {
                $data = array();				

                // first set the default route params 
                foreach ( $this->getDefaultParams() as $key => $value )
                {
                    $data[$key] = $value;
                }

                // then set the matched
                foreach ( $matches as $key => $value )
                {
                    if( is_int($key) === false )
                    {
                            $data[$key] = $value;
                    }
                }

                return $data;
            }

            return false;
        }
        
        
        public function reverseMatch( $pArgument = array() ) 
        {
            // @todo: functie reverseMatch maken 
        }
    }	