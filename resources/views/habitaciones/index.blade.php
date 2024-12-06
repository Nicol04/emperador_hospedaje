@extends('layouts.admin')

@section('content')
    <!-- Sección de Habitaciones Agrupadas por Piso -->
    @php
        // Agrupar habitaciones por piso
        $habitacionesPorPiso = $habitaciones->groupBy(function ($item) {
            return $item->detalle->piso; // Agrupa por el piso de cada habitación
        });
    @endphp
    <div class="content-header">

        <div>
            <h1 class="m-0">Administrar Habitaciones</h1>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between" style="padding: 10px;">
        <!-- Buscador -->
        <form action="{{ route('habitaciones.tipohabitacion.index') }}" method="GET" class="d-flex">
            <div class="input-group" style="width: 300px;">
                <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por ID o Nombre"
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

            </div>
        </form>

        <!-- Botón para crear nuevo tipo de habitación -->
        <a href="{{ route('habitaciones.tipohabitacion.create') }}" class="btn btn-outline-dark" style="margin-left: 10px;">
            <i class="bi bi-plus-circle"></i> Nueva Habitación
        </a>
    </div>

    <div class="d-flex align-items-center justify-content-between" style="padding: 10px;">
        <!-- Buscador -->
        <form action="{{ route('habitaciones.tipohabitacion.index') }}" method="GET" class="d-flex">
            <div class="input-group" style="width:fit-content">
                <select name="categoria_id" id="categoria" class="form-control">
                    <option value="">Todas las Categorías</option>
                </select>
                <select name="categoria_id" id="categoria" class="form-control">
                    <option value="">-- Todas las Categorías --</option>
                </select>
                
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter"></i>
                    </button>
                </div>

            </div>
        </form>

        <!-- Botón para crear nuevo tipo de habitación -->
        <a href="{{ route('habitaciones.tipohabitacion.create') }}" class="btn btn-outline-dark" style="margin-left: 10px;">
            <i class="bi bi-filter"></i> Filtrar
        </a>
    </div>

    <br>
    @foreach ($habitacionesPorPiso as $piso => $habitacionesEnPiso)
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">
                    Piso {{ $piso }}00
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    @foreach ($habitacionesEnPiso as $habitacion)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <!-- Small box para cada habitación -->
                            <div
                                class="small-box 
                @if ($habitacion->estado == 'Libre') bg-success 
                @elseif($habitacion->estado == 'Ocupado') bg-danger
                @else bg-secondary @endif">
                                <div class="inner p-4">
                                    <!-- Número de habitación -->
                                    <h3 class="text-white">Hab. #{{ $habitacion->idHabitacion }}</h3>
                                    <p class="text-white">{{ $habitacion->tipo_habitacion->nombre }}</p>
                                    <!-- Estado de limpieza con badge -->
                                    <p><strong>Estado de limpieza:</strong>
                                        <span
                                            class="badge badge-{{ $habitacion->estadoLimpieza == 'Limpio'
                                                ? 'primary'
                                                : ($habitacion->estadoLimpieza == 'Sucio'
                                                    ? 'warning'
                                                    : 'danger') }}">
                                            {{ $habitacion->estadoLimpieza }}
                                        </span>
                                    </p>
                                </div>
                                <div class="icon p-3">
                                    <i class="fas fa-bed fa-2x"></i>
                                </div>
                                <!-- Información adicional en un contenedor más limpio -->
                                <div class="small-box-footer d-flex justify-content-between align-items-center px-3 py-1">
                                    <div>
                                        <!-- Ubicación y Piso -->
                                        <p class="mb-0"><strong>Ubicación:</strong> {{ $habitacion->detalle->ubicacion }}
                                        </p>
                                    </div>
                                    <div>
                                        <!-- Tipo de habitación -->
                                        <p class="mb-0"><strong>Tipo:</strong>
                                            {{ $habitacion->tipo_habitacion->tipoHabitacion }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Enlace para ver detalles -->
                                <a href="{{ route('habitaciones.show', $habitacion->idHabitacion) }}"
                                    class="small-box-footer text-center py-2">
                                    <strong>Ver detalles</strong> <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    @endforeach
@endsection
