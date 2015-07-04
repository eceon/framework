<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractoAuth.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Service/oAuth
     */

    namespace Eceon\Service\oAuth;

    abstract class AbstractoAuth
    {
        protected $strVersion = '1.0';
        
        protected $strCallbackUrl;
        
        protected $strRequestTokenUrl;
        protected $strAccessTokenUrl;
        protected $strAuthorizeUrl;
        protected $strApiUrl;
                
        protected $strConsumerKey;
        protected $strConsumerSecret;
        
        protected $strToken;
        protected $strTokenSecret;
        protected $strTokenVerifier;
        // protected $signatureMethod;        
        
        
        
        /**
         * Create a oAuth object
         * 
         * @param string $pConsumerKey
         * @param string $pConsumerSecret
         * @param string $pOauthToken [optional]
         * @param string $pOauthTokenSecret [optional]
         */
        public function __construct( $pConsumerKey, $pConsumerSecret, $pOauthToken = null, $pOauthTokenSecret = null )
        {
            // set consumer data
            $this->strConsumerKey = $pConsumerKey;
            $this->strConsumerSecret = $pConsumerSecret;
            
            // set token 
            $this->setToken( $pOauthToken, $pOauthTokenSecret );
        }

        
        
        /**
         * Sets the token
         * 
         * @param string $pToken
         * @param string $pSecret
         */
        public function setToken( $pToken = null, $pSecret = null)
        {
            $this->strToken = $pToken;
            $this->strTokenSecret = $pSecret;
        } 
        
        
        /**
         * Sets the callback url, used for the request token/authorizeurl functions
         * 
         * @param type $pUrl
         */
        public function setCallbackURL( $pUrl )
        {
            $this->strCallbackUrl = $pUrl;
        }
        

        /**
         * Request a token to make a followup request
         * 
         * @return string
         */
        public function getRequestToken()
        {
            $response = $this->httpRequest(
                            'post', 
                            $this->strRequestTokenUrl, 
                            array( 'consumer_key', 'nonce', 'callback', 'timestamp', 'version', 'signature' ),
                            array()
                    
                    );
            
            return $response;
        }
        
        
        /**
         * Gets the authorize url, to redirect the user after the request token is recieved
         * 
         * @return string
         */
        public function getAuthorizeURL()
        {
            return str_replace('%token%', $this->strToken, $this->strAuthorizeUrl);
        }


        
        
        /**
         * set the token verifier data, used to request the access token
         * 
         * @param string $data
         */
        public function setTokenVerifier( $pData )
        {
            $this->strTokenVerifier = $pData;
        }
        
        
        /**
         * Request the access token, which will be used in the next requests
         * 
         * @return string
         */
        public function getAccessToken()
        {
            $response = $this->httpRequest(
                            'post', 
                            $this->strAccessTokenUrl, 
                            array( 'consumer_key', 'nonce', 'timestamp', 'token', 'version', 'verifier', 'signature' ),
                            array()
                    );
    
            return $response;            
        }
        
        
        
        /**
         * Makes a get request to the oauth server
         * 
         * @param string $pUrl
         * @param array $pParameters
         * @return string
         */
        public function get( $pUrl, $pParameters = array())
        {
            $response = $this->httpRequest(
                            'get', 
                            $this->strApiUrl . '/' . $pUrl, 
                            array( 'consumer_key', 'nonce', 'timestamp', 'token', 'version', 'signature' ), 
                            $pParameters
                        );
            
            return $response;
        }
        
        /**
         * Makes a post request to the oauth server
         * 
         * @param string $pUrl
         * @param array $pParameters
         * @return string
         */
        public function post( $pUrl, $pParameters = array())
        {
            $response = $this->httpRequest(
                            'post', 
                            $this->strApiUrl . '/' . $pUrl, 
                            array( 'consumer_key', 'nonce', 'timestamp', 'token', 'version', 'signature' ), 
                            $pParameters
                        );
            
            return $response;
        }
                
        
        
        
        
        /**
         * Makes a http request to the oauth server
         * 
         * @param string $pMethod
         * @param string $pUrl
         * @param array $pRequiredoAuth
         * @param array $pUrlParams
         * @return string
         */
        protected function httpRequest($pMethod, $pUrl, $pRequiredoAuth = array(), $pUrlParams = array())
        {
            // create curl object
            $ch = curl_init();
            
            // set options
            // curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt( $ch, CURLINFO_HEADER_OUT, true );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

            if( substr( $pUrl, 0 , 8 ) == 'https://' )
            {
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
            }
            
            // add required oauth header
            if( count( $pRequiredoAuth ) > 0 )
            {
                $oauth_header = array();

                foreach( $pRequiredoAuth as $header )
                {
                    switch( $header )
                    {
                        case 'consumer_key':
                                $oauth_header['oauth_consumer_key'] = $this->strConsumerKey;
                            break;
                        
                        case 'timestamp':
                                $oauth_header['oauth_timestamp'] = time();
                            break;
                        
                        case 'nonce':
                                $oauth_header['oauth_nonce'] = md5($this->strConsumerKey . uniqid());
                            break;
                        
                        case 'token':
                                $oauth_header['oauth_token'] = $this->strToken;
                            break;
                        
                        case 'version':
                                $oauth_header['oauth_version'] = $this->strVersion;
                            break;
                        
                        case 'callback':
                                $oauth_header['oauth_callback'] = $this->strCallbackUrl;
                            break;
                        
                        case 'verifier':
                                $oauth_header['oauth_verifier'] = $this->strTokenVerifier;
                            break;
                        
                        case 'signature':
                                $oauth_header['oauth_signature_method'] = 'HMAC-SHA1';
                            
                                $signature = $this->generateSignature( $pMethod, $pUrl, array_merge( $pUrlParams, $oauth_header ) );
                                $oauth_header['oauth_signature'] = $signature;
                            break;
                        
                    }
                }
                
                ksort( $oauth_header );
                
                $oauth_header_string = 'Authorization: OAuth ';
                foreach( $oauth_header as $key => $value )
                {
                        $oauth_header_string .= $key . '="' . rawurlencode( $value ) . '", ';
                }
                
                curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Expect:', 'Content-Length:', substr( $oauth_header_string, 0, -2 ) ) ); 
            }
            
            
            
            switch( $pMethod )
            {
                case 'get':
                    if( count( $pUrlParams ) > 0 )
                    {
                        $pUrl = $pUrl . '?' . http_build_query( $pUrlParams );
                    }
                    
                    curl_setopt( $ch, CURLOPT_URL, $pUrl );
                    break;
                    
                case 'post':
                    curl_setopt( $ch, CURLOPT_URL, $pUrl );
                    curl_setopt( $ch, CURLOPT_POST, true );
                    if( count( $pUrlParams ) > 0 )
                    {
                        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $pUrlparams ) );
                    }
                    break;
            }
            
            // execute url request
            $response = curl_exec( $ch );            
            
            // $info = curl_getinfo($ch);
            
            // close curl obj
            curl_close( $ch );
             
            // return response
            return $response;
        }
        


        /**
         * Creates a signature for the oauth request
         * 
         * @see https://dev.twitter.com/docs/auth/creating-signature
         * @param str $pMethod [POST/GET]
         * @param str $pUrl
         * @param array $pParams
         * @return string
         */
        protected function generateSignature($pMethod, $pUrl, $pParams = array())
        {
            // sort values
            ksort( $pParams );
            
            // build string
            $paramString = http_build_query( $pParams, null, '&' );
           
            // create base string
            $signatureBaseString = strtoupper( $pMethod ) . '&'. rawurlencode( $pUrl ) . '&'. rawurlencode( $paramString );

            // create key
            $key = rawurlencode( $this->strConsumerSecret ) . '&' . rawurlencode( $this->strTokenSecret );
            
            // return encoded data
            $encodedString = base64_encode( hash_hmac( 'sha1', $signatureBaseString, $key, true ) );
            
            return $encodedString;
        }
        
    }