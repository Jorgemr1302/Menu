@extends('Admin.layout')


@section('contenido')





<div class="container-fluid">

<!-- moda editar menu -->
<div class="modal fade" role="dialog" tabindex="-1" id="editar-menu">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEditarMenu" method="POST" action="{{ route('editarpra') }}">
                @csrf
                <input type="hidden" name="id_menu" id="editar_id_menu_pra">
                <div class="modal-header" style="background: rgb(78,115,223);">
                    <h4 class="modal-title" style="color: black;">Editar Menú Prandium</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Fecha:</label>
                    <input class="form-control form-control-sm" name="fecha_menu" id="editar_fecha_pra" type="date" readonly required>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-spoon"></i></span>
                        <textarea class="form-control" name="descripcion_plato" id="editar_descripcion_pra" placeholder="Descripción"></textarea>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                        <input type="text" class="form-control" name="precio_plato" id="editar_precio_pra" placeholder="Precio" inputmode="numeric">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-sort-numeric-asc"></i></span>
                        <input type="text" class="form-control" name="cantidad_plato" id="editar_stock_pra" placeholder="Stock" inputmode="numeric">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin -->
<!-- modal editar lonchera-->
<div class="modal fade" role="dialog" tabindex="-1" id="editar-lonchera">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEditarLonchera" method="POST" action="{{ route('editarlonchera') }}">
                @csrf
                <input type="hidden" name="id_menu" id="editar_id_menu_lonchera">
                <div class="modal-header" style="background: rgb(78,115,223);">
                    <h4 class="modal-title" style="color: black;">Editar Lonchera</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Fecha:</label>
                    <input class="form-control form-control-sm" name="fecha_menu" id="editar_fecha_lonchera" type="date" readonly required>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-shopping-basket"></i></span>
                        <select class="form-select" name="nombre_plato" id="editar_nombre_lonchera">
                            <option value="">Tipo de Lonchera</option>
                            <option value="LONCHERA BASICA">LONCHERA BÁSICA</option>
                            <option value="LONCHERA ESPECIAL">LONCHERA ESPECIAL</option>
                            <option value="LONCHERA ROYAL">LONCHERA ROYAL</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-film"></i></span>
                        <textarea class="form-control" name="descripcion_plato" id="editar_descripcion_lonchera" placeholder="Descripción"></textarea>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                        <input type="text" class="form-control" name="precio_plato" id="editar_precio_lonchera" placeholder="Precio" inputmode="numeric">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-sort-numeric-asc"></i></span>
                        <input type="text" class="form-control" name="cantidad_plato" id="editar_stock_lonchera" placeholder="Stock" inputmode="numeric">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>



    <div class="modal fade" role="dialog" tabindex="-1" id="agregar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: rgb(78,115,223);">
                    <h4 class="modal-title" style="color: rgb(0,0,0);font-size: 19px;"><i class="fa fa-plus"></i>&nbsp;Agregar Plato y/o snacks</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('agregarmenu') }}" method="POST">
                     @csrf
                    	<label class="form-label" style="color: rgb(0,0,0);">Fecha:</label>
                        <input class="form-control form-control-sm" name="fecha_menu" type="date" id="fecha1" required="" readonly>

                    	<label class="form-label" style="color: rgb(0,0,0);">Nombre del Plato y/o Snacks:</label>
                        <select class="form-select form-select-sm" required="" name="idplato">
                            <option value="" selected="">Seleccione una opción</option>
                            @foreach($platos as $plato)
                            <option value="{{$plato->idplato}}">{{$plato->nombre_plato}}</option>
                            @endforeach
                        </select>
                        
                       
                        <label class="form-label" style="color: rgb(0,0,0);">Cantidad de Platos:</label>
                        <input class="form-control form-control-sm" type="number" data-bs-toggle="tooltip" data-bss-tooltip="" required="" title="Escriba un número entero" name="cantidad_plato">
                   
                </div>
                <div class="modal-footer" style="margin-top: -1px;margin-bottom: -8px;"><button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-success btn-sm" type="submit">Guardar</button></div>
            </div>
        </div> </form>
    </div>
    
    
    <div role="dialog" tabindex="-1" class="modal fade" id="menu">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(78,115,223);">
                <h4 class="modal-title" style="color: rgb(0,0,0);"><i class="fa fa-cutlery"></i> Agregar Menu Prandium</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('agregarpra') }}" method="POST">
                    @csrf
                    <label class="form-label" style="color: rgb(0,0,0);">Fecha:</label>
                    <input class="form-control form-control-sm" name="fecha_menu" type="date" id="fecha3" required="" readonly>
                    <br>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-spoon" style="font-size: 24px;color: rgb(0,0,0);"></i></span></div><textarea class="form-control" placeholder="Entradas" name="entrada_plato"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-circle-o-notch" style="font-size: 24px;color: rgb(0,0,0);"></i></span></div><textarea class="form-control" placeholder="Segundo" name="segundo_plato"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-dollar" style="font-size: 24px;color: rgb(10,10,10);"></i></span></div><input type="text" class="form-control" inputmode="numeric" placeholder="Precio" name="precio_plato" />
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-sort-numeric-asc" style="font-size: 24px;color: rgb(10,10,10);"></i></span></div><input type="text" class="form-control" inputmode="numeric" placeholder="Stock" name="cantidad_plato" />
                    </div>
                
            </div>
            <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cerrar</button><button class="btn btn-primary" type="submit">Agregar</button></div>
        </div></form>
    </div>
