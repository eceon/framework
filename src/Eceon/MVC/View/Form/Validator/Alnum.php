<?php
    /**
     * Eceon (http://eceon.mezio.nl)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Alnum.php 196 2015-01-15 16:11:18Z ted $
     * $package Eceon/MVC/View/Form/Validator
     */
     
     namespace Eceon\MVC\View\Form\Validator;
     
     
     class Alnum extends Regex
     {
         protected $strRegex = "'^[0-9]+$'si";
         
         public function setRegex(){}
     }