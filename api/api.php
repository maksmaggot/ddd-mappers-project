<?php
/** @var \Composer\Autoload\ClassLoader $loader  */
$loader = require __DIR__.'/../vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationRegistry;
use Infrastructure\Application;

(new \Dotenv\Dotenv(__DIR__.'/../'))->load();

/** Workaround for Doctrine annotation autoloader */
AnnotationRegistry::registerLoader(function($class) use ($loader) {
    return $loader->loadClass($class);
});

$routes = include __DIR__ . '/../src/app/config/restRoutes.php';

$request = (new \Infrastructure\Models\RichRequest())->createFromGlobals();

(new Application($routes))->handle($request)->send();