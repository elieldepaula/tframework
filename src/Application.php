<?php

declare(strict_types=1);

namespace Wpanel\Core;

use FastRoute\Dispatcher;
use DI\ContainerBuilder;

class Application {

    protected $container;
    protected $route;

    public function __construct($route)
    {

        $this->route = $route;

        $containerBuilder = new ContainerBuilder;
        $containerBuilder->addDefinitions(BASE_PATH . 'app/config.php');
        $this->container = $containerBuilder->build();;
        
    }

    public function run()
    {
        switch ($this->route[0]) {
            case Dispatcher::NOT_FOUND:
                echo '404 Not Found';
                break;
        
            case Dispatcher::METHOD_NOT_ALLOWED:
                echo '405 Method Not Allowed';
                break;
        
            case Dispatcher::FOUND:
                $controller = $this->route[1];
                $parameters = $this->route[2];
        
                // We could do $container->get($controller) but $container->call()
                // does that automatically
                $this->container->call($controller, $parameters);
                break;
        }
    }

}