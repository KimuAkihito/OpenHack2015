<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
<<<<<<< HEAD
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
=======
  'default' => array(
      'connection'  => array(
      'dsn'        => 'mysql:host=localhost;dbname=openhackday',
      'username'   => 'root',
      'password'   => '',
    ),
  ),
)
>>>>>>> 1d94572be18a2b834df33916884e2c554e5cb3c5
