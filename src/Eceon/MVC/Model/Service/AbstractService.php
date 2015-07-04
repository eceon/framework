<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractService.php 259 2015-02-22 14:32:35Z ted $
     * $package Eceon/MVC/Model/Service
     */
    
    namespace Eceon\MVC\Model\Service;
    
    use Eceon\MVC\Model\DataMapper\Factory as DataMapperFactory;
    use Eceon\MVC\Model\DomainObject\Factory as DomainObjectFactory;
    use Eceon\MVC\Model\Form\Factory as FormFactory;
    
    
    abstract class AbstractService implements InterfaceService
    {
        
        /**
         * @var DataMapperFactory
         */
        protected $objDataMapperFactory = null;

        /**
         * @var DomainObjectFactory 
         */
        protected $objDomainObjectFactory = null;
        
        /**
         * @var FormFactory
         */
        protected $objFormFactory = null;
        
        
        
        
        
        /**
         * Sets a DataMapperFactory to the Service
         * 
         * @param DataMapperFactory $pFactory
         */
        public function setDataMapperFactory( DataMapperFactory $pFactory )
        {
            $this->objDataMapperFactory = $pFactory;
        }
        
        /**
         * Gets the DataMapper Factory
         * 
         * @return DataMapperFactory
         */
        protected function getDataMapperFactory()
        {
            return $this->objDataMapperFactory;
        }        
        

        

        /**
         * Sets a domainObjectFactory to the Service
         * 
         * @param DomainObjectFactory $pFactory
         */
        public function setDomainObjectFactory( DomainObjectFactory $pFactory )
        {
            $this->objDomainObjectFactory = $pFactory;
        }
        
        /**
         * Gets the domainObject Factory
         * 
         * @return DomainObjectFactory
         */
        protected function getDomainObjectFactory()
        {
            return $this->objDomainObjectFactory;
        }        
        
        
        
        /**
         * Sets a FormFactory object to the Service
         * 
         * @param FormFactory $pFactory
         */
        public function setFormFactory( FormFactory $pFactory )
        {
            $this->objFormFactory = $pFactory;
        }
        
        /**
         * Gets the Form Factory
         * 
         * @return FormFactory
         */
        protected function getFormFactory()
        {
            return $this->objFormFactory;
        }
        
    }