<?php
// Archivo: /var/www/html/Adelitas/default/app/controllers/carrito_controller.php

Load::model('carrito');
Load::model('productos');

class CarritoController extends AppController
{
    public function index()
    {
        $this->carritos = (new Carrito)->getCarritoPorCliente(Session::get('id_cliente'));
        $this->productos = new Productos();
    }

    public function actualizar($id_carrito, $cantidad)
    {
        if ((new Carrito)->actualizarCantidad($id_carrito, $cantidad)) {
            Flash::valid('Cantidad actualizada correctamente');
        } else {
            Flash::error('Error al actualizar la cantidad');
        }
        return Redirect::to('carrito/');
    }

    public function cancelar($id_carrito)
    {
        if ((new Carrito)->cancelarItem($id_carrito)) {
            Flash::valid('Producto cancelado correctamente');
        } else {
            Flash::error('Error al cancelar el producto');
        }
        return Redirect::to('carrito/');
    }

    public function procesar($id_carrito)
    {
        if ((new Carrito)->procesarItem($id_carrito)) {
            Flash::valid('Pedido procesado correctamente');
        } else {
            Flash::error('Error al procesar el pedido');
        }
        return Redirect::to('carrito/');
    }
}
?>