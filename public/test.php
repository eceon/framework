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
 
    $profiler = Eceon\Debug\Profiler::getInstance();


    
    $container = new Eceon\DI\Container();
    $di_loader = new Eceon\DI\Loader\Xml( $container );
    $di_loader->parse( $sourcePath . '\\Eceon\\wire.xml' );
    
    // print_r($container);
    
    print_r( $container->get( 'app.router' ) );
    
    
    
    
    
    
    $profiler->outputStatistics( true, true );