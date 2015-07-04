<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Resize.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Service/Image
     */

    namespace Eceon\Service\Image;

    class Resize
    {
        
        protected $strImagePath = '';
        protected $strCachePath = '';

        protected $intOrginalWidth = 0;
        protected $intNewImageWidth = 0;
        protected $intResizeWidth = 0;
        protected $intStartX = 0;

        protected $intOrginalHeight = 0;
        protected $intNewImageHeight = 0;
        protected $intResizeHeight = 0;
        protected $intStartY = 0;

        protected $strBackgroundColor = 'ffffff';


        /**
         * Create a new image object, requires a valid image path
         * 
         * @param string $pImagePath
         */
        public function __construct( $pImagePath )
        {
            // @todo: check if image path exists, throw exception if fails
            
            // set orignal width & height
            list( $orginWidth, $orginHeight ) = getimagesize( $pImagePath );

            $this->intOrginalWidth = $orginWidth;
            $this->intNewImageWidth = $orginWidth;
            $this->intResizeWidth = $orginWidth;

            $this->intOrginalHeight = $orginHeight;
            $this->intNewImageHeight = $orginHeight;
            $this->intResizeHeight = $orginHeight;

            $this->strImagePath = $pImagePath;
        }


        /**
         * Sets an cache path. 
         * 
         * @param string $path 
         */
        public function setCachePath( $pPath )
        {
            $this->strCachePath = $pPath;
        }


        /**
         * Resize the orginal image based on a given width, calc
         * the height on the ratio of the orginal image
         * 
         * @param int $pWidth
         */
        public function resizeOnWidth( $pWidth )
        {
            // set width
            $this->intNewImageWidth = $pWidth;
            $this->intResizeWidth = $pWidth;

            // calculate new height
            $this->intNewImageHeight = round( $this->intOrginalHeight * $pWidth / $this->intOrginalWidth );
            $this->intResizeHeight = $this->intNewImageHeight;
        }

        /**
         * Resize the orginal image based on a given height, calc
         * the width on the ratio of the orginal image
         * 
         * @param int $pHeight
         */                
        public function resizeOnHeight( $pHeight )
        {
            // set height
            $this->intNewImageHeight = $pHeight;
            $this->intResizeHeight = $pHeight;

            // calculate new width
            $this->intNewImageWidth = round( $this->intOrginalWidth * $pHeight / $this->intOrginalHeight );
            $this->intResizeWidth = $this->intNewImageWidth;
        }


        /**
         *  Resize the orginal image based on width and height, will 
         *  stretch the image if ratio is not the same as orginal
         * 
         * @param int $pWidth
         * @param int $pHeight 
         */
        public function resizeStretch( $pWidth, $pHeight )
        {
            // set width
            $this->intNewImageWidth = $pWidth;
            $this->intResizeWidth = $pWidth;

            // set height
            $this->intNewImageHeight = $pHeight;
            $this->intResizeHeight = $pHeight;
        }


        /**
         * Resize the orginal image based on width and height, will keep
         * the orginal ratio and centers the new image if ratio mismatch
         * 
         * @param int $pWidth
         * @param int $pHeight
         * @param boolean $pCenter
         */
        public function resizeKeepRatio( $pWidth, $pHeight, $pCenter = true )
        {
            // calc ratio x-as
            $ratioX = round( $this->intOrginalWidth / $pWidth );

            // calc ratio y-as
            $ratioY = round( $this->intOrginalHeight / $pHeight );


            if( $ratioX == $ratioY )
            {
                $this->resizeStretch( $pWidth, $pHeight );
                
            } elseif ( $ratioX > $ratioY ) {
                $this->intResizeWidth = $pWidth;
                $this->intResizeHeight = round( $this->intOrginalHeight / $ratioX );
                
            } else {
                $this->intResizeWidth = round( $this->intOrginalWidth / $ratioY );
                $this->intResizeHeight = $pHeight;
            }

            // set new width & height
            $this->intNewImageWidth = $pWidth;
            $this->intNewImageHeight = $pHeight;

            // if center is true, resized image will be centered inside width/height image,
            // otherwise it will be place in the top left corner
            if( $pCenter === true )
            {
                $this->intStartX = round( ( $this->intNewImageWidth - $this->intResizeWidth ) / 2 );
                $this->intStartY = round( ( $this->intNewImageHeight - $this->intResizeHeight ) / 2 );
            }
        }


        /**
         * Create the image and output
         */
        public function createImage()
        {
            header( 'Cache-Control: private, max-age=604800, pre-check=604800' );
            header( 'Pragma: private' );
            header( 'Expires: '. date( DATE_RFC822, time() + 604800 ) );
            header( 'Content-type: image/png' );

            if( file_exists( $this->strCachePath . '/' . $this->getCacheFileName() ) === false )
            {
                $thumb = imagecreatetruecolor( $this->intNewImageWidth, $this->intNewImageHeight );
                $colorBackground = imagecolorallocate( $thumb, 255,255,255 );
                imagefill( $thumb, 0, 0, $colorBackground );

                // load image object based on the file extension
                switch( strtolower( $this->getFileExtension() ) )
                {
                        case 'jpg':
                        case 'jpeg':
                                $source = imagecreatefromjpeg( $this->strImagePath );
                                break;
                        case 'gif':
                                imagecolortransparent( $thumb, imagecolorallocate( $thumb, 0, 0, 0 ) );
                                imagealphablending( $thumb, false );
                                imagesavealpha( $thumb, true );

                                $source = imagecreatefromgif( $this->strImagePath );
                                break;
                        case 'png':
                                $source = imagecreatefrompng( $this->strImagePath );
                                break;
                }

                // create resized image
                imagecopyresampled(
                        $thumb, 
                        $source, 
                        $this->intStartX, 
                        $this->intStartY, 
                        0, 
                        0, 
                        $this->intResizeWidth, 
                        $this->intResizeHeight, 
                        $this->intOrginalWidth, 
                        $this->intOrginalHeight);

                // destroy source, we dont need it anymore
                imagedestroy( $source );

                // output image
                imagepng( $thumb );

                // save to cache if we have a cache path available
                if( $this->strCachePath != '' )
                {
                    // create image and save
                    imagepng( $thumb, $this->strCachePath . '/' . $this->getCacheFileName() );
                } 

                // destroy create image
                imagedestroy( $thumb );

            // read cache file    
            } else {
                readfile( $this->strCachePath . '/' . $this->getCacheFileName() );
            }
        }


        /**
         * Retrieves the filename of the image
         * 
         * @return string
         */
        public function getFileName()
        {
            return substr( $this->strImagePath, strrpos( $this->strImagePath, '/' ) +1 );
        }

        /**
         * Retrieves the extension of the image
         * 
         * @return string
         */
        public function getFileExtension()
        {
            return substr( $this->getFileName(), strrpos( $this->getFileName(), '.' ) +1 );
        }


        /**
         * Generate a new file name based on the filename of the image and resize settings
         * useable as caching name
         * 
         * <filename>_widthXheight_newwidthXnewheight_startxXstarty.extension
         * 
         * @return string
         */
        public function getCacheFileName()
        {
            $filename = substr( $this->getFileName(), 0, strrpos( $this->getFileName(), '.' ) );
            $extension = $this->getFileExtension();

            return $filename . '_' . 
                   $this->intNewImageWidth . 'x' . $this->intNewImageHeight . '_' . 
                   $this->intResizeWidth . 'x' . $this->intResizeHeight . '_' .
                   $this->intStartX . 'x' . $this->intStartY . '.' .
                   $extension;
        }
    }