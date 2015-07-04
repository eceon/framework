<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: PHPConfig.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Config
     */

    namespace Eceon\Config;

    class PHPConfig extends AbstractConfig
    {
        public function __construct( $pConfigFile = '' )
        {
            if( $pConfigFile != '' )
            {
                $this->parseFile( $pConfigFile );
            }

            parent::__construct();
        }

        public function parseFile( $pConfigFile )
        {
            $this->addData( include $pConfigFile );
        }


        public function addData( $pData )
        {
            foreach ( $pData as $key => $value )
            {
                if( is_array( $value ) )
                {
                    if( isset( $this->arrData[$key] ) === false )
                    {
                        $this->arrData[$key] = new ConfigPHP();
                    }

                    $this->arrData[$key]->addData( $value );
                } else {
                    $this->arrData[$key] = $value;
                }
            }
        }
    }
