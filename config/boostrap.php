<?php

use App\Loader\CustomAnnotationsClassLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;



require __DIR__.'/../vendor/autoload.php';

//PHP lOADER =========================
//$loader = new PhpFileLoader(new FileLocator(__DIR__.'/config'));
//$collection = $loader->load('routes.php');

//YAML LOADER
//$loader = new YamlFileLoader(new FileLocator(__DIR__.'/config'));
//$collection = $loader->load('routes.yaml');

//Annotations LOADER
$loader = new AnnotationDirectoryLoader(new FileLocator(__DIR__.'/../src/Controller'),new CustomAnnotationsClassLoader(new AnnotationReader()));
$collection = $loader->load(__DIR__.'/../src/Controller');

$matcher = new UrlMatcher($collection,new RequestContext('',$_SERVER['REQUEST_METHOD']));
$generator = new UrlGenerator($collection,new RequestContext());


$pathInfo = $_SERVER["PATH_INFO"] ?? '/';