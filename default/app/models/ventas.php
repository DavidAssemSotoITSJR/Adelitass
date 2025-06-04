<?php
class Ventas extends ActiveRecord
{
    public function initialize()
    {
        $this->has_many('detalle_venta');
        $this->belongs_to('clientes');

        // Callbacks
        $this->before_create = 'before_create';
        $this->before_update = 'before_update';
    }

    public function before_create()
    {
        $this->fecha_creacion = date('Y-m-d H:i:s');
        $this->fecha_actualizacion = date('Y-m-d H:i:s');
    }

    public function before_update()
    {
        $this->fecha_actualizacion = date('Y-m-d H:i:s');
    }

    /**
     * Retorna el nombre del método de pago basado en su ID
     */
    public function getMetodoPagoNombre()
    {
        $metodos = [
            1 => 'Efectivo',
            2 => 'Transferencia Bancaria',
            3 => 'Tarjeta de Crédito',
            4 => 'Tarjeta de Débito',
            5 => 'A crédito'
        ];

        return $metodos[$this->metodos_pago_id] ?? 'No especificado';
    }
}
?>
