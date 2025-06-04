<?php
class Usuarios extends ActiveRecord
{
    public function initialize()
    {
        $this->validates_presence_of('nombre', 'message: El nombre es obligatorio');
        $this->validates_presence_of('email', 'message: El email es obligatorio');
        $this->validates_uniqueness_of('email', 'message: Este email ya está registrado');
        $this->validates_presence_of('password', 'on: create', 'message: La contraseña es obligatoria');
        $this->validates_length_of('password', 'min: 6', 'on: create', 'message: La contraseña debe tener al menos 6 caracteres');
    }

    public function before_save()
    {
        $this->email = strtolower(trim($this->email));
    }

    public function autenticar($email, $password)
    {
        $usuario = $this->find_first("email = '$email'");

        if ($usuario) {
            // Verificar contraseña (sin hash para este caso de prueba)
            if ($usuario->password === $password) {
                return $usuario;
            }
        }

        return false;
    }
}
