<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Image.php 289 2015-03-25 19:08:06Z ted $
     * $package Eceon/Image
     */

    namespace Eceon\Image;

    class Image
    {
        /**
         *
         * @var resource Image 
         */
        protected $objImage = null;
        
        
        /**
         * Creates a new image object
         * 
         * @param string $pFilename
         * @throws \Exception
         */
        public function __construct( $pFilename )
        {
            $this->loadImage( $pFilename );
        }
        
        
        
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
            
            switch(strtolower(substr( $filename, strrpos( $filename, '.') + 1)))
            {
                case 'gif':
                    $source = imagecreatefromgif( $filename );
                    break;
                
                case 'jpg':
                case 'jpeg':
                    $source = imagecreatefromjpeg( $filename );
                    break;

                case 'png':
                    $source = imagecreatefrompng( $filename );
                    break;
            }
            
            $this->objImage = $source;
        }
        
        
        /**
         * Creates an image from the resource. If filename is given, output will 
         * be stored in the filename.
         * 
         * @param string $pImageType
         * @param string $pFilename [optional]
         */
        public function outputImage( $pImageType, $pFilename = null )
        {
            
            // save to filename? create new directory if filename dir doesnt exists
            if( $pFilename != null )
            {
                if( is_dir( substr( $pFilename, 0, strrpos( $pFilename, '/' ) ) ) == false ) 
                {
                    mkdir( substr( $pFilename, 0, strrpos( $pFilename, '/' ) ), 0777, true );
                }
            }
	
            
            // output image based on the image type
            switch( $pImageType )
            {
                case 'gif':
                        header('Content-Type: image/gif');
            
                        ob_start();
                        imagegif( $this->objImage );
                        $content = ob_get_contents();
                        ob_end_clean();
                    break;
                
                case 'jpg':
                case 'jpeg':
                        header('Content-Type: image/jpeg');

                        ob_start();
                        imagejpeg( $this->objImage );
                        $content = ob_get_contents();
                        ob_end_clean();
                    break;
                
                case 'png':
                        header('Content-Type: image/png');

                        ob_start();
                        imagepng( $this->objImage );
                        $content = ob_get_contents();
                        ob_end_clean();
                    break;
            }
            
            if( $pFilename != '' )
            {
                // save file to disk
                file_put_contents( $pFilename, $content );
            }
            
            
            header('Accept-Ranges: bytes');
            header('Content-Length: '. strlen( $content ) );
            header('ETag: ' . md5( $content ) );
            
            echo $content;
        }
        
        
        /**
         * Destroys the image resource
         */
        public function destroyImage()
        {
            imagedestroy( $this->objImage );
            $this->objImage = null;
        }
        
        
        /**
         * Resize current image resource to new width & height
         * 
         * @param type $pNewWidth
         * @param type $pNewHeight
         * @param type $pAlignHorizontal [optional]
         * @param type $pAlignVertical [optional]
         * @param type $pBackground [optional]
         */
        public function resizeImage( $pNewWidth, $pNewHeight, $pAlignHorizontal = 'L', $pAlignVertical = 'T', $pBackground = 'ffffff')
        {
            
            // resize with width/height ratio if newwidth/newheight is set to 0
            if( $pNewWidth == 0)
            {
                $pNewWidth = round( imagesx( $this->objImage ) * $pNewHeight / imagesy( $this->objImage ) );
            }
            if( $pNewHeight == 0)
            {
                $pNewHeight = round( imagesy( $this->objImage ) * $pNewWidth / imagesx( $this->objImage ) );
            }
            
            
            // create base image resource
            $newImage = imagecreatetruecolor($pNewWidth, $pNewHeight);
            
            
            // set background
            $backgroundColor = imagecolorallocate($newImage, hexdec(substr($pBackground, 0, 2)), hexdec(substr($pBackground, 2, 2)), hexdec(substr($pBackground, 4, 2)));
            imagefill($newImage, 0, 0, $backgroundColor);
            
            
            // calculate new resolutions
            if( imagesx( $this->objImage ) / imagesy( $this->objImage ) > 1 )
            {
                $calcWidth = $pNewWidth;
                $calcHeight = round( $pNewWidth * imagesy( $this->objImage ) / imagesx( $this->objImage ) );
            } else {
                $calcWidth =  round( $pNewHeight * imagesx( $this->objImage ) / imagesy( $this->objImage ) );
                $calcHeight = $pNewHeight;
            }
            
            
            // calculate x&y startpositions
            switch( $pAlignHorizontal )
            {
                case 'L':
                    $calcX = 0;
                    break;
                case 'C':
                    $calcX = round( ( $pNewWidth - $calcWidth ) / 2 );
                    break;
                case 'R':
                    $calcX = ( $pNewWidth - $calcWidth );
                    break;
                case 'S':
                    $calcX = 0;
                    $calcWidth = $pNewWidth;
                    break;
            }
            
            switch( $pAlignVertical )
            {
                case 'T':
                    $calcY = 0;
                    break;
                case 'C':
                    $calcY = round( ( $pNewHeight - $calcHeight ) / 2 );
                    break;
                case 'B':
                    $calcY = ( $pNewHeight - $calcHeight );
                    break;
                case 'S':
                    $calcY = 0;
                    $calcHeight = $pNewHeight;
                    break;
            }

            
            // copy image resource resampled into the new image resource
            imagecopyresampled($newImage, $this->objImage, $calcX, $calcY, 0, 0, $calcWidth, $calcHeight, imagesx( $this->objImage ), imagesy( $this->objImage ));
            
            // remove old image resource
            $this->destroyImage();
            
            // copy new image resource to the main image resource
            $this->objImage = $newImage;
        }
        
        
    }