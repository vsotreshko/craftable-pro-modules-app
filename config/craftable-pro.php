<?php

// config for Brackets/CraftablePro
use Brackets\CraftablePro\Translations\Scanners\External\JsonScanner;
use Brackets\CraftablePro\Translations\Scanners\External\PhpArrayScanner;
use Brackets\CraftablePro\Translations\Scanners\Internal\JsScanner;
use Brackets\CraftablePro\Translations\Scanners\Internal\PhpScanner;

return [
    /*
     * The fully qualified class name of the Craftable Pro user model.
     */
    'craftable_pro_user_model' => Brackets\CraftablePro\Models\CraftableProUser::class,
    // default media disk name
    'default_media_disk_name' => 'media',

    // define if email must be verified in order to be able to log in
    'require_email_verified' => true,

    // define or only active users can log in
    'allow_only_active_users_login' => true,

    // define if track user last activity timestamp
    'track_user_last_active_time' => true,

    'handle-inertia-request-class' => App\Http\Middleware\LocalHandleInertiaRequests::class,

    'self_registration' => [
        // define if users can self register into craftable pro interface
        'enabled' => false,

        // and if enabled, then which role(s) they should have assigned by default. Use role names here.
        // It can be a string for one role or an array for multiple roles.
        'default_role' => 'Guest',
        'allowed_domains' => [], // use * for allowing any domain
    ],

    'translations' => [
        'scan' => [
            PHPScanner::class => [
                'paths' => [
                    base_path('vendor/brackets/craftable-pro/src/Http/Controllers'),
                    resource_path('views'),
                ],
            ],
            JsScanner::class => [
                'paths' => [
                    base_path('vendor/brackets/craftable-pro/resources/js'),
                    resource_path('js'),
                ],
            ],
        ],

        //-----------------------------------------------------
        // Example of external language file
        //-----------------------------------------------------

        'external' => [
            [
                'group' => 'permissions',
                'scan' => [
                    JsonScanner::class => [
                        'paths' => [
                            resource_path('translations/permissions'),
                        ],
                    ],
                ],
            ],
            [
                'group' => 'locales',
                'scan' => [
                    JsonScanner::class => [
                        'paths' => [
                            resource_path('translations/locales'),
                        ],
                    ],
                ],
            ],
            [
                'scan' => [
                    PhpArrayScanner::class => [
                        'paths' => [
                            lang_path('/'),
                        ],
                    ],
                ],
            ],
        ],

        //-----------------------------------------------------
        // Example of publishing of json file with translations
        //-----------------------------------------------------

        'publish' => [
            'craftable-pro' => [
                'groups' => ['craftable-pro', 'permissions', 'locales'],
                'path' => public_path('lang/'),
            ],
        ],
    ],
    'social_login' => [
        'allowed_services' => [
            'microsoft' => false,
            'github' => false,
            'google' => false,
            'twitter' => false,
            'facebook' => false,
            'apple' => false,
        ],
        'self_registration' => [
            // define if users can self register into craftable pro interface
            'enabled' => true,
            // and if enabled, then which role(s) they should have assigned by default. Use role names here.
            // It can be a string for one role or an array for multiple roles.
            'default_role' => 'Administrator',
            'allowed_domains' => [], // use * for allowing any domain
        ],
    ],
];
