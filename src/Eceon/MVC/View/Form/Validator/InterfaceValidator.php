<?php
    /**
     * Eceon (http://eceon.mezio.nl)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceValidator.php 196 2015-01-15 16:11:18Z ted $
     * $package Eceon/MVC/View/Form/Validator
     */
     
    namespace Eceon\MVC\View\Form\Validator;
     
     
    interface InterfaceValidator
    {
        
        public function validate( $pData );
        
        
        public function getErrorMessage();
    }
    
    