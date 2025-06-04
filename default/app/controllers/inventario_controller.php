<?php
class InventarioController extends AppController {

    public function index() {
        // Cargar todos los registros de la tabla inventario
        $this->inventarios = Load::model('inventario')->find();
    }
}
