<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Detalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Container\Attributes\Database;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class HabitacionController extends Controller
{
    /**
     * Muestra una lista de habitaciones con la opción de buscar por detalle.
     */
    public function index(Request $request)
    {
        // Obtener los criterios de búsqueda desde la solicitud
        $ubicacion = $request->input('ubicación');
        $piso = $request->input('piso');

        // Construir consulta base
        $query = Habitacion::with(['detalle', 'tipo_habitacion']);

        // Aplicar filtros si se proporcionan 
        if ($ubicacion) {
            $query->whereHas('detalle', function ($q) use ($ubicacion) {
                $q->where('ubicacion', 'like', '%' . $ubicacion . '%');
            });
        }

        if ($piso) {
            $query->whereHas('detalle', function ($q) use ($piso) {
                $q->where('piso', $piso);
            });
        }

        // Obetener las habitaciones con los filtros aplicados
        $habitaciones = $query->get();

        // Retornamos la vista
        return view('habitaciones.index', compact('habitaciones'));
    }

    /**
     * Muestra el formulario para crear una nueva habitación.
     */

    public function create()
    {

        return view('habitaciones.gestionar.create');
    }
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'idtipoHabitacion' => 'required|integer|exists:tipo_habitacion,id',
            'estado' => 'required|string',
            'estadoLimpieza' => 'required|string',
            'detalle.ubicacion' => 'required|string',
            'detalle.piso' => 'required|integer',
        ]);

        // Usar una transacción para manejar los datos relacionados
        DB::beginTransaction();
        try {
            // Crear el detalle de la habitación
            $detalle = Detalle::create([
                'ubicacion' => $validatedData['detalle']['ubicacion'],
                'piso' => $validatedData['detalle']['piso'],
            ]);

            // Crear la habitación asociada al detalle
            $habitacion = Habitacion::create([
                'idtipoHabitacion' => $validatedData['idtipoHabitacion'],
                'iddetalle' => $detalle->idDetalle,
                'estado' => $validatedData['estado'],
                'estadoLimpieza' => $validatedData['estadoLimpieza'],
            ]);

            DB::commit();

            // Redirigir con mensaje de éxito
            return redirect()->route('habitaciones.index')->with('success', 'Habitación creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Hubo un problema al crear la habitación: ' . $e->getMessage()]);
        }
    }

    /**
     * Muestra los detalles de una habitación específica.
     */

    public function show($id)
    {
        $habitacion = Habitacion::with(['detalle', 'tipo_habitacion'])->findOrFail($id);
        return view('habitaciones.show', compact('habitacion'));
    }
    /**
     * Muestra el formulario para editar una habitación (opcional).
     */
    public function edit($id)
    {
        // Cargar la habitación para editar
        $habitacion = Habitacion::findOrFail($id);
        return view('habitaciones.edit', compact('habitacion'));
    }

/**
     * Actualiza los datos de una habitación en la base de datos (opcional).
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'idtipoHabitacion' => 'required|integer|exists:tipo_habitacion,id',
            'estado' => 'required|string',
            'estadoLimpieza' => 'required|string',
            'detalle.ubicacion' => 'sometimes|string',
            'detalle.piso' => 'sometimes|integer',
        ]);

        DB::beginTransaction();

        try {
            // Actualizar la habitación
            $habitacion = Habitacion::findOrFail($id);
            $habitacion->update([
                'idtipoHabitacion' => $validatedData['idtipoHabitacion'],
                'estado' => $validatedData['estado'],
                'estadoLimpieza' => $validatedData['estadoLimpieza'],
            ]);

            // Actualizar el detalle asociado si se envían datos
            if (isset($validatedData['detalle'])) {
                $habitacion->detalle->update($validatedData['detalle']);
            }

            DB::commit();

            return redirect()->route('habitaciones.index')->with('success', 'Habitación actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Hubo un problema al actualizar la habitación: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Elimina una habitación de la base de datos (opcional).
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $habitacion = Habitacion::findOrFail($id);

            // Eliminar el detalle asociado
            $habitacion->detalle->delete();

            // Eliminar la habitación
            $habitacion->delete();

            DB::commit();

            return redirect()->route('habitaciones.index')->with('success', 'Habitación eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Hubo un problema al eliminar la habitación: ' . $e->getMessage()]);
        }
    }
}
