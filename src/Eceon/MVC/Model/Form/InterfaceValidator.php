<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceValidator.php 253 2015-02-19 13:58:19Z ted $
     * $package Eceon/MVC/Model/Form
     */

    namespace Eceon\MVC\Model\Form;

    interface InterfaceValidator
    {

        /**
         * Sets the error message to show if the validator fails to validate the 
         * given data
         * 
         * @param string $pValue
         */
        public function setErrorMessage( $pValue );

        
        /**
         * Gets the error message
         * 
         * @return string
         */
        public function getErrorMessage();
        
        
        
        /**
         * Validates the given data
         * 
         * @param string $pData
         * @return boolean
         */
        public function validate( $pData );
    }