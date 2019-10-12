<?php

return [
    'name' => 'E-SPJ',
    'manifest' => [
        'name' => env('APP_NAME', 'LARAVEL'),
        'short_name' => env('APP_NAME', 'LARAVEL'),
        'start_url' => '/',
        'background_color' => '#56BCC9',
        'theme_color' => '#56BCC9',
        'display' => 'standalone',
        'orientation'=> 'any',
        'icons' => [
            '72x72' => '/app-images/images/icons/icon-72x72.png',
            '96x96' => '/app-images/images/icons/icon-96x96.png',
            '128x128' => '/app-images/images/icons/icon-128x128.png',
            '144x144' => '/app-images/images/icons/icon-144x144.png',
            '152x152' => '/app-images/images/icons/icon-152x152.png',
            '192x192' => '/app-images/images/icons/icon-192x192.png',
            '384x384' => '/app-images/images/icons/icon-384x384.png',
            '512x512' => '/app-images/images/icons/icon-512x512.png'
        ],
        'splash' => [
            '640x1136' => '/app-images/images/icons/splash-640x1136.png',
            '750x1334' => '/app-images/images/icons/splash-750x1334.png',
            '828x1792' => '/app-images/images/icons/splash-828x1792.png',
            '1125x2436' => '/app-images/images/icons/splash-1125x2436.png',
            '1242x2208' => '/app-images/images/icons/splash-1242x2208.png',
            '1242x2688' => '/app-images/images/icons/splash-1242x2688.png',
            '1536x2048' => '/app-images/images/icons/splash-1536x2048.png',
            '1668x2224' => '/app-images/images/icons/splash-1668x2224.png',
            '1668x2388' => '/app-images/images/icons/splash-1668x2388.png',
            '2048x2732' => '/app-images/images/icons/splash-2048x2732.png',
        ],
        'custom' => []
    ]
];
