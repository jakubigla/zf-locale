<?php

namespace QEngine\Locale\View\Helper;

use QEngine\Locale\ModuleOptions;
use Zend\View\Exception;
use Zend\View\Helper\Url as ZendUrl;

class UrlHelper extends ZendUrl
{
    /** @var ModuleOptions */
    private $moduleOptions;

    /**
     * @param ModuleOptions $moduleOptions
     */
    public function __construct(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * Generates a url given the name of a route.
     *
     * @see    Zend\Mvc\Router\RouteInterface::assemble()
     * @param  string               $name               Name of the route
     * @param  array                $params             Parameters for the link
     * @param  array|\Traversable    $options            Options for the route
     * @param  bool                 $reuseMatchedParams Whether to reuse matched parameters
     * @return string Url                         For the link href attribute
     * @throws Exception\RuntimeException         If no RouteStackInterface was provided
     * @throws Exception\RuntimeException         If no RouteMatch was provided
     * @throws Exception\RuntimeException         If RouteMatch didn't contain a matched route name
     * @throws Exception\InvalidArgumentException If the params object was not an array or \Traversable object
     */
    public function __invoke($name = null, $params = [], $options = [], $reuseMatchedParams = false)
    {
        $url    = parent::__invoke($name, $params, $options, $reuseMatchedParams);
        $locale = $this->moduleOptions->getCurrentLocale();

        if (isset($params['locale'])) {
            $locale = $params['locale'];
        }

        $url = '/' . $locale . $url;

        return $url;
    }
}