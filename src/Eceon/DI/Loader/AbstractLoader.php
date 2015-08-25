<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * $package Eceon/DI/Loader
     */

    namespace Eceon\DI\Loader;
    
    use Eceon\DI\Container;
    
    
    abstract class AbstractLoader implements InterfaceLoader
    {
        
        /**
         * Holds the DI container
         *
         * @var Container
         */
        protected $objContainer = null;
        
        
        /**
         * Constructor
         * 
         * @param Container $pContainer
         */
        final public function __construct( Container $pContainer )
        {
            $this->objContainer = $pContainer;
        }
        
        
        /**
         * Gets the container
         * 
         * @return Container
         */
        protected function container()
        {
            return $this->objContainer;
        }

        
    }
