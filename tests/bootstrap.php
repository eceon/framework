<?php
    /**
     * @author Ted van Diepen
     */

    $sourcePath = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'src';

    // add the src directory to the include path
    set_include_path(get_include_path() . PATH_SEPARATOR . $sourcePath);

    // include psr-4 loader
    require_once('Eceon\\Autoload.php');
    
    // create loader 
    $loader = new Eceon\Autoload();
    $loader->addNamespace( 'Eceon\\', $sourcePath . DIRECTORY_SEPARATOR . 'Eceon' );
    $loader->register();
 
    echo "loaded bootstrap\n";