<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Text.php 261 2015-02-22 16:24:05Z ted $
     * $package Eceon/MVC/Model/Form
     */

    namespace Eceon\MVC\Model\Form\Input;
    
    use Eceon\MVC\Model\Form;

    class Text extends Form\AbstractInput
    {
        public function __construct( $pName )
        {
            $this->setName( $pName );
        }
    }
