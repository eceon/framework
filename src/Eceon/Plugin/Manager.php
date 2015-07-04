<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Manager.php 222 2015-02-12 22:00:42Z ted $
     * $package Eceon/Plugin
     */

    namespace Eceon\Plugin;

    class Manager
    {
        /**
         * @var InterfacePlugin[]
         */
        protected $arrPlugin = array();
        
        
        /**
         * Adds a plugin 
         * 
         * @param InterfacePlugin $pPlugin
         * @param int $pPriority 
         */
        public function addPlugin( InterfacePlugin $pPlugin, $pPriority = 0 )
        {
            if( is_array($pPriority) == true )
            {
                $pPriority = 0;
            }
            
            // if priority is zero, set the priority to the amount of items + 1
            if( $pPriority == 0 )
            {
                $pPriority = count( $this->arrPlugin );
            }
            
            // if prority is already set with a plugin, increase the priority with 1
            while( isset( $this->arrPlugin[$pPriority] ) === true )
            {
                $pPriority++;
            }
            
            $this->arrPlugin[$pPriority] = $pPlugin;
        }

        
        /**
         * Runs trough all plugin and execute the event (if exists)
         * 
         * @param string $pEventName
         * @param array $pArguments [optional]
         */
        public function triggerEvent( $pEventName, $pArguments = array() )
        {
            foreach( $this->arrPlugin as $plugin )
            {
                if(  is_callable( array( $plugin, $pEventName ) ) == true )
                {
                    call_user_func_array( array( $plugin, $pEventName ), $pArguments );
                }
            }
        }
        
        
    }