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
    
    use Eceon\DI\Container;
    use Eceon\DI\ServiceReference;
    use Eceon\DI\ParameterReference;
    
    class XML implements InterfaceLoader
    {
        /**
         * Array of files that are loaded
         *
         * @var string[]
         */
        protected $arrFilesLoaded = array();
        
        
        
        /**
         * Loads and process a file and build up the di container
         * 
         * @param Container $pContainer
         * @param string $pPath
         */
        public function importFileIntoContainer( Container $pContainer, $pPath )
        {
            
            // resolve the xml_file
            $xml_file = stream_resolve_include_path( $pPath );
            
            
            // check if file exists on the system
            if( $xml_file === false)
            {
                throw new \Exception( "XML wire file '". $pPath ."' ('.$xml_file.') not found!" );
            }
            
            
            // check if file is allready loaded
            if( in_array( $xml_file, $this->arrFilesLoaded ) == true )
            {
                return;
            }
            
            
            // add file to loaded files
            $this->arrFilesLoaded[] = $xml_file;
            
            // load xml and convert to simplexml element
            $xml = simplexml_load_file( $xml_file );

            
            // load parameters
            if( isset( $xml->parameters ) === true )
            {
                foreach( $xml->parameters->parameter as $parameter )
                {
                    $pContainer->addParameter( (string) $parameter['key'], (string) $parameter['value'] );
                }
            }
            
            
            // load imports
            if( isset( $xml->imports ) === true )
            {
                foreach( $xml->imports->file as $wirefile )
                {
                    $this->importFileIntoContainer( $pContainer, $wirefile );
                }
            }            

            
            // load services
            if( isset( $xml->services ) === true )
            {
                foreach( $xml->services->service as $xml_service )
                {
                    $service = $pContainer->register( (string) $xml_service['id'], (string) $xml_service['class'] );
                    
                    // load method calls for service
                    if( isset( $xml_service->call ) === true)
                    {
                        foreach( $xml_service->call as $method_call )
                        {
                            
                            // get arguments
                            $arguments = array();
                            foreach( $method_call->argument as $argument )
                            {
                                switch( (string)$argument['type'] )
                                {
                                    case 'service':
                                        $arguments[] = new ServiceReference( $argument['id'] );
                                        break;
                                    
                                    case 'parameter':
                                        $arguments[] = new ParameterReference( $argument['id'] );
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
                            
                            if( (string) $method_call['method'] == 'construct' )
                            {
                                $service->setConstructArguments( $arguments );
                            } else {
                                $service->addMethodCall( (string) $method_call['method'], $arguments );
                            }
                        }
                    }
                    
                    
                    // inject service into an other loaded service
                    if( isset( $xml_service->inject ) === true )
                    {
                        
                        if( isset( $xml_service->inject['id']) === false || isset( $xml_service->inject['method'] ) === false )
                        {
                            throw new \Exception('Injection of a servince needs a service id and method');
                        }
                        
                        // get the service to be injected to
                        $other_service = $pContainer->getDefinition( (string)$xml_service->inject['id'] );
                        
                        // get arguments
                        $arguments = array();
                        foreach( $xml_service->inject->argument as $argument )
                        {
                            switch( (string)$argument['type'] )
                            {
                                case 'service':
                                    $arguments[] = new ServiceReference( $argument['id'] );
                                    break;

                                case 'parameter':
                                    $arguments[] = new ParameterReference( $argument['id'] );
                                    break;

                                case 'this':
                                    $arguments[] = new ServiceReference( (string) $xml_service['id'] );

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
                        
                        // no arguments given in wire file
                        if( count( $arguments ) == 0 )
                        {
                            $arguments[] = new ServiceReference( (string) $xml_service['id'] );
                        }
                        
                        // add inject method call
                        $other_service->addMethodCall( (string) $xml_service->inject['method'], $arguments );    
                        
                    }
                }
            } // end load services
            
            
          
            
        }
        
        
    }