<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractController.php 359 2015-06-02 09:37:25Z ted $
     * $package Eceon/MVC/Controller
     */

    namespace Eceon\MVC\Controller;

    use Eceon\MVC\Model\Service\InterfaceService;
    use Eceon\MVC\View\InterfaceView;
    use Eceon\Request\InterfaceRequest;
    
    abstract class AbstractController implements InterfaceController
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
         * Executes the given request object
         * 
         * @param string $pAction
         * @param InterfaceRequest $pRequest
         * @throws Exception 
         */
        public function execute( $pAction, InterfaceRequest $pRequest )
        {
            if( is_callable( array( $this, $pAction . 'Action' ) ) === false )
            {
                throw new \Exception( 'Cannot find command ' . $pAction . 'Action in ' . get_class( $this ) );
            }
            
            // execute function
            call_user_func( array( $this, $pAction . 'Action' ), $pRequest );
        }
        
        
        
        /**
         * Magic call function, use for helpers
         * 
         * @param string $pName
         * @param string $pParams
         * @return mixed
         */
        public function __call( $pName, $pParams )
        {
            if( $this->getHelperManager() !== null )
            {
                $helper = $this->getHelperManager()->getHelper( $pName );

                if( $helper !== null )
                {
                    return call_user_func_array( array($helper, 'helper'), $pParams);
                }
            }
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
                throw new \Exception( 'ControllerHelper ' .$pName . ' not found!' );
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