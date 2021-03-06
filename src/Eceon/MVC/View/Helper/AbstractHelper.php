<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractHelper.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/MVC/View/Helper
     */

    namespace Eceon\MVC\View\Helper;

    abstract class AbstractHelper implements InterfaceHelper
    {
        abstract public function helper();
    }