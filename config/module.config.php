<?php

namespace QEngine\Locale;

use QEngine\Locale\Service\LocaleNameParserService;
use QEngine\Locale\Service\LocaleNameParserServiceFactory;

return [
    'QEngine\Locale' => [
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
