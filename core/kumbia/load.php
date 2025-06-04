<?php
/**
 * KumbiaPHP web & app Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 *
 * @category   Kumbia
 *
 * @copyright  Copyright (c) 2005 - 2023 KumbiaPHP Team (http://www.kumbiaphp.com)
 * @license    https://github.com/KumbiaPHP/KumbiaPHP/blob/master/LICENSE   New BSD License
 */

/**
 * Cargador Selectivo.
 *
 * Clase para la carga de librerías tanto del core como de la app.
 * Carga de los modelos de una app.
 *
 * @category   Kumbia
 */
class Load
{
    /**
     * Carga librería de APP, si no existe carga del CORE.
     *
     * @param string $lib Librería a cargar
     * @return mixed Resultado de la inclusión
     * @throws KumbiaException
     */
    public static function lib($lib)
    {
        if (!is_string($lib) || trim($lib) === '') {
            throw new KumbiaException("El nombre de la librería debe ser un string no vacío");
        }

        $file = APP_PATH . "libs/" . basename($lib) . ".php";
        if (is_file($file)) {
            return include $file;
        }

        return self::coreLib($lib);
    }

    /**
     * Carga librería del core.
     *
     * @param string $lib Librería a cargar
     * @return mixed Resultado de la inclusión
     * @throws KumbiaException
     */
    public static function coreLib($lib)
    {
        if (!is_string($lib) || trim($lib) === '') {
            throw new KumbiaException("El nombre de la librería debe ser un string no vacío");
        }

        $file = CORE_PATH . "libs/" . basename($lib) . "/" . basename($lib) . ".php";
        if (!is_file($file)) {
            throw new KumbiaException("Librería: \"$lib\" no encontrada");
        }

        return include $file;
    }

    /**
     * Obtiene la instancia de un modelo.
     *
     * @param string $model Modelo a instanciar
     * @param array $params Parámetros para el modelo
     * @return object Instancia del modelo
     * @throws KumbiaException
     */
    public static function model($model, array $params = [])
    {
        if (!is_string($model) || trim($model) === '') {
            throw new KumbiaException("El nombre del modelo debe ser un string no vacío");
        }

        $model = basename($model); // Previene path traversal
        $Model = Util::camelcase($model);

        if (!class_exists($Model, false)) {
            $modelFile = APP_PATH . "models/$model.php";
            if (!is_file($modelFile)) {
                throw new KumbiaException("Modelo \"$model\" no encontrado");
            }
            include $modelFile;
        }

        return new $Model($params);
    }

    /**
     * Carga múltiples modelos.
     *
     * @param string|array $models Modelo(s) a cargar
     * @throws KumbiaException
     */
    public static function models($models)
    {
        $args = is_array($models) ? $models : func_get_args();

        if (empty($args)) {
            throw new KumbiaException("Debe especificar al menos un modelo");
        }

        foreach ($args as $model) {
            if (!is_string($model) || trim($model) === '') {
                throw new KumbiaException("El nombre del modelo debe ser un string no vacío");
            }

            $model = basename($model);
            $Model = Util::camelcase($model);

            if (!class_exists($Model, false)) {
                $modelFile = APP_PATH . "models/$model.php";
                if (!is_file($modelFile)) {
                    throw new KumbiaException("Modelo \"$model\" no encontrado");
                }
                include $modelFile;
            }
        }
    }
}
