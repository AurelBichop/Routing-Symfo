<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

require __DIR__.'/vendor/autoload.php';


$listeRoute = new Route('/',[
    'controller'=>'App\Controller\TaskController@index'
]);
$createRoute = new Route('/create',[
    'controller'=>'App\Controller\TaskController@create'
],[],[],'localhost',['http'],['GET','POST']);
$showRoute = new Route('/show/{id}',[
    'controller'=>'App\Controller\TaskController@show'
],['id'=>'\d+']);
$helloRoute = new Route(
    '/hello/{name}',
    [
        'name'=>'World',
        'controller'=>'App\Controller\HelloController@sayHello'
    ]
);


$collection = new RouteCollection();
$collection->add('list',$listeRoute);
$collection->add('create',$createRoute);
$collection->add('show',$showRoute);
$collection->add('hello',$helloRoute);



$matcher = new UrlMatcher($collection,new RequestContext('',$_SERVER['REQUEST_METHOD']));
$generator = new UrlGenerator($collection,new RequestContext());


$pathInfo = $_SERVER["PATH_INFO"] ?? '/';

try{
    
    $currentRoute = $matcher->match($pathInfo);

    $controller = $currentRoute['controller'];
    $currentRoute['generator'] = $generator;

    $className = substr($controller,0,strpos($controller,'@'));
    $methodName  = substr($controller, strpos($controller,'@')+1);

    $instance = new $className;

    call_user_func([$instance,$methodName],$currentRoute);

}catch(ResourceNotFoundException $e){
    require 'pages/404.html.php';
    return;
}

