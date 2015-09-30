<?php

namespace QEngine\Locale\Navigation;

use QEngine\Locale\ModuleOptions;
use QEngine\Locale\Navigation\Page\Mvc;
use Zend\Navigation\Navigation;
use Zend\Navigation\Service\DefaultNavigationFactory;
use Zend\Config;
use Zend\Http\Request;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\RouteStackInterface as Router;
use Zend\Navigation\Exception;
use Zend\ServiceManager\ServiceLocatorInterface;

class LocaleNavigationFactory extends DefaultNavigationFactory
{
    /** @var ServiceLocatorInterface */
    private $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Zend\Navigation\Navigation
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $pages                = $this->getPages($serviceLocator);

        return new Navigation($pages);
    }

    /**
     * @param array $pages
     * @param RouteMatch $routeMatch
     * @param Router $router
     * @param null|Request $request
     * @return array
     */
    protected function injectComponents(
        array $pages,
        RouteMatch $routeMatch = null,
        Router $router = null,
        $request = null
    ) {
        foreach ($pages as &$page) {
            $hasUri = isset($page['uri']);
            $hasMvc = isset($page['action']) || isset($page['controller']) || isset($page['route']);
            if ($hasMvc) {
                if (!isset($page['routeMatch']) && $routeMatch) {
                    $page['routeMatch'] = $routeMatch;
                }
                if (!isset($page['router'])) {
                    $page['router'] = $router;
                }

                $page['locale'] = $this->serviceLocator->get(ModuleOptions::class)->getCurrentLocale();
                $page['type']   = Mvc::class;

            } elseif ($hasUri) {
                if (!isset($page['request'])) {
                    $page['request'] = $request;
                }
            }

            if (isset($page['pages'])) {
                $page['pages'] = $this->injectComponents($page['pages'], $routeMatch, $router, $request);
            }
        }
        return $pages;
    }
}