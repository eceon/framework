<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Factory.php 253 2015-02-19 13:58:19Z ted $
     * $package Eceon/MVC/Model/DataMapper
     */
    
    namespace Eceon\MVC\Model\DataMapper;
    
    use Eceon\DI\AbstractFactory;
    
    
    class Factory extends AbstractFactory
    {
        
        /**
         * Builds a DataMapper
         * 
         * @param string $pModuleName
         * @param string $pObjectName
         * @return InterfaceDataMapper
         */
        public function build( $pModuleName, $pObjectName )
        {
            // build datamapper id: <module>.datamapper.<name>
            $dataMapperId = sprintf( 
                                '%s.model.datamapper.%s', 
                                strtolower( $pModuleName ), 
                                strtolower( $pObjectName ) 
                            );
            
            // load DataMapper
            $dataMapperClass = $this->getDiContainer()->load( $dataMapperId );
            
            // return dataMapper
            return $dataMapperClass;            
        }

        
    }