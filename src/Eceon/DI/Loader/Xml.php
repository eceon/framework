<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: XML.php 354 2015-06-01 13:44:53Z ted $
     * $package Eceon/DI/Loader
     */

    namespace Eceon\DI\Loader;
    
    use Eceon\DI\Definition;
    use Eceon\DI\DefinitionReference;
    
    
    class Xml extends AbstractLoader
    {
        /**
         * Parses a file and gets the contents as an array
         * 
         * @param string $pPath
         * @return array
         */        
        public function parse( $pPath )
        {
            // load xml and convert to simplexml element
            $xml = simplexml_load_file( $pPath );            
            
            // create services
            $this->parseServices( $xml->services );
        }
            
        
        /**
         * Parses services from the given XML Data
         * 
         * @param \SimpleXMLElement $pXmlData
         */
        protected function parseServices( \SimpleXMLElement $pXmlData )
        {
            if( isset( $pXmlData->service ) === false )
            {
                return;
            }
            
            // get each service
            foreach( $pXmlData->service as $xml_service )
            {
                // create new service
                $definition = new Definition( (string) $xml_service['class'] );
                
                // set constructor call
                $definition->setConstructArguments( $this->parseConstructorCall( $xml_service ) );
                
                // set method calls
                $definition->setMethodCalls( $this->parseMethodCalls( $xml_service ) );

                
                // add definition to the container
                $this->container()->addDefinition( (string) $xml_service['id'], $definition );
            }     
        }
        
        
        /**
         * Parses the constructor from the given XML data
         * 
         * @param SimpleXMLElement $pXmlData
         * 
         * @return array
         */
        protected function parseConstructorCall( \SimpleXMLElement $pXmlData )
        {
            if( isset( $pXmlData->construct ) === false )
            {
                return array();
            }
            
            return $this->parseArguments( $pXmlData->construct );
        }        
        
        
        
        /**
         * Parses the calls from the given XML data
         * 
         * @param SimpleXMLElement $pXmlData
         * 
         * @return array
         */
        protected function parseMethodCalls( \SimpleXMLElement $pXmlData )
        {
            $arrMethodCall = array();
            
            if( isset( $pXmlData->call ) === false )
            {
                return $arrMethodCall;
            }
            
            foreach( $pXmlData->call as $method_call )
            {
                $arrMethodCall[(string) $method_call['method']] = $this->parseArguments( $method_call );
            }
            
            return $arrMethodCall;
        }
        
        
        /**
         * Parses the arguments from the given XML Data
         * 
         * @param \SimpleXMLElement $pXmlData
         * @return array();
         */
        protected function parseArguments( \SimpleXMLElement $pXmlData )
        {
            // get arguments
            $arguments = array();
            
            if( isset($pXmlData->argument ) === false )
            {
                return null;
            }
            
            foreach( $pXmlData->argument as $argument )
            {
                switch( (string)$argument['type'] )
                {
                    case 'service':
                        $arguments[] = new DefinitionReference( (string)$argument['id'] );
                        break;

                    case 'array':
                        $argumentArrayData = array();

                        foreach( $argument->value as $value)
                        {
                            $argumentArrayData[(string) $value['key']] = (string) $value['data'];
                        }
                        $arguments[] = $argumentArrayData;

                        break;

                    default:
                        $arguments[] = (string) $argument['value'];
                        break;
                }
            }
            
            return $arguments;
        }
 
        
    }