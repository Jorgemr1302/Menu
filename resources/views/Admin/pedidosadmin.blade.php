@extends('Admin.layout')

@section('contenido')

<body id="page-top">

{{-- ✅ Modal para realizar pedido --}}
<div class="modal fade" role="dialog" tabindex="-1" id="pedir">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--bs-blue);">
                <h4 class="modal-title text-white">
                    <i class="fa fa-plus"></i>&nbsp;Pedir Plato
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('realizarpedido') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idmenu" id="idmenu">
                    
                    <label class="form-label">Nombre del Plato:</label>
                    <input class="form-control form-control-sm" type="text" id="nombre_plato" name="nombre_plato" readonly>

                    <label class="form-label mt-2">Fecha:</label>
                    <input class="form-control form-control-sm" type="date" id="fecha_menu" name="fecha_pedido" readonly>

                    <label class="form-label mt-2">Padre/Hijo:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input class="form-control" list="padres_alumnos_list" required id="idalumno_input" name="idalumno"
                               placeholder="Seleccione o busque un alumno" oninput="setIdAlumno(this)" />
                        <datalist id="padres_alumnos_list">
                            @foreach($padres as $padre)
                                <option value="{{ $padre->nombre_padre }} {{$padre->apellido_padre}} - {{$padre->nombre_alumno}} {{$padre->apellido_alumno}}" data-id="{{ $padre->idalumno }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <input type="hidden" name="idalumno" id="idalumno" required />

                    <label class="form-label mt-2">Recreo:</label>
                    <select class="form-select" name="Recreo" required>
                        <option value="">Seleccione</option>
                        <option value="Primer Recreo">Primer Recreo</option>
                        <option value="Segundo Recreo">Segundo Recreo</option>
                        <option value="Hora de Salida">Hora de Salida</option>
                    </select>
                
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-success btn-sm" type="submit">Realizar Pedido</button>
            </div></form>
        </div>
    </div>
</div>

{{-- ✅ Mensaje superior --}}
<div class="info-box">
    <span class="info-box-icon bg-primary"><i class="far fa-envelope"></i></span>
    <div class="info-box-content">
        <span class="info-box-text">Mensaje:</span>
        <span class="info-box-number">Agregue el plato de acuerdo al día en que piensa venderlo. Verifique la fecha.</span>
    </div>
</div>

<div class="card shadow mx-3">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <p class="text-primary fw-bold m-0">
                <i class="fa fa-book"></i>&nbsp; Menú Semanal
            </p>
            <p class="text-muted m-0 small">
                📅 Semana del {{ $rangoSemana }}
            </p>
        </div>

        {{-- 🔹 Navegación de semanas --}}
        <div class="d-flex gap-2">
            <a href="{{ route('pedidosadmin', ['week' => $offset - 1]) }}" class="btn btn-outline-primary btn-sm">
                ⬅️ Semana anterior
            </a>
            <a href="{{ route('pedidosadmin', ['week' => $offset + 1]) }}" class="btn btn-outline-primary btn-sm">
                Semana siguiente ➡️
            </a>
        </div>
    </div>

    <div class="card-body">
        {{-- 🔹 Tabs dinámicos (lunes a viernes) --}}
        <ul class="nav nav-tabs" role="tablist">
            @php $first = true; @endphp
            @foreach($fechas as $dia => $info)
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $first ? 'active' : '' }}" role="tab" data-bs-toggle="tab"
                       href="#tab-{{ $loop->index + 1 }}" style="color: rgb(0,32,255);">
                       {{ ucfirst($info['texto']) }}
                    </a>
                </li>
                @php $first = false; @endphp
            @endforeach
        </ul>

        {{-- 🔹 Contenido de los tabs --}}
        <div class="tab-content">
            @php $first = true; @endphp
            @foreach($menus as $dia => $platos)
                <div class="tab-pane fade {{ $first ? 'show active' : '' }}" role="tabpanel" id="tab-{{ $loop->index + 1 }}">
                    <div class="table-responsive text-nowrap mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre del plato</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th class="text-center">Stock Actual</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($platos as $p)
                                    <tr>
                                        <td>{{ $p->nombre_plato }}</td>
                                        <td>{{ $p->descripcion_plato }}</td>
                                        <td>S/ {{ number_format($p->precio_plato, 2) }}</td>
                                        <td class="text-center">{{ $p->stock_plato }}</td>
                                        <td class="text-center">
                                            @if($p->stock_plato <= 0)
                                                <span class="text-danger">Sin Stock</span>
                                            @else
                                                <button class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#pedir"
                                                        onclick="pedir('{{ $p->idmenu }}','{{ $p->nombre_plato }}','{{ $p->fecha_menu }}')">
                                                    <i class="fa fa-heart-o"></i>&nbsp;Pedir
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted">No hay menús registrados.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @php $first = false; @endphp
            @endforeach
        </div>
    </div>
</div>

{{-- 🔹 JS --}}
<script>
function pedir(idmenu, nombre_plato, fecha_menu) {
    document.getElementById('idmenu').value = idmenu;
    document.getElementById('nombre_plato').value = nombre_plato;
    document.getElementById('fecha_menu').value = fecha_menu;
}

function setIdAlumno(input) {
    var datalist = document.getElementById('padres_alumnos_list');
    var options = datalist.getElementsByTagName('option');
    for (var i = 0; i < options.length; i++) {
        if (options[i].value === input.value) {
            document.getElementById('idalumno').value = options[i].getAttribute('data-id');
            break;
        }
    }
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const hoy = new Date();
    const hoyYMD = hoy.toISOString().split('T')[0];
    const tabs = document.querySelectorAll('.nav-tabs .nav-link');
    const tabPanes = document.querySelectorAll('.tab-pane');

    // Leer el tab guardado o calcular el de hoy
    let tabActivo = localStorage.getItem("tabActivoPedidos") || null;
    let encontrado = false;

    tabs.forEach((tab, index) => {
        const texto = tab.textContent.toLowerCase();

        // buscar coincidencia con la fecha del día actual (YYYY-MM-DD) dentro de los href o texto
        const fechaEnTexto = texto.match(/\b\d{1,2}\b/);
        const mesActual = hoy.toLocaleString('es-ES', { month: 'long' }).toLowerCase();

        // Si el texto del tab coincide con el mes y día actual, lo marcamos
        if (tab.textContent.toLowerCase().includes(mesActual) && fechaEnTexto && parseInt(fechaEnTexto[0]) === hoy.getDate()) {
            tabActivo = tab.getAttribute('href');
            encontrado = true;
        }
    });

    // Si no se encontró (por ejemplo, está viendo otra semana), usa el primero
    if (!tabActivo) {
        tabActivo = tabs[0].getAttribute('href');
    }

    // Activar el tab correcto
    const tabEl = document.querySelector(`[href="${tabActivo}"]`);
    if (tabEl) {
        new bootstrap.Tab(tabEl).show();
    }

    // Guardar el tab activo cuando cambia
    tabs.forEach(tab => {
        tab.addEventListener("shown.bs.tab", function (event) {
            localStorage.setItem("tabActivoPedidos", event.target.getAttribute("href"));
        });
    });

    // 🔹 Resaltar el tab activo con color
    function pintarActivo() {
        tabs.forEach(t => t.classList.remove("bg-primary", "text-white"));
        const activo = document.querySelector(".nav-link.active");
        if (activo) activo.classList.add("bg-primary", "text-white");
    }

    pintarActivo();
    document.querySelectorAll('.nav-link').forEach(t => {
        t.addEventListener('shown.bs.tab', pintarActivo);
    });
});
</script>

@endsection
