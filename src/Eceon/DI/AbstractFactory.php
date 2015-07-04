<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractFactory.php 201 2015-01-15 16:34:35Z ted $
     * $package Eceon/DI
     */

    namespace Eceon\DI;
    
    use Eceon\Factory;

    
    abstract class AbstractFactory implements Factory\InterfaceFactory
    {
        /**
         * @var Container
         */
        protected $objDiContainer = null;   
        
        
  
        /**
         * Builds the requested object
         * 
         * @param string $pModuleName
         * @param string $pObjectName
         */
        abstract public function build( $pModuleName, $pObjectName );
        
        
        
        /**
         * Sets the dependecy injector container
         * 
         * @param Container $pContainer
         */
        public function setDiContainer( Container $pContainer )
        {
            $this->objDiContainer = $pContainer;
        }
        
        /**
         * Gets the dependecy injector container
         * 
         * @return Container
         */
        public function getDiContainer()
        {
            return $this->objDiContainer;
        }                
    }
