<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoPagoRequest;
use App\Http\Requests\UpdateTipoPagoRequest;
use App\Models\TipoPago;
use Illuminate\Http\Request;

class TipoPagoController extends Controller
{
    /**
     * Muestra una lista de los tipos de pago con funcionalidad de búsqueda y ordenación.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Captura parámetros de búsqueda y ordenación
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'idTipoPago'); // Columna por defecto
        $sortOrder = $request->input('sort_order', 'asc'); // Orden por defecto

        // Realiza la consulta con filtros y ordenación
        $tipoPagos = TipoPago::when($search, function ($query, $search) {
                return $query->where('tipoPago', 'like', "%{$search}%")
                             ->orWhere('numCuenta', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10); // Paginación

        return view('tipo_pago.index', compact('tipoPagos', 'search', 'sortBy', 'sortOrder'));
    }

    /**
     * Muestra el formulario para crear un nuevo tipo de pago.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tipo_pago.create');
    }

    /**
     * Almacena un nuevo tipo de pago en la base de datos.
     *
     * @param StoreTipoPagoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTipoPagoRequest $request)
    {
        TipoPago::create($request->validated());

        return redirect()->route('tipo_pago.index')->with('success', 'Tipo de pago creado exitosamente.');
    }

    /**
     * Muestra los detalles de un tipo de pago específico.
     *
     * @param TipoPago $tipoPago
     * @return \Illuminate\View\View
     */
    public function show(TipoPago $tipoPago)
    {
        return view('tipo_pago.show', compact('tipoPago'));
    }

    /**
     * Muestra el formulario para editar un tipo de pago existente.
     *
     * @param TipoPago $tipoPago
     * @return \Illuminate\View\View
     */
    public function edit(TipoPago $tipoPago)
    {
        return view('tipo_pago.edit', compact('tipoPago'));
    }

    /**
     * Actualiza un tipo de pago existente en la base de datos.
     *
     * @param UpdateTipoPagoRequest $request
     * @param TipoPago $tipoPago
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTipoPagoRequest $request, TipoPago $tipoPago)
    {
        $tipoPago->update($request->validated());

        return redirect()->route('tipo_pago.index')->with('success', 'Tipo de pago actualizado exitosamente.');
    }

    /**
     * Elimina un tipo de pago de la base de datos.
     *
     * @param TipoPago $tipoPago
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TipoPago $tipoPago)
    {
        $tipoPago->delete();

        return redirect()->route('tipo_pago.index')->with('success', 'Tipo de pago eliminado exitosamente.');
    }
}
