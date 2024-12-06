<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriumRequest;
use App\Models\Categorium;
use Illuminate\Http\Request;

class CategoriumController extends Controller
{
    /**
     * Muestra una lista de categorías con opciones de búsqueda y ordenación.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Categorium::query();

        // Búsqueda por nombre o descripción
        if ($search = $request->input('search')) {
            $query->where('nomCategoria', 'like', '%' . $search . '%')
                  ->orWhere('descripcion', 'like', '%' . $search . '%');
        }

        // Ordenación
        $sortBy = $request->input('sortBy', 'nomCategoria'); // Ordenar por nombre por defecto
        $sortDirection = $request->input('sortDirection', 'asc'); // Ascendente por defecto

        $categorias = $query->orderBy($sortBy, $sortDirection)->paginate(10);

        return view('categorium.index', compact('categorias', 'search', 'sortBy', 'sortDirection'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('categorium.create');
    }

    /**
     * Almacena una nueva categoría en la base de datos.
     *
     * @param CategoriumRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoriumRequest $request)
    {
        Categorium::create($request->validated());

        return redirect()->route('categorium.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una categoría existente.
     *
     * @param Categorium $categorium
     * @return \Illuminate\View\View
     */
    public function edit(Categorium $categorium)
    {
        return view('categorium.edit', compact('categorium'));
    }

    /**
     * Actualiza una categoría en la base de datos.
     *
     * @param CategoriumRequest $request
     * @param Categorium $categorium
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoriumRequest $request, Categorium $categorium)
    {
        $categorium->update($request->validated());

        return redirect()->route('categorium.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Elimina una categoría de la base de datos.
     *
     * @param Categorium $categorium
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Categorium $categorium)
    {
        $categorium->delete();

        return redirect()->route('categorium.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}

