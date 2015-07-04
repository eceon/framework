<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Ini.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Config
     */

    namespace Eceon\Config;

    class Ini extends AbstractConfig
    {

        public function __construct( $pConfigfile = '' )
        {
            if( $pConfigfile != '' )
            {
                $this->parseFile( $pConfigfile );
            }
        }


        public function parseFile( $pConfigFile )
        {
            // open the config file
            // @todo: exception for not finding config file?
            $contents = file( $pConfigFile );

            // loop through all lines of the config file
            foreach ( $contents as $line )
            {
                // strip away the comment
                if( strpos( $line, ';' ) !== false )
                {
                    $line = substr($line, 0, strpos($line, ';'));
                }
                
                // continue if line is empty
                if( trim( $line ) == '' )
                {
                    continue;
                }
         
                // create a key/value from the config line
                $key = substr($line, 0, strpos($line, ' ='));
                $value = trim(substr($line, strpos($line, '= ')+2));

                // add the key/value to this config object
                $this->set($key, $value);
            }		
        }


        /**
         * Set the key/value.
         * 
         * @param string $key
         * @param string|interger $value
         * @return null
         * @throws \Exception
         */
        public function set( $pKey, $pValue )
        {
            // set the value if the key is not defined with sections
            if( strpos( $pKey, '.' ) === false )
            {
                $this->arrData[$pKey] = $pValue;
                return;
            }	

            // key value has one or more sections. Retrieve the first section
            // example:  foo.bar.name = test   
            //           foo will be the section
            //           send bar.name = test to the child config object (repeat process)
            $section = substr( $pKey, 0, strpos($pKey, '.') );
            
    
            // if section doesnt exists, create a new section with an new config object
            if( isset( $this->arrData[$section] ) === false)
            {
                $this->arrData[$section] = new Ini();
            }
            
            // section exists, but isnt a config object?
            if( ( $this->arrData[$section] instanceof Ini ) === false )
            {
                throw new \Exception('Config key ' . $section . ' was set as value!');
            }
                
            // deligate the new key/value to the child config object
            $this->arrData[$section]->set( substr( $pKey, strpos( $pKey, '.' ) +1 ), $pValue );
        }		
    }
