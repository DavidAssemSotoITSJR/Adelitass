<?php
class DetallesVentas extends ActiveRecord
{
    public function initialize()
    {
        $this->belongs_to('ventas');
        $this->belongs_to('productos');

        // Callback como string
        $this->before_create = 'before_create';
    }

    public function before_create()
    {
        $this->creado_en = date('Y-m-d H:i:s');
    }
}
?>
