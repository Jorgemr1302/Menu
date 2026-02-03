@extends('Admin.layout')

@section('contenido')

<form method="POST" action="{{ route('recargar') }}">
    @csrf
    <h1 class="text-center" style="font-size: 26px;"><i class="fas fa-money-bill-wave"></i> Recargar Saldo</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="color: rgb(0,0,0);"><i class="fa fa-user" style="font-size: 24px; border-color: rgb(0,0,0); color: rgb(0,0,0);"></i></span>
                    </div>
                    <!-- Input para mostrar el nombre -->
                    <input class="form-control" id="padre_name" list="listaclientes" name="idpadre" placeholder="Seleccione el Cliente" oninput="setPadreId(this)" />
                    <!-- Datalist con las opciones -->
                    <datalist id="listaclientes">
                        <option value="" selected>Seleccione el Cliente</option>
                        @foreach($padres as $padre)
                            <option value="{{ $padre->nombre_padre }} {{ $padre->apellido_padre }}" data-id="{{ $padre->idpadre }}"></option>
                        @endforeach
                    </datalist>
                    <!-- Campo oculto para enviar el id del padre -->
                    <input type="hidden" name="idpadre_hidden" id="padre_id" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label" style="color: rgb(0,0,0);">Fecha de Recarga:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar" style="font-size: 24px; color: rgb(0,0,0);"></i></span>
                    </div>
                    <input class="form-control" type="date" name="fecha_recarga" />
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label" style="color: rgb(0,0,0);">Monto:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-dollar" style="font-size: 24px; color: rgb(0,0,0);"></i></span>
                    </div>
                    <input type="text" class="form-control" inputmode="numeric" name="saldo_recarga" />
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 15px;">
        <button class="btn btn-primary" type="submit"><i class="fa fa-refresh"></i> Recargar</button>
    </div>
</form>

@endsection

<script>
    // Función para sincronizar el ID del padre con el input oculto
    function setPadreId(input) {
        var datalist = document.getElementById('listaclientes');
        var options = datalist.getElementsByTagName('option');
        
        // Recorre todas las opciones en el datalist
        for (var i = 0; i < options.length; i++) {
            // Si el valor del input coincide con el texto de la opción, asignar el id al campo oculto
            if (options[i].value === input.value) {
                var padreId = options[i].getAttribute('data-id');
                document.getElementById('padre_id').value = padreId;
                break;
            }
        }
    }
</script>

