<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'Subidha',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => '<b>Subidha</b>',
    'logo_img' => 'images/subidha_logo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Subidha',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#661-authentication-views-classes
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#662-admin-panel-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'admin/dashboard',

    'logout_url' => 'admin/logout',

    'login_url' => 'admin/login',

    'register_url' => 'register',

    'password_reset_url' => 'password/reset',

    'password_email_url' => 'password/email',

    'profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/main.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        [
            'text' => 'search pharmacy',
            'search' => false,
            'topnav' => true,
        ],
//        [
//            'text' => 'blog',
//            'url'  => 'admin/blog',
//            'can'  => 'manage-blog',
//        ],
//        [
//            'text'        => 'pages',
//            'url'         => 'admin/pages',
//            'icon'        => 'far fa-fw fa-file',
//            'label'       => 4,
//            'label_color' => 'success',
//        ],
//        [
//            'text'        => 'users',
//            'url'         => 'admin/pages',
//            'icon'        => 'far fa-fw fa-file',
//            'label'       => 4,
//            'label_color' => 'success',
//        ],
        [
            'text'    => 'Manage Product',
            'icon'    => 'fas fa-cogs',
            'submenu' => [
                [
                    'text' => 'Product',
                    'icon_color' => 'cyan',
                    'url'  => 'products',
                ],
                [
                    'text' => 'Product Category',
                    'icon_color' => 'cyan',
                    'url'  => 'categories',
                ],
                [
                    'text' => 'Product Generic',
                    'icon_color' => 'cyan',
                    'url'  => 'generics',
                ],
                [
                    'text' => 'Product Form',
                    'icon_color' => 'cyan',
                    'url'  => 'forms',
                ],
                [
                    'text' => 'Product Unit',
                    'icon_color' => 'cyan',
                    'url'  => 'units',
                ],
                [
                    'text' => 'Product Company',
                    'icon_color' => 'cyan',
                    'url'  => 'companies',
                ],
            ],
        ],
        [
            'text'    => 'Pharmacy',
            'icon'    => 'fas fa-cogs',
            'url'     => 'pharmacies'
        ],
        [
            'text'    => 'Transaction History',
            'icon'    => 'fas fa-cogs',
            'submenu' => [
                [
                    'text'    => 'E-pay Transaction History',
                    'icon_color' => 'cyan',
                    'url'     => 'transaction-history'
                ],
                [
                    'text'    => 'COD Transaction History',
                    'icon_color' => 'cyan',
                    'url'     => 'cod-transaction-history'
                ],
                [
                    'text' => 'All transaction History',
                    'icon_color' => 'cyan',
                    'url' => 'all-transaction-history'
                ],
            ],
        ],
        [
            'text'    => 'Location',
            'icon'    => 'fas fa-map',
            'submenu' => [
                [
                    'text' => 'Divisions',
                    'icon_color' => 'cyan',
                    'url'  => 'locations/divisions',
                ],
                [
                    'text' => 'Districts',
                    'icon_color' => 'cyan',
                    'url'  => 'locations/districts',
                ],
                [
                    'text' => 'Thana',
                    'icon_color' => 'cyan',
                    'url'  => 'locations/thana',
                ],
                [
                    'text' => 'Area',
                    'icon_color' => 'cyan',
                    'url'  => 'locations/areas',
                ],
            ],
        ],
        [
            'text'    => 'Resources',
            'icon'    => 'fas fa-store-alt',
//            'url'     => 'resources',
            'submenu' => [
                [
                    'text' => 'Resource List',
                    'icon_color' => 'cyan',
                    'url'  => 'resources',
                ],
                [
                    'text' => 'Resource with Link',
                    'icon_color' => 'cyan',
                    'url'  => 'resources/create-with-link',
                ],
                [
                    'text' => 'Resource with File',
                    'icon_color' => 'cyan',
                    'url'  => 'resources/create-with-file',
                ],
            ],
        ],
        [
            'text'    => 'Notice',
            'icon'    => 'fas fa-store-alt',
            'url'     => 'notice'
        ],
        [
            'text'    => 'Customers',
            'icon'    => 'fas fa-store-alt',
            'url'     => 'customers'
        ],
        [
            'text'    => 'Orders',
            'icon'    => 'fas fa-store-alt',
            'url'     => 'orders'
        ],
        [
            'text'    => 'Banks',
            'icon'    => 'fas fa-store-alt',
            'url'     => 'bank'
        ],
        [
            'text'    => 'Delivery Time',
            'icon'    => 'fas fa-map',
            'submenu' => [
                [
                    'text' => 'Normal Delivery',
                    'icon_color' => 'cyan',
                    'url'  => 'delivery/normal-delivery',
                ],
                [
                    'text' => 'Express Delivery',
                    'icon_color' => 'cyan',
                    'url'  => 'delivery/express-delivery',
                ],
            ],
        ],
        [
            'text'    => 'Points',
            'icon'    => 'fas fa-store-alt',
//            'url'     => 'feedback'
            'submenu' => [
                [
                    'text' => 'Create Manual Point',
                    'icon_color' => 'cyan',
                    'url'  => 'points/create',
                ],
            ],
        ],
//        ['header' => 'account_settings'],
//        [
//            'text' => 'profile',
//            'url'  => 'admin/settings',
//            'icon' => 'fas fa-fw fa-user',
//        ],
//        [
//            'text' => 'change_password',
//            'url'  => 'admin/settings',
//            'icon' => 'fas fa-fw fa-lock',
//        ],
//        [
//            'text'    => 'multilevel',
//            'icon'    => 'fas fa-fw fa-share',
//            'submenu' => [
//                [
//                    'text' => 'level_one',
//                    'url'  => '#',
//                ],
//                [
//                    'text'    => 'level_one',
//                    'url'     => '#',
//                    'submenu' => [
//                        [
//                            'text' => 'level_two',
//                            'url'  => '#',
//                        ],
//                        [
//                            'text'    => 'level_two',
//                            'url'     => '#',
//                            'submenu' => [
//                                [
//                                    'text' => 'level_three',
//                                    'url'  => '#',
//                                ],
//                                [
//                                    'text' => 'level_three',
//                                    'url'  => '#',
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//                [
//                    'text' => 'level_one',
//                    'url'  => '#',
//                ],
//            ],
//        ],
//        ['header' => 'labels'],
//        [
//            'text'       => 'important',
//            'icon_color' => 'red',
//            'url'        => '#',
//        ],
//        [
//            'text'       => 'warning',
//            'icon_color' => 'yellow',
//            'url'        => '#',
//        ],
//        [
//            'text'       => 'information',
//            'icon_color' => 'cyan',
//            'url'        => '#',
//        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
