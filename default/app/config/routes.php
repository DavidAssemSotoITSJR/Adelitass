<?php
return [
    'routes' => [
        // Ruta principal - redirige a index/index
        '/' => [
            'controller' => 'index',
            'action'     => 'index'
        ],
        
        // Ruta alternativa para /default/public
        '/default/public' => [
            'controller' => 'index',
            'action'     => 'index'
        ],
        
        // Ruta de status del sistema
        '/status' => 'pages/kumbia/status',
        
    ]
];
