<?php

class OpinionesController extends AppController
{
    public function index()
    {
        // Redirige automáticamente a dashboard
        Redirect::to('opiniones/dashboard');
    }

    public function dashboard()
    {
        // Cargar modelo solo una vez
        $model = Load::model('opiniones');

        // Obtener todas las opiniones
        $this->opiniones = $model->getOpiniones();

        // Conteo por calificación (0 a 5)
        $conteo = [];
        for ($i = 0; $i <= 5; $i++) {
            $conteo[$i] = $model->count("calificacion = $i");
        }
        $this->conteo_json = json_encode(array_values($conteo));

        // Calcular promedio de calificaciones
        $total = $model->count();
        $suma = $model->sum('calificacion');
        $this->promedio = ($total > 0) ? round($suma / $total, 2) : 0;
    }
}
