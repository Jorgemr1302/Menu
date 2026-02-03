@extends('Admin.layout')

@section('contenido')
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-lg p-5" style="max-width: 700px; margin: 0 auto;">
        <h4 class="mb-4 text-primary text-center"><i class="fas fa-file-alt"></i> Generar Reporte de Pedidos</h4>

        <form method="POST" action="{{ route('generar') }}">
            @csrf

            <!-- Cliente -->
            <div class="mb-4">
                <label for="select_cliente" class="form-label fw-semibold">Cliente:</label>
                <select class="form-select" name="idpadre" id="select_cliente" required style="width: 100%;">
                    <option value="">Seleccione el Cliente</option>
                </select>
            </div>

            <!-- Fechas -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="fecha_inicio" class="form-label fw-semibold">Fecha Inicio:</label>
                    <input class="form-control" name="fecha_inicio" type="date" required />
                </div>
                <div class="col-md-6">
                    <label for="fecha_fin" class="form-label fw-semibold">Fecha Fin:</label>
                    <input class="form-control" name="fecha_fin" type="date" required />
                </div>
            </div>

            <!-- Botón -->
            <div class="text-center">
                <button class="btn btn-primary px-4 py-2 fw-bold" type="submit">
                    <i class="fas fa-file-pdf"></i> Generar Reporte
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery + Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    $('#select_cliente').select2({
        placeholder: 'Seleccione el Cliente',
        minimumInputLength: 2,
        width: '100%',
        ajax: {
            url: '{{ route('buscar.cliente') }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.map(cliente => ({
                        id: cliente.id,
                        text: cliente.text
                    }))
                };
            },
            cache: true
        }
    });
});
</script>
@endpush
