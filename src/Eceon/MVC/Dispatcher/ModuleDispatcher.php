<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: ModuleDispatcher.php 355 2015-06-02 09:29:16Z ted $
     * $package Eceon/MVC/Dispatcher
     */

    namespace Eceon\MVC\Dispatcher;

    use Eceon\DI\Container;
    use Eceon\MVC\Controller\InterfaceController;
    use Eceon\Request\InterfaceRequest;
    use Eceon\Response\InterfaceResponse;
    
    
    
    class ModuleDispatcher extends AbstractDispatcher
    {
        /**
         * @var Container
         */
        protected $objDiContainer = null;
        
        /**
         * @var string
         */
        protected $strDefaultModule = 'system';
        
        /**
         * @var string
         */
        protected $strDefaultController = 'controller';
        
        /**
         * @var string
         */
        protected $strDefaultAction = 'listing';
        
        
        
        
        /**
         * Dispatch request 
         */
        public function dispatch( InterfaceRequest $pRequest, InterfaceResponse $pResponse )
        {
            // loads the controller
            $controller = $this->getController( $pRequest );
            
            
            if( $this->viewExists( $pRequest ) === true )
            {
                // load view
                $view = $this->getView( $pRequest );
                $controller->setView( $view );

                // execute controller
                $controller->execute( 
                    $pRequest->getParam( 'action', $this->getDefaultAction() ), 
                    $pRequest 
                );

                if( $pResponse->getStatus() == 200)
                {
                    // render view
                    $pResponse->appendResponse( $view->render() );
                }
            } else {
                
                // only execute controller
                $controller->execute( 
                    $pRequest->getParam( 'action', $this->getDefaultAction() ), 
                    $pRequest 
                );
            }
            
        }                
        
        
        /**
         * Loads a controller based on the module and controller name from the di container
         * 
         * @param InterfaceRequest $pRequest
         * @return InterfaceController
         */
        protected function getController( InterfaceRequest $pRequest ) 
        {
            // build controller id: <module>.controller.<controller>
            $controllerId = sprintf( 
                                '%s.controller.%s', 
                                strtolower( $pRequest->getParam( 'module', $this->getDefaultModule() ) ), 
                                strtolower( $pRequest->getParam( 'controller', $this->getDefaultController() ) ) 
                            );
            
            // load controller
            $controllerClass = $this->getDiContainer()->load( $controllerId );
            
            // return controller
            return $controllerClass;
        }
    
        
        /**
         * Loads a view based on the module, controller and action from the di container
         * 
         * @param InterfaceRequest $pRequest
         * @return InterfaceView
         */
        protected function getView( InterfaceRequest $pRequest ) 
        {
            // build view id: <module>.view.<controller>.<action>
            $viewId = sprintf( 
                                '%s.view.%s.%s', 
                                strtolower( $pRequest->getParam( 'module', $this->getDefaultModule() ) ), 
                                strtolower( $pRequest->getParam( 'controller', $this->getDefaultController() ) ),
                                strtolower( $pRequest->getParam( 'action', $this->getDefaultAction() ) )
                            );
            
            // load view
            $viewClass = $this->getDiContainer()->load( $viewId );
            
            // return view
            return $viewClass;
        }        
      
        
        /**
         * Checks if a view exists in the DI container
         * 
         * @param InterfaceRequest $pRequest
         * @return boolean
         */
        protected function viewExists( InterfaceRequest $pRequest )
        {
            // build view id: <module>.view.<controller>.<action>
            $viewId = sprintf( 
                                '%s.view.%s.%s', 
                                strtolower( $pRequest->getParam( 'module', $this->getDefaultModule() ) ), 
                                strtolower( $pRequest->getParam( 'controller', $this->getDefaultController() ) ),
                                strtolower( $pRequest->getParam( 'action', $this->getDefaultAction() ) )
                            );
            
            // load view
            return $this->getDiContainer()->definitionExists( $viewId );
        }
        
        
        
        
        
        /**
         * Sets the dependecy injector container
         * 
         * @param Container $pContainer
         */
        public function setDiContainer( Container $pContainer )
        {
            $this->objDiContainer = $pContainer;
        }
        
        /**
         * Gets the dependecy injector container
         * 
         * @return Container
         */
        public function getDiContainer()
        {
            return $this->objDiContainer;
        }
        
        
        /**
         * Sets the default module to load, used when no module is set in 
         * the request
         * 
         * @param string $pDefaultModule
         */
        public function setDefaultModule( $pDefaultModule )
        {
            $this->strDefaultModule = $pDefaultModule;
        }
        
        /**
         * Gets the default module to load
         * 
         * @return string
         */
        public function getDefaultModule()
        {
            return $this->strDefaultModule;
        }
        
        
        /**
         * Sets the default controller to load, used when no controller is set
         * in the request
         * 
         * @param string $pDefaultController
         */
        public function setDefaultController( $pDefaultController )
        {
            $this->strDefaultController = $pDefaultController;
        }
        
        /**
         * Gets the default controller to load
         * 
         * @return string
         */
        public function getDefaultController()
        {
            return $this->strDefaultController;
        }
        
        
        /**
         * Sets the default action to run, used when no action is set in the
         * request object
         * 
         * @param string $pDefaultAction
         */
        public function setDefaultAction( $pDefaultAction )
        {
            $this->strDefaultAction = $pDefaultAction;
        }
        
        /**
         * Gets the default action to run
         * 
         * @return string
         */
        public function getDefaultAction()
        {
            return $this->strDefaultAction;
        }
    }