<?php
class DetallesVentas extends ActiveRecord
{
    public function initialize()
    {
        $this->belongs_to('ventas');
        $this->belongs_to('productos');
    }

    public function before_save()
    {
        $this->subtotal = $this->precio * $this->cantidad;
    }
}