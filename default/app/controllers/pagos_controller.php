<?php
class PagosController extends AppController
{
    // Configuración de paginación
    const ITEMS_POR_PAGINA = 15;

    public function index()
    {
        try {
            // 1. Verificar existencia del modelo
            if (!class_exists('Pago')) {
                throw new Exception("Modelo no encontrado: app/models/pago.php");
            }

            // 2. Configurar paginación
            $pagina = max(1, Filter::get('pagina', 'int') ?? 1);
            $busqueda = Filter::get('busqueda', 'string');

            // 3. Construir consulta segura
            $conditions = '1=1';
            $params = [];

            if ($busqueda) {
                $conditions .= " AND (
                    referencia LIKE :busqueda OR 
                    cliente_id IN (
                        SELECT id FROM clientes 
                        WHERE nombre LIKE :busqueda
                    )
                )";
                $params[':busqueda'] = "%{$busqueda}%";
            }

            // 4. Obtener datos con eager loading
            $this->pagos = (new Pago)->find_all_by_sql(
                "SELECT p.*, 
                        c.nombre as cliente_nombre,
                        mp.nombre as metodo_pago_nombre
                 FROM pagos p
                 LEFT JOIN clientes c ON p.cliente_id = c.id
                 LEFT JOIN metodos_pago mp ON p.metodo_pago_id = mp.id
                 WHERE {$conditions}
                 ORDER BY p.created_at DESC
                 LIMIT " . self::ITEMS_POR_PAGINA .
                " OFFSET " . (($pagina - 1) * self::ITEMS_POR_PAGINA),
                $params
            );

            // 5. Configurar paginación
            $this->total_pagos = (new Pago)->count($conditions, $params);
            $this->total_paginas = ceil($this->total_pagos / self::ITEMS_POR_PAGINA);
            $this->pagina = $pagina;

        } catch (Exception $e) {
            // Manejo profesional de errores
            Logger::error("PagosController - " . $e->getMessage());
            Flash::error(
                "Error al cargar pagos. " .
                (K_DEBUG ? $e->getMessage() : "Contacte al administrador")
            );

            // Redirección segura
            Router::redirect('errores/sistema');
        }
    }
}
?>