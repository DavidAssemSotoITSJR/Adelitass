<?php
class detalle extends ActiveRecord {
    public function initialize() {
        $this->belongs_to('ventas');
        $this->belongs_to('productos');
    }
}
?>
