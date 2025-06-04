<?php
class UsuariosController extends AppController
{
    public function before_filter()
    {
        Load::model('usuarios');
        View::template('default');
    }

    public function index()
    {
        try {
            $this->usuarios = (new Usuarios)->find();
        } catch (Exception $e) {
            Session::set('flash', [
                'type' => 'error',
                'message' => 'Error al cargar usuarios: '.$e->getMessage()
            ]);
        }
    }

    public function registro()
    {
        // Solo muestra la vista de registro
    }

    public function crear()
    {
        try {
            $usuario = new Usuarios(Input::post('usuarios'));

            // Validar que las contraseñas coincidan
            if (Input::post('usuarios')['password'] !== Input::post('confirm_password')) {
                Session::set('flash', [
                    'type' => 'error',
                    'message' => 'Las contraseñas no coinciden'
                ]);
                Redirect::to('usuarios/registro');
                return;
            }

            if ($usuario->password) {
                $usuario->password = password_hash($usuario->password, PASSWORD_DEFAULT);
            }

            if ($usuario->save()) {
                Session::set('flash', [
                    'type' => 'success',
                    'message' => 'Registro exitoso. Por favor inicia sesión'
                ]);
                Redirect::to('usuarios/login');
            } else {
                // Mantener los datos ingresados para mostrarlos nuevamente
                Session::set('form_data', Input::post('usuarios'));
                Session::set('flash', [
                    'type' => 'error',
                    'message' => 'Por favor corrige los errores en el formulario'
                ]);
                Redirect::to('usuarios/registro');
            }
        } catch (Exception $e) {
            Session::set('flash', [
                'type' => 'error',
                'message' => 'Error en el registro: '.$e->getMessage()
            ]);
            Redirect::to('usuarios/registro');
        }
    }

    public function login()
    {
        // Solo muestra la vista de login
    }

    public function autenticar()
    {
        try {
            $email = Input::post('email');
            $password = Input::post('password');

            // Buscar usuario en la base de datos
            $usuario = (new Usuarios)->autenticar($email, $password);

            if ($usuario) {
                // Configurar sesión (forma correcta para KumbiaPHP 1.2.1)
                Session::set('auth', [
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'email' => $usuario->email,
                    'rol' => $usuario->rol
                ]);

                Session::set('flash', [
                    'type' => 'success',
                    'message' => "Bienvenido {$usuario->nombre}"
                ]);
                Redirect::to('carrito/');
            } else {
                Session::set('flash', [
                    'type' => 'error',
                    'message' => 'Email o contraseña incorrectos'
                ]);
                Redirect::to('usuarios/login');
            }
        } catch (Exception $e) {
            Session::set('flash', [
                'type' => 'error',
                'message' => 'Error en el sistema: '.$e->getMessage()
            ]);
            Redirect::to('usuarios/login');
        }
    }

    public function logout()
    {
        // Cerrar sesión
        Session::delete('auth');
        Session::set('flash', [
            'type' => 'success',
            'message' => 'Sesión cerrada correctamente'
        ]);
        Redirect::to('usuarios/login');
    }
}