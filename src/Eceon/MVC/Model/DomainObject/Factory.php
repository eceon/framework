<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Factory.php 253 2015-02-19 13:58:19Z ted $
     * $package Eceon/MVC/Model/DomainObject
     */
    
    namespace Eceon\MVC\Model\DomainObject;
    
    use Eceon\DI\AbstractFactory;
    
    
    class Factory extends AbstractFactory
    {
        
        /**
         * Builds a DomainObject
         * 
         * @param string $pModuleName
         * @param string $pObjectName
         * @return InterfaceDomainObject
         */
        public function build( $pModuleName, $pObjectName )
        {
            // build DomainObject id: <module>.domainobject.<name>
            $domainObjectId = sprintf( 
                                '%s.model.domainobject.%s', 
                                strtolower( $pModuleName ), 
                                strtolower( $pObjectName ) 
                            );
            
            // recreate a domain object on loading
            $recreate_object = true;
            
            // load DomainObject
            $domainObjectClass = $this->getDiContainer()->load( $domainObjectId, $recreate_object );
            
            // return DomainObject
            return $domainObjectClass;            
        }
        
  
    }