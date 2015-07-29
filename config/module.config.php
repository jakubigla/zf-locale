<?php

namespace QEngineLocale;

use QEngineLocale\Service\LocaleNameParserService;
use QEngineLocale\Service\LocaleNameParserServiceFactory;

return [
    'QEngineLocale' => [
        'multi_language' => true,
        'available'     => [
            'pl' => 'pl_PL',
            'en' => 'en_GB',
        ],
        'default'       => 'pl',
        'domain_map' => [
            //'localhost' => 'pl',
        ],
        'mapped_domain_redirectable' => false,
    ],

    'service_manager' => [
        'factories' => [
            ModuleOptions::class           => ModuleOptionsFactory::class,
            LocaleNameParserService::class => LocaleNameParserServiceFactory::class,
        ],
    ],
];
