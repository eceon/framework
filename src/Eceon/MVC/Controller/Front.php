<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Front.php 325 2015-03-27 15:53:19Z ted $
     * $package Eceon/MVC/Controller
     */

    namespace Eceon\MVC\Controller;

    use Eceon\MVC\Dispatcher\InterfaceDispatcher;
    use Eceon\Request\InterfaceRequest;
    use Eceon\Response\InterfaceResponse;
    use Eceon\Plugin\Manager as PluginManager;
    use Eceon\Router\InterfaceRouter;
    
    class Front
    {
        /**
         * @var InterfaceDispatcher
         */
        protected $objDispatcher = null;
        
        /**
         * @var PluginManager
         */
        protected $objPluginManager = null;
        
        /**
         * @var InterfaceRouter
         */
        protected $objRouter = null;
        
        
        /**
         * constructor
         */
        public function __construct(){}
        
        
        /**
         * Run the front controller 
         * 
         * @param InterfaceRequest $pRequest
         * @param InterfaceResponse $pResponse
         */
        public function run( InterfaceRequest $pRequest, InterfaceResponse $pResponse )
        {
            
            /**
             * ROUTE
             */
            
            // trigger before route event            
            $this->triggerEvent( 'onBeforeRoute', array( $pRequest, $pResponse ) );
            
            // if router exists, route command
            if( $this->getRouter() != null )
            {
                // route command
                $this->getRouter()->route( $pRequest );
            }

            // trigger after route event            
            $this->triggerEvent( 'onAfterRoute', array( $pRequest, $pResponse ) );

            
            
            /**
             * DISPATCH
             */
            
            // trigger before dispatch event
            $this->triggerEvent( 'onBeforeDispatch', array( $pRequest, $pResponse ) );
            
            // dispatch the dispatcher
            $this->getDispatcher()->dispatch( $pRequest, $pResponse );    

            // trigger after dispatch event            
            $this->triggerEvent( 'onAfterDispatch', array( $pRequest, $pResponse ) );

            
            
            
            /**
             * RESPONSE
             */

            // trigger before send response event            
            $this->triggerEvent( 'onBeforeSendResponse', array( $pRequest, $pResponse ) );
            
            // output response
            $pResponse->sendResponse();
            
            // trigger after send reponse event            
            $this->triggerEvent( 'onAfterSendResponse', array( $pRequest, $pResponse ) );
            
        }
        
        
        /**
         * Sets the dispatcher
         * 
         * @param InterfaceDispatcher $pDispatcher 
         * @return Front
         */
        public function setDispatcher( InterfaceDispatcher $pDispatcher )
        {
            $this->objDispatcher = $pDispatcher;
            
            return $this;
        }
        
        /**
         * Gets the dispatcher
         * 
         * @return InterfaceDispatcher
         */
        public function getDispatcher()
        {
            return $this->objDispatcher;
        }
        
        
        
        /**
         * Sets the plugin manager
         * 
         * @param PluginManager $pManager 
         * @return Front
         */
        public function setPluginManager( PluginManager $pManager )
        {
            $this->objPluginManager = $pManager;
            
            return $this;
        }
        
        /**
         * Gets the plugin manager
         * 
         * @return PluginManager
         */
        public function getPluginManager()
        {
            return $this->objPluginManager;
        }
        
        
        /**
         * Triggers an event 
         * 
         * @param string $pEvent
         * @param \ArrayObject $pData
         */
        private function triggerEvent( $pEvent, $pData )
        {
            // if plugin manager is set, trigger event
            if($this->getPluginManager() != null)
            {
                $this->getPluginManager()->triggerEvent( $pEvent, $pData );
            }            
        }
        
        
        
        /**
         * Sets the router object
         * 
         * @param InterfaceRouter $pRouter
         * @return Front
         */
        public function setRouter( InterfaceRouter $pRouter )
        {
            $this->objRouter = $pRouter;
            
            return $this;
        }
        
        /**
         * Gets the router
         * 
         * @return InterfaceRouter
         */
        public function getRouter()
        {
            return $this->objRouter;
        }
        
        
    }