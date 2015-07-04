<?php
    /**
     * Eceon (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractForm.php 196 2015-01-15 16:11:18Z ted $
     * $package 
     */
     
    namespace Eceon\MVC\View\Form;
    
    use Eceon\MVC\View\Form\Element\InterfaceElement;
    
    
    abstract class AbstractForm implements InterfaceForm
    {
        /**
         *
         * @var InterfaceElement[]
         */
        protected $arrElements = array();
        
        
        
        
        /**
         * Add an element to this form
         * 
         * @param InterfaceElement $pElement
         */
        public function addElement( InterfaceElement $pElement )
        {
            $this->arrElements[] = $pElement;
        }
        
        
        
        /**
         * Sanitize data 
         * 
         * @param array $pData
         * @return array
         */
        public function sanitizeData( $pData = array())
        {
            $newData = array();
            
            foreach( $this->arrElements as $element )
            {
                if( isset( $pData[$element->getFieldName()]) === false )
                {
                    continue;
                }
                
                $newData[$element->getFieldName()] = $element->sanitize( $pData[$element->getFieldName()] );
            }
            
            return $newData;
        }
        
        
        
        
        /**
         * Validate this form
         * 
         * @param array $pData
         * @return boolean
         */
        public function validateForm( $pData = array() )
        {
            foreach( $this->arrElements as $element )
            {
                if( isset( $pData[$element->getFieldName()] ) === false && $element->getRequired() === true )
                {
                    return false;
                } elseif( $element->validate( $pData[$element->getFieldName()] ) === false ) {
                    return false;
                }
            }
            
            return true;
        }
        
        
        /**
         * Validate given data
         * 
         * @param array $pData
         * @return boolean
         */
        public function validateData( $pData = array() )
        {
            foreach( $this->arrElements as $element )
            {
                if( isset( $pData[$element->getFieldName()]) === false )
                {
                    continue;
                }
                
                if( $element->validate( $pData[$element->getFieldName()] ) === false )
                {
                    return false;
                }
            }
            
            return true;
        }
        
        
        /**
         * Gets the error messages
         * 
         * @param array $pData
         * @return array|false
         */
        public function errorMessages( $pData = array() )
        {
            $error = array();
            
            foreach( $this->arrElements as $element )
            {
                if( isset( $pData[$element->getFieldName()]) === false )
                {
                    continue;
                }
                
                $element_error = $element->errorMessage( $pData[$element->getFieldName()] );
                
                if( $element_error != false ) 
                {
                    $error[$element->getFieldName()] = $element_error;
                }
                
            }
            
            if( count( $error ) == 0 )
            {
                return false;
            }
            
            return $error;            
        }
        
        
        
    }