<?php

namespace QEngine\Locale\Event\Listener;

use QEngine\Locale\Exception\LocaleNotFoundException;
use QEngine\Locale\ModuleOptions;
use Locale;
use QEngine\Locale\Service\LocaleNameParserService;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Http\PhpEnvironment\Response as PhpResponse;
use Zend\Mvc\MvcEvent;

/**
 * Class LocaleListener
 *
 * @package QEngine\Locale\Event\Listener
 * @author Jakub Igla <jakub.igla@valtech.co.uk>
 */
class LocaleListener extends AbstractListenerAggregate implements ListenerAggregateInterface
{
    const PRIORITY = 999;

    /** @var MvcEvent */
    private $mvcEvent;

    public function __construct(MvcEvent $mvcEvent)
    {
        $this->mvcEvent = $mvcEvent;
    }

    /**
     * Attach handleLocale listener
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_ROUTE,
            array(
                $this,
                'handleLocale'
            ),
            self::PRIORITY
        );
    }

    /**
     * Handle locale
     */
    public function handleLocale()
    {
        /** @var PhpRequest $request */
        $request       = $this->mvcEvent->getRequest();
        $response      = $this->mvcEvent->getResponse();
        $moduleOptions = $this->getModuleOptions();

        if (!$request instanceof PhpRequest || !$moduleOptions->isMultiLanguage()) {
            return null;
        }

        /** @var LocaleNameParserService $localeNameParserService */
        $localeNameParserService = $this->mvcEvent
            ->getApplication()->getServiceManager()->get(LocaleNameParserService::class);

        try {
            $localeFromHost = $localeNameParserService->getLocaleFromHost();
            $this->setAppLocale($localeFromHost);

            if (!$moduleOptions->isMappedDomainRedirectable()) {
                return null;
            }
        } catch (LocaleNotFoundException $exception) {
            //no locale in host? Let's fond them somewhere else!
            $localeFromHost = null;
        }

        try {
            $localeFromPath = $localeNameParserService->getLocaleFromUriPath();
            $this->setAppLocale($localeFromPath);
            return null;

        } catch (LocaleNotFoundException $exception) {
            $localeFromPath = null;
        }

        if (is_null($localeFromPath) && !is_null($localeFromHost)) {

            return null;
        }

        //use browser locale
        try {
            $locale = $localeNameParserService->getLocaleFromBrowser();
        } catch (LocaleNotFoundException $exception) {
            $locale = $localeNameParserService->getDefaultLocale();
        }

        /** @var PhpResponse $response */
        $url      = $localeNameParserService->getUrlForLocale($locale);

        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(PhpResponse::STATUS_CODE_302);
        $response->sendHeaders();
        $this->mvcEvent->stopPropagation(true);

        return $response;
    }

    /**
     * @return ModuleOptions
     */
    private function getModuleOptions()
    {
        return $this->mvcEvent->getApplication()->getServiceManager()->get(ModuleOptions::class);
    }

    private function setAppLocale($locale)
    {
        Locale::setDefault($locale);

        /** @var LocaleNameParserService $localeNameParserService */
        /** @var PhpRequest              $request */
        $request                 = $this->mvcEvent->getRequest();
        $localeNameParserService = $this->mvcEvent
            ->getApplication()->getServiceManager()->get(LocaleNameParserService::class);
        $localeAlias             = $localeNameParserService->getAliasFromLocale($locale);

        $this->getModuleOptions()->setCurrentLocale($localeAlias);
    }
}
