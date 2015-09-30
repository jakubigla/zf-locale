<?php

namespace QEngine\Locale\View\Helper;

use QEngine\Locale\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;

/**
 * Class LocaleHelperFactory
 *
 * @package QEngine\Locale\View\Helper
 * @author Jakub Igla <jakub.igla@valtech.co.uk>
 */
class LocaleHelperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var HelperPluginManager     $serviceLocator */
        /** @var ServiceLocatorInterface $mainServiceLocator */
        /** @var ModuleOptions           $localeOptions */
        $mainServiceLocator = $serviceLocator->getServiceLocator();
        $localeOptions      = $mainServiceLocator->get(ModuleOptions::class);

        $helper = new LocaleHelper($localeOptions);
        return $helper;
    }
}