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

    use Eceon\MVC\Model\Service\Factory as ServiceFactory;
    use Eceon\MVC\View\InterfaceView;
    use Eceon\Request\InterfaceRequest;
    
    abstract class AbstractController implements InterfaceController
    {
        /**
         * @var ServiceFactory
         */
        protected $objServiceFactory = null;
        
        /**
         * @var InterfaceView
         */
        protected $objView = null;
        
        /**
         * @var Helper\Manager
         */
        protected $objHelperManager = null;
        
        
        
        
    
        /**
         * Executes the given request object
         * 
         * @param string $pAction
         * @param InterfaceRequest $pRequest
         * @throws Exception 
         */
        public function execute( $pAction, InterfaceRequest $pRequest )
        {
            if( is_callable( array( $this, 'action' . $pAction ) ) === false )
            {
                throw new \Exception( 'Cannot find command ' . $pAction . ' in ' . get_class( $this ) );
            }
            
            // execute function
            call_user_func( array( $this, 'action' . $pAction ), $pRequest );
        }
        
        

        
        
        
        /**
         * Sets the ServiceFactory
         * 
         * @param ServiceFactory $pFactory
         */
        public function setServiceFactory( ServiceFactory $pFactory )
        {
            $this->objServiceFactory = $pFactory;
        }
        
        
        /**
         * Get the ServiceFactory
         * 
         * @return ServiceFactory
         */
        protected function getServiceFactory()
        {
            return $this->objServiceFactory;
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
        
        
        
        
        /**
         * Sets the helper manager
         * 
         * @param Helper\Manager $pManager
         */
        public function setHelperManager( Helper\Manager $pManager ) 
        {
            $this->objHelperManager = $pManager;
        }
        
        /**
         * 
         * @return Helper\Manager
         */
        public function getHelperManager()
        {
            return $this->objHelperManager;
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
         * @see getHelperManager->getHelper()
         * @param string $pName
         * @return Helper\InterfaceHelper
         */
        public function helper( $pName )
        {
            return $this->getHelperManager()->getHelper( $pName );
        }
        
        

    }