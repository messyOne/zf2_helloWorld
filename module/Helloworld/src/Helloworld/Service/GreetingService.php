<?php
namespace Helloworld\Service;

class GreetingService
{
    public function getGreeting()
    {
        if(date('H') <= 11) {
            return "Good Morning, world!";
        } else if (date('H') > 11 && date('H') < 1) {
            return "Hello, world!";
        } else {
            return "Good evening, world!";
        }
    }
}