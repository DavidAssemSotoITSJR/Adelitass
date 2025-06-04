<?php
/**
 * KumbiaPHP web & app Framework.
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 *
 * @copyright  Copyright (c) 2005 - 2023 KumbiaPHP Team (http://www.kumbiaphp.com)
 * @license    https://github.com/KumbiaPHP/KumbiaPHP/blob/master/LICENSE   New BSD License
 */

/**
 * Esta sección prepara el entorno
 * Todo esto se puede hacer desde la configuración del
 * Servidor/PHP, en caso de no poder usarlo desde ahí
 * Puedes descomentar estas lineas.
 */

//*Locale*
//setlocale(LC_ALL, 'es_ES');

//*Timezone*
//ini_set('date.timezone', 'America/New_York');

/**
 * Configuración de la aplicación
 */
const APP_CHARSET = 'UTF-8';
const PRODUCTION = false;

/*
 * Descomentar para mostrar los errores
 */
//error_reporting(E_ALL ^ E_STRICT);ini_set('display_errors', 'On');

/*
 * Define el APP_PATH
 */
define('APP_PATH', dirname(__DIR__).'/app/');
//const APP_PATH = '/path/to/app/';

/*
 * Define el CORE_PATH
 */
define('CORE_PATH', dirname(APP_PATH, 2).'/core/');
//const CORE_PATH = '/path/to/core/';

/*
 * Define el PUBLIC_PATH
 */
define('PUBLIC_PATH', substr($_SERVER['SCRIPT_NAME'], 0, -9)); // - index.php string[9]
//const PUBLIC_PATH = '/';

/**
 * Define la URL base de la aplicación
 * (Añadido para solucionar el error de URL_APP)
 */
define('URL_APP', 'http://localhost:8080/Adelitas/default/public/'.$_SERVER['HTTP_HOST'].PUBLIC_PATH);
// Para producción sería mejor usar:
// const URL_APP = 'https://tudominio.com/';

/**
 * Obtiene la URL de la aplicación
 */
$url = $_SERVER['PATH_INFO'] ?? '/';
//$url = $_GET['_url'] ?? '/'; // Alternativa usando $_GET

/**
 * Carga el gestor de arranque
 */
require CORE_PATH.'kumbia/bootstrap.php'; //bootstrap del core