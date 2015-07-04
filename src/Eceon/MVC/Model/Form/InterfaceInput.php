<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceInput.php 259 2015-02-22 14:32:35Z ted $
     * $package Eceon/MVC/Model/Form
     */

    namespace Eceon\MVC\Model\Form;

    interface InterfaceInput
    {
        
        /**
         * Sets the name of this input
         * 
         * @param string $pValue
         */
        public function setName( $pValue );
        
        /**
         * Gets the name of this input
         * 
         * @return string
         */
        public function getName();
        
        
        
        /**
         * Sets the value of this input
         * 
         * @param string $pValue
         */
        public function setValue( $pValue );
        
        /**
         * Gets the value of this input
         * 
         * @return string
         */
        public function getValue();
        
        
        /**
         * Adds a validator to this input
         * 
         * @param InterfaceValidator $pValidator
         * @return InterfaceInput
         */
        public function addValidator( InterfaceValidator $pValidator );
        
        /**
         * Gets an array of validators attached to this input
         * 
         * @return InterfaceValidator[]
         */
        public function getValidators();
        
        
        /**
         * Adds a sanitizer to this input
         * 
         * @param InterfaceSanitzier $pSanitizer
         * @return InterfaceInput
         */
        public function addSanitizer( InterfaceSanitizer $pSanitizer );
        
        /**
         * Gets an array of sanitizers attached to this input
         * 
         * @return InterfaceSanitizer[]
         */
        public function getSanitizers();
        
    }