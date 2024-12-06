<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlquilerRequest;
use App\Models\Alquiler;
use Illuminate\Http\Request;

class AlquilerController extends Controller
{
    /**
     * Muestra un listado de alquileres con soporte para búsqueda y ordenación.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Captura los parámetros de búsqueda y ordenación
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'fecha_entrada');
        $sortOrder = $request->get('sort_order', 'asc');

        // Obtiene el listado de alquileres con filtros aplicados
        $alquileres = Alquiler::query()
            ->when($search, function ($query, $search) {
                $query->where('idAlquiler', 'like', "%$search%")
                    ->orWhereHas('cliente', function ($q) use ($search) {
                        $q->where('nombre', 'like', "%$search%");
                    });
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);

        return view('alquiler.index', compact('alquileres'));
    }

    /**
     * Muestra el formulario para crear un nuevo alquiler.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alquiler.create');
    }

    /**
     * Guarda un nuevo alquiler en la base de datos.
     *
     * @param AlquilerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AlquilerRequest $request)
    {
        Alquiler::create($request->validated());

        return redirect()->route('alquiler.index')
            ->with('success', 'Alquiler creado exitosamente.');
    }

    /**
     * Muestra los detalles de un alquiler específico.
     *
     * @param Alquiler $alquiler
     * @return \Illuminate\Http\Response
     */
    public function show(Alquiler $alquiler)
    {
        return view('alquiler.show', compact('alquiler'));
    }

    /**
     * Muestra el formulario para editar un alquiler existente.
     *
     * @param Alquiler $alquiler
     * @return \Illuminate\Http\Response
     */
    public function edit(Alquiler $alquiler)
    {
        return view('alquiler.edit', compact('alquiler'));
    }

    /**
     * Actualiza los datos de un alquiler en la base de datos.
     *
     * @param AlquilerRequest $request
     * @param Alquiler $alquiler
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AlquilerRequest $request, Alquiler $alquiler)
    {
        $alquiler->update($request->validated());

        return redirect()->route('alquiler.index')
            ->with('success', 'Alquiler actualizado exitosamente.');
    }

    /**
     * Elimina un alquiler de la base de datos.
     *
     * @param Alquiler $alquiler
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Alquiler $alquiler)
    {
        $alquiler->delete();

        return redirect()->route('alquiler.index')
            ->with('success', 'Alquiler eliminado exitosamente.');
    }
}
