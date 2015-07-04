<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Factory.php 253 2015-02-19 13:58:19Z ted $
     * $package Eceon/MVC/Model/Service
     */
    
    namespace Eceon\MVC\Model\Service;
    
    use Eceon\DI\AbstractFactory;
    
    
    class Factory extends AbstractFactory
    {
        
        /**
         * Builds a Service
         * 
         * @param string $pModuleName
         * @param string $pObjectName
         * @return InterfaceService
         */
        public function build( $pModuleName, $pObjectName )
        {
            // build Service id: <module>.service.<name>
            $serviceId = sprintf( 
                                '%s.model.service.%s', 
                                strtolower( $pModuleName ), 
                                strtolower( $pObjectName ) 
                            );
            
            // load Service
            $serviceClass = $this->getDiContainer()->load( $serviceId );
            
            // return Service
            return $serviceClass;            
        }
      
    }