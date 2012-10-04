<?php

namespace Helloworld\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    private $greetingService;

    public function indexAction()
    {
        return new ViewModel(
                        array(
                            'greeting' => $this->greetingService->getGreeting()
                        )
        );
    }

    public function setGreetingService($service)
    {
        $this->greetingService = $service;
    }

    public function dateAction()
    {
        $format = $this->getRequest()->getParam('format');

        if ($format) {
            return date($format) . PHP_EOL;
        } else {
            return date('D M d H:i:s e Y') . PHP_EOL;
        }
    }

    public function helloAction()
    {
        return new ViewModel(
            array(
                "number" => 3324234234.34234243,
                "price" => 1039.32,
                "date" => new \DateTime(),
                "greeting" => "Willkommen"
            )
        );
    }

}
