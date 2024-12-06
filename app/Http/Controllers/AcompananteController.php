<?php

namespace App\Http\Controllers;

use App\Models\Acompanante;
use App\Http\Requests\AcompananteRequest;
use Illuminate\Http\Request;

class AcompananteController extends Controller
{
    /**
     * Muestra una lista de los acompañantes con búsqueda y ordenación.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Recuperar los parámetros de búsqueda y ordenación
        $search = $request->input('search');
        $sortField = $request->input('sort_field', 'nombre'); // Campo de orden por defecto
        $sortDirection = $request->input('sort_direction', 'asc'); // Dirección por defecto

        // Construir la consulta con búsqueda y ordenación
        $acompanantes = Acompanante::query()
            ->when($search, function ($query, $search) {
                $query->where('dni', 'like', "%$search%")
                      ->orWhere('nombre', 'like', "%$search%")
                      ->orWhere('apellido', 'like', "%$search%")
                      ->orWhere('telefono', 'like', "%$search%");
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10); // Paginación

        return view('acompanantes.index', compact('acompanantes', 'search', 'sortField', 'sortDirection'));
    }

    /**
     * Muestra el formulario para crear un nuevo acompañante.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('acompanantes.create');
    }

    /**
     * Almacena un nuevo acompañante en la base de datos.
     *
     * @param AcompananteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AcompananteRequest $request)
    {
        Acompanante::create($request->validated());

        return redirect()->route('acompanantes.index')
            ->with('success', 'Acompañante creado correctamente.');
    }

    /**
     * Muestra los detalles de un acompañante específico.
     *
     * @param Acompanante $acompanante
     * @return \Illuminate\View\View
     */
    public function show(Acompanante $acompanante)
    {
        return view('acompanantes.show', compact('acompanante'));
    }

    /**
     * Muestra el formulario para editar un acompañante.
     *
     * @param Acompanante $acompanante
     * @return \Illuminate\View\View
     */
    public function edit(Acompanante $acompanante)
    {
        return view('acompanantes.edit', compact('acompanante'));
    }

    /**
     * Actualiza un acompañante en la base de datos.
     *
     * @param AcompananteRequest $request
     * @param Acompanante $acompanante
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AcompananteRequest $request, Acompanante $acompanante)
    {
        $acompanante->update($request->validated());

        return redirect()->route('acompanantes.index')
            ->with('success', 'Acompañante actualizado correctamente.');
    }

    /**
     * Elimina un acompañante de la base de datos.
     *
     * @param Acompanante $acompanante
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Acompanante $acompanante)
    {
        $acompanante->delete();

        return redirect()->route('acompanantes.index')
            ->with('success', 'Acompañante eliminado correctamente.');
    }
}

// AcompananteRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcompananteRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dni' => 'required|string|max:8|unique:acompanante,dni,' . ($this->acompanante->idalquiler ?? 'NULL') . ',idalquiler',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:15',
        ];
    }

    /**
     * Mensajes de validación personalizados.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.max' => 'El DNI no puede superar los 8 caracteres.',
            'dni.unique' => 'El DNI ya está registrado.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede superar los 100 caracteres.',
            'telefono.max' => 'El teléfono no puede superar los 15 caracteres.',
        ];
    }
}
