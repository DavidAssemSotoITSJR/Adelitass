<?php
class metodos_pago extends ActiveRecord {
    public function initialize() {
        $this->has_many('ventas', 'model: Ventas', 'fk: clientes_id');
    }
}
