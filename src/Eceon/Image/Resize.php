<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Resize.php 285 2015-03-04 12:46:42Z ted $
     * $package Eceon/Image
     */

    namespace Eceon\Image;

    class Resize extends AbstractImage
    {
        
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