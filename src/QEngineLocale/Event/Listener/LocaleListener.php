<?php

namespace QEngineLocale\Event\Listener;

use QEngineLocale\Exception\LocaleNotFoundException;
use QEngineLocale\ModuleOptions;
use Locale;
use QEngineLocale\Service\LocaleNameParserService;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Http\PhpEnvironment\Response as PhpResponse;
use Zend\Mvc\MvcEvent;

/**
 * Class LocaleListener
 *
 * @package QEngineLocale\Event\Listener
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
        $request       = $this->mvcEvent->getApplication()->getRequest();
        $moduleOptions = $this->getModuleOptions();

        if (!$request instanceof PhpRequest || !$moduleOptions->isMultiLanguage()) {
            return;
        }

        /** @var LocaleNameParserService $localeNameParserService */
        $localeNameParserService = $this->mvcEvent
            ->getApplication()->getServiceManager()->get(LocaleNameParserService::class);

        try {
            $localeFromHost = $localeNameParserService->getLocaleFromHost();
            Locale::setDefault($localeFromHost);

            if (!$moduleOptions->isMappedDomainRedirectable()) {
                return;
            }
        } catch (LocaleNotFoundException $exception) {
            //no locale in host? Let's fond them somewhere else!
            $localeFromHost = null;
        }



        try {
            $localeFromPath = $localeNameParserService->getLocaleFromUriPath();
            Locale::setDefault($localeFromPath);
            return;

        } catch (LocaleNotFoundException $exception) {
            $localeFromPath = null;
        }

        if (is_null($localeFromPath) && !is_null($localeFromHost)) {
            Locale::setDefault($localeFromHost);
            return;
        }

        //use browser locale
        try {
            $locale = $localeNameParserService->getLocaleFromBrowser();
        } catch (LocaleNotFoundException $exception) {
            $locale = $localeNameParserService->getDefaultLocale();
        }

        /** @var PhpResponse $response */
        $uri      = $localeNameParserService->getUriForLocale($locale);
        $response = $this->mvcEvent->getResponse();

        $response->getHeaders()->addHeaderLine('Location', $uri->getPath());
        $response->setStatusCode(PhpResponse::STATUS_CODE_302);
        $response->sendHeaders();
        $this->mvcEvent->stopPropagation(true);
    }

    /**
     * @return ModuleOptions
     */
    private function getModuleOptions()
    {
        return $this->mvcEvent->getApplication()->getServiceManager()->get(ModuleOptions::class);
    }
}
