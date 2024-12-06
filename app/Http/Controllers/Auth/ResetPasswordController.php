<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Controlador para manejar el restablecimiento de contraseñas.
 *
 * Este controlador utiliza el trait `ResetsPasswords` para implementar la lógica 
 * de restablecimiento de contraseñas proporcionada por Laravel. 
 * Redirige a la ruta especificada tras un restablecimiento exitoso.
 */

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    /**
     * La ruta a la que se redirigirá al usuario después de un restablecimiento exitoso.
     *
     * @var string
     */
    protected $redirectTo = '/home';
}
