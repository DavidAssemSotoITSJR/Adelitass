<?php
class LoginController extends AppController
{
    public function index()
    {
        View::template('pizza'); // Usa tu template 'pizza.phtml'

        // Redireccionar si ya hay sesión válida
        if (Auth::is_valid()) {
            return Redirect::to('dashboard/');
        }

        if (Input::hasPost('login')) {
            $login = Input::post('login');
            $email = trim($login['email']);
            $password = $login['password'];

            // Validaciones básicas
            if (empty($email) || empty($password)) {
                Flash::error('Por favor ingresa el correo y la contraseña');
                return;
            }

            // Autenticación personalizada desde tu modelo Usuarios
            $usuario = Usuarios::authenticate($email, $password);

            if ($usuario) {
                // Guardar la identidad en sesión
                Auth::set($usuario);

                // Registrar fecha de último acceso
                $usuario->ultimo_acceso = date('Y-m-d H:i:s');
                $usuario->save();

                // Redirección
                $redirect = Session::get('redirect_to', 'dashboard/');
                Session::delete('redirect_to');
                return Redirect::to($redirect);
            } else {
                Flash::error('Credenciales incorrectas');
                Logger::error("Login fallido para: $email");
            }
        }
    }

    public function salir()
    {
        Auth::destroy_identity();
        Flash::success('Sesión cerrada correctamente');
        return Redirect::to('login/');
    }

    public function migrar()
    {
        if (Usuarios::migrarContraseñas() > 0) {
            Flash::success('Contraseñas migradas correctamente');
        } else {
            Flash::info('No había contraseñas para migrar');
        }
        return Redirect::to('login/');
    }
}
