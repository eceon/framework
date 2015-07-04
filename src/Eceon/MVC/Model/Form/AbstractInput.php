<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractInput.php 263 2015-02-22 16:33:51Z ted $
     * $package Eceon/MVC/Model/Form
     */

    namespace Eceon\MVC\Model\Form;

    abstract class AbstractInput implements InterfaceInput
    {
        /**
         * @var string 
         */
        protected $strName = '';

        /**
         * @var string
         */
        protected $strValue = '';
        
        /**
         * @var InterfaceValidator[] 
         */
        protected $arrValidator = array();
        
        /**
         * @var InterfaceSanitizer[] 
         */
        protected $arrSanitizer = array();
        
        
        
        
        /**
         * Sets the name of this input
         * 
         * @param string $pValue
         */
        public function setName( $pValue )
        {
            $this->strName = $pValue;
        }
        
        /**
         * Gets the name of this input
         * 
         * @return string
         */
        public function getName()
        {
            return $this->strName;
        }
        
        
        /**
         * Sets the value of this input
         * 
         * @param string $pValue
         */
        public function setValue( $pValue )
        {
            $data = $this->sanitizeData( $pValue );
            
            $this->strValue = $data;
        }
        
        /**
         * Gets the value of this input
         * 
         * @return string
         */
        public function getValue()
        {
            return $this->strValue;
        }
        
        
        /**
         * Adds a validator to this input
         * 
         * @param InterfaceValidator $pValidator
         * @return InterfaceInput
         */        
        public function addValidator( InterfaceValidator $pValidator )
        {
            $this->arrValidator[] = $pValidator;
            
            return $this;
        }
        
        /**
         * Gets an array of validators attached to this input
         * 
         * @return InterfaceValidator[]
         */        
        public function getValidators()
        {
            return $this->arrValidator;
        }
        
        
        /**
         * Adds a sanitizer to this input
         * 
         * @param InterfaceSanitzier $pSanitizer
         * @return InterfaceInput
         */        
        public function addSanitizer( InterfaceSanitizer $pSanitizer )
        {
            $this->arrSanitizer[] = $pSanitizer;
            
            return $this;
        }
        
        /**
         * Gets an array of sanitizers attached to this input
         * 
         * @return InterfaceSanitizer[]
         */        
        public function getSanitizers()
        {
            return $this->arrSanitizer;
        }
        
        
        

        
        /**
         * Checks if this input is valid.
         * 
         * @return boolean
         */
        public function isValid()
        {
            foreach( $this->getValidators() as $validator )
            {
                if( $validator->validate( $this->getValue() ) === false )
                {
                    return false;
                }
            }

            return true;
        }        

        
        /**
         * Validates this input. returns an
         * array with errors if validation fails.
         * 
         * @return \ArrayObject
         */
        public function getErrors( )
        {
            $arrErrors = array();
            
            foreach( $this->getValidators() as $validator )
            {
                if( $validator->validate( $this->getValue() ) === false )
                {
                    $arrErrors[] = $validator->getErrorMessage();
                }
            }
            
            return $arrErrors;
        }        
        
        
        /**
         * Sanitize the given data
         * 
         * @param string $pData
         * @return string
         */
        public function sanitizeData( $pData )
        {
            $data = $pData;
            
            foreach( $this->getSanitizers() as $sanitizer )
            {
                $data = $sanitizer->sanitize( $data );
            }
            
            return $data;
        }
        
    }