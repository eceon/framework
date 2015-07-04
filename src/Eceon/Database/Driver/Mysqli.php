<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Mysqli.php 302 2015-03-27 14:36:41Z ted $
     * $package Eceon/Database/Driver
     */

    namespace Eceon\Database\Driver;

  
    class Mysqli extends AbstractDriver
    {
        /**
         * Connects with the database 
         */        
        public function connect()
        {
            // create a new mysqli connection
            $this->objConnection = new \mysqli(
                        $this->getHost(), 
                        $this->getUsername(), 
                        $this->getPassword(), 
                        $this->getDatabase()
                    );
            
            // mysqli driver created an error
            if( $this->getErrorNumber() != 0 )
            {
                throw new \Exception( $this->getErrorNumber() . ": " . $this->getError() . "\nError connecting to: " . $this->getHost() );
            }
            
            // try setting charset. if fails throw exception
            if( $this->objConnection->set_charset( $this->getCharset() ) == false )
            {
                throw new \Exception( $this->getErrorNumber() . ": " . $this->getError() . "\nError setting charset to: " . $this->getCharset() );
            }

        }
        
        
        /**
         * Executes the query against the database and returns the resource. 
         * Parameters will be escaped and quoted, use :key to add quotes, #key 
         * to skip quoting.
         *
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return array | true
         */
        protected function query( $pSQL, $pParam = array() )
        {
            // connect if there isn't an active connection to the server
            if( $this->isConnected() === false )
            {
                $this->connect();
            }

            // escape paramters for the sql query
            foreach( $pParam as $key => $param )
            {
                $pSQL = str_replace( 
                    array(
                        ':'.$key, // add quotes
                        '#'.$key, // skip quotes
                    ), array(
                        $this->escape( $param ),       // add quotes
                        $this->escape( $param, true )  // skip quotes
                    ), $pSQL );
            }
            
            // execute the query
            $result = $this->objConnection->query( $pSQL );

            // executing the query failed, throw exception
            if( $result === false )
            {
                throw new \Exception( $this->getErrorNumber() . ": " . $this->getError() . "\nError running sql query: " . $pSQL );
            }

            
            // insert/update/delete query. mysqli_query returns true;
            if( $result === true )
            {
                return true; 
                
                
             // select query. mysql_query returns the resultset   
            } else {
                
                return $result;
            }
        }
        
  
        
        /**
         * executes a sql query and returns a single row as an array
         * 
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return array()
         */
        public function fetchRow( $pSQL, $pParam = array() )
        {
            $result = $this->query( $pSQL, $pParam );
         
            $row = $result->fetch_array( MYSQLI_ASSOC );
                     
            return $row;
        }
        
        /**
         * executes a sql query and returns the resultset as an array
         * 
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return array()
         */
        public function fetchRows( $pSQL, $pParam = array() )
        {
            $result = $this->query( $pSQL, $pParam );
         
            $arrResult = array();
            
            while( $row = $result->fetch_array( MYSQLI_ASSOC ) )
            {
                $arrResult[] = $row;
            }
                     
            return $arrResult;            
        }
        
        
        /*
         * executes an INSERT statement, returns the inserted ID
         * 
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return int
         */
        public function insertId( $pSQL, $pParam = array() )
        {
            $this->query( $pSQL, $pParam );
            
            return $this->objConnection->insert_id;
        }
        
        /*
         * executes an UPDATE, DELETE or DROP statement and returns the amount
         * of affected rows. 
         *  
         * @param string $pSQL
         * @param array $pParam [optional]
         * @return int
         */
        public function affectedRows( $pSQL, $pParam = array() )
        {
            $this->query( $pSQL, $pParam );
            
            return $this->objConnection->affected_rows;
        }
        

        
        /**
         * Escapes database based on the escaping mechaincs 
         * (real_escape_string is recommended)
         * 
         * @param string $pData
         * @param boolean $pSkipQuotes [optional]
         * @return string 
         */
        public function escape( $pData, $pSkipQuotes = false )
        {
            // connect if there isn't an active connection to the server
            if( $this->isConnected() === false )
            {
                $this->connect();
            }

            if( $pData === null )
            {
                return 'NULL';
            }
            
            $escaped_data = $this->objConnection->real_escape_string( $pData );
            
            if( $pSkipQuotes == true )
            {
                return $escaped_data;
            }
            
            // only user real_escape_string
            return "'". $escaped_data . "'";
        }

        
        /**
         * Gets the error thrown by the mysql driver
         * 
         * @return string
         */        
        public function getError()
        {
            return $this->objConnection->connect_error;
        }

        /**
         * Gets the error number thrown by the mysql driver
         * 
         * @return interger
         */        
        public function getErrorNumber()
        {
            return $this->objConnection->connect_errno;
        }        
        
    }