<?php
Load::model('empleados');

class EmpleadosController extends AppController
{
    public function index()
    {
        try {
            // Mostrar solo empleados activos
            $this->empleados = (new Empleados())->find();
        } catch (Exception $e) {
            Flash::error('Error al cargar empleados: ' . $e->getMessage());
            $this->empleados = [];
        }
    }

    public function show($id)
    {
        try {
            $this->empleado = (new Empleados())->find_first((int)$id);
            if (!$this->empleado) {
                Flash::error('Empleado no encontrado');
                return Redirect::to('empleados/index');
            }
        } catch (Exception $e) {
            Flash::error('Error al cargar empleado: ' . $e->getMessage());
            return Redirect::to('empleados/index');
        }
    }

    public function registrar()
    {
        if (Input::hasPost('empleados')) {
            $datos = Input::post('empleados');

            // Encriptar la contraseña antes de guardar
            if (!empty($datos['contraseña'])) {
                $datos['contraseña'] = password_hash($datos['contraseña'], PASSWORD_DEFAULT);
            }

            $empleado = new Empleados($datos);

            if ($empleado->save()) {
                Flash::valid('Empleado registrado correctamente');
                return Redirect::to('empleados/index');
            } else {
                Flash::error('No se pudo registrar el empleado');
                foreach ($empleado->get_messages() as $msg) {
                    Flash::error($msg);
                }
                $this->empleado = $empleado;
            }
        }
    }


    public function crear()
    {
        if (Input::hasPost('empleados')) {
            $datos = Input::post('empleados');

            // Sanitizar teléfono: dejar solo números
            $datos['telefono'] = preg_replace('/[^0-9]/', '', $datos['telefono']);

            // Establecer por defecto activo = 1 si el campo existe
            $datos['activo'] = 1;

            $empleado = new Empleados($datos);

            if ($empleado->save()) {
                Flash::valid('Empleado registrado correctamente');
                return Redirect::to('empleados/index');
            } else {
                Flash::error('Error al registrar empleado');
                $this->empleado = $empleado;
            }
        }
    }
    public function actualizar($id)
    {
        $empleado = Empleados::find($id);

        if (!$empleado) {
            Flash::error('Empleado no encontrado');
            return Redirect::to('empleados/index');
        }

        if (Input::hasPost('empleados')) {
            $datos = Input::post('empleados');

            $empleado->nombre = $datos['nombre'];
            $empleado->email = $datos['email'];
            $empleado->telefono = $datos['telefono'];

            if (!empty($datos['contraseña'])) {
                $empleado->contraseña = password_hash($datos['contraseña'], PASSWORD_DEFAULT);
            }

            if ($empleado->save()) {
                Flash::valid('Empleado actualizado correctamente');
                return Redirect::to('empleados/index');
            } else {
                Flash::error('Error al actualizar');
                foreach ($empleado->get_messages() as $msg) {
                    Flash::error($msg);
                }
            }
        }

        $this->empleado = $empleado;
    }


}
