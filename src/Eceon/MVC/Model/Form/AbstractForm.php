<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractForm.php 264 2015-02-22 16:53:44Z ted $
     * $package Eceon/MVC/Model/Form
     */

    namespace Eceon\MVC\Model\Form;

    abstract class AbstractForm implements InterfaceForm
    {
        /**
         * @var InterfaceInput[]
         */
        protected $arrInput = array();
        
        
        
        /**
         * Adds an input to the form
         * 
         * @param InterfaceInput $pInput
         * @return InterfaceForm
         */
        public function addInput( InterfaceInput $pInput )
        {
            $this->arrInput[$pInput->getName()] = $pInput;
            
            return $this;
        }
        
        
        public function getInputByName( $pName )
        {
            if( isset( $this->arrInput[$pName]) === true )
            {
                return $this->arrInput[$pName];
            }
            
            return null;
        }

        
        
        /**
         * Get an array of inputs that are attached to this form
         * 
         * @return InterfaceInput[]
         */
        public function getInputs()
        {
            return $this->arrInput;
        }        
        
        
        
        
        
                
        /**
         * Fills the form inputs with data
         * 
         * @param \ArrayObject $pData
         */
        public function populate( $pData = array() )
        {
            foreach( $pData as $name => $value )
            {
                $input = $this->getInputByName( $name );
                
                if( $input !== null )
                {
                    $input->setValue( $value );
                }
            }
        }
        
        
        
        /**
         * Gets the value of an input by inputname. Returns null if no input 
         * exists
         * 
         * @param string $pName
         * @return string|null
         */
        public function getValueByName( $pName )
        {
            if( isset( $this->arrInput[$pName]) === true )
            {
                return $this->arrInput[$pName]->getValue();
            }
            
            return null;            
        }        
        
        
        
        /**
         * Checks the form input values against there validators.
         * 
         * @return boolean
         */
        public function isValid()
        {
            foreach( $this->getInputs() as $input )
            {
                if( $input->isValid() === false )
                {
                    return false;
                }
            }
            
            return true;
        }


        /**
         * Get the validator input errors if the form is invalid
         * 
         * @return \ArrayObject
         */
        public function getErrors()
        {
            $arrErrors = array();
            
            foreach( $this->getInputs() as $input )
            {
                if( $input->isValid() === false )
                {
                    $arrErrors[$input->getName()] = $input->getErrors();
                }
            }
            
            return $arrErrors;
        }
                

        /**
         * Returns the - sanitized - form input values
         * 
         * @return \ArrayObject
         */
        public function getData()
        {
            $arrData = array();
            
            foreach( $this->getInputs() as $input )
            {
                $arrData[$input->getName()] = $input->getValue();
            }
                
            return $arrData;
        }
        
    }