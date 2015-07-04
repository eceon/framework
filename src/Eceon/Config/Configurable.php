<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Configurable.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Config
     */

    namespace Eceon\Config;

    interface Configurable 
    {
        public function parseConfig( InterfaceConfig $pConfig );
    }