<?php
    /**
     * Eceon (http://eceon.mezio.nl)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractElement.php 196 2015-01-15 16:11:18Z ted $
     * $package Eceon/MVC/View/Form/Element
     */

    namespace Eceon\MVC\View\Form\Element;
     
    use Eceon\MVC\View\Form\Filter\IntefaceFilter;
    use Eceon\MVC\View\Form\Validator\InterfaceValidator;
    
    abstract class AbstractElement implements InterfaceElement
    {
        /**
         * @var string
         */
        protected $strFieldName = '';
        
        /**
         * @var boolean
         */
        protected $boolRequired = false;
        
        /**
         * @var IntefaceValidator[]
         */
        protected $arrValidator = array();
        
        /**
         * @var InterfaceFilter
         */
        protected $arrFilter = array();
        

        
        
        /**
         * 
         * @param string $pFieldName
         * @param InterfaceValidator[]|InterfaceValidator $pValidators
         * @param InterfaceFilter[]|InterfaceFilter $pFilters
         */
        public function __construct( $pFieldName, $pValidators = null, $pFilters = null )
        {
            // set fieldname
            $this->setFieldName( $pFieldName );
            
            
            // add validator(s)
            if( is_array( $pValidators ) === true )
            {
                foreach( $pValidators as $validator )
                {
                    $this->addValidator( $validator );
                }
            } elseif( $pValidators instanceof InterfaceValidator ) {
                $this->addValidator( $pValidators );   
            }
            
            // add filter(s)
            if( is_array( $pFilters ) === true )
            {
                foreach( $pFilters as $filter )
                {
                    $this->addFilter( $filter );
                }
            } elseif( $pFilters instanceof InterfaceFilter ) {
                $this->addFilter( $pFilters );
            }
                
        }
        
        
        
        
        /**
         * Sets the field name
         * 
         * @param string $pValue
         */
        public function setFieldName( $pValue )
        {
            $this->strFieldName = $pValue;
        }
        
        /**
         * Gets the field name
         * 
         * @return string
         */
        public function getFieldName()
        {
            return $this->strFieldName;
        }
        
        
        /**
         * Sets if this element is required
         * 
         * @param boolean $pValue
         */
        public function setRequired( $pValue )
        {
            $this->boolRequired = $pValue;
        }
        
        /**
         * Gets if this element is required
         * 
         * @return boolean
         */
        public function getRequired()
        {
            return $this->boolRequired;
        }
        
        
        /**
         * Adds a validator to the element
         * 
         * @param InterfaceValidator $pValidator
         */
        public function addValidator( InterfaceValidator $pValidator )
        {
            $this->arrValidator[] = $pValidator;
        }
        
        
        
        /**
         * Adds a filter to the element
         * 
         * @param IntefaceFilter $pFilter
         */
        public function addFilter( IntefaceFilter $pFilter )
        {
            $this->arrFilter[] = $pFilter;
        }
        
        
        
        
        
        
        
        /**
         * Sanitize the given data to the filters
         * 
         * @param string $pData
         * @return string
         */
        public function sanitize( $pData )
        {
            $data = $pData;
            
            foreach( $this->arrFilter as $filter )
            {
                $data = $filter->filter( $data );
            }
            
            return $data;
        }        
        
        
        /**
         * Validate this element
         * 
         * @param string $pData
         * @return boolean
         */
        public function validate( $pData )
        {
            foreach( $this->arrValidator as $validator )
            {
                if( $validator->validate( $pData ) === false )
                {
                    return false;
                }
            }
            
            return true;
        }
        
        
        
        /**
         * 
         * Gets the error messages for this element
         * 
         * @param string $pData
         * @return array|false
         */
        public function errorMessage( $pData )
        {
            $error = array();
            
            foreach( $this->arrValidator as $validator )
            {
                if( $validator->validate( $pData ) === false )
                {
                    $error[] = $validator->getErrorMessage();
                }
            }     
            
            // no errors, return false
            if( count($error) == 0 )
            {
                return false;
            }
            
            return $error;
        }


        
    }