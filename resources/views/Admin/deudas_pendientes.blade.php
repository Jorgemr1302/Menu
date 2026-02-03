@extends('Admin.layout')

@section('contenido')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <i class="fa fa-credit-card"></i> Deudas de Padres y Profesores
        </div>
        <div class="card-body">
            <input type="text" id="buscarInput" class="form-control mb-3" placeholder="Buscar...">
            <div class="table-responsive">
                <table class="table table-striped" id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo Usuario</th>
                            <th>Email</th>
                            <th>Deuda Total</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $padre)
                        <tr>
                            <td>{{ $padre->nombre_padre }} {{ $padre->apellido_padre }}</td>
                            <td>{{ $padre->tipo_usuario ?? 'Padre' }}</td>
                            <td>{{ $padre->email_padre }}</td>
                            <td>
                                @php
                                    $deuda = number_format($padre->deuda_total, 2);
                                    $esDeuda = $padre->deuda_total > 0;
                                @endphp
                                <span class="{{ $esDeuda ? 'text-danger' : 'text-success' }}">
                                    S/ {{ $deuda }}
                                </span>
                            </td>
                            <td>
                                @if($esDeuda)
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalPagar" onclick="cargarModal({{ $padre->idpadre }}, '{{ $padre->nombre_padre }} {{ $padre->apellido_padre }}')">
                                    <i class="fa fa-money"></i> Pagar Deuda
                                </button>
                                @else
                                <span class="text-muted">Sin deuda</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de pago -->
<div class="modal fade" id="modalPagar" tabindex="-1" aria-labelledby="modalPagarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="modalPagarLabel">Pagar Deuda</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idpadreInput" name="idpadre">
            <p id="textoPadre"></p>
            <div class="mb-3">
                <label for="tipo_pago" class="form-label">Seleccione método de pago:</label>
                <select id="tipo_pago" class="form-select" required>
                    <option value="">Seleccione</option>
                    <option value="Plin">Plin</option>
                    <option value="Yape">Yape</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Efectivo">Efectivo</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-success" onclick="pagarDeudaAjax()">Confirmar Pago</button>
        </div>
    </div>
  </div>
</div>

<!-- Toast elegante -->
<div id="toastDeuda" class="toast align-items-center text-white bg-success border-0 position-fixed top-0 start-50 translate-middle-x mt-4 z-3"
     role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 9999;">
    <div class="d-flex">
        <div class="toast-body">
            ✅ Deuda pagada correctamente.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Buscador en tiempo real
document.getElementById('buscarInput').addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tablaUsuarios tbody tr');
    filas.forEach(fila => {
        const texto = fila.innerText.toLowerCase();
        fila.style.display = texto.includes(filtro) ? '' : 'none';
    });
});

let padreActualId = null;
function cargarModal(id, nombre) {
    padreActualId = id;
    document.getElementById('idpadreInput').value = id;
    document.getElementById('textoPadre').innerText =
        "¿Deseas registrar el pago total de la deuda de: " + nombre + "?";
}

function pagarDeudaAjax() {
    const idpadre = document.getElementById('idpadreInput').value;
    const tipo_pago = document.getElementById('tipo_pago').value;

    if (!tipo_pago) {
        alert('Seleccione un método de pago');
        return;
    }

    fetch("{{ route('pagar.deuda.total') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ idpadre, tipo_pago })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) throw new Error(data.mensaje || 'Error inesperado');

        // Cerrar el modal correctamente
        const modalEl = document.getElementById('modalPagar');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) {
            modalInstance.hide();
        }

        // 🔧 Restaurar scroll y eliminar backdrop
        setTimeout(() => {
            // Eliminar cualquier fondo oscuro del modal
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

            // Eliminar clases que bloquean el scroll
            document.body.classList.remove('modal-open');
            document.body.style.overflow = 'auto'; // fuerza scroll
            document.body.style.position = 'static'; // limpia posible bloqueo por fixed
            document.body.style.paddingRight = '0px';
        }, 400);

        // Actualizar visualmente la fila
        const fila = document.querySelector(`button[onclick*="${idpadre}"]`)?.closest('tr');
        if (fila) {
            fila.querySelectorAll('td')[3].innerHTML = '<span class="text-success">S/ 0.00</span>';
            fila.querySelectorAll('td')[4].innerHTML = '<span class="text-muted">Sin deuda</span>';
        }

        // Mostrar toast confirmación
        const toastEl = document.getElementById('toastDeuda');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error al pagar la deuda. Intente nuevamente.");
    });
}


</script>
<!-- Bootstrap Bundle con Modal y Toast -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
