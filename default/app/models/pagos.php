<?php
class Pago extends ActiveRecord
{
    // Configuración básica
    public function initialize()
    {
        // Conexión a BD (opcional si usas databases.ini)
        $this->set_connection('default');

        // Relaciones (ajusta según tu esquema)
        $this->belongs_to('cliente');       // Relación 1:1 con cliente
        $this->belongs_to('metodo_pago');   // Relación 1:1 con método de pago
        $this->has_many('pago_detalles');   // Relación 1:N con detalles (opcional)

        // Validaciones
        $this->validates_presence_of(
            'cliente_id',
            'message' => 'Debe seleccionar un cliente'
        );
    }

    /**
     * Calcula el total aplicado sumando detalles
     */
    public function getTotalAplicado()
    {
        if ($this->pago_detalles) {
            return array_reduce($this->pago_detalles,
                function($total, $detalle) {
                    return $total + $detalle->monto;
                }, 0);
        }
        return $this->monto ?? 0;
    }

    /**
     * Método para debug rápido
     */
    public static function healthCheck()
    {
        try {
            return (new self)->find_first();
        } catch (Exception $e) {
            throw new Exception("Error en modelo Pago: " . $e->getMessage());
        }
    }
}
?>