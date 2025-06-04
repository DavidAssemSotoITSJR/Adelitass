<?php
class VentasController extends AppController
{
    public function index()
    {
        $this->ventas = (new Ventas())->find();
    }

    public function nueva()
    {
        $this->clientes = (new Clientes())->find();
        $this->productos = (new Productos())->find();

        // Inicializar variables para la vista
        $this->cliente_id = null;
        $this->productos_seleccionados = [];
        $this->total = 0;
    }

    public function calcular()
    {
        $cliente_id = Input::post('venta')['clientes_id'];
        $productos = Input::post('productos');

        // Validar cliente
        $cliente = (new Clientes())->find_first((int)$cliente_id);
        if (!$cliente) {
            Flash::error('Cliente no válido');
            return Redirect::to('ventas/nueva');
        }

        $productos_seleccionados = [];
        $total = 0;

        if (is_array($productos)) {
            foreach ($productos as $producto) {
                $p = (new Productos())->find_first((int)$producto['id']);
                $cantidad = (int)$producto['cantidad'];

                if ($p && $cantidad > 0) {
                    $productos_seleccionados[] = [
                        'id' => $p->id,
                        'nombre' => $p->nombre,
                        'precio' => $p->precio,
                        'cantidad' => $cantidad
                    ];
                    $total += $p->precio * $cantidad;
                }
            }
        }

        if (empty($productos_seleccionados)) {
            Flash::error('Debe seleccionar al menos un producto con cantidad válida');
            return Redirect::to('ventas/nueva');
        }

        // Guardar carrito en sesión
        Session::set('carrito', [
            'cliente_id' => $cliente_id,
            'productos' => $productos_seleccionados,
            'total' => $total
        ]);

        return Redirect::to('ventas/carrito');
    }

    public function carrito()
    {
        $carrito = Session::get('carrito');

        if (!$carrito) {
            Flash::error('No hay productos en el carrito');
            return Redirect::to('ventas/nueva');
        }

        $this->cliente = (new Clientes())->find_first((int)$carrito['cliente_id']);
        $this->productos = $carrito['productos'];
        $this->total = $carrito['total'];

        // Métodos de pago
        $this->metodos_pago = [
            'efectivo' => 'Efectivo',
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito',
            'transferencia' => 'Transferencia Bancaria'
        ];
    }

    public function procesarPago()
    {
        if (Input::hasPost('pago')) {
            $pago = Input::post('pago');
            $carrito = Session::get('carrito');

            if (!$carrito) {
                Flash::error('La sesión del carrito ha expirado');
                return Redirect::to('ventas/nueva');
            }

            $venta = new Ventas([
                'clientes_id' => $carrito['cliente_id'],
                'fecha' => date('Y-m-d H:i:s'),
                'status' => 'completada',
                'metodo_pago' => $pago['metodo'],
                'total' => $carrito['total']
            ]);

            if ($venta->save()) {
                foreach ($carrito['productos'] as $producto) {
                    $detalle = new DetallesVentas([
                        'ventas_id' => $venta->id,
                        'productos_id' => $producto['id'],
                        'cantidad' => $producto['cantidad'],
                        'precio' => $producto['precio'],
                        'subtotal' => $producto['precio'] * $producto['cantidad']
                    ]);
                    $detalle->save();
                }

                Session::delete('carrito');
                Flash::valid('Venta registrada exitosamente');
                return Redirect::to('ventas/detalle/' . $venta->id);
            } else {
                Flash::error('Error al guardar la venta: ' . implode(', ', $venta->get_messages()));
            }
        }

        Flash::error('Error al procesar el pago');
        return Redirect::to('ventas/carrito');
    }

    public function getMetodoPagoNombre()
    {
        $metodos = [
            1 => 'Efectivo',
            2 => 'Transferencia Bancaria',
            3 => 'Tarjeta de Crédito',
            4 => 'Tarjeta de Débito',
            5 => 'A crédito'
        ];
        return $metodos[$this->metodos_pago_id] ?? 'No especificado';
    }
    public function detalle($id)
    {
        $this->venta = (new Ventas())->find_first((int)$id);
        $this->detalles = (new DetallesVentas())->find("ventas_id = {$id}");
    }
}
