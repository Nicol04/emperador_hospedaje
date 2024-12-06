@extends('layouts.admin')

@section('content')
    <form method="POST"
        action="{{ isset($tipoHabitacion) ? route('habitaciones.tipohabitacion.update', $tipoHabitacion->idTipoHabitacion) : route('habitaciones.tipohabitacion.store') }}"
        id="registerForm" enctype="multipart/form-data">
        @csrf
        @if (isset($tipoHabitacion))
            @method('PUT')
        @endif

        <div class="card card-primary mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    {{ isset($tipoHabitacion) ? __('Editar Tipo de Habitación') : __('Registrar Nuevo Tipo de Habitación') }}
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="tipoHabitacion">{{ __('Nombre de Tipo') }}</label>
                    <input id="tipoHabitacion" type="text"
                        class="form-control @error('tipoHabitacion') is-invalid @enderror" name="tipoHabitacion"
                        maxlength="12"
                        value="{{ old('tipoHabitacion', isset($tipoHabitacion) ? $tipoHabitacion->tipoHabitacion : '') }}"
                        placeholder="Ingresa un nombre" required autofocus pattern="[A-Za-z\s]+"
                        title="Solo letras y espacios">
                    <small id="usernameCounter" class="char-counter">12 caracteres restantes</small>

                    @error('tipoHabitacion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="card-footer text-center">
                <a href="{{ route('habitaciones.tipohabitacion.index') }}" class="btn btn-outline-dark me-2">
                    <i class="bi bi-x-circle-fill"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-outline-dark">
                    <i class="bi bi-save-fill"></i> {{ isset($tipoHabitacion) ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nombreInput = document.getElementById('tipoHabitacion');
            const counter = document.getElementById('usernameCounter');

            nombreInput.addEventListener('input', function() {
                const remaining = 12 - nombreInput.value.length;
                counter.textContent = `${remaining} caracteres restantes`;
            });
        });
    </script>
@endsection
