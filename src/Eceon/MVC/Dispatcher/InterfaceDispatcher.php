<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceDispatcher.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/MVC/Dispatcher
     */

    namespace Eceon\MVC\Dispatcher;

    use Eceon\Request\InterfaceRequest;
    use Eceon\Response\InterfaceResponse;
    
    interface InterfaceDispatcher
    {
        public function dispatch( InterfaceRequest $pRequest, InterfaceResponse $pResponse );
    }