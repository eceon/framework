<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Required.php 263 2015-02-22 16:33:51Z ted $
     * $package Eceon/MVC/Model/Form
     */

    namespace Eceon\MVC\Model\Form\Validator;
    
    use Eceon\MVC\Model\Form;

    class Required extends Form\AbstractValidator
    {
        /**
         * @var string
         */
        protected $strErrorMessage = 'Dit veld is verplicht';
        
        
        /**
         * Validates the data.
         * 
         * @param string $pData
         * @return boolean
         */
        public function validate( $pData )
        {
            return ( $pData != '' );
        }
        
    }
