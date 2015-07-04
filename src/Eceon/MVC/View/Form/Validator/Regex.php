<?php
    /**
     * Eceon (http://eceon.mezio.nl)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Regex.php 196 2015-01-15 16:11:18Z ted $
     * $package Eceon/MVC/View/Form/Validator
     */
     
     namespace Eceon\MVC\View\Form\Validator;
     
     
     class Regex extends AbstractValidator
     {
         /**
          * @var string
          */
         protected $strRegex = '';
         
         
         /**
          * Constructor
          * 
          * @param string $pRegex
          */
         public function __construct( $pRegex )
         {
             $this->setRegex( $pRegex );
         }
         
         
         /**
          * Validate the given data to this regex
          * 
          * @param string $pData
          * @return boolean
          */
         public function validate( $pData ) 
         {
              return preg_match($this->strRegex, $pData);
         }
         
         
         /**
          * Sets the regex
          * 
          * @param string $pValue
          */
         public function setRegex( $pValue )
         {
             $this->strRegex = $pValue;
         }
         
     }