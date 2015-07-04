<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: InterfaceDriver.php 276 2015-02-26 11:10:17Z ted $
     * $package Eceon/Database/Driver
     */

    namespace Eceon\Database\Driver;

    interface InterfaceDriver
    {
        /**
         * Connects with the database 
         */
        public function connect();
        
        /**
         * executes a sql query and returns a single row as an array
         * 
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return array()
         */
        public function fetchRow( $pSQL, $pParam = array() );
        
        /**
         * executes a sql query and returns the resultset as an array
         * 
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return array()
         */
        public function fetchRows( $pSQL, $pParam = array() );
        
        
        /*
         * executes an INSERT statement, returns the inserted ID
         * 
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return int
         */
        public function insertId( $pSQL, $pParam = array() );
        
        /*
         * executes an UPDATE, DELETE or DROP statement and returns the amount
         * of affected rows. 
         *  
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return int
         */
        public function affectedRows( $pSQL, $pParam = array() );
        
        
        /**
         * Escapes database based on the escaping mechaincs 
         * (real_escape_string is recommended)
         * 
         * @param string $pData
         * @param boolean $pSkipQuotes [optional]
         * @return string 
         */
        public function escape( $pData, $pSkipQuotes = false );
        
    }