@extends('Admin.layout')

@section('contenido')
<!-- Modal de confirmación para cambiar estado -->
<div class="modal fade" id="confirmarModal" tabindex="-1" aria-labelledby="confirmarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmarModalLabel">Confirmación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas actualizar el <span id="campo_modal"></span> para este pedido?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="confirmarBtn" onclick="enviarCambio()">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<!-- Formulario oculto -->


<form id="formularioEnvio" method="POST" action="{{ url('/pedidosupdate') }}">
    @csrf
    <input type="hidden" id="campo_a_actualizar" name="campo_a_actualizar">
    <input type="hidden" id="nuevo_valor" name="nuevo_valor">
    <input type="hidden" id="pedido_id" name="pedido_id">
</form>

<div role="dialog" tabindex="-1" class="modal fade" id="recreo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(78, 115, 223);height: 59px;">
                <h4 class="modal-title" style="color: rgb(255,255,255);"><i class="far fa-bell"></i> Editar Recreo</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('recreo') }}">
                    @csrf
                    <input type="hidden" name="idpedido" id="idpedido">
                    <label class="form-label">Seleccione el Nuevo Recreo:</label>
                    <select class="form-select form-select-sm" name="Recreo">
                        <option value selected>Seleccione</option>
                        <option value="Primer Recreo">Primer Recreo</option>
                        <option value="Segundo Recreo">Segundo Recreo</option>
                        <option value="Salida">Salida</option>
                    </select>
            </div>
            <div class="modal-footer" style="height: 67px;"><button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-info btn-sm" type="submit">Guardar</button></div>
        </div>
    </div></form>
</div>


