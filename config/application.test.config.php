<?php
return array(
    'modules' => array(
        'Application',
        'Finance',
        'Import',
    ),

    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),

        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,test}.php',
        ),

    ),

);
