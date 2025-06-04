<?php
class ProductosController extends AppController {

    public function index() {
        $model = new Productos();
        $this->productos = $model->find();

        if (empty($this->productos)) {
            Flash::info('No hay productos registrados aún');
        }
    }

    public function show($id) {
        $model = new Productos();
        $this->producto = $model->find_first($id);

        if (!$this->producto) {
            Flash::error('El producto solicitado no existe');
            return $this->redirect('productos/index');
        }
    }

    public function registrar() {
        if (Input::hasPost('productos')) {
            $producto = new Productos(Input::post('productos'));

            // Manejo de la imagen
            if (isset($_FILES['productos']['tmp_name']['imagen_url']) &&
                $_FILES['productos']['error']['imagen_url'] == UPLOAD_ERR_OK) {

                $uploadDir = APP_PATH . 'public/img/productos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $fileName = 'product_' . time() . '_' . basename($_FILES['productos']['name']['imagen_url']);
                $targetFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['productos']['tmp_name']['imagen_url'], $targetFile)) {
                    $producto->imagen_url = $fileName;
                } else {
                    Flash::error('Error al subir la imagen');
                }
            }

            if ($producto->save()) {
                Flash::valid('Producto registrado correctamente');
                return $this->redirect('productos/index');
            } else {
                Flash::error('Error al registrar el producto: ' . $producto->get_error_string());
            }
        }
    }
}