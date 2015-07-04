<?php
    /**
     * Eceon (http://eceon.mezio.nl)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractValidator.php 196 2015-01-15 16:11:18Z ted $
     * $package Eceon/MVC/View/Form/Validator
     */
     
     namespace Eceon\MVC\View\Form\Validator;
     
     
     abstract class AbstractValidator implements InterfaceValidator
     {
         /**
          * @var string
          */
         protected $strErrorMessage = '';
         
         
         /**
          * Sets the error message
          * 
          * @param string $pValue
          */
         public function setErrorMessage( $pValue )
         {
             $this->strErrorMessage = $pValue;
         }
         
         /**
          * Gets the error message
          * 
          * @return string
          */
         public function getErrorMessage()
         {
             return $this->strErrorMessage;
         }
         
     }