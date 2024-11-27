<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

 * Controlador para gestionar la confirmación de contraseñas.
 * 
 * Este controlador utiliza el trait `ConfirmsPasswords` para manejar la lógica
 * de confirmación de contraseñas antes de realizar acciones sensibles.
 */

class ConfirmPasswordController extends Controller
{
    use ConfirmsPasswords;

    /**
     * Ruta de redirección después de confirmar la contraseña.
     */
    
   protected $redirectTo = '/home';

     /**
     * Constructor del controlador.
     * 
     * Aplica el middleware `auth` para garantizar que solo usuarios autenticados
     * puedan acceder a las funcionalidades de confirmación de contraseña.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
}
