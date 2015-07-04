<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractRouter.php 211 2015-02-05 12:31:03Z ted $
     * $package Eceon/Router
     */

    namespace Eceon\Router;

    
    abstract class AbstractRouter implements InterfaceRouter
    {

        /**
         * @var \SplPrioiryQueue
         */
        protected $objRouteQueue = null;


        
        public function __construct()
        {
            $this->objRouteQueue = new \SplPriorityQueue();
        }
        
        
        /**
         * Adds a route to this router
         *
         * @param Route\InterfaceRoute $pRoute
         * @param integer $pPriority [optional]
         * @return AbstractRouter
         */
        public function addRoute( Route\InterfaceRoute $pRoute, $pPriority = 50 )
        {
            $this->objRouteQueue->insert( $pRoute, $pPriority );

            return $this;
        }

    }

    
    