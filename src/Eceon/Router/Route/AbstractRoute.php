<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractRoute.php 223 2015-02-13 00:27:54Z ted $
     * $package Eceon/Router/Route
     */

    namespace Eceon\Router\Route;

    
    abstract class AbstractRoute implements InterfaceRoute
    {
        /**
         * @var string
         */
        protected $strRouteMap = '';

        /**
         * @var array
         */
        protected $arrDefaultParam = array();


        /**
         * Constructor
         *
         * @param str $pRouteMap Defines the route map
         * @param array $pDefaultParam [optional]
         */
        public function __construct( $pRouteMap = '', $pDefaultParam = array() )
        {
            // sets the route mapping
            $this->setRouteMap( $pRouteMap );

            // adds default parameter values
            foreach ( $pDefaultParam as $param => $value )
            {
                $this->addDefaultParam( $param, $value );
            }
        }
        

        /**
          * Setter for RouteMap
          *
          * @param string $pMap
          */
        public function setRouteMap( $pMap )
        {
            $this->strRouteMap = $pMap;
        }
        
        /**
          * Getter for RouteMap
          *
          * @return string
          */
        public function getRouteMap()
        {
            return $this->strRouteMap;
        }

        
        /**
         * Adds a default parameter value
         *
         * @param string $pParam
         * @param string $pValue
         */
        protected function addDefaultParam( $pParam, $pValue )
        {
            $this->arrDefaultParam[$pParam] = $pValue;
        }

        /**
         * Checks if a default param is set
         *
         * @param string $pParam
         * @return boolean
         */
        protected function isDefaultParam( $pParam )
        {
            return isset( $this->arrDefaultParam[$pParam] );
        }

        /**
         * Gets a default param value
         *
         * @param string $pParam
         * @return string|null
         */
        protected function getDefaultParam( $pParam )
        {
            if( $this->isDefaultParam( $pParam ) === true )
            {
                return $this->arrDefaultParam[$pParam];
            }
            
            return null;
        }

        /**
         * Gets all default params
         *
         * @return array
         */
        protected function getDefaultParams()
        {
            return $this->arrDefaultParam;
        }


    }
