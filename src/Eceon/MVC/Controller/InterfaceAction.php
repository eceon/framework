<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * $package Eceon/MVC/Controller
     */

    namespace Eceon\MVC\Controller;

    use Eceon\Request\InterfaceRequest;
    
    interface InterfaceAction
    {
        public function execute( InterfaceRequest $pRequest );
        
        
        
    }