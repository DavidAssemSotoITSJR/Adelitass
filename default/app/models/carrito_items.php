<?php
class CarritoItems extends ActiveRecord
{
    public function initialize()
    {
        $this->belongs_to('carrito', 'model: carrito', 'fk: id_carrito');
        $this->belongs_to('productos', 'model: productos', 'fk: id_productos');
    }

    public function getSubtotal()
    {
        $producto = (new Productos)->find_first($this->id_productos);
        return $producto ? $producto->precio * $this->cantidad : 0;
    }

    public function getProducto()
    {
        return (new Productos)->find_first($this->id_productos);
    }
}