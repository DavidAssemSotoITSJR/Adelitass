<?php
class Inventario extends ActiveRecord {

    public function getIngredientes() {
        return $this->find("order: nombre ASC");
    }

    public function getIngredientesBajoStock() {
        return $this->find("conditions: stock < 10", "order: stock ASC");
    }
}
