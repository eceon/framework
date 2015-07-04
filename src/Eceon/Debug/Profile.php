<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Profile.php 360 2015-06-02 10:42:55Z ted $
     * $package Eceon/Debug
     */

    namespace Eceon\Debug;

    class Profile
    {
        /**
         * @var string
         */
        protected $strTitle = '';
        
        /**
         * @var integer
         */
        protected $intStartTime = 0;
        
        /**
         * @var integer
         */
        protected $intEndTime = 0;
        
        /**
         * @var array() \Eceon\Debug\Profile
         */
        protected $arrChild = array();

        

        /**
         * Constructor
         * 
         * @param string $pTitle
         */
        public function __construct( $pTitle )
        {
            // set title
            $this->strTitle = $pTitle;		

            // start timer
            $this->intStartTime = $this->getMicroTime();	
        }

        
        /**
         * Add a child profile to the current running profile.
         * 
         * @param \Eceon\Debug\Profile $pNewProfile
         * @return null;
         */
        public function addChild( Profile $pNewProfile )
        {
            // search for a child that is currently active, add the new 
            // profile to that child.
            foreach ( $this->arrChild as $profile )
            {
                if( $profile->isActive() )
                {
                    $profile->addChild( $pNewProfile );

                    return;
                }				
            }

            // add the new profile 
            $this->arrChild[] = $pNewProfile;
        }

        
        
        /**
         * Stop the current running profile
         * 
         * @return null;
         */
        public function stop()
        {
            // search for a child that is currently active and stop it.
            foreach ( $this->arrChild as $profile )
            {
                if( $profile->isActive() === true)
                {
                    $profile->stop();

                    return;
                }				
            }			

            // stop this profile and set the endtime
            $this->intEndTime = $this->getMicroTime();
        }


        /**
         * Stop all profiles
         */
        public function stopAll()
        {
            // run through all childs and stop them
            foreach ( $this->arrChild as $profile )
            {
                $profile->stopAll();
            }
            
            // if current profile is active, set the endtime
            if( $this->isActive() )
            {
                $this->intEndTime = $this->getMicroTime();
            }
        }


        /**
         * Return true if current profile is active
         * 
         * @return boolean
         */
        public function isActive()
        {
            return ( $this->intEndTime == 0 );	
        }

        
        /**
         * Get the running time of this profile
         * 
         * @return integer
         */
        public function getRunTime()
        {
            return $this->intEndTime - $this->intStartTime;
        }

        
        /**
         * Gets the start time
         * 
         * @return integer
         */
        public function getStartTime()
        {
                return $this->intStartTime;
        }

        /**
         * Gets the end time
         * 
         * @return integer
         */
        public function getEndTime()
        {
            return $this->intEndTime;
        }

        /**
         * Create a table with all the data. 
         * 
         * @param integer $pTotal
         * @return string
         */
        public function getRunTitle( $pTotal = 0, $pIncludedFiles = false, $pIncludeMemoryUsage = false, $pAddTable = false )
        {
            // build table row:
            $strInfo = '<tr>
                                <td style="border-bottom:1px solid #cccccc; font-family: Courier new; font-size: 13px; text-align: left;">' . str_repeat( '--> ', $pTotal ) . $this->strTitle . '</td>
                                <td style="width: 100px; border-bottom:1px solid #cccccc; font-family: Courier new; font-size: 13px; text-align: right;">' . round( $this->getRunTime(), 4 ) * 1000 . 'ms</td>
                                <td style="width: 100px; border-bottom:1px solid #cccccc; font-family: Courier new; font-size: 13px; text-align: right;">'. round( $this->getRunTime(), 4 ) . 's</td>'.
                        "</tr>\n";

            // add the data from the children
            foreach ( $this->arrChild as $profile )
            {
                $strInfo .= $profile->getRunTitle( $pTotal + 1, false );
            }
            
            // add included files
            if( $pIncludedFiles == true )
            {
                $strInfo .= '<tr><td style="font-family: Courier new; font-size: 13px; text-align: left;">' . implode("<br/>\n", get_included_files()) . "<br/>\n<br/>\nTotal loaded files: " . count(get_included_files()) . '</td></tr>' . "\n";
            }
            
            if( $pIncludeMemoryUsage == true )
            {
                $strInfo .= '<tr>
                                <td style="border-bottom:1px solid #cccccc; font-family: Courier new; font-size: 13px; text-align: left;">Memory usage</td>
                                <td style="width: 100px; border-bottom:1px solid #cccccc; font-family: Courier new; font-size: 13px; text-align: right;">' . $this->convertBitSize(memory_get_peak_usage()) . ' peak</td>
                                <td style="width: 100px; border-bottom:1px solid #cccccc; font-family: Courier new; font-size: 13px; text-align: right;">'. $this->convertBitSize(memory_get_usage()) . '</td>'.
                        "</tr>\n";
                
            }
            
            // add starting and ending table tag
            if( $pAddTable === true )
            {
                $strInfo = '<table width="100%">' . $strInfo . '</table>';
            }
            
            // return the html table.
            return $strInfo;
        }


        /**
         * Getst he microtime, easier to calculate with;
         * 
         * @return integer
         */
        private function getMicroTime()
        { 
            list( $usec, $sec ) = explode( " ", microtime() ); 
            return ( (float)$usec + (float)$sec ); 
        } 		
        
        private function convertBitSize($size)
        {
            $unit=array('b','kb','mb','gb','tb','pb');
            return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
        }        
    }
