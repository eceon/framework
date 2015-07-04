<?php 
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: HTTP.php 224 2015-02-13 00:37:31Z ted $
     * $package Eceon/Router
     */

    namespace Eceon\Router;

    use Eceon\Request\InterfaceRequest;
    
    class HTTP extends AbstractRouter
    {
        /**
         * Routes the urls 
         *
         * @param InterfaceRequest $pRequest
         */
        public function route( InterfaceRequest $pRequest )
        {
            // getting the path info 
            $uri = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : '';

            // create empty parameters (none found so far)
            $params = array();

            // try to match all the routes to the uri
            foreach ( $this->objRouteQueue as $route )
            {
                // get params if route is found
                $params = $route->match( $uri );

                // if params are found, process them
                if( is_array( $params ) === true )
                {

                    // load params into the request
                    foreach ( $params as $key => $value )
                    {
                        // add key & value
                        $pRequest->setParam( $key, $value );
                    }

                    // don't match other routes
                    break;
                }
            }

            // return params
            return $params;
        }


        /**
         * Creates an URL based on the arguments given
         *
         * @param array $pArgument
         * @return string|boolean
         */
        public function reverseRoute( $pArgument = array() )
        {
            // try to match all the routes to the uri
            foreach ( $this->objRouteQueue as $route )
            {
                // get params if route is found
                $uri = $route->reverseMatch( $pArgument );

                if( $uri !== false )
                {
                    return $uri;
                }
            }

            return false;
        }		
    }
