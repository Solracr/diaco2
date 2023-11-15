<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Control de Expedientes',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
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
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<br>',
    //'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img' => 'img/pexx.jpeg',
    'logo_img2' => 'img/logo.png',
    'logo_img_class' => 'brand-image  elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AdminLTE',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
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
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
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
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
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
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
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
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => true,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => false,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => false,
        ],
       /* [
            'text'    => 'Usuarios',
            'icon'    => 'fas fa-arrow-circle-right',   
            'url'  => '/usuarios',                                 
        ],
        [
            'text'    => 'Roles',
            'icon'    => 'fas fa-arrow-circle-right',   
            'url'  => '/roles',                                 
        ],*/

        /*
          Permission::create(['name' => 'analista.analista'])->assignRole([1,3]);        
        Permission::create(['name' => 'analista.supervisor'])->assignRole([1,6]);        
        Permission::create(['name' => 'analista.firmante'])->assignRole([1,8]);        
        */ 
        [
            'text'    => 'Bandeja de expedientes',
            'icon'    => 'fas fa-arrow-circle-right',                        
            'can'  => 'analista.mesatrabajo',
            'submenu' => [
                [
                    'text' => 'Analista',
                    'icon' => 'fa fa-info-circle',
                    'url'  => '/analista/mesadetrabajo?status=ANALISIS',
                    'can'  => 'analista.analista'
                ],               
                [
                    'text' => 'Busquedad',
                    'icon' => 'fa fa-info-circle',
                    'url'  => '/migracion/buscar',
                    'can'  => 'analista.analista'
                ],   
                [
                    'text' => 'Jefe de Departamento',
                    'icon' => 'fa fa-check-square',
                    'url'  => '/analista/mesadetrabajo?status=RESOLUCION',
                    'can'  => 'analista.supervisor'
                ],
                [
                    'text' => 'Dashboard ',
                    'icon' => 'fa fa-check-square',
                    'url'  => '/analista/dashboard',
                    'can'  => 'analista.supervisor'
                ],
                [
                    'text' => 'Dirección',
                    'icon' => 'fa fa-dot-circle',
                    'url'  => '/analista/mesadetrabajo?status=APROBACION',
                    'can'  => 'analista.firmante'
                ],                                
            ],
        ],      
        /*[
            'text'    => 'Empresas',
            'icon'    => 'fa fa-university',     
            'can'     => 'solicitud.form_solicitud',                   
            'submenu' => [
                [
                    'text' => 'Nuevo Expediente',
                    'icon' => 'fa fa-file-alt',
                    'url'  => '/empresa/solicitud',                    
                ],
                [
                    'text' => 'Expedientes de Empresa',
                    'icon' => 'fa fa-file-alt',
                    'url'  => 'expedientes',
                ],
            ],
        ],*/
        [
            'text'    => 'Contratos de Adhesion',
            'icon'    => 'fa fa-user',  
            'can'     => 'solicitud.form_solicitud',                              
            'submenu' => [
                [
                    'text' => 'Bandeja Expedientes Contratos de Adhesion',
<<<<<<< HEAD
                    'icon' => 'fa fa-file-alt',
=======
                    'icon' => 'fa fa-inbox',
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f
                    //'route' => ['solicitud.grid_expedientes', ['selector' => 'C']],
                    //'url' => route('solicitud.grid_expedientes', 'C'),
                    'url'  => '/expedientes/grid?selector=C',
                    //url('expedientes/grid') . '?' . http_build_query(['selector' => 'C']),
                ],
                [
                    'text' => 'Formulario digital de solicitud de contrato de adhesión',
                    'icon' => 'fa fa-users',
                    'url'  => '/empresa/form_solicitud?IdEmpresa=0&tipo1=Solicitud&tipo2=A',
                ],            
            ],            
        ],
        [
            'text'    => 'Libro de Quejas',
            'icon'    => 'fa fa-user',  
            'can'     => 'solicitud.form_solicitud',                              
            'submenu' => [
                [
                    'text' => 'Bandeja de Expedientes Libro de Quejas',
                    'icon' => 'fa fa-file-alt',
                    'url'  => '/expedientes/grid_libro?selector=L',                  
                ],
                [
<<<<<<< HEAD
                    'text' => 'Formulario digital de solicitud de contrato de adhesión',
                    'icon' => 'fa fa-users',
                    'url'  => '/empresa/form_solicitud_libro?IdEmpresa=0&tipo1=Solicitud&tipo2=A',
                ], 
                [
                    'text' => 'Reporte de Libros de Quejas por rango de fechas',
                    'icon' => 'fa fa-users',
                    'url'  => '/empresa/rep_libro_fechas',
=======
                    'text' => 'Reporte de contrato de adhesión por rango de fechas',
                    'icon' => 'fa fa-file-alt',
                    'url'  => '/contrato/rep_contrato_fechas',
                ],            
            ],            
        ],
        [
            'text'    => 'Libro de Quejas',
            'icon'    => 'fa fa-user',  
            'can'     => 'solicitud.form_solicitud',                              
            'submenu' => [
                [
                    'text' => 'Bandeja de Expedientes Libro de Quejas',
                    'icon' => 'fa fa-inbox',
                    'url'  => '/expedientes/grid_libro?selector=L',                  
                ],
                [
                    'text' => 'Formulario digital de solicitud ',
                    'icon' => 'fa fa-users',
                    'url'  => '/empresa/form_solicitud_libro?IdEmpresa=0&tipo1=Solicitud&tipo2=B',
                ],
                [
                    'text' => 'Consulta de Libros de Quejas',
                    'icon' => 'fa fa-search',
                    'url'  => '/libro/rep_consultar',
                ],
                [
                    'text' => 'Libros de Quejas Anteriores',
                    'icon' => 'fa fa-search',
                    'url'  => '/libro/rep_consultar_old',
                ], 
                [
                    'text' => 'Reporte de Libros de Quejas por rango de fechas',
                    'icon' => 'fa fa-file-alt',
                    'url'  => '/libro/rep_periodo',
                ],                
            ],            
        ],
        [
            'text'    => 'Instrumentos de Medición y Pesaje',
            'icon'    => 'fa fa-user',  
            'can'     => 'solicitud.form_solicitud',                              
            'submenu' => [
                [
                    'text' => 'Listado de Expedientes',
                    'icon' => 'fa fa-inbox',
                    'url'  => '/empresa/grid_pesas?selector=L',                  
                ],
                [
                    'text' => 'Formulario digital de Instrumentos de Medición y Pesaje',
                    'icon' => 'fa fa-users',
                    'url'  => '/empresa/form_solicitud_pesas?IdEmpresa=0&tipo1=Solicitud&tipo2=C',
                ], 
                [
                    'text' => 'Reporte de Instrumentos de Medición y Pesaje por rango de fechas',
                    'icon' => 'fa fa-file-alt',
                    'url'  => '/empresa/rep_pesas_fechas',
                ],                
            ],            
        ],
        [
            'text'    => 'Certificaciones',
            'icon'    => 'fa fa-user',  
            'can'     => 'solicitud.form_solicitud',                              
            'submenu' => [                
                [
                    'text' => 'Formulario de Certificaciones y Otros ingresos',
                    'icon' => 'fa fa-users',
                    'url'  => '/certificaciones/f63a_solicitud?IdEmpresa=0&tipo1=Solicitud&tipo2=D',
                ], 
                [
                    'text' => 'Reportes',
<<<<<<< HEAD
                    'icon' => 'fa fa-users',                    
                    'url'  => '/certificaciones/grid_f63a_solicitud?Idx=5465465z&tipo3=z',
=======
                    'icon' => 'fa fa-users',
                    'url'  => '/empresa/rep_pesas_fechas',
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f
>>>>>>> d0850ca8e03bcd9df297446a98e3d52681dae4e3
                ],                
            ],            
        ],
