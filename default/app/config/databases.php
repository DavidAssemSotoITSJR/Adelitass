<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de conexión a la base de datos
 *
 * Configuración para entornos de desarrollo y producción
 */
return [
    'development' => [
        'host'      => 'localhost',
        'username'  => 'web',
        'password'  => '123456789',
        'name'      => 'pizzeria',
        'type'      => 'mysql',
        'charset'   => 'utf8mb4',
        'port'      => 3306,
        'collation' => 'utf8mb4_unicode_ci',
        'persistent'=> false,
        'options'   => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'production' => [
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => '123456789',
        'name'      => 'pizzeria',
        'type'      => 'mysql',
        'charset'   => 'utf8mb4',
        'port'      => 3306,
        'collation' => 'utf8mb4_unicode_ci',
        'persistent'=> false,
        'options'   => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => false,
            PDO::MYSQL_ATTR_SSL_CA => '/path/to/ca-cert.pem' // SSL para producción
        ]
    ]
];
