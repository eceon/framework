<?php
    /**
     * Eceon (http://eceon.mezio.nl)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Trim.php 196 2015-01-15 16:11:18Z ted $
     * $package Eceon/MVC/View/Form/Filter
     */
     
     namespace Eceon\MVC\View\Form\Filter;
     
     
     class Trim extends AbstractFilter
     {
         protected $charlist = null;
         
         public function filter( $pData )
         {
             return trim( $pData, $this->charlist );
         }
     }