<?php
    /**
     * Eceon Framework (http://eceon.mezio.nl/)
     *
     * @author Ted van Diepen (t.v.diepen@mezio.nl)
     * @copyright Copyright (c) 2012-2014 Mezio (http://www.mezio.nl)
     * @version $Id: Histogram.php 96 2015-01-08 21:37:04Z ted $
     * $package Eceon/Service/Image
     */

    namespace Eceon\Service\Image;
    
    class Histogram
    {
        public function getHistogram( $pImage )
        {
            $arrHistogram = array();
            $arrHistogram['red'] = array();
            $arrHistogram['green'] = array();
            $arrHistogram['blue'] = array();
            $arrHistogram['rgb'] = array();
            
            for($n = 0; $n < 256; $n++)
            {
                $arrHistogram['red'][$n] = 0;
                $arrHistogram['green'][$n] = 0;
                $arrHistogram['blue'][$n] = 0;
                $arrHistogram['rgb'][$n] = 0;
            } 
            
            
            for( $x = 0; $x < imagesx( $pImage ); $x++ )
            {
                for( $y = 0; $y < imagesy( $pImage ); $y++ )
                {
                    $color_index = imagecolorat( $pImage, $x, $y );
                    $pixel_rgb = imagecolorsforindex( $pImage, $color_index ); 
                    
                    $arrHistogram['red'][$pixel_rgb['red']]++;
                    $arrHistogram['green'][$pixel_rgb['green']]++;
                    $arrHistogram['blue'][$pixel_rgb['blue']]++;
                    $arrHistogram['rgb'][($pixel_rgb['red'] + $pixel_rgb['green'] + $pixel_rgb['blue']) / 3]++;
                    
                }
            }
            
            $max_red = max($arrHistogram['red']);
            $max_green = max($arrHistogram['green']);
            $max_blue = max($arrHistogram['blue']);
            $max_rgb = max($arrHistogram['rgb']);
            
            for($n = 0; $n < 256; $n++)
            {
                $arrHistogram['red'][$n] = round( $arrHistogram['red'][$n] * 100 / $max_red );
                $arrHistogram['green'][$n] = round( $arrHistogram['green'][$n] * 100 / $max_green );
                $arrHistogram['blue'][$n] = round( $arrHistogram['blue'][$n] * 100 / $max_blue );
                $arrHistogram['rgb'][$n] = round( $arrHistogram['rgb'][$n] * 100 / $max_rgb );
            }
            
            
            return $arrHistogram;
        }
        
        
        
        public function makeHistogram( $pData = array() )
        {
            $im = imagecreate( 258, count($pData) * 120 );
            
            $white = imagecolorallocate( $im, 255, 255, 255);
            $black = imagecolorallocate( $im, 0, 0, 0);

            $starty = 0;

            
            foreach( $pData as $color => $precentages)
            {
                
                
                foreach( $precentages as $x => $percentage)
                {
                    imageline( $im, $x + 1, $starty + 100, $x + 1, $starty + 100 - $percentage, $black);
                }
                
                $starty += 120;
            }
            header( "Content-type: image/png" );
            imagepng( $im );
            
        }
    }