/*************************************** */
        [
            'text'    => 'Informatica',
            'icon'    => 'fas fa-arrow-circle-right',   
            'can'     => 'admin.informatica',                             
            'submenu' => [                
                [
                    'text' => 'Inbox',
                    'icon' => 'fas fa-tools',
                    'url'  => '/empresa/ticket_grid',
                ],
                [
                    'text' => 'Reportes',
                    'icon' => 'fas fa-tools',
                    'url'  => '/empresa/grid_ticket_report',
                ],          
            ],
        ],

        /*************************************** */
        /*************************************** */
        [
            'text'    => 'Administrativo SGC',
            'icon'    => 'fas fa-arrow-circle-right',   
            'can'     => 'admin.sgc',                             
            'submenu' => [                
                [
                    'text' => 'Reporte Encuestas',
                    'icon' => 'fas fa-tools',
                    'url'  => '/empresa/sgc_grid',
                ],
            ],
        ],

/*************************************** */
        [
            'text'    => 'Soporte Tecnico Informatica',
            'icon'    => 'fas fa-arrow-circle-right',   
            //'can'     => 'solicitud.form_solicitud',                             
            'can'     => 'admin.informatica',                             
            'submenu' => [                               
                [
                    'text' => 'Crear Ticket',
                    'icon' => 'fas fa-tools',
                    'url'  => '/empresa/ticket',
                ],                     
            ],
        ],        
        [
            'text'    => 'USUARIOS',
            'icon'    => 'fas fa-arrow-circle-right',                        
            'can'  => 'analista.firmante',
            'submenu' => [
                [
                    'text' => 'ROLES Y PERMISOS',
                    'icon' => 'fa fa-user',
                    'url'  => '/users/viewx',
                    'can'  => 'analista.firmante'
                ],                                         
            ],
        ],            
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
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
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
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
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
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

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => false,
];
