<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Profiler.php 360 2015-06-02 10:42:55Z ted $
     * $package Eceon/Debug
     */

    namespace Eceon\Debug;

    class Profiler
    {
        /**
         * @var \Eceon\Debug\Profiler
         */
        protected static $instance = null;


        /**
         * @var \Eceon\Debug\Profile
         */
        protected $objProfile = null;


        /**
         * Private constructor, use getInstance();
         *
         * @see getInstance();
         */
        private function __construct()
        {
             $this->objProfile = new Profile( 'main' );
        }

        /**
         * Singleton function
         *
         * @return \Eceon\Debug\Profiler
         */
        public static function getInstance()
        {
            if( self::$instance === null ) self::$instance = new self();

            return self::$instance;
        }

        
        /**
         * Start a (new) profile
         * 
         * @param string $pTitle
         */
        public function startAnalyse( $pTitle )
        {
            $this->objProfile->addChild( new Profile( $pTitle ) );				
        }

        /**
         * Stop the current/active profile
         */
        public function stopAnalyse()
        {
            $this->objProfile->stop();
        }

        /**
         * Show table with all data
         */
        public function outputStatistics( $pShowIncludedFiles = false, $pIncludeMemoryUsage = false )
        {
            $this->objProfile->stopAll();

            echo $this->objProfile->getRunTitle( 0, $pShowIncludedFiles, $pIncludeMemoryUsage, true );
        }

    }