<div class="container-fluid">
                    @if (session('alert1'))
                    <div class="alert alert-success" role="alert">
                     <i class="fa fa-check-circle" style="font-size: 20px;"></i><span class="text-dark margin-left" style="margin: 0px;margin-left: 10px;" ><strong>{{ session('alert1') }}</strong></span><span class="text-info margin-left" style="margin: 0px;margin-left: 10px;"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: relative; float: right;"></button>
                    </div>
                    @endif
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Registro de Pedidos</p>
                        </div>
                        <div class="card-body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1" style="color: rgb(0,32,255);"><i class="far fa-list-alt"></i>&nbsp;General</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-2" style="color: rgb(86,227,36);"><i class="far fa-check-circle"></i>&nbsp;Pagados</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-3" style="color: rgb(254,17,88);"><i class="fa fa-window-close"></i>&nbsp;Pendiente</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" id="tab-1">
                                        <br>
                                        <div class="mb-3 d-flex align-items-end gap-3">
                                            <div>
                                                <label for="filterDate" class="form-label mb-1">Filtrar por fecha:</label>
                                                <input type="date"  id="filterDate1" class="form-control" onchange="applyFiltersTo('pedidosTable', 'filterDate1', 'searchInput1')">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label for="searchInput" class="form-label mb-1">Buscar:</label>
                                                <input type="text" id="searchInput1" class="form-control" onkeyup="applyFiltersTo('pedidosTable', 'filterDate1', 'searchInput1')">
                                            </div>
                                        </div>
                                        <div class="table-responsive text-nowrap" style="max-height: 520px; overflow-y: auto;">
                                        <table class="table" id="pedidosTable">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        
                                                        <th>Docente</th>
                                                        <th colspan="2">Resumen</th>
                                                        <th>Precio Total</th>
                                                        <th class="text-center">Estado pago</th>
                                                        <th class="text-center">Recreo</th>
                                                        <th>Tipo Pago</th>
                                                        <th>Estado Pedido</th>
                                                        <th class="text-center">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($grupos_pedidos as $grupo)
                                                    <tr>
                                                        <td>{{ date('d/m/Y', strtotime($grupo->fecha_pedido)) }}</td>
                                                       
                                                        <td>{{ $grupo->nombre_alumno }} {{ $grupo->apellido_alumno }}</td>

                                                        <!-- Resumen -->
                                                        <td colspan="2">Total pedidos: <strong>{{ $grupo->cantidad_pedidos }}</strong></td>
                                                         <td>Precio Total: <strong>S/ {{ number_format($grupo->precio_total, 2) }}</strong></td>
                                                        <!-- Estado pago -->
                                                        <td class="text-center">
                                                            <span id="estado_pago_{{ $grupo->idalumno }}|{{ $grupo->fecha_pedido }}|{{ $grupo->Recreo }}"
                                                                  class="btn btn-{{ $grupo->estado_pago === 'Pagado' ? 'success' : 'warning' }} btn-sm"
                                                                  style="font-size:13px;">
                                                                <b>{{ $grupo->estado_pago ?? '-' }}</b>
                                                            </span>
                                                        </td>

                                                        <!-- Recreo agrupado -->
                                                        <td class="text-center">
                                                            <span class="btn btn-{{ $grupo->Recreo == 'Primer Recreo' ? 'outline-info' : 'outline-danger' }} btn-sm" style="font-size:13px;">
                                                                <b>{{ $grupo->Recreo }}</b>
                                                            </span>
                                                        </td>
                                                        <!-- Tipo de Pago -->
                                                        <td>
                                                        <select class="form-select form-select-sm" id="tipo_pago_grupo_{{ $grupo->idalumno }}_{{ $grupo->fecha_pedido }}_{{ $grupo->Recreo }}" onchange="confirmarCambioGrupo('tipo_pago', '{{ $grupo->idalumno }}', '{{ $grupo->fecha_pedido }}', '{{ $grupo->Recreo }}')">
                                                            <option value="No definido" {{ $grupo->tipo_pago == 'No definido' ? 'selected' : '' }}>No definido</option>
                                                            <option value="Plin" {{ $grupo->tipo_pago == 'Plin' ? 'selected' : '' }}>Plin</option>
                                                            <option value="Yape" {{ $grupo->tipo_pago == 'Yape' ? 'selected' : '' }}>Yape</option>
                                                            <option value="Transferencia" {{ $grupo->tipo_pago == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                                            <option value="Efectivo" {{ $grupo->tipo_pago == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                                        </select>
                                                        </td>

                                                        <!-- Estado Pedido -->
                                                        <td>
                                                            <select class="form-select form-select-sm" id="estado_pedido_grupo_{{ $grupo->idalumno }}_{{ $grupo->fecha_pedido }}_{{ $grupo->Recreo }}" onchange="confirmarCambioGrupo('estado_pedido', '{{ $grupo->idalumno }}', '{{ $grupo->fecha_pedido }}', '{{ $grupo->Recreo }}')">
                                                                <option value="No entregado" {{ $grupo->estado_pedido == 'No entregado' ? 'selected' : '' }}>No entregado</option>
                                                                <option value="Entregado" {{ $grupo->estado_pedido == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                                                                <option value="Anulado" {{ $grupo->estado_pedido == 'Anulado' ? 'selected' : '' }}>Anulado</option>
                                                            </select>
                                                        </td>

                                                        <!-- Botón de ticket agrupado -->
                                                        <td class="text-center">
                                                            <a class="btn btn-info btn-sm" type="button" target="_blank"
                                                            href="{{ route('pedido.ticket.grupo', [
                                                                'fecha' => $grupo->fecha_pedido,
                                                                'alumno' => $grupo->idalumno,
                                                                'recreo' => $grupo->Recreo
                                                            ]) }}">
                                                                <i class="fas fa-print"></i>&nbsp;Ticket
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>



                                        </div>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="tab-2">
                                        
                                        <div class="table-responsive text-nowrap" style="max-height: 520px; overflow-y: auto;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                      
                                                        <th>Docente</th>
                                                        <th>Plato</th>
                                                        <th>Precio</th>
                                                        <th class="text-center">Estado pago</th>
                                                        <th>Recreo</th>
                                                        <th>Tipo Pago</th>
                                                        <th>Estado Pedido</th>
                                                  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pedidos as  $pedido)
                                                	@if($pedido->estado_pago=='Pagado')
                                                    <tr>
                                                        <td>{{ date('d/m/Y', strtotime($pedido->fecha_pedido)) }}</td>
                                                      
                                                        <td>{{$pedido->nombre_alumno;}} {{$pedido->apellido_alumno}}</td>
                                                        <td>{{$pedido->nombre_plato}}</td>
                                                        <td>S/{{$pedido->precio_plato}}.00</td>
                                                        <td class="text-center"><span class="btn btn-success btn-sm" style="font-size:13px;"><b>{{$pedido->estado_pago}}</b></span></td>
                                                        <td>{{$pedido->Recreo}}</td>
                                                        <td>{{$pedido->tipo_pago}}</td>
                                                        <td style="color: rgb(255,0,0);font-weight: bold;">{{$pedido->estado_pedido}}</td>
                                                        
                                                    </tr>
                                                
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="tab-3">
                                        <br>
                                        <div class="mb-3 d-flex align-items-end gap-3">
                                            <div>
                                                <label for="filterDate" class="form-label mb-1">Filtrar por fecha:</label>
                                                <input type="date" class="form-control" id="filterDate3" onchange="applyFiltersTo('pedidosTableNuevo', 'filterDate3', 'searchInput3')">
                                                
                                            </div>
                                            <div class="flex-grow-1">
                                                <label for="searchInput" class="form-label mb-1">Buscar:</label>
                                                <input type="text" id="searchInput3" class="form-control" onkeyup="applyFiltersTo('pedidosTableNuevo', 'filterDate3', 'searchInput3')">
                                            
                                            </div>
                                        </div>
                                        <div class="table-responsive text-nowrap" style="max-height: 520px; overflow-y: auto;">
                                            <table class="table" id="pedidosTableNuevo">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                
                                                        <th>Docente</th>
                                                        <th>Plato</th>
                                                        <th>Precio</th>
                                                        <th class="text-center">Estado pago</th>
                                                        <th>Recreo</th>
                                                        <th>Tipo Pago</th>
                                                        <th>Estado Pedido</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@foreach($pedidos as  $pedido)
                                                	@if($pedido->estado_pago=='Pendiente')
                                                    <tr>
                                                        <td>{{ date('d/m/Y', strtotime($pedido->fecha_pedido)) }}</td>
                                                       
                                                        <td>{{$pedido->nombre_alumno;}} {{$pedido->apellido_alumno}}</td>
                                                        <td>{{$pedido->nombre_plato}}</td>
                                                        <td>S/{{$pedido->precio_plato}}.00</td>
                                                        <td class="text-center"><span class="btn btn-warning btn-sm" style="font-size:13px;"><b>{{$pedido->estado_pago}}</b></span></td>
                                                        <td>{{$pedido->Recreo}}</td>
                                                        <td>{{$pedido->tipo_pago}}</td>
                                                        <td style="color: rgb(255,0,0);font-weight: bold;">{{$pedido->estado_pedido}}</td>
                                                        
                                                    </tr>
                                                   
                                                    @endif
                                                    @endforeach
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



<script type="text/javascript">
let campoAActualizar = '';
let pedidoId = null;
let campoModal = document.getElementById('campo_modal');

// Mostrar el modal de confirmación
function confirmarCambioGrupo(campo, idAlumno, fecha, recreo) {
    campoAActualizar = campo;
    campoModal.textContent = campo === 'tipo_pago' ? 'Tipo de Pago' : 'Estado de Pedido';

    const inputId = `${campo}_grupo_${idAlumno}_${fecha}_${recreo}`;
    const valor = document.getElementById(inputId).value;

    document.getElementById('campo_a_actualizar').value = campoAActualizar;
    document.getElementById('nuevo_valor').value = valor;
    document.getElementById('pedido_id').value = `${idAlumno}|${fecha}|${recreo}`;

    $('#confirmarModal').modal('show');
}
// Enviar el cambio por AJAX
function enviarCambio() {
    const campo = document.getElementById('campo_a_actualizar').value;
    const valor = document.getElementById('nuevo_valor').value;
    const id = document.getElementById('pedido_id').value;

    const formData = new FormData();
    formData.append('campo_a_actualizar', campo);
    formData.append('nuevo_valor', valor);
    formData.append('pedido_id', id);

    const esGrupo = id.includes('|');
    formData.append('es_grupo', esGrupo ? 1 : 0);

    fetch("{{ route('pedidosupdate') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => {
        if (!res.ok) throw new Error('Error HTTP: ' + res.status);
        return res.json();
    })
    .then(data => {
        $('#confirmarModal').modal('hide');
        mostrarToast(data.mensaje);

         // Actualizar visual si el campo es tipo_pago
        if (campo === 'tipo_pago') {
            const badge = document.getElementById('estado_pago_' + id);
            if (badge) {
                badge.textContent = 'Pagado';
                badge.classList.remove('btn-warning');
                badge.classList.add('btn-success');
            }
        }
    })
    .catch(err => {
        console.error('Error AJAX:', err);
        mostrarToast('Ocurrió un error al actualizar: ' + err.message, true);
    });
}

