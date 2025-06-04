<?php
class ClientesController extends AppController {

    public function index(){
        $this->clientes = (new Clientes())->find();
    }

    public function show($id = null){
        if ($id) {
            $this->cliente = (new Clientes())->find($id);
        } else {
            Flash::error("ID de cliente no proporcionado.");
            return Redirect::to('clientes');
        }
    }

    public function registrar(){
        if (Input::hasPost('clientes')) {
            $postData = Input::post('clientes');

            // Procesar y validar datos
            $postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);
            $postData['activo'] = isset($postData['activo']) ? 1 : 0;
            $postData['created_at'] = date('Y-m-d H:i:s');
            $postData['updated_at'] = date('Y-m-d H:i:s');

            $cliente = new Clientes($postData);

            if ($cliente->create()) {
                Flash::valid("Cliente registrado correctamente");
                return Redirect::to('clientes');
            } else {
                Flash::error("Error al registrar el cliente");
            }
        }
    }
}