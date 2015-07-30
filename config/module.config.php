<?php

namespace QEngineLocale;

use QEngineLocale\Service\LocaleNameParserService;
use QEngineLocale\Service\LocaleNameParserServiceFactory;

return [
    'QEngineLocale' => [
        'multi_language' => false,
        'available'      => [],
        'default'        => null,
        'domain_map'     => [],
        'mapped_domain_redirectable' => false,
    ],

    'service_manager' => [
        'factories' => [
            ModuleOptions::class           => ModuleOptionsFactory::class,
            LocaleNameParserService::class => LocaleNameParserServiceFactory::class,
        ],
    ],
];
