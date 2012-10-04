<?php
namespace Helloworld;

use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;


require_once 'autoload_register.php';

class Module implements ConsoleBannerProviderInterface, \Zend\ModuleManager\Feature\ConsoleUsageProviderInterface
{
    public function onBootstrap($e)
    {
        \Zend\Validator\AbstractValidator::setDefaultTranslator(
            $e->getApplication()
                ->getServiceManager()
                ->get('translator')
            );
    }

        public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
              __DIR__ . '/autoload_classmap.php'  
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getConsoleBanner(Console $console)
    {
        return
            "==----------------------------------==\n" .
            "
            Helloworld-Modul, Version 1.0
            \n" .
            "==----------------------------------==\n";
    }
    
    public function getConsoleUsage(Console $console)
    {
        return array(
            'show date [--format=]' => 'Zeigt das aktuelle Datum/Uhrzeit an.',
            
            array(
                '--format=FORMAT',
                'Es wird die Formatierung der PHP "date"-Funktion unterstützt.'
            ),
        );
    }

}