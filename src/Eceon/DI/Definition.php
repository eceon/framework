<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Definition.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/DI
     */

    namespace Eceon\DI;
    
    class Definition
    {
        /**
         * The classname of this service
         *
         * @var string
         */
        protected $strClassName = '';
        
        /**
         * Array of construction arguments
         *
         * @var string[] 
         */
        protected $arrConstructArgument = array();
        
        /**
         * Array of method thats need to be called upon creation of the class
         *
         * @var string[] 
         */
        protected $arrMethodCall = array();
        
        
        
        /**
         * Constructor
         * 
         * @param string $pClassName
         */
        public function __construct( $pClassName )
        {
            $this->strClassName = $pClassName;
        }
        
 
        
        /**
         * Gets the class name of the service
         * 
         * @return string
         */
        public function getClassName()
        {
            return $this->strClassName;
        }
        
        
        
        /**
         * Adds a construction argument to the service
         * 
         * @param string|ParameterReference|ServiceReference $pParameter
         * @return Definition
         */
        public function addConstructArgument( $pParameter )
        {
            $this->arrConstructArgument[] = $pParameter;
            
            return $this;
        }
        
        /**
         * Sets the array of construction arguments
         * 
         * @param type $pParameters
         * @return Definition
         */
        public function setConstructArguments( $pParameters = array() )
        {
            $this->arrConstructArgument = $pParameters;
            
            return $this;
        }
        
        /**
         * Gets the complete array of construct arguments
         * 
         * @return string[]
         */
        public function getConstructArguments()
        {
            return $this->arrConstructArgument;
        }
        
        /**
         * Return true if this definition has construct arguments
         * 
         * @return boolean
         */
        public function hasConstructArguments()
        {
            return count( $this->arrConstructArgument ) > 0;
        }
        
        
        
        
        
        /**
         * Adds a method that will be called upon creating the class
         * 
         * @param string $pMethodName
         * @param string[] $pArguments
         * @return Definition
         */
        public function addMethodCall( $pMethodName, $pArguments = array() )
        {
            $this->arrMethodCall[] = array( 
                'method' => $pMethodName, 
                'arguments' => $pArguments 
            );
            
            return $this;
        }

        public function setMethodCalls( $pMethodCalls = array() )
        {
            $this->arrMethodCall = $pMethodCalls;
        }
        
        
        
        /**
         * Gets the complete array of method's that will be called upon creating the class
         * 
         * @return string[]
         */
        public function getMethodCalls()
        {
            return $this->arrMethodCall;
        }        
        
        
    } 