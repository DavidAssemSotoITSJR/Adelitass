<?php
class IndexController extends AppController
{
    public function index()
    {
        // Lógica para cargar tu página principal
        $this->title = 'Bienvenido a Adelitas';
        $this->render();
    }
}
