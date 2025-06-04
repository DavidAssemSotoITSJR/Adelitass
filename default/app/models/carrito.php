<?php
class Carrito extends ActiveRecord {
    public function getCarritoPorCliente($id_cliente) {
        return $this->find("conditions: id_clientes = '$id_cliente'", "order: fecha_agregado DESC");
    }
    public function actualizarCantidad($id_carrito, $cantidad) {
        $carrito = $this->find($id_carrito);
        $carrito->cantidad = $cantidad;
        return $carrito->update();
    }
    public function cancelarItem($id_carrito) {
        $carrito = $this->find($id_carrito);
        $carrito->estado = 1; // Cancelado
        return $carrito->update();
    }
    public function procesarItem($id_carrito) {
        $carrito = $this->find($id_carrito);
        return $carrito->delete(); // O mover a tabla pedidos
    }
}
?>