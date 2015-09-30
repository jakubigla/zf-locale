<?php

namespace QEngine\Locale;

use QEngine\Locale\Service\LocaleNameParserService;
use QEngine\Locale\Service\LocaleNameParserServiceFactory;
use QEngine\Locale\View\Helper\LocaleHelperFactory;

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

    'view_helpers' => [
        'factories'=> [
            'qengineLocale' => LocaleHelperFactory::class,
        ],
    ],
];
