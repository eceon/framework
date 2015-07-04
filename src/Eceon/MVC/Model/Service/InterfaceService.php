<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceService.php 259 2015-02-22 14:32:35Z ted $
     * $package Eceon/MVC/Model/Service
     */

    namespace Eceon\MVC\Model\Service;
    
    use Eceon\MVC\Model\DataMapper\Factory as DataMapperFactory;
    use Eceon\MVC\Model\DomainObject\Factory as DomainObjectFactory;
    use Eceon\MVC\Model\Form\Factory as FormFactory;

    
    interface InterfaceService
    {
        
        /**
         * Sets a DataMapperFactory to the Service
         * 
         * @param DataMapperFactory $pFactory
         */
        public function setDataMapperFactory( DataMapperFactory $pFactory );
        
       

        /**
         * Sets a domainObjectFactory to the Service
         * 
         * @param DomainObjectFactory $pFactory
         */
        public function setDomainObjectFactory( DomainObjectFactory $pFactory );

      
        
        /**
         * Sets a FormFactory object to the Service
         * 
         * @param FormFactory $pFactory
         */
        public function setFormFactory( FormFactory $pFactory );
        
        
    }