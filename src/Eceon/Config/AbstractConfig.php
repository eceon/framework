<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractConfig.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Config
     */

    namespace Eceon\Config;

    
    abstract class AbstractConfig implements InterfaceConfig, \Iterator, \Countable
    {
        /**
         * @var integer
         */
        protected $intIndex = 0;

        /**
         * @var array() data
         */
        protected $arrData = array();



        /**
         * Constructor
         */
        public function __construct() 
        {
            $this->intIndex = 0;
        }


        /**
         * Parse the given config file. 
         * 
         * @param mixed $pConfigFile
         */
        abstract public function parseFile( $pConfigFile );

        
        /**
         * ITERATOR FUNCTIONS
         */
        public function rewind() 
        {
            reset( $this->arrData );
            
            $this->intIndex = 0;
        }

        public function current() 
        {
            return current( $this->arrData );   
        }

        public function key() 
        {
            return key( $this->arrData );
        }

        public function next() 
        {
            $this->intIndex++;
            
            next( $this->arrData );
        }

        public function valid() 
        {
            return $this->intIndex < count( $this->arrData );
        }


        /**
         * COUNTABLE FUNCTIONS
         */
        public function count()
        {
            return count( $this->arrData );
        }


        /**
         * GET FUNCTIONS
         */
        public function get( $pKey, $pDefault = null )
        {
            if( isset( $this->arrData[$pKey] ) === false )
            {
                return $pDefault;
            }

            return $this->arrData[$pKey];
        }

        public function __get( $pKey )
        {
            return $this->get( $pKey );
        }


        public function __isset( $pKey )
        {
            return isset( $this->arrData[$pKey] );
        }
    }
