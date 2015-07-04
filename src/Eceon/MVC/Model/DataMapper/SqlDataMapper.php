<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl) 
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: SqlDataMapper.php 199 2015-01-15 16:17:06Z ted $
     * $package Eceon/MVC/Model/DataMapper
     */
     
    namespace Eceon\MVC\Model\DataMapper;
     
    use Eceon\Database\Driver\InterfaceDriver;
    
    
    class SqlDataMapper extends AbstractDataMapper
    {
        /**
         * @var InterfaceDriver
         */
        protected $objConnection = null;
        

        /**
         * Sets the database connection
         * 
         * @param InterfaceDriver $pConnection 
         */
        public function setConnection( InterfaceDriver $pConnection )
        {
            $this->objConnection = $pConnection;
        }
        
        /**
         * Get connection
         * 
         * @return InterfaceDriver
         */
        protected function getConnection()
        {
            return $this->objConnection;
        }
        
        /**
         * Alias of getConnection();
         * 
         * @return InterfaceDriver
         * @see getConnection()
         */
        protected function conn()
        {
            return $this->getConnection();
        }
         
    }
