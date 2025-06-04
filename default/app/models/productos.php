<?php
class Productos extends ActiveRecord
{
    public function initialize()
    {
        $this->has_many('detalle_venta');
    }
}
?>
