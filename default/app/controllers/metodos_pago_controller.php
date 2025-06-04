<?php
class MetodosPagoController extends AppController {
    public function index(){
        $this->metodos_pago=(new metodos_pago())->find();
    }
    public function show($id){
        $this->metodos_pago=(new metodos_pago())->find($id);
        //$this->id=$id;
    }
    public function test(){
    }
    public function registrar(){
        if(input::hasPost('metodos_pago')){
            $metodos_pago=new metodos_pago(Input::post('metodos_pago'));
            if($metodos_pago->create()){
                Flash::valid("metodo pago registrado");
                Input::delete();
            }
        }
        else{
            Flash::error("Error al registrar el metodo pago");
        }

    }

}