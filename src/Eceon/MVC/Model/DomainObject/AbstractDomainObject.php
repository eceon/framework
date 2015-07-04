<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractDomainObject.php 261 2015-02-22 16:24:05Z ted $
     * $package Eceon/MVC/Model/DomainObject
     */

    namespace Eceon\MVC\Model\DomainObject;

    
    abstract class AbstractDomainObject implements InterfaceDomainObject
    {
        
        /**
         * populates the domainobject with the given data 
         * 
         * @param \ArrayObject $pRow
         * @param string $pPrefix
         */
        public function loadData( $pRow, $pPrefix = '' )
        {
        }
        
    }