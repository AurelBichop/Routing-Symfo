<?php

namespace App\Controller;

class HelloController
{
    public function sayHello(array $currentRoute)
    {
        dump($currentRoute);
        require __DIR__.'../../../pages/hello.html.php';
    }
}