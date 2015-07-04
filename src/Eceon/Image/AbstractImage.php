<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: AbstractImage.php 302 2015-03-27 14:36:41Z ted $
     * $package Eceon/Image
     */

    namespace Eceon\Image;

    abstract class AbstractImage
    {
        /**
         *
         * @var resource Image 
         */
        protected $objImage = null;
        
        protected $strImageHash = '';
        
        /**
         * Loads an image resource from a file
         * 
         * @param string $pFilename
         * @throws \Exception
         */
        public function loadImage( $pFilename )
        {
            $filename = stream_resolve_include_path( $pFilename );
            
            if( $filename === false )
            {
                throw new \Exception('Image not found on ' . $pFilename);
            }

            $source = null;
            
            switch( exif_imagetype( $filename) )
            {
                case IMAGETYPE_GIF:
                    $source = imagecreatefromgif( $filename );
                    break;
                
                case IMAGETYPE_JPEG:
                    $source = imagecreatefromjpeg( $filename );
                    break;

                case IMAGETYPE_PNG:
                    $source = imagecreatefrompng( $filename );
                    break;
                
                default:
                    throw new \Exception( 'Not a valid image in ' . $filename );
            }
            
            $this->objImage = $source;
            
            $this->strImageHash = md5_file( $filename );
        }
        
        
        public function storeImage( $pFilename )
        {
            // create new directory if filename path doesn't exists
            if( is_dir( substr( $pFilename, 0, strrpos( $pFilename, '/' ) ) ) == false ) 
            {
                mkdir( substr( $pFilename, 0, strrpos( $pFilename, '/' ) ), 0644, true );
            }
            
            
            switch( strtolower( substr( $pFilename, strrpos( $pFilename, '.') + 1 ) ) )
            {
                case 'gif':
                        imagegif( $this->objImage, $pFilename );
                    break;
                
                case 'jpg':
                case 'jpeg':
                        imagejpeg( $this->objImage, $pFilename );
                    break;
                
                case 'png':
                        imagepng( $this->objImage, $pFilename );
                    break;                
                
                default:
                    throw new \Exception( 'File type not supported on ' . $pFilename );
            }
            
            
        }
        
        
        public function outputImage( $pFilename, $match_etag = '' )
        {
            // get extension from filename
            $extension = strtolower( substr( $pFilename, strrpos( $pFilename, '.') +1 ) );

            // only serve png,gif,jpg and jpeg
            if( in_array( $extension, array( 'png', 'gif', 'jpg', 'jpeg' ) ) === false )
            {
                throw new \Exception( 'File type not supported ' . $pFilename );
            }
           
            switch( $extension )
            {
                case 'gif':
                        header( 'Content-Type: image/gif' );
                    break;
                case 'jpg':
                case 'jpeg':
                        header( 'Content-Type: image/jpeg' );
                    break;
                case 'png':
                        header( 'Content-Type: image/png' );
                    break;                
            }            
            
            header( 'Etag: ' . $this->getEtag() );
            
            if( $match_etag ==  $this->getEtag() )
            {
                header( 'HTTP/1.1 304 Not Modified' );
                return;                
            }
            
            
            switch( $extension )
            {
                case 'gif':
                        imagegif( $this->objImage );
                    break;
                case 'jpg':
                case 'jpeg':
                        imagejpeg( $this->objImage );
                    break;
                case 'png':
                        imagepng( $this->objImage );
                    break;                
            }
                        
        }
    
        
        
        /**
         * Destroys the image resource
         */
        public function destroyImage()
        {
            imagedestroy( $this->objImage );
            $this->objImage = null;
        }
        
        

        public function getEtag()
        {
            return md5( $this->strImageHash . '_' . imagesx( $this->objImage ) . '_' . imagesy( $this->objImage ) );
        }
        
    }