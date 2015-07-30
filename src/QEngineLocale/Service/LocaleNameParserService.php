<?php

namespace QEngineLocale\Service;

use QEngineLocale\Exception\LocaleNotFoundException;
use QEngineLocale\ModuleOptions;
use Zend\Uri\UriInterface;

/**
 * Class LocaleNameParserService
 *
 * @package QEngineLocale\Service
 * @author Jakub Igla <jakub.igla@valtech.co.uk>
 */
class LocaleNameParserService
{
    /** @var ModuleOptions */
    private $moduleOptions;

    /** @var UriInterface */
    private $uri;

    /** @var string */
    private $localeHeader;

    public function __construct(ModuleOptions $moduleOptions, UriInterface $uri, $localeHeader)
    {
        $this->localeHeader  = $localeHeader;
        $this->moduleOptions = $moduleOptions;
        $this->uri           = $uri;
    }

    /**
     * Get Locale from host
     *
     * @return null|string
     * @throws LocaleNotFoundException
     */
    public function getLocaleFromHost()
    {
        $host = $this->uri->getHost();

        if (!isset($this->moduleOptions->getDomainMap()[$host])) {
            throw new LocaleNotFoundException('No locale is mapped to this host');
        }

        return $this->getLocaleFromOptionsByKey($this->moduleOptions->getDomainMap()[$host]);
    }

    /**
     * Get locale from uri path
     *
     * @return string
     * @throws LocaleNotFoundException
     */
    public function getLocaleFromUriPath()
    {
        $pathParts = explode('/', $this->uri->getPath());

        if (!isset($pathParts[1])) {
            throw new LocaleNotFoundException('Locale not found in uri path');
        }

        $localeFromPath = $pathParts[1];

        if (empty($localeFromPath) || !$locale = $this->getLocaleFromOptionsByKey($localeFromPath)) {
            throw new LocaleNotFoundException('Uri path is not valid locale');
        }

        unset($pathParts[1]);
        $path = implode('/', $pathParts);

        if (empty($path)) {
            $path = '/';
        }

        $this->uri->setPath($path);

        return $locale;
    }

    /**
     * Get locale from browser
     *
     * @return string
     * @throws LocaleNotFoundException
     */
    public function getLocaleFromBrowser()
    {
        $locale = \Locale::acceptFromHttp($this->localeHeader);
        if (is_null($locale)) {
            throw new LocaleNotFoundException('Locale could not be obtain from browser');
        }

        return $this->getLocaleFromOptionsByKey($locale);
    }

    /**
     * Get default locale
     *
     * @return string
     * @throws LocaleNotFoundException
     */
    public function getDefaultLocale()
    {
        return $this->getLocaleFromOptionsByKey($this->moduleOptions->getDefault());
    }



    /**
     * Get uri for locale
     *
     * @param string $locale
     *
     * @return string
     */
    public function getUrlForLocale($locale)
    {
        $alias     = $this->getAliasFromLocale($locale);
        $path      = $this->uri->getPath();
        $pathParts = explode('/', $path);

        array_splice($pathParts, 1, 0, $alias);
        $path      = rtrim(implode('/', $pathParts), '/');

        return $path;
    }

    /**
     * Get Locale based on alias or actual locale
     *
     * @param string $key
     *
     * @return string
     * @throws LocaleNotFoundException
     */
    private function getLocaleFromOptionsByKey($key)
    {
        $available = $this->moduleOptions->getAvailable();

        if (isset($available[$key])) {
            return $available[$key];
        }

        if (array_search($key, $available) !== false) {
            return $key;
        }

        throw new LocaleNotFoundException('Locale could not be found in config');
    }

    /**
     * Get alias (if exists) from locale, otherwise return locale
     *
     * @param string $locale
     *
     * @return string
     * @throws LocaleNotFoundException
     */
    private function getAliasFromLocale($locale)
    {
        $locale = $this->getLocaleFromOptionsByKey($locale);
        $alias  = array_search($locale, $this->moduleOptions->getAvailable());

        if (is_string($alias)) {
            return $alias;
        }

        return $locale;
    }
}
