<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
    'default' => array(
        'type'        => 'pdo',
        'connection'  => array(
            'dsn'        => 'mysql:host=localhost;dbname=openhack;charset=utf8;unix_socket=/private/tmp/mysql.sock',
            'username'   => 'root',
            'password'   => '7102531k',
            'persistent' => false,
            'compress'   => false,
        ),
        'identifier'   => '',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'enable_cache' => true,
        'profiling'    => false,
    ),
);
