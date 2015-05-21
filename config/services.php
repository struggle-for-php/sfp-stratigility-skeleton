<?php
return (new Zend\ServiceManager\ServiceManager)
->setService('Config', include 'parameters.php')
->setFactory('application', function($sm){
    return new SfpBackbeard\Middleware($sm);
})
->setFactory('routing-factory', function($sm){
    return function ($sm) {
        yield '/' => function () {
            return 'hello';
        };
    };
})
->setFactory('ErrorHandler', function($sm){
    $displayErrors = ($sm->get('Config')['env'] !== 'production');
    return new Application\ErrorHandler('views', $displayErrors);
});
