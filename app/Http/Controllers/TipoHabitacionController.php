<?php

namespace App\Http\Controllers;

use App\Models\TipoHabitacion;
use Illuminate\Http\Request;

class TipoHabitacionController extends Controller
{
    // Muestra el listado de tipos de habitación
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tiposHabitacion = TipoHabitacion::when($search, function($query, $search) {
            return $query->where('tipoHabitacion', 'like', '%' . $search . '%')
                         ->orWhere('idTipoHabitacion', $search);
        })->get();

        return view('habitaciones.tipohabitacion.index', compact('tiposHabitacion'));
    }

    // Muestra el formulario para crear un nuevo tipo de habitación
    public function create()
    {
        return view('habitaciones.tipohabitacion.form');
    }

    // Almacena un nuevo tipo de habitación
    public function store(Request $request)
    {
        $request->validate([
            'tipoHabitacion' => 'required|string|max:255',
        ]);

        TipoHabitacion::create($request->only('tipoHabitacion'));

        return redirect()->route('habitaciones.tipohabitacion.index')->with('success', 'Tipo de habitación creado exitosamente.');
    }

    // Muestra el formulario para editar un tipo de habitación existente
    public function edit($id)
    {
        $tipoHabitacion = TipoHabitacion::findOrFail($id);
        return view('habitaciones.tipohabitacion.form', compact('tipoHabitacion'));
    }

    // Actualiza un tipo de habitación existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipoHabitacion' => 'required|string|max:255',
        ]);

        $tipoHabitacion = TipoHabitacion::findOrFail($id);
        $tipoHabitacion->update($request->only('tipoHabitacion'));

        return redirect()->route('habitaciones.tipohabitacion.index')->with('success', 'Tipo de habitación actualizado exitosamente.');
    }

    // Elimina un tipo de habitación
    public function destroy($id)
    {
        try {
            $tipoHabitacion = TipoHabitacion::findOrFail($id);
            $tipoHabitacion->delete();

            return redirect()->route('habitaciones.tipohabitacion.index')->with('success', 'Tipo de habitación eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('habitaciones.tipohabitacion.index')->with('error', 'No se pudo eliminar el tipo de habitación.');
        }
    }
}
