<?php
    /**
     * Eceon (http://eceon.mezio.nl)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: IntefaceFilter.php 196 2015-01-15 16:11:18Z ted $
     * $package Eceon/MVC/View/Form/Filter
     */

    namespace Eceon\MVC\View\Form\Filter; 
    
    
    interface IntefaceFilter
    {
        
        public function filter( $pData );
        
    }