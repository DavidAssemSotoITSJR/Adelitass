<?php
class Clientes extends ActiveRecord
{
    public function initialize()
    {
        $this->has_many('ventas');
    }
}
?>
