<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmpleadoController extends Controller
{
    /**
     * Muestra la lista de empleados.
     */
    public function index(Request $request)
    {
        //$empleados = Empleado::all();
        //return view('admin.listaEmpleados', compact('empleados'));
    }

    public function create(array $data) {}
    public function calcularEdad($fechaNacimiento)
    {
        if (!$fechaNacimiento) {
            return null;
        }
        $fecha = new \DateTime($fechaNacimiento);
        $hoy = new \DateTime();
        $edad = $hoy->diff($fecha)->y;

        return $edad;
    }
    
    /**
     * Almacena un nuevo empleado y usuario en la base de datos.
     * Valida los datos del formulario antes de proceder.
     */
    
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'idrol' => 'required|integer|exists:rol,idRol',
            'nombreUsuario' => 'required|string|max:12|unique:usuario',
            'email' => 'required|string|email|max:255|unique:usuario',
            'password' => 'required|string|min:8|confirmed',
            'dni' => 'required|digits:8|unique:empleados,dni',
            'nombre' => ['required', 'string', 'max:40', 'regex:/^[\p{L}\s]+$/u'],
            'apellido' => ['required', 'string', 'max:40', 'regex:/^[\p{L}\s]+$/u'],
            'telefono' => 'required|digits:9',
            'fNacimiento' => 'nullable|date',
            'direccion' => ['required', 'string', 'max:50'],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // 'nullable' hace que la foto sea opcional
        ], [
            'idrol.required' => 'El rol es obligatorio.',
            'nombreUsuario.required' => 'El nombre de usuario es obligatorio.',
            'nombreUsuario.unique' => 'El nombre de usuario ya está registrado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener 8 dígitos.',
            'dni.unique' => 'El dni ya está registrado verifica que es correcto.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'telefono.digits' => 'El teléfono debe tener 9 dígitos.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
            'foto.max' => 'La imagen no debe superar los 2MB.',
        ]);

        // Crear Usuario
        $usuario = Usuario::create([
            'idrol' => $request->idrol,
            'nombreUsuario' => $request->nombreUsuario,
            'email' => $request->email,

            'password' => Hash::make($request->password),
            'estado' => 'Activo',
        ]);

        // Cargar foto
        $rutaFoto = $request->file('foto') ? $request->file('foto')->store('fotos', 'public') : '';

        // Crear Empleado
        $empleado = Empleado::create([
            'idusuario' => $usuario->idUsuario,
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'fNacimiento' => $request->fNacimiento,
            'direccion' => $request->direccion,
            'foto' => $rutaFoto,
        ]);

        return redirect()->route('admin.createEmpleados')
            ->with('mensaje', 'Empleado creado exitosamente.')
            ->with('icono', 'success');
    }

     /**
     * Muestra la información de un usuario y su empleado asociado.
     */    

    public function show($id)
    {
        $usuario = Usuario::with('empleado')->findOrFail($id);
        $empleadoController = new EmpleadoController();
        $usuario->edad = $empleadoController->calcularEdad(optional($usuario->empleado)->fNacimiento);
        return view('admin.show', ['usuario' => $usuario]);
    }

    public function search(Request $request) {}


    /**
     * Edita la información de un usuario y su empleado asociado.
     */
    
    public function edit($id)
    {
        $usuario = Usuario::with('empleado')->findOrFail($id);
        $empleadoController = new EmpleadoController();
        $usuario->edad = $empleadoController->calcularEdad(optional($usuario->empleado)->fNacimiento);
        return view('admin.edit', ['usuario' => $usuario]);
    }

    public function update(Request $request, $id)
    {
        // Obtener el usuario y su empleado
        $usuario = Usuario::with('empleado')->findOrFail($id);
        $empleado = $usuario->empleado;

        // ValidaciÃ³n de datos
        $request->validate([
            'idrol' => Auth::user()->idrol == 1 ? 'required|integer|exists:rol,idRol' : 'nullable|integer|exists:rol,idRol',
            'nombreUsuario' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuario,email,' . $usuario->idUsuario . ',idUsuario',  // Usar idUsuario en vez de id
            'password' => $request->filled('password') ? 'required|string|min:8|confirmed' : '',
            'dni' => 'required|digits:8|unique:empleados,dni,' . $empleado->idEmpleado . ',idEmpleado',
            'nombre' => ['required', 'string', 'max:40', 'regex:/^[\p{L}\s]+$/u'],
            'apellido' => ['required', 'string', 'max:40', 'regex:/^[\p{L}\s]+$/u'],
            'telefono' => 'required|digits:9',
            'fNacimiento' => 'nullable|date',
            'direccion' => ['required', 'string', 'max:50'],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $rutaFoto = $empleado->foto; // Mantener la foto actual si no se sube una nueva
        if ($request->hasFile('foto')) {
            // Eliminar la foto anterior si existe
            if ($empleado->foto) {
                Storage::disk('public')->delete($empleado->foto);
            }
            // Guardar la nueva foto y obtener la ruta
            $rutaFoto = $request->file('foto')->store('fotos', 'public');
        }
        $idRolFinal = Auth::user()->idrol == 1 ? $request->idrol : $usuario->idrol;
        // Actualizar Usuario y Empleado
        $usuario->update([
            'idrol' => $idRolFinal,
            'nombreUsuario' => $request->nombreUsuario,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $usuario->password,
        ]);

        $empleado->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'fNacimiento' => $request->fNacimiento,
            'direccion' => $request->direccion,
            'foto' => $rutaFoto,
        ]);

        return redirect()->route('admin.empleados')
        ->with('mensaje', 'Datos actualizados exitosamente.')
        ->with('icono', 'success');
    }
    public function destroy($id)
    {
        // $empleado = Empleado::with('usuario')->findOrFail($id);
        // $usuario = $empleado->usuario;

        // // Eliminar empleado y usuario 
        // $empleado->delete();
        // $usuario->delete();
        // return redirect()->route('empleados.index')->with('success', 'Empleado y usuario eliminados exitosamente.');
    }
    // En tu controlador de usuarios
    public function deactivate($idUsuario)
    {
        $usuario = Usuario::find($idUsuario);
        if ($usuario) {
            // Cambia el estado a "Inactivo"
            $usuario->estado = 'Inactivo';
            $usuario->save();

            return redirect()->back()
                ->with('mensaje', 'Usuario desactivado exitosamente.')
                ->with('icono', 'success');
        }

        return redirect()->back()
            ->with('mensaje', 'Usuario no encontrado.')
            ->with('icono', 'error');
    }
    public function activate($idUsuario)
    {
        $usuario = Usuario::find($idUsuario);
        if ($usuario) {
            $usuario->estado = 'Activo';
            $usuario->save();
            return redirect()->back()
                ->with('mensaje', 'Usuario activado exitosamente.')
                ->with('icono', 'success');
        }
        return redirect()->back()
            ->with('mensaje', 'Usuario no encontrado.')
            ->with('icono', 'error');
    }
}
