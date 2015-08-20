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
    
    use Eceon\MVC\Model\DataMapper\InterfaceDataMapper;
    
    
    abstract class AbstractService implements InterfaceService
    {
        
        /**
         * @var InterfaceDataMapper[]
         */
        protected $arrDataMapper = array();

        
        
        /**
         * Adds a DataMapper to the services
         * 
         * @param string $pName
         * @param InterfaceDataMapper $pDataMapper
         */
        public function addDataMapper( $pName, InterfaceDataMapper $pDataMapper )
        {
            $this->arrDataMapper[$pName] = $pDataMapper;
        }
        
        /**
         * Gets a DataMapper. Returns null if the requested datamapper is not 
         * set
         * 
         * @param string $pName
         * @return InterfaceDataMapper
         */
        public function getDataMapper( $pName )
        {
            if( isset( $this->arrDataMapper[$pName] ) === false )
            {
                return null;
            }
            
            return $this->arrDataMapper[$pName];
        }
        

        
    }