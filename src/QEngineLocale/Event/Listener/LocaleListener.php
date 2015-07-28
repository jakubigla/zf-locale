<?php

namespace QEngineLocale\Event\Listener;

use QEngineLocale\ModuleOptions;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\RequestInterface;

class LocaleListener extends AbstractListenerAggregate implements ListenerAggregateInterface
{
    CONST PRIORITY = -10000;

    /** @var ModuleOptions */
    private $moduleOptions;

    /** @var PhpRequest */
    private $request;

    public function __construct(ModuleOptions $moduleOptions, RequestInterface $request)
    {
        $this->moduleOptions = $moduleOptions;
        $this->request       = $request;
    }

    /**
     * Attach one or more listeners
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

    public function handleLocale()
    {
        if ($this->moduleOptions->isMultiLingual() === false) {
            return;
        }

        if ($this->request instanceof PhpRequest === false) {
            return;
        }

        $uri   = $this->request->getUri();
        $parts = explode('/', $uri->getPath());


    }
}
