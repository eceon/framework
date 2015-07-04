<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceSanitizer.php 253 2015-02-19 13:58:19Z ted $
     * $package Eceon/MVC/Model/Form
     */

    namespace Eceon\MVC\Model\Form;

    interface InterfaceSanitzier
    {
        /**
         * Cleans the given data
         * 
         * @param string $pData
         * @return string
         */
        public function sanitize( $pData );
    }