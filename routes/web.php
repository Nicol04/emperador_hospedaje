<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {return view('welcome');});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Admin
Route::get('/admin', action: [App\Http\Controllers\UsuarioController::class, 'indexAdmin'])->name('admin.index')->middleware('auth');
Route::get('/admin', [App\Http\Controllers\UsuarioController::class, 'conteoEmpleados'])->name('admin.index')->middleware('auth');
Route::get('/empleados', [App\Http\Controllers\UsuarioController::class, 'indexEmpleados'])->name('admin.empleados')->middleware('auth');
Route::get('/empleados/buscar', [App\Http\Controllers\UsuarioController::class, 'search'])->name('admin.empleados.search')->middleware('auth');

Route::get('/empleados/createEmpleados', [App\Http\Controllers\UsuarioController::class, 'create'])->name('admin.createEmpleados')->middleware('auth');
Route::post('/empleados/createEmpleados', [App\Http\Controllers\EmpleadoController::class, 'store'])->name('empleados.createEmpleados')->middleware('auth');

Route::get('/empleados/{id}', [App\Http\Controllers\EmpleadoController::class, 'show'])->name('admin.empleados.show')->middleware('auth');
//      Editar
Route::get('/empleados/{id}/edit', [App\Http\Controllers\EmpleadoController::class, 'edit'])->name('admin.empleados.edit')->middleware('auth');
Route::put('/empleados/{id}', [App\Http\Controllers\EmpleadoController::class, 'update'])->name('admin.empleados.update')->middleware('auth');
Route::post('/empleados/{id}/deactivate', [App\Http\Controllers\EmpleadoController::class, 'deactivate'])->name('admin.empleados.deactivate');
Route::post('/empleados/{id}/activate', [App\Http\Controllers\EmpleadoController::class, 'activate'])->name('admin.empleados.activate');


//Limpieza
Route::get('/habitaciones/limpieza', action: [App\Http\Controllers\InsumosLimpiezaController::class, 'index'])->name('habitaciones.limpieza.insumos_limpieza')->middleware('auth');
Route::get('/habitaciones/limpieza/registrar', action: [App\Http\Controllers\RegistroLimpiezaController::class, 'index'])->name('habitaciones.limpieza.index')->middleware('auth');
Route::get('/habitaciones/limpieza/agregarInsumos', action: [App\Http\Controllers\InsumosLimpiezaController::class, 'create'])->name('habitaciones.limpieza.agregarInsumos')->middleware('auth');
Route::post('/habitaciones/limpieza/agregarInsumos', action: [App\Http\Controllers\InsumosLimpiezaController::class, 'store'])->name('limpieza.agregarInsumos')->middleware('auth');

//Tipo Habitación
// Listar todos los tipos de habitación y buscar
Route::get('/habitaciones/tipohabitacion', [App\Http\Controllers\TipoHabitacionController::class, 'index'])
    ->name('habitaciones.tipohabitacion.index')
    ->middleware('auth');

// Mostrar el formulario para crear un nuevo tipo de habitación
Route::get('/habitaciones/tipohabitacion/create', [App\Http\Controllers\TipoHabitacionController::class, 'create'])
    ->name('habitaciones.tipohabitacion.create')
    ->middleware('auth');

// Guardar el nuevo tipo de habitación
Route::post('/habitaciones/tipohabitacion', [App\Http\Controllers\TipoHabitacionController::class, 'store'])
    ->name('habitaciones.tipohabitacion.store')
    ->middleware('auth');

// Mostrar el formulario para editar un tipo de habitación existente
Route::get('/habitaciones/tipohabitacion/{id}/edit', [App\Http\Controllers\TipoHabitacionController::class, 'edit'])
    ->name('habitaciones.tipohabitacion.edit')
    ->middleware('auth');

// Actualizar un tipo de habitación existente
Route::put('/habitaciones/tipohabitacion/{id}', [App\Http\Controllers\TipoHabitacionController::class, 'update'])
    ->name('habitaciones.tipohabitacion.update')
    ->middleware('auth');

// Eliminar un tipo de habitación
Route::delete('/habitaciones/tipohabitacion/{id}', [App\Http\Controllers\TipoHabitacionController::class, 'destroy'])
    ->name('habitaciones.tipohabitacion.destroy')
    ->middleware('auth');


use App\Http\Controllers\HabitacionController;

// Rutas para el controlador HabitacionController
Route::resource('habitaciones', HabitacionController::class);
    
// Ruta adicional para búsqueda de habitaciones por detalle (ubicación y piso)
Route::get('habitaciones/buscar', [HabitacionController::class, 'search'])->name('habitaciones.search');
    

//Reservas
Route::get('/habitaciones/reservas', action: [App\Http\Controllers\AlquilerController::class, 'index'])->name('habitaciones.reservas.index')->middleware('auth');
