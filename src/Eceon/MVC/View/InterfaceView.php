<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceView.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/MVC/View
     */

    namespace Eceon\MVC\View;

    
    interface InterfaceView
    {
        
        
        /**
         * adds a parameter to this view 
         * 
         * @param stirng $pKey
         * @param mixed $pValue
         * @return InterfaceView
         */
        public function setParam( $pKey, $pValue );
        
        
        /**
         * Does this request object has the key parameter?
         *
         * @param string $pKey
         * @return boolean
         */
        public function hasParam( $pKey );
        
        
        /**
         * Gets a parameter value by key. Returns null if key is not set
         *
         * @param string $pKey
         * @param string $pDefault [optional]
         * @return string
         */
        public function getParam( $pKey, $pDefault = null );
    }