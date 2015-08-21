<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * $package Eceon/MVC/Controller
     */

    namespace Eceon\MVC\Controller;

    use Eceon\MVC\Model\Service\InterfaceService;
    use Eceon\MVC\View\InterfaceView;

    
    abstract class AbstractAction implements InterfaceAction
    {
        /**
         * @var Helper\InterfaceHelper[]
         */
        protected $arrHelper = array();
        
        /**
         * @var InterfaceService[]
         */
        protected $arrService = array();
        
        /**
         * @var InterfaceView
         */
        protected $objView = null;
        


        /**
         * Magic call function, use for helpers
         * 
         * @param string $pName
         * @param string $pParams
         * @return mixed
         */
        public function __call( $pName, $pParams )
        {
            $helper = $this->getHelper( $pName );
            
            if( $helper === null )
            {
                throw new \Exception( 'ActionHelper ' .$pName . ' not found!' );
            }
            
            return call_user_func_array( array($helper, 'helper'), $pParams);
        }        
        
        

        /**
         * Adds a helper to this controller
         * 
         * @param string $pName
         * @param Helper\InterfaceHelper $pHelper
         */
        public function addHelper( $pName, Helper\InterfaceHelper $pHelper)
        {
            $this->arrHelper[$pName] = $pHelper;
        }
        
        /**
         * Gets the helper based on the given name. Throws an exception if the
         * helper is not found
         * 
         * @param string $pName
         * @return Helper\InterfaceHelper
         * @throws \Exception
         */
        public function getHelper( $pName )
        {
            if( isset( $this->arrHelper[$pName] ) === false )
            {
                return null;
            }
            
            return $this->arrHelper[$pName];
        }
        
        /**
         * @see getHelper()
         * @param string $pName
         * @return Helper\InterfaceHelper
         */
        public function helper( $pName )
        {
            return $this->getHelper( $pName );
        }
        
                
        

        /**
         * Adds a service to this controller
         * 
         * @param string $pName
         * @param InterfaceService $pService
         */
        public function addService( $pName, InterfaceService $pService)
        {
            $this->arrService[$pName] = $pService;
        }
        
        /**
         * Gets the service based on the given name. return null if the service
         * is not found
         * 
         * @param string $pName
         * @return InterfaceService|null
         */
        public function getService( $pName )
        {
            if( isset( $this->arrService[$pName] ) === false )
            {
                return null;
            }
            
            return $this->arrService[$pName];
        }
        
        
        
        /**
         * Sets the view 
         * 
         * @param InterfaceView $pView 
         */
        public function setView( InterfaceView $pView )
        {
            $this->objView = $pView;
        }
        
        /**
         * Gets the view
         * 
         * @return InterfaceView
         */
        public function getView()
        {
            return $this->objView;
        }
        
        /**
         * Gets the view
         * 
         * @see getView()
         * @return InterfaceView
         */
        public function view()
        {
            return $this->objView;
        }
        
      
        

        
        


    }