</div>
 
    
    <div role="dialog" tabindex="-1" class="modal fade" id="lonchera">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(78,115,223);">
                <h4 class="modal-title" style="color: rgb(0,0,0);"><i class="fa fa-window-maximize"></i>Agregar Lonchera</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('agregarlonchera') }}" method="POST">
                    @csrf
                    <label class="form-label" style="color: rgb(0,0,0);">Fecha:</label>
                    <input class="form-control form-control-sm" name="fecha_menu" type="date" id="fecha2" required="" readonly>
                    <br>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-shopping-basket" style="font-size: 24px;color: rgb(0,0,0);"></i></span></div>
                        <select class="form-select" name="nombre_plato">
                            <option value selected>Tipo de Lonchera</option>
                            <option value="LONCHERA BASICA">LONCHERA BÁSICA</option>
                            <option value="LONCHERA ESPECIAL">LONCHERA ESPECIAL</option>
                            <option value="LONCHERA ROYAL">LONCHERA ROYAL</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-film" style="font-size: 24px;color: rgb(0,0,0);"></i></span></div><textarea class="form-control" placeholder="Descripcion" name="descripcion_plato"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-dollar" style="font-size: 24px;color: rgb(10,10,10);"></i></span></div><input type="text" class="form-control" placeholder="Precio" inputmode="numeric" name="precio_plato" />
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-sort-numeric-asc" style="font-size: 24px;color: rgb(10,10,10);"></i></span></div><input type="text" class="form-control" placeholder="Stock" inputmode="numeric" name="cantidad_plato" />
                    </div>
                
            </div>
            <div class="modal-footer"><button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cerrar</button><button class="btn btn-primary" type="submit">Agregar</button></div>
        </div></form>
    </div>
</div>

    
    <div class="modal fade" role="dialog" tabindex="-1" id="stock">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: rgb(78,115,223);">
                    <h4 class="modal-title" style="color: rgb(0,0,0);font-size: 19px;"><i class="fa fa-plus"></i>&nbsp;Editar Stock</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('editarstock') }}" method="POST">
                     @csrf
                        <input type="hidden" id="idmenu" name="idmenu">
                    	<label class="form-label" style="color: rgb(0,0,0);">Stock:</label>
                        <input class="form-control form-control-sm" name="stock_plato" type="text" id="stock_plato" required="">
                        
                    	
                </div>
                <div class="modal-footer" style="margin-top: -1px;margin-bottom: -8px;"><button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-success btn-sm" type="submit">Guardar</button></div>
            </div>
        </div> </form>
    </div>
    

    <div class="modal fade" role="dialog" tabindex="-1" id="eliminar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--bs-red);">
                    <h4 class="modal-title" style="color: rgb(255,255,255);font-size: 19px;"><i class="fa fa-plus"></i>&nbsp;Eliminar Plato</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger text-nowrap" role="alert"><span><strong>Alert</strong>&nbsp;¿Desea Eliminar el siguiente registro ?</span></div>
                    <form action="{{ route('eliminarmenu') }}" method="POST">
                     @csrf
                       <input type="hidden" name="idmenu" id="idmenue" >
                </div>
                <div class="modal-footer" style="margin-top: -1px;margin-bottom: -8px;"><button class="btn btn-primary btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-danger btn-sm" type="submit">Eliminar</button></div>
            </div>
        </div></form>
    </div>

<!-- Modal -->
<div class="modal fade" id="mantenimiento" tabindex="-1" aria-labelledby="menuLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      
      <!-- Encabezado del modal -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="menuLabel">
          <i class="fas fa-tools me-2"></i> Modo Mantenimiento
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- Cuerpo del modal -->
      <div class="modal-body text-center">
        <form action="{{ route('mantenimiento') }}" method="POST">
          @csrf
          <input type="hidden" name="estado" value="{{ $estado }}">

          @if($estado == '1')               
            <div class="alert alert-warning d-flex align-items-center" role="alert">
              <i class="fas fa-exclamation-circle me-2"></i>
              <p class="m-0">Si desactiva el modo mantenimiento, los usuarios podrán realizar pedidos.</p>
            </div>
            <i class="fas fa-wrench fa-3x text-warning my-3"></i>
          @else
            <div class="alert alert-info d-flex align-items-center" role="alert">
              <i class="fas fa-info-circle me-2"></i>
              <p class="m-0">Si activa el modo mantenimiento, los usuarios no podrán realizar pedidos.</p>
            </div>
            <i class="fas fa-ban fa-3x text-info my-3"></i>
          @endif
      </div>

      <!-- Pie del modal -->
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-danger rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">
          <i class="fas fa-times-circle me-1"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
          <i class="fas fa-check-circle me-1"></i> Confirmar
        </button>
      </div>
      </form>
      
    </div>
  </div>
</div>



<div class="info-box">
<span class="info-box-icon bg-primary"><i class="far fa-envelope"></i></span>
<div class="info-box-content">
<span class="info-box-text">Mensaje:</span>
<span class="info-box-number">Agregue el plato de acuerdo al día en que piensa venderlo. Verifique la fecha.</span>
</div>
</div>
@if (session('alert1'))
<div class="alert alert-success" role="alert">
 <i class="fa fa-check-circle" style="font-size: 20px;"></i><span class="text-dark margin-left" style="margin: 0px;margin-left: 10px;" ><strong>{{ session('alert1') }}</strong></span><span class="text-info margin-left" style="margin: 0px;margin-left: 10px;"></span>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: relative; float: right;"></button>
</div>
@endif
               
