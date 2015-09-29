<?php

namespace QEngine\Locale\Service;

use QEngine\Locale\ModuleOptions;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\ServiceManager\Exception\RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class LocaleNameParserServiceFactory
 *
 * @package QEngine\Locale\Service
 * @author Jakub Igla <jakub.igla@valtech.co.uk>
 */
class LocaleNameParserServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return LocaleNameParserService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var PhpRequest $request */
        $request = $serviceLocator->get('Request');

        if (!$request instanceof PhpRequest) {
            throw new RuntimeException('Only request of Http type can work with this service');
        }

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);
        $localeHeader  = $request->getServer('HTTP_ACCEPT_LANGUAGE');

        return new LocaleNameParserService($moduleOptions, $request->getUri(), $localeHeader);
    }
}
