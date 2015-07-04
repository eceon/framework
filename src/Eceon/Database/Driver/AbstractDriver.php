<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractDriver.php 222 2015-02-12 22:00:42Z ted $
     * $package Eceon/Database/Driver
     */

    namespace Eceon\Database\Driver;

    
    abstract class AbstractDriver implements InterfaceDriver
    {
        /**
         * @var string 
         */
        protected $strHost = '';

        /**
         * @var string 
         */
        protected $strUsername = '';

        /**
         * @var string 
         */
        protected $strPassword = '';

        /**
         * @var string 
         */
        protected $strDatabase = '';

        /**
         * @var string 
         */
        protected $strCharset = 'utf8';

        
        
        /**
         * @var mixed
         */
        protected $objConnection = null;


        /**
         * Constructor
         * 
         * @param string $pHost
         * @param string $pUsername
         * @param string $pPassword
         * @param string $pDatabase
         * @param string $pCharset
         */
        public function __construct( $pHost, $pUsername, $pPassword, $pDatabase, $pCharset = 'utf8' )
        {
            $this->setHost( $pHost );
            $this->setUsername( $pUsername );
            $this->setPassword( $pPassword );
            $this->setDatabase( $pDatabase );	
            $this->setCharset( $pCharset );
        }

        
        
        /**
         * Checks if there is an active connection
         * 
         * @return boolean
         */
        public function isConnected()
        {
            if( $this->objConnection === null || $this->objConnection === false )
            {
                return false;
            }
            
            return true;
        }

        /**
         * Set of hostname of the database server
         *
         * @param string $pHost
         */
        public function setHost( $pHost )
        {
            $this->strHost = $pHost;
        }

        /**
         * Gets the hostname of the database server
         *
         * @return string
         */
        public function getHost()
        {
            return $this->strHost;
        }


        /**
         * Sets the username of the database server
         *
         * @param string $pUsername
         */
        public function setUsername( $pUsername )
        {
            $this->strUsername = $pUsername;
        }

        /**
         * Gets the username of the database server
         *
         * @return string
         */
        public function getUsername()
        {
            return $this->strUsername;
        }


        /**
         * Sets the password of the database server
         *
         * @param string $pPassword
         */
        public function setPassword( $pPassword )
        {
            $this->strPassword = $pPassword;
        }

        /**
         * Gets the password of the database server
         *
         * @return string
         */
        public function getPassword()
        {
            return $this->strPassword;
        }

        /**
         * Sets the name of the database to use
         *
         * @param string $pDatabase
         */
        public function setDatabase( $pDatabase )
        {
            $this->strDatabase = $pDatabase;
        }

        /**
         * Gets the database name
         *
         * @return string
         */
        public function getDatabase()
        {
            return $this->strDatabase;
        }

        
        /**
         * Sets the charset for the database connection
         *
         * @param string $pCharset
         */
        public function setCharset( $pCharset )
        {
            $this->strCharset = $pCharset;
        }

        /**
         * Gets the charset for the database connection
         *
         * @return string
         */
        public function getCharset()
        {
            return $this->strCharset;
        }
        
        
        
        /**
         * executes a sql query and returns a resource on SELECT, SHOW, DESCRIBE
         * and EXPLAIN statements. returns a boolean on INSERT, UPDATE, DELETE
         * and DROP statements. 
         * 
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return resource|boolean
         */
        abstract protected function query( $pSQL, $pParam = array() );        
        
    }