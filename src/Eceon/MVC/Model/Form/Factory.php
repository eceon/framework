<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Factory.php 253 2015-02-19 13:58:19Z ted $
     * $package Eceon/MVC/Model/Form
     */
    
    namespace Eceon\MVC\Model\Form;
    
    use Eceon\DI\AbstractFactory;
    
    
    class Factory extends AbstractFactory
    {
        
        /**
         * Builds a Form Object
         * 
         * @param string $pModuleName
         * @param string $pObjectName
         * @return InterfaceForm
         */
        public function build( $pModuleName, $pObjectName )
        {
            // build Form id: <module>.form.<name>
            $formId = sprintf( 
                '%s.model.form.%s', 
                strtolower( $pModuleName ), 
                strtolower( $pObjectName ) 
            );

            // load Form
            $formClass = $this->getDiContainer()->load( $formId );
            
            // return Form
            return $formClass;            
        }
        
  
    }