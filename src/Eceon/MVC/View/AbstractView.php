<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractView.php 200 2015-01-15 16:23:06Z ted $
     * $package Eceon/MVC/View
     */

    namespace Eceon\MVC\View;

    use Eceon\MVC\Model\Service\Factory as ServiceFactory;
    use Eceon\Response\InterfaceResponse;
    use Eceon\MVC\View\Form\InterfaceForm;
    
    abstract class AbstractView implements InterfaceView
    {
        
        /**
         * @var string 
         */
        protected $strTemplatePath = '';
        
        
        /**
         * @var ServiceFactory
         */
        protected $objServiceFactory = null;

        
        /**
         * @var InterfaceResponse
         */
        protected $objResponse = null;

        
        /**
         * @var array parameters
         */
        protected $arrParam = array();        
        
        
        /**
         * @var Helper\InterfaceHelper 
         */
        protected $objHelperManager = null;
        
     
        /**
         * @var InterfaceForm;
         */
        protected $objForm = null;
        
        
        
        
        
        /**
         * Renders the view template and returns the output
         */        
        public function render()
        {
         
            // load the template and return the content as string
            ob_start();
            include( $this->getTemplatePath() );
            $content = ob_get_clean(); 

            // return the content
            return $content;
        }        
        
        

        
        
        
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
         * Sets the template path
         * 
         * @param type $pPath
         */
        public function setTemplatePath( $pPath )
        {
            $this->strTemplatePath = $pPath;
        }
        
        /**
         * Gets the template path
         * 
         * @return string
         */
        public function getTemplatePath()
        {
            return $this->strTemplatePath;
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
         * Sets the response object
         * 
         * @param InterfaceResponse $pResponse 
         */
        public function setResponse( InterfaceResponse $pResponse )
        {
            $this->objResponse = $pResponse;
        }
        
        /**
         * Gets the response object
         * 
         * @return InterfaceResponse
         */
        public function getResponse()
        {
            return $this->objResponse;
        }
        
        
        /**
         * adds a parameter to this view 
         * 
         * @param stirng $pKey
         * @param mixed $pValue
         * @return InterfaceView
         */
        public function setParam( $pKey, $pValue )
        {
            $this->arrParam[$pKey] = $pValue;
            
            return $this;
        }
        
        /**
         * Does this request object has the key parameter?
         *
         * @param string $pKey
         * @return boolean
         */
        public function hasParam( $pKey )
        {
            return isset( $this->arrParam[$pKey] );
        }

        /**
         * Gets a parameter value by key. Returns null if key is not set
         *
         * @param string $pKey
         * @param string $pDefault [optional]
         * @return string
         */
        public function getParam( $pKey, $pDefault = null )
        {
            if( $this->hasParam( $pKey ) )
            {
                return $this->arrParam[$pKey];
            }
            
            return $pDefault;
        }                

        
        /**
         * Sets the helper manager
         * 
         * @param Helper\Manager $pManager
         */
        public function setHelperManager( Helper\Manager $pManager)
        {
            $this->objHelperManager = $pManager;
        }
        
        /**
         * Gets the helper manager
         * 
         * @return Helper\Manager
         */
        public function getHelperManager()
        {
            return $this->objHelperManager;
        }
        
        
        
        /**
         * Sets the form
         * 
         * @param InterfaceForm $pForm
         */
        public function setForm( InterfaceForm $pForm )
        {
            $this->objForm = $pForm;
        }
        
        /**
         * Gets the form 
         * 
         * @return InterfaceForm
         */
        public function getForm()
        {
            return $this->objForm;
        }
        
    }