// Mostrar notificación en la parte superior
function mostrarToast(mensaje, esError = false) {
    const toast = document.getElementById('toast-notificacion');
    toast.className = `alert ${esError ? 'alert-danger' : 'alert-success'} d-block position-fixed top-0 start-50 translate-middle-x mt-3 shadow`;
    toast.style.zIndex = 9999;
    toast.textContent = mensaje;

    setTimeout(() => {
        toast.classList.add('d-none');
    }, 4000);
}
    
function applyFiltersTo(tableId, dateInputId, textInputId) {
    const texto = document.getElementById(textInputId).value.toUpperCase();
    const fechaFiltro = document.getElementById(dateInputId).value;
    const table = document.getElementById(tableId);
    const tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        const row = tr[i];
        const tds = row.getElementsByTagName("td");
        let mostrar = false;

        for (let j = 0; j < tds.length; j++) {
            const contenido = tds[j].textContent.toUpperCase();
            if (contenido.includes(texto)) {
                mostrar = true;
                break;
            }
        }

        if (fechaFiltro) {
            const fechaCelda = tds[0]?.textContent.trim(); // dd/mm/yyyy
            const partes = fechaCelda.split('/');
            const fechaFormateada = partes.length === 3 ? `${partes[2]}-${partes[1]}-${partes[0]}` : '';
            if (fechaFiltro !== fechaFormateada) {
                mostrar = false;
            }
        }

        row.style.display = mostrar ? '' : 'none';
    }
}




</script>

<div id="toast-notificacion" class="alert d-none position-fixed top-0 start-50 translate-middle-x mt-3 shadow" role="alert"></div>
@endsection