<div class="card shadow px-3">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <p class="text-primary m-0 fw-bold me-3">
                <i class="fa fa-book"></i>&nbsp; Menú Semanal
            </p>

            {{-- 🔹 Botones para navegar entre semanas --}}
            <a href="{{ route('menu', ['week' => $offset - 1]) }}" class="btn btn-outline-primary btn-sm">
                ⬅️ Semana anterior
            </a>
            <a href="{{ route('menu', ['week' => $offset + 1]) }}" class="btn btn-outline-primary btn-sm">
                Semana siguiente ➡️
            </a>
        </div>

        {{-- 🔹 Botón de mantenimiento --}}
        @if($estado == '1')
            <button class="btn btn-success btn-sm d-flex align-items-center px-3" 
                type="button" data-bs-toggle="modal" data-bs-target="#mantenimiento">
                <i class="fas fa-tools me-2"></i> Mantenimiento Activo
            </button>
        @else
            <button class="btn btn-danger btn-sm d-flex align-items-center px-3" 
                type="button" data-bs-toggle="modal" data-bs-target="#mantenimiento">
                <i class="fas fa-times-circle me-2"></i> Mantenimiento Desactivado
            </button>
        @endif
    </div>

    <div class="card-body">
    {{-- ✅ Tabs solo lunes a viernes --}}
    <ul class="nav nav-tabs" role="tablist">
        @foreach ($fechas as $dia => $info)
            @if (in_array($dia, ['lunes','martes','miércoles','jueves','viernes']))
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                       id="tab-{{ $dia }}" 
                       role="tab" 
                       data-bs-toggle="tab" 
                       href="#content-{{ $dia }}" 
                       data-tab="content-{{ $dia }}"
                       style="color: rgb(0,32,255); text-transform: capitalize;">
                        {{ ucfirst($info['texto']) }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>

    {{-- ✅ Contenido dinámico de cada día --}}
    <div class="tab-content">
        @foreach ($fechas as $dia => $info)
            @if (in_array($dia, ['lunes','martes','miércoles','jueves','viernes']))
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                     id="content-{{ $dia }}" role="tabpanel">

                    <div class="text-end my-3">
                        <button class="btn btn-warning btn-sm text-nowrap" type="button" 
                            data-bs-toggle="modal" data-bs-target="#menu"
                            onclick="fecha3('{{ $info['fecha'] }}')">
                            <i class="fa fa-plus"></i> Agregar Menú Prandium
                        </button>
                        <button class="btn btn-info btn-sm text-nowrap" type="button" 
                            data-bs-toggle="modal" data-bs-target="#lonchera"
                            onclick="fecha2('{{ $info['fecha'] }}')">
                            <i class="fa fa-plus"></i> Agregar Lonchera
                        </button>
                        <button class="btn btn-primary btn-sm text-nowrap" type="button" 
                            data-bs-toggle="modal" data-bs-target="#agregar"
                            onclick="fecha1('{{ $info['fecha'] }}')">
                            <i class="fa fa-plus"></i> Agregar Plato y/o Snacks
                        </button>
                    </div>

                    @php
                        $platosDia = $menus[$dia] ?? collect();
                    @endphp

                    {{-- Loncheras --}}
                    <h1 style="color:black;font-size: 28px">
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i> Loncheras
                    </h1>
                    <table class="table">
                        <tbody>
                            @forelse($platosDia->where('tipo_plato', 'Lonchera') as $plato)
                                <tr>
                                    <td>{{ $plato->nombre_plato }}</td>
                                    <td>{{ $plato->descripcion_plato }}</td>
                                    <td>S/ {{ number_format($plato->precio_plato, 2) }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-info btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#stock"
                                            onclick="editarstock('{{ $plato->idmenu }}','{{ $plato->stock_plato }}')">
                                            Stock: {{ $plato->stock_plato }}
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm btn-editar-menu"
                                            data-id="{{ $plato->idmenu }}"
                                            data-tipo="lonchera"
                                            data-fecha="{{ $plato->fecha_menu }}"
                                            data-nombre="{{ $plato->nombre_plato }}"
                                            data-descripcion="{{ $plato->descripcion_plato }}"
                                            data-precio="{{ $plato->precio_plato }}"
                                            data-cantidad="{{ $plato->cantidad_plato }}">
                                            <i class="fa fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-danger btn-sm" type="button" 
                                            data-bs-toggle="modal" data-bs-target="#eliminar"
                                            onclick="eliminar('{{ $plato->idmenu }}')">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Sin loncheras</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Menú Prandium --}}
                    <h1 style="color:black;font-size: 28px">
                        <i class="fa fa-cutlery" aria-hidden="true"></i> Menú Prandium
                    </h1>
                    <table class="table">
                        <tbody>
                            @forelse($platosDia->where('tipo_plato', 'Menu') as $menu)
                                <tr>
                                    <td>{{ $menu->nombre_plato }}</td>
                                    <td>{{ $menu->descripcion_plato }}</td>
                                    <td>S/ {{ number_format($menu->precio_plato, 2) }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-info btn-sm" 
                                            data-bs-toggle="modal" data-bs-target="#stock"
                                            onclick="editarstock('{{ $menu->idmenu }}','{{ $menu->stock_plato }}')">
                                            Stock: {{ $menu->stock_plato }}
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm btn-editar-menu"
                                            data-id="{{ $menu->idmenu }}"
                                            data-tipo="prandium"
                                            data-fecha="{{ $menu->fecha_menu }}"
                                            data-descripcion="{{ $menu->descripcion_plato }}"
                                            data-precio="{{ $menu->precio_plato }}"
                                            data-cantidad="{{ $menu->cantidad_plato }}">
                                            <i class="fa fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-danger btn-sm" type="button" 
                                            data-bs-toggle="modal" data-bs-target="#eliminar"
                                            onclick="eliminar('{{ $menu->idmenu }}')">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Sin menú prandium</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Extras --}}
                    <h1 style="color:black;font-size: 28px">
                        <i class="fa fa-star" aria-hidden="true"></i> Extras y Snacks
                    </h1>
                    <table class="table table-striped align-middle">
                        <tbody>
                            @forelse($platosDia->where('tipo_plato', 'Individual') as $extra)
                                <tr>
                                    <td>{{ $extra->nombre_plato }}</td>
                                    <td>S/ {{ number_format($extra->precio_plato, 2) }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-info btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#stock"
                                            onclick="editarstock('{{ $extra->idmenu }}','{{ $extra->stock_plato }}')">
                                            Stock: {{ $extra->stock_plato }}
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm"
                                            type="button" data-bs-toggle="modal" data-bs-target="#eliminar"
                                            onclick="eliminar('{{ $extra->idmenu }}')">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Sin extras</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach
    </div>
</div>

</div>


</div>
<script>
    // Función para abrir el modal y mostrar los datos
    function fecha1(fecha1) {
      // Asignamos los valores a los campos de texto
      document.getElementById('fecha1').value = fecha1;
      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }
    
    function fecha2(fecha2) {
      // Asignamos los valores a los campos de texto
      document.getElementById('fecha2').value = fecha2;
      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }
    
    function fecha3(fecha3) {
      // Asignamos los valores a los campos de texto
      document.getElementById('fecha3').value = fecha3;
      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }

    function editarstock(idmenu,stock_plato) {
      // Asignamos los valores a los campos de texto
      document.getElementById('idmenu').value = idmenu;
      document.getElementById('stock_plato').value = stock_plato;
     

      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
      
    }
    function eliminar(idmenu) {
      // Asignamos los valores a los campos de texto
      document.getElementById('idmenue').value = idmenu;
      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }
  </script>    
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.btn-editar-menu').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const tipo = this.dataset.tipo;
                const id = this.dataset.id;

                if (tipo === 'prandium') {
                    const modal = new bootstrap.Modal(document.getElementById('editar-menu'));
                    document.getElementById('editar_id_menu_pra').value = id;
                    document.getElementById('editar_fecha_pra').value = this.dataset.fecha;
                    document.getElementById('editar_descripcion_pra').value = this.dataset.descripcion;
                    document.getElementById('editar_precio_pra').value = this.dataset.precio;
                    document.getElementById('editar_stock_pra').value = this.dataset.cantidad;
                    modal.show();
                } else if (tipo === 'lonchera') {
                    const modal = new bootstrap.Modal(document.getElementById('editar-lonchera'));
                    document.getElementById('editar_id_menu_lonchera').value = id;
                    document.getElementById('editar_fecha_lonchera').value = this.dataset.fecha;
                    document.getElementById('editar_nombre_lonchera').value = this.dataset.nombre;
                    document.getElementById('editar_descripcion_lonchera').value = this.dataset.descripcion;
                    document.getElementById('editar_precio_lonchera').value = this.dataset.precio;
                    document.getElementById('editar_stock_lonchera').value = this.dataset.cantidad;
                    modal.show();
                }
            });
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll('.nav-tabs .nav-link');
    if (tabs.length === 0) return;

    const STORAGE_KEY = "tabActivoMenuSemanal";
    const WEEK_KEY = "semanaActualMenu";

    // Detectar semana actual desde la URL o desde localStorage (fallback)
    const urlParams = new URLSearchParams(window.location.search);
    let semanaActual = urlParams.get('week');
    if (semanaActual === null) semanaActual = localStorage.getItem(WEEK_KEY) || '0';

    // Guardar la semana actual para siguientes redirecciones
    localStorage.setItem(WEEK_KEY, semanaActual);

    let tabActivo = null;
    const semanaGuardada = localStorage.getItem(WEEK_KEY);

    // Si estamos en la misma semana, mantener tab guardado
    if (semanaGuardada === semanaActual) {
        tabActivo = localStorage.getItem(STORAGE_KEY);
    } else {
        localStorage.removeItem(STORAGE_KEY);
        localStorage.setItem(WEEK_KEY, semanaActual);
    }

    // Buscar el tab del día actual si no hay guardado
    if (!tabActivo) {
        const hoy = new Date();
        const dia = hoy.getDate();
        const mes = hoy.toLocaleString('es-ES', { month: 'short' }).replace('.', '');
        tabs.forEach(tab => {
            if (tab.textContent.includes(dia) && tab.textContent.includes(mes)) {
                tabActivo = tab.getAttribute('href');
            }
        });
    }

    // Si no encuentra nada, usar el primero
    if (!tabActivo) tabActivo = tabs[0].getAttribute("href");

    // Activar el tab
    const tabEl = document.querySelector(`[href="${tabActivo}"]`);
    if (tabEl) new bootstrap.Tab(tabEl).show();

    // Guardar al cambiar
    tabs.forEach(tab => {
        tab.addEventListener("shown.bs.tab", (event) => {
            localStorage.setItem(STORAGE_KEY, event.target.getAttribute("href"));
            localStorage.setItem(WEEK_KEY, semanaActual);
            pintarActivo();
        });
    });

    // Colorear activo
    function pintarActivo() {
        tabs.forEach(t => t.classList.remove("bg-primary", "text-white"));
        const activo = document.querySelector(".nav-link.active");
        if (activo) activo.classList.add("bg-primary", "text-white");
    }

    pintarActivo();
});
</script>




@endsection