<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractValidator.php 253 2015-02-19 13:58:19Z ted $
     * $package Eceon/MVC/Model/Form
     */

    namespace Eceon\MVC\Model\Form;

    abstract class AbstractValidator implements InterfaceValidator
    {
        /**
         * @var string
         */
        protected $strErrorMessage = '';
        

        /**
         * Sets the error message to show if the validator fails to validate the 
         * given data
         * 
         * @param string $pValue
         */
        public function setErrorMessage( $pValue )
        {
            $this->strErrorMessage = $pValue;
        }
        
        /**
         * Gets the error message
         * 
         * @return string
         */
        public function getErrorMessage()
        {
            return $this->strErrorMessage;
        }
    }