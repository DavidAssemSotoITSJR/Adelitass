<?php
class CategoriasController extends AppController{
    public function index()
    {
        $this->categorias=(new categorias())->find();
    }
    public function show($id)
    {
        $this->categorias=(new categorias())->find($id);
    }
    public function registrar(){
        if(input::hasPost('categorias')){
            $categoria=new categorias(Input::post('categorias'));
            if($categoria->create()){
                Flash::valid("Categoria registrada");
                Input::delete();
            }
        }
        else{
            Flash::error("Error al registrar la categoria");
        }

    }
}