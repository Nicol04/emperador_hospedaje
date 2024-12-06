<?php

namespace App\Http\Controllers;

use App\Models\Caracteristica;
use Illuminate\Http\Request;

class CaracteristicaController extends Controller
{
    /**
     * Muestra un listado de las características con opciones de búsqueda y ordenación.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Búsqueda por nombre y ordenación por columna
        $query = Caracteristica::query();

        // Filtrar por nombre si se proporciona
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Ordenar por columna especificada (por defecto, 'idCaracteristica')
        $sortBy = $request->get('sortBy', 'idCaracteristica');
        $sortOrder = $request->get('sortOrder', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginar resultados
        $caracteristicas = $query->paginate(10);

        return view('caracteristicas.index', compact('caracteristicas'));
    }

    /**
     * Muestra el formulario para crear una nueva característica.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('caracteristicas.create');
    }

    /**
     * Almacena una nueva característica en la base de datos.
     * 
     * @param \App\Http\Requests\StoreCaracteristicaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaracteristicaRequest $request)
    {
        Caracteristica::create($request->validated());

        return redirect()->route('caracteristicas.index')->with('success', 'Característica creada exitosamente.');
    }

    /**
     * Muestra los detalles de una característica específica.
     * 
     * @param Caracteristica $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function show(Caracteristica $caracteristica)
    {
        return view('caracteristicas.show', compact('caracteristica'));
    }

    /**
     * Muestra el formulario para editar una característica específica.
     * 
     * @param Caracteristica $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function edit(Caracteristica $caracteristica)
    {
        return view('caracteristicas.edit', compact('caracteristica'));
    }

    /**
     * Actualiza una característica específica en la base de datos.
     * 
     * @param \App\Http\Requests\UpdateCaracteristicaRequest $request
     * @param Caracteristica $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCaracteristicaRequest $request, Caracteristica $caracteristica)
    {
        $caracteristica->update($request->validated());

        return redirect()->route('caracteristicas.index')->with('success', 'Característica actualizada exitosamente.');
    }

    /**
     * Elimina una característica específica de la base de datos.
     * 
     * @param Caracteristica $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caracteristica $caracteristica)
    {
        $caracteristica->delete();

        return redirect()->route('caracteristicas.index')->with('success', 'Característica eliminada exitosamente.');
    }
}

