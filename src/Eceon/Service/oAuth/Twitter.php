<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Twitter.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Service/oAuth
     */

    namespace Eceon\Service\oAuth;

    class Twitter extends AbstractoAuth
    {
        protected $strCallbackUrl = 'oob';
        
        protected $strRequestTokenUrl = 'https://api.twitter.com/oauth/request_token';
        protected $strAccessTokenUrl = 'https://api.twitter.com/oauth/access_token';
        protected $strAuthorizeUrl = 'https://api.twitter.com/oauth/authenticate?oauth_token=%token%';        
        protected $strApiUrl = 'https://api.twitter.com/1.1';
        
        
    }

