<?php

namespace QEngineLocale;

use QEngineLocale\Event\Listener\LocaleListener;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 *
 * @package QEngineI18n
 * @author Jakub Igla <jakub.igla@gmail.com>
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface
{
    /**
     * Listen to the bootstrap event
     *
     * @param MvcEvent $event
     * @return array
     */
    public function onBootstrap(MvcEvent $event)
    {
        $localeListener = new LocaleListener($event);
        $localeListener->attach($event->getApplication()->getEventManager());
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'factories'  => [

            ],
        ];
    }
}
