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
                        'controller'    => 'Helloworld\Controller\Index',
                        'action'        => 'index',
                    )
                ),
            ),
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller'    => 'Helloworld\Controller\Auth',
                        'action'        => 'login'
                    )
                )
            )
        )
    ),
    'controllers' => array( 
        'factories' => array(
            'Helloworld\Controller\Index' => 
                function(ServiceLocatorInterface $serviceLocator) 
                {
                    $ctr = new Helloworld\Controller\IndexController();
                    $ctr->setGreetingService($serviceLocator->getServiceLocator()->get('greetingService'));
                    return $ctr;
                },
            'Helloworld\Controller\Auth' =>
                function(ServiceLocatorInterface $serviceLocator)
                {
                    $ctr = new Helloworld\Controller\AuthController();
                    $ctr->setLoginForm(new \Helloworld\Form\Login());
                    return $ctr;
                }
        )
    ),
    'service_manager' => array(
        'invokables' => array(
            'greetingService' => 'Helloworld\Service\GreetingService'
        )
    )
);