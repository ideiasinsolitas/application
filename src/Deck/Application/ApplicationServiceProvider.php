<?php

namespace Deck\Application;

use Deck\Application\Log\Log;
use Deck\Application\Cache\ApcCache;

class ApplicationServiceProvider implements ServiceProviderInterface
{
    /**
     *
     *
     *
     * @access       public
     * @param        type [ $varname] description
     * @return       type description
     */
    public function register(Container $container)
    {
        /* app */
        $container['app.resolver'] = function ($container) {
            return new PackageResolver($container['app.namespaces'], $container['app.settings']['resources']);
        };

        $container['app.cache'] = function ($container) {
            return new ApcCache($container['settings']['utility']['cache.default_ttl']);
        };

        $container['app.log'] = function ($container) {
            return new Log($container['log.handler']);
        };

        $container['app.encryption'] = function ($container) {
            return new Encryption($container['app.encryption']);
        };

        return $container;
    }
}
