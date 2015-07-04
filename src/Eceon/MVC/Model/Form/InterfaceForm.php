<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceForm.php 261 2015-02-22 16:24:05Z ted $
     * $package Eceon/MVC/Model/Form
     */

    namespace Eceon\MVC\Model\Form;

    interface InterfaceForm
    {
        
        /**
         * Adds an input to the form
         * 
         * @param InterfaceInput $pInput
         * @return InterfaceForm
         */        
        public function addInput( InterfaceInput $pInput );
        
        /**
         * Get an array of inputs that are attached to this form
         * 
         * @return InterfaceInput[]
         */        
        public function getInputs();
        
        
        /**
         * Fills the form inputs with data
         * 
         * @param \ArrayObject $pData
         */
        public function populate( $pData );

        
        /**
         * Gets the value of an input by inputname. Returns null if no input 
         * exists
         * 
         * @param string $pName
         * @return string|null
         */
        public function getValueByName( $pName );
     
        
        /**
         * Checks the form input values against there validators.
         * 
         * @return boolean
         */
        public function isValid();

        /**
         * Get the validator input errors if the form is invalid
         * 
         * @return \ArrayObject
         */
        public function getErrors();
                

        /**
         * Returns the - sanitized - form input values
         * 
         * @return \ArrayObject
         */
        public function getData();

                
    }