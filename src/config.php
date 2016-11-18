<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stub Groups
    |--------------------------------------------------------------------------
    |
    | You can register multiple stub groups and switch between them using
    | the -g|--group option
    |
    */
    'default_group' => 'siege',

    'groups' => [
    	// group name => path (relative to stub dir)
    	'siege' => 'base/'
    ],

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Unless you've configured Laravel resource locations,
    | these should work. (View is configured in config/view.php)
    |
    */
    'paths' => [
    	'stub' => realpath(base_path('resources/stubs')),
        'model' => realpath(base_path('app/')),
    	'controller' => realpath(base_path('app/Http/Controllers')),
    	'migration' => realpath(base_path('database/migrations')),
    	'seed' => realpath(base_path('database/seeds')),
    	'routes_file' => realpath(base_path('routes/web.php')),
        'factory_file' => realpath(base_path('database/factories/ModelFactory.php')),
    ],


];