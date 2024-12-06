<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;
  /**
     * Middleware para permitir solo acceso de usuarios invitados (no autenticados).
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Valida los datos del registro de usuario.
     *
     * @param array $data Datos proporcionados por el formulario de registro.
     * @return \Illuminate\Contracts\Validation\Validator Validador configurado con las reglas.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'idrol' => ['required', 'integer', 'exists:rol,idRol'], // Verifica que idrol exista en la tabla rol
            'nombreUsuario' => ['required', 'string', 'max:12'],
            'email' => ['required', 'string', 'email', 'max:90', 'unique:usuario'],
            'password' => ['required', 'string', 'min:8', 'max:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
        ]);
    }
       /**
     * Crea una nueva instancia de usuario tras el registro exitoso.
     *
     * @param array $data Datos validados proporcionados por el formulario de registro.
     * @return \App\Models\Usuario El modelo de usuario creado.
     */
    protected function create(array $data)
    {
        return Usuario::create([
            'idrol' => $data['idrol'], 
            'nombreUsuario' => $data['nombreUsuario'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
