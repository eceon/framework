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
    use Eceon\MVC\Model\DomainObject\InterfaceDomainObject;
    use Eceon\MVC\Model\Form\InterfaceForm;
    
    
    abstract class AbstractService implements InterfaceService
    {
        
        /**
         * @var InterfaceDataMapper[]
         */
        protected $arrDataMapper = array();

        /**
         * @var InterfaceDomainObject[]
         */
        protected $arrDomainObject = array();
        
        /**
         * @var InterfaceForm[]
         */
        protected $arrForm = array();
        
    }