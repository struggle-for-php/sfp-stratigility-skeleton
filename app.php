<?php
use Zend\Stratigility\MiddlewarePipe;
use Application\NotFound;

return call_user_func(function() {

    $services = include 'config/services.php';

    $app = new MiddlewarePipe();

    // basics eg.redirect

    // site 1
    $app->pipe($services->get('application'));
    // errors
    $app->pipe(new NotFound());

    // authentication
    
    // error handler
    $app->pipe($services->get('ErrorHandler'));

    return $app;
});
