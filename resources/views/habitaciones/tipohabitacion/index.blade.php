@extends('layouts.admin')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Listado de tipos de habitación</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html"
                    data-source-selector="#card-refresh-content">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between" style="padding: 10px;">
            <!-- Buscador -->
            <form action="{{ route('habitaciones.tipohabitacion.index') }}" method="GET" class="d-flex">
                <div class="input-group" style="width: 300px;">
                    <input type="text" name="search" id="search" class="form-control"
                        placeholder="Buscar por ID o Nombre" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Botón para crear nuevo tipo de habitación -->
            <a href="{{ route('habitaciones.tipohabitacion.create') }}" class="btn btn-outline-dark"
                style="margin-left: 10px;">
                <i class="bi bi-plus-circle"></i> Nuevo Tipo de Habitación
            </a>
        </div>

        <!-- Tabla de resultados -->
        <div id="tableView">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tiposHabitacion as $tipoHabitacion)
                        <tr>
                            <td>{{ $tipoHabitacion->idTipoHabitacion }}</td>
                            <td>{{ $tipoHabitacion->tipoHabitacion }}</td>
                            <td>
                                
                                <!-- Botón de Editar -->
                                <a href="{{ route('habitaciones.tipohabitacion.edit', $tipoHabitacion->idTipoHabitacion) }}" class="btn btn-success">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>

                                <!-- Botón de Eliminar -->
                                <form action="{{ route('habitaciones.tipohabitacion.destroy', $tipoHabitacion->idTipoHabitacion) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tipo de habitación?');">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </button>
                                </form>

                                

                            </td>

                            <td>
                                <!-- Botón de eliminación con mensaje personalizado -->
                                <button class="btn btn-danger" onclick="confirmAction('{{ route('habitaciones.tipohabitacion.destroy', $tipoHabitacion->idTipoHabitacion) }}', 'POST', '¿Estás seguro de eliminar el tipo de habitación: {{ $tipoHabitacion->tipoHabitacion }}?', 'Eliminar')">
                                    <i class="bi bi-trash-fill"></i> Eliminar
                                </button>
    
                                <!-- Botón de edición -->
                                <a href="{{ route('habitaciones.tipohabitacion.edit', $tipoHabitacion->idTipoHabitacion) }}" class="btn btn-success">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');
    
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const tipoHabitacionId = this.getAttribute('data-id');
                    const tipoHabitacionName = this.getAttribute('data-name');
    
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `Estás a punto de eliminar el tipo de habitación: ${tipoHabitacionName}`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Crear un formulario temporal para enviar la solicitud DELETE
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/habitaciones/tipohabitacion/${tipoHabitacionId}`;
    
                            // Agregar los tokens de CSRF y método DELETE
                            form.innerHTML = `
                                @csrf
                                @method('DELETE')
                            `;
    
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    

@endsection
