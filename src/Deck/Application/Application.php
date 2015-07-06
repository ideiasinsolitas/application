<?php

namespace Deck\Application;

use Deck\Framework\StateManager;
use Deck\Router\Route;
use Deck\Router\Router;
use Deck\Router\Dispatcher;


/**
 * The short description
 *
 * As many lines of extendend description as you want {@link element}
 * links to an element
 * {@link http://www.example.com Example hyperlink inline link} links to
 * a website. The inline
 *
 * @package package name
 * @author  Pedro Koblitz
 */
class Application
{

   /*
    *
    */
    const VERSION = '0.1';

   /*
     * @var
     */
    protected $path;

    /*
     * @var
     */
    protected $container;

    /*
     * @var
     */
    protected $loader;

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    final public function __construct($path, array $providers = null)
    {

        if (!is_string($path)) {
            throw new \InvalidArgumentException('$path must be string');
        }
        
        $this->path = $path;
        $this->container = new Container();
        $this->dispatcher = new Dispatcher();
        $this->loader = new ResourceLoader();
        $routing = $this->loader->load('routing');
        $this->router = new Router($routing);

        $this->initialize();

        if ($providers) {
            foreach ($providers as $provider) {
                $this->addProvider($provider);
            }
        }
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function addProvider(ServiceProviderInterface $provider, $settings = array())
    {
        $this->container->register($provider, $settings);
    }

    public function initialize()
    {
        /**/
        $this->container['app.state'] = function ($container) {
            return new StateManager();
        };

        $this->container['app.state']->change('initialize.before');
        $this->container['app.path'] = $this->path;
        $this->container['app.settings'] = $this->loader->load('settings');

        $namespaces = array();
        $namespaces['package.core'] = self::PACKAGE_NAMESPACE;
        $namespaces['package.child'] = self::PACKAGE_CHILD_NAMESPACE;

        $this->container['app.namespaces'] = $namespaces;
        $this->container['app.state']->change('initialize.after');
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function run()
    {
        $this->container['app.state']->change('run.before');

        /* dispatch route */
        $this->container['app.state']->change('route.dispatch.before');
        $uri = $this->container['http.request']->getRequestUri();
        $this->router->match($uri);
        $action = $this->dispatcher->dispatch($route, $this->container);
        $this->container['app.state']->change('route.dispatch.after');

        /* call controller */
        $this->container['app.state']->change('controller.before');
        $action[0]->setContainer($this->container);
        $controller = MethodCaller::call($action[0], $action[1], $action[2]);
        $this->container['app.state']->setController($controller);
        $this->container['app.state']->change('controller.after');

        /* stop application */
        $this->container['app.state']->change('run.after');
        exit(0);
    }
}

$app = new Application('/');
$app->addProvider();
$app->run();
