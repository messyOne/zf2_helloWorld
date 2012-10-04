<?php

use Zend\ServiceManager\ServiceLocatorInterface;

return array(
    'view_manager' => array(
        'template_path_stack' => array(__DIR__ . '/../view')
    ),
    'router' => array(
        'routes' => array(
            'sayhello' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/sayhello',
                    'defaults' => array(
                        'controller' => 'Helloworld\Controller\Index',
                        'action' => 'index',
                    )
                ),
            ),
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'Helloworld\Controller\Auth',
                        'action' => 'login'
                    )
                )
            ),
            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'Helloworld\Controller\Auth',
                        'action' => 'logout'
                    )
                )
            ),
            'hello' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/hello',
                    'defaults' => array(
                        'controller' => 'Helloworld\Controller\Index',
                        'action' => 'hello',
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'factories' => array(
            'Helloworld\Controller\Index' =>
            function(ServiceLocatorInterface $serviceLocator) {
                $ctr = new Helloworld\Controller\IndexController();
                $ctr->setGreetingService($serviceLocator->getServiceLocator()->get('greetingService'));
                return $ctr;
            },
            'Helloworld\Controller\Auth' => 'Helloworld\Controller\AuthControllerFactory',
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        )
    ),
    'service_manager' => array(
        'invokables' => array(
            'greetingService' => 'Helloworld\Service\GreetingService'
        ),
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function($sm) {
                $config = $sm->get('Config');
                $dbParams = $config['dbParams'];

                return new Zend\Db\Adapter(array(
                            'driver' => 'pdo',
                            'dsn' => 'mysql:dbname=' . $dbParams['database'] . 'host='
                            . $dbParams['hostname'],
                            'database' => $dbParams['database'],
                            'username' => $dbParams['username'],
                            'password' => $dbParams['password'],
                            'hostname' => $dbParams['hostname'],
                        ));
            },
            'Helloworld\Service\AuthService' => 'Helloworld\Service\AuthServiceFactory',
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        )
    ),
                    
    'console' => array(
        'router' => array(
            'routes' => array(
                'date' => array(
                    'options' => array(
                        'route' => 'show date [--format=]',
                        'defaults' => array(
                            'controller' => 'Helloworld\Controller\Index',
                            'action' => 'date'
                        )
                    )
                )
            )
        )
    ),
);