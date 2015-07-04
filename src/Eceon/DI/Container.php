<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Container.php 259 2015-02-22 14:32:35Z ted $
     * $package Eceon/DI
     */

    namespace Eceon\DI;
    
    class Container
    {
        /**
         * The parameters
         *
         * @var string[]
         */
        protected $arrParameter = array();        
        
        /**
         * Array of all loaded services
         *
         * @var mixed[] 
         */
        protected $arrServices = array();
        
        /**
         * Array of service definitions
         *
         * @var Definition[] 
         */
        protected $arrDefinition = array();
        
        
        /**
         * Array that holds the id's of services that are currently being loaded
         *
         * @var string[]
         */
        protected $arrLoadedIDs = array();
        
        
        /**
         * 
         * Creates a dependency injector container. If an id is given, this 
         * container will load itself into the service array
         * 
         * @param string $pSelfServiceId [optional]
         */
        public function __construct( $pSelfServiceId = '' ) 
        {
            if( $pSelfServiceId != '' )
            {
                $this->addService( $pSelfServiceId , $this );
            }
        }
        
        
        
        
        /**
         * Adds a parameter to the container
         * 
         * @param string $pKey
         * @param mixed $pValue
         * @return Container
         */
        public function addParameter( $pKey, $pValue )
        {
            $this->arrParameter[ strtolower( $pKey ) ] = $pValue;
            
            return $this;
        }
        
        
        /**
         * Gets a parameter by key, returns null if key doesnt exists
         * 
         * @param string $pKey
         * @return mixed
         */
        public function getParameter( $pKey )
        {
            if( isset( $this->arrParameter[$pKey] ) === true )
            {
                return $this->arrParameter[$pKey];
            }
            
            return null;
        }
        
        
        /**
         * Adds a service to the container
         * 
         * @param string $pID
         * @param mixed $pClass
         * @return Container
         */
        public function addService( $pID, $pClass )
        {
            $this->arrServices[$pID] = $pClass;
            
            return $this;
        }
        
        /**
         * Gets a service by id, returns null if no service is found
         * 
         * @param string $pID
         * @return mixed
         */
        public function getService( $pID )
        {
            if( isset( $this->arrServices[$pID] ) === true )
            {
                return $this->arrServices[$pID];
            }
            
            return null;
        }
        
        
        /**
         * Register a definition to the container
         * 
         * @param string $pID
         * @param string $pClassName
         * @return Definition
         */
        public function register( $pID, $pClassName )
        {
            // create definition based on id and classname
            $definition = new Definition( $pID, $pClassName );

            // add definition to the definition array
            $this->arrDefinition[$pID] = $definition;
            
            // return definition
            return $definition;
        }
        
        
        /**
         * Gets a definition by id, returns null if no service is found
         * 
         * @param string $pID
         * @return mixed
         */        
        public function getDefinition( $pID )
        {
            if( isset( $this->arrDefinition[$pID] ) === true )
            {
                return $this->arrDefinition[$pID];
            }
            
            return null;
        }
        
        
       /**
         * Check if a definition exists by id
         * 
         * @param string $pId
         * @return boolean
         */
        public function definitionExists( $pId )
        {
            return isset( $this->arrDefinition[$pId] );
        }
               
        
        
        /**
         * Loads a services
         * 
         * @param string $pServiceID
         * @param boolean $pRecreate [optional] recreate an new service instead of loading it from cache
         * @return mixed
         */
        public function load( $pServiceID, $pRecreate = false )
        {
            // if services is already being loaded atm, throw exception
            if( isset( $this->arrLoadedIDs[$pServiceID] ) === true )
            {
                throw new \Exception( 'Service ' . $pServiceID . ' is creating a infinity loop, aborted' );
            }
            
            
            // services has been loaded before, give out that one 
            if( isset( $this->arrServices[$pServiceID] ) === true && $pRecreate == false) 
            {
                return $this->arrServices[$pServiceID];
            }
            
            
            
            // is there a definition of the service?
            if( isset( $this->arrDefinition[$pServiceID] ) === false )
            {
                throw new \Exception('Definition of ' . $pServiceID . ' not found in container');
            }
            
            // get definition
            $definition = $this->arrDefinition[$pServiceID];

            
            
            // add the service id to the loading array
            $this->arrLoadedIDs[$pServiceID] = true;
            
            // create reflection class
            $rflClass = new \ReflectionClass( $definition->getClassName() );
            
            // build constructor arguments
            $constructArguments = $this->buildArguments( $definition->getConstructArguments() );

            // create service class
            if( count( $constructArguments ) > 0 )
            {
                /**
                 * @todo: array wordt mee gestuurd..
                 */
                
                $serviceClass = $rflClass->newInstanceArgs( $constructArguments );
            } else {
                $serviceClass = $rflClass->newInstance();
            }

            
            // call methods on the class
            foreach( $definition->getMethodCalls() as $call)
            {
                if( is_callable( array( $serviceClass, $call['method']) ) === false )
                {
                    throw new \Exception( 'The method ' . $call['method'] . ' does not exists in class ' . get_class( $serviceClass ) );
                }
                
                
                // build method arguments
                $methodArguments = $this->buildArguments( $call['parameter'] );
                
                // call method on class
                call_user_func_array( array( $serviceClass, $call['method'] ), $methodArguments );
            }
            
            // add class to service array
            $this->arrServices[$pServiceID] = $serviceClass;
            
            
            // done loading the service, remove from the list
            unset($this->arrLoadedIDs[$pServiceID]);
            
            
            // return service class
            return $serviceClass;
        }
        
        
        /**
         * Builds arguments based on an array. Convert references
         * 
         * @param array $pArguments
         * @return array
         */
        protected function buildArguments( $pArguments = array() )
        {
            $arguments = array();
            
            foreach($pArguments as $argument)
            {
                // service reference
                if( $argument instanceof ServiceReference )
                {
                    $arguments[] = $this->load( $argument->getID() );

                // parameter reference
                } elseif( $argument instanceof ParameterReference) {
                    
                    $arguments[] = $this->getParameter( $argument->getID() );
                    
                // string | int
                } else {
                    $arguments[] = $argument;
                }
            }

            return $arguments;
        }
        
        
        
    }