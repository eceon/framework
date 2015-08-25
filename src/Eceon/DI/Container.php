<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * $package Eceon/DI
     */

    namespace Eceon\DI;
    
    class Container
    {
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
        protected $arrLoadedId = array();        
        
        
        
        
        
       /**
         * Register a definition to the container
         * 
         * @param string $pId
         * @param string $pClassName
        * 
         * @return Definition
         */
        public function register( $pId, $pClassName )
        {
            // create a new definition
            $definition = new Definition( $pClassName );
            
            // add definition to the definition array
            $this->addDefinition( $pId , $definition );
            
            // return definition
            return $definition;
        }        

        
        /**
         * Adds a definition to the container
         * 
         * @param type $pId
         * @param \Eceon\DI\Definition $pDefinition
         */
        public function addDefinition( $pId, Definition $pDefinition )
        {
            // convert the definition id to lower case. 
            $id = strtolower( $pId );
            
            // add definition to the definition array
            $this->arrDefinition[$id] = $pDefinition;
        }
        
        
        /**
         * Gets a definition by id, returns null if no service is found
         * 
         * @param string $pId
         * 
         * @return Definition|null
         */        
        public function getDefinition( $pId )
        {
            $id = strtolower( $pId );
            
            if( $this->hasDefinition( $id ) === false )
            {
                return null;
            }
            
            return $this->arrDefinition[$id];
        }
        
        
       /**
         * Check if a definition exists by id
         * 
         * @param string $pId
         * @return boolean
         */
        public function hasDefinition( $pId )
        {
            $id = strtolower( $pId );
            
            return isset( $this->arrDefinition[$id] );
        }
        
        
        
        
        
        
        public function get( $pId )
        {
            // if services is already being loaded atm, throw exception
            if( isset( $this->arrLoadedId[$pId] ) === true )
            {
                throw new \Exception( 'Service ' . $pId . ' is creating a infinity loop, aborted' );
            }

            // get the definition
            $definition = $this->getDefinition( $pId );

            
            // is there a definition of the service?
            if( $definition === null )
            {
                throw new \Exception( 'Definition of ' . $pId . ' not found in container' );
            }
            
            // add the service id to the loading array
            $this->arrLoadedId[$pId] = true;

            
            // create service from definition
            $service = $this->createService( $definition );

            
            // done loading the service, remove from the list
            unset( $this->arrLoadedId[$pId] );
            
            // return service
            return $service;
            
        }
        
        
        
        
        protected function createService( Definition $pDefinition )
        {
               
            // create reflection class
            $rflClass = new \ReflectionClass( $pDefinition->getClassName() );
            

            // create service with constructor arguments
            if( $pDefinition->hasConstructArguments() === true )
            {
                // build constructor arguments
                $constructArguments = $this->buildArguments( $pDefinition->getConstructArguments() );
                
                // build service
                $serviceClass = $rflClass->newInstanceArgs( $constructArguments );

                
            // create service without construct arguments    
            } else {

                // build service
                $serviceClass = $rflClass->newInstance();
            }

            
            // call methods on the class
            foreach( $pDefinition->getMethodCalls() as $methodName => $arguments )
            {
                $this->callMethod( $serviceClass, $methodName, $arguments );
            }            
            
            
            // return service
            return $serviceClass;
        }
        
        
        protected function callMethod( $pService, $pMethodName, $pArguments = array() )
        {
            if( is_callable( array( $pService, $pMethodName) ) === false )
            {
                throw new \Exception( 'The method ' . $pMethodName . ' does not exists in class ' . get_class( $pService ) );
            }

            // build method arguments
            $methodArguments = $this->buildArguments( $pArguments );

            // call method on class
            call_user_func_array( array( $pService, $pMethodName ), $methodArguments );            
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
                if( $argument instanceof DefinitionReference )
                {
                    $arguments[] = $this->get( $argument->getID() );

                // string | int
                } else {
                    $arguments[] = $argument;
                }
            }

            return $arguments;
        }        
        
  
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
                // $this->( $pSelfServiceId , $this );
            }
        }
        

        
 
        
        

        
        
         

      
        
        
    }