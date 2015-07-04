<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceController.php 359 2015-06-02 09:37:25Z ted $
     * $package Eceon/MVC/Controller
     */

    namespace Eceon\MVC\Controller;

    use Eceon\Request\InterfaceRequest;
    
    interface InterfaceController
    {
        public function execute( $pAction, InterfaceRequest $pRequest );
        
        
        
    }