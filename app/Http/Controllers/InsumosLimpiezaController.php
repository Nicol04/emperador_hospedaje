<?php

namespace App\Http\Controllers;
use App\Models\InsumosLimpieza;
use App\Models\Categorium;
use Illuminate\Http\Request;

class InsumosLimpiezaController extends Controller
{

    /**
     * Muestra un listado de insumos de limpieza con opción de filtro por categoría.
     */
    public function index(Request $request)
    {
        // Captura el ID de la categoría para aplicar el filtro, si está presente.
        $categoria_id = $request->input('categoria_id');
        
        // Consulta los insumos aplicando un filtro condicional por categoría y realiza la paginación.
        $insumos = InsumosLimpieza::when($categoria_id, function ($query, $categoria_id) {
            return $query->where('idcategoria', $categoria_id);
        })->paginate(10);
        // Obtiene todas las categorías para mostrarlas como opciones de filtro.
        $categorias = Categorium::all();
        
        // Retorna la vista con los datos de insumos y categorías.
        return view('habitaciones.limpieza.insumos_limpieza', compact('insumos', 'categorias'));
    }

    /**
     * Muestra el formulario para crear un nuevo insumo de limpieza.
     */
    
    public function create()
    {
        // Obtiene todas las categorías para asignarlas en el formulario.
        $categorias = Categorium::all();
        return view('habitaciones.limpieza.agregarInsumos', compact( 'categorias'));
    }

    /**
     * Almacena un nuevo insumo de limpieza en la base de datos.
     */
    
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'categoria_id' => 'required|integer|exists:categoria,idCategoria',
            'nombre' => ['required', 'string', 'max:50', 'regex:/^[\p{L}\s]+$/u'],
            'descripcion' => ['required', 'string', 'max:255'],
            'stock' => 'required|integer|min:1',
            'unidadMedida' => 'required|string|in:Kilogramos,Litros,Unidades,Paquete',
            'stockMinimo' => 'required|integer|min:1',
        ], [
            // Mensajes de error personalizados para mejorar la experiencia del usuario.
            'categoria_id.required' => 'La categoría es obligatoria.',
            'nombre.required' => 'El nombre del insumo de limpieza es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'unidadMedida.required' => 'La unidad de medida es obligatoria.',
            'stockMinimo.required' => 'El stock mínimo es obligatorio.',
        ]);

        // Crea un nuevo insumo de limpieza con los datos validados.
        InsumosLimpieza::create([
            'idcategoria' => $request->input('categoria_id'),
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'stock' => $request->input('stock'),
            'unidadMedida' => $request->input('unidadMedida'),
            'stockMinimo' => $request->input('stockMinimo'),
        ]);

        // Redirecciona a la ruta específica con un mensaje de éxito.
        return redirect()->route('habitaciones.limpieza.agregarInsumos')
            ->with('mensaje', 'Insumo de limpieza creado exitosamente.')
            ->with('icono', 'success');
    }

    /**
     * Muestra un recurso específico.
     */
    public function show(string $id)
    {
        //
    }

   /**
     * Muestra el formulario para editar un recurso específico.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Actualiza un recurso específico en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Elimina un recurso específico de la base de datos.
     */
    public function destroy(string $id)
    {
        //
    }
}
