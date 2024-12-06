<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Muestra una lista de clientes con funcionalidad de búsqueda y ordenación.
     */
    public function index(Request $request)
    {
        // Capturar parámetros de búsqueda y ordenación
        $search = $request->get('search', '');
        $sortBy = $request->get('sortBy', 'idCliente');
        $sortDirection = $request->get('sortDirection', 'asc');

        // Validar los parámetros de ordenación
        if (!in_array($sortBy, ['idCliente', 'dni', 'nombre', 'apellido', 'correo', 'telefono'])) {
            $sortBy = 'idCliente';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        // Consultar clientes con filtros aplicados
        $clientes = Cliente::query()
            ->where('dni', 'like', "%{$search}%")
            ->orWhere('nombre', 'like', "%{$search}%")
            ->orWhere('apellido', 'like', "%{$search}%")
            ->orWhere('correo', 'like', "%{$search}%")
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);

        return view('clientes.index', compact('clientes', 'search', 'sortBy', 'sortDirection'));
    }

    /**
     * Muestra el formulario para crear un nuevo cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Almacena un nuevo cliente en la base de datos.
     */
    public function store(ClienteRequest $request)
    {
        Cliente::create($request->validated());

        return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito.');
    }

    /**
     * Muestra los detalles de un cliente específico.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Muestra el formulario para editar un cliente específico.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualiza un cliente en la base de datos.
     */
    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito.');
    }

    /**
     * Elimina un cliente de la base de datos.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito.');
    }
}
