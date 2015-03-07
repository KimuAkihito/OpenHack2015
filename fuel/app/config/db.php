<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
  'default' => array(
    'type' => 'mysql'
    'connection'  => array(
      'hostname'        => 'localhost',
      'database' => 'openhackday'
      'username'   => 'root',
      'password'   => '',
    ),
  ),
)
