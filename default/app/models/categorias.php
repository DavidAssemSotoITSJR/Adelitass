<?php
class categorias extends ActiveRecord{
    public function initialize() {
        $this->has_many('ventas', 'model: Ventas', 'fk: clientes_id');
    }
}