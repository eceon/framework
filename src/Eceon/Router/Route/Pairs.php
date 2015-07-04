<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Pairs.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Router/Route
     */

    namespace Eceon\Router\Route;

    class Pairs extends AbstractRoute
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
            $data = array();

            // create a uri without a starting/ending slash
            $uri = trim( $pURI, '/' );

            // uri is empty
            if( $uri == '' )
            {
                return false;
            }

            // break up the uri in parts
            $uri_parts = explode( '/', $uri );

            // loop parts
            foreach ( $uri_parts as $key => $value )
            {
                switch( $key )
                {
                    case 0: // module
                            $data['module'] = urldecode( $value );
                            break;

                    case 1: // command
                            $data['command'] = urldecode( $value );
                            break;

                    case 2: // id?
                            if( isset( $uri_parts[3] ) === false )
                            {
                                    $data['id'] = urldecode( $value );
                            }

                    default:
                            // zijn we bij een even key en bestaat de volgende key ook?
                            // dan hebben we een pair
                            if( $key % 2 == 0 && isset( $uri_parts[$key + 1] ) === true )
                            {
                                    $data[urldecode( $value )] = urldecode( $uri_parts[$key + 1] );
                            }
                }

            }

            // found data? return it
            if( count( $data ) > 0 )
            {
                return $data;
            }

            // return false if there is not data
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
            // @todo: functie maken
            return '';
        }        
    }