@extends('Padre.layout')

@section('contenido')
@if($estado == '1')
    <div class="alert alert-info text-center p-4 rounded">
        <h3>⏳ Estamos actualizando los registros de los platos</h3>
        <p>La administradora está trabajando en las actualizaciones. Por favor, vuelve más tarde. ¡Gracias por tu paciencia! 😊</p>
    </div>
@else
<style>
    /* Default style */
    .responsive-button {
        font-size: 24px;
        padding: 8px 16px;
    }

    /* Mobile screen adjustment */
    @media (max-width: 767px) {
        .responsive-button {
            font-size: 18px;
            padding: 6px 12px;
        }
    }
</style>
<style>
.tabs {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Mejora el deslizamiento en dispositivos móviles */
    width: 100%; /* Asegura que el contenedor ocupe todo el ancho disponible */
}

.tabs ul {
    display: flex;
    padding: 0;
    margin: 0;
    text-decoration:none ;
}

.tabs li {
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .tabs a {
        font-size: 12px;  /* Ajusta el tamaño del texto */
        padding: 10px;
        display: inline-block;
        text-align: center;
    }
}

.tabs a {
    white-space: nowrap; /* Impide que el texto se corte */
    text-decoration: none;
}

.tabs .nav-link.active {
    background-color: #4CAF50; /* Cambia este color por el que prefieras */
    color: white; /* Asegura que el texto sea blanco para un buen contraste */
    border-radius: 25px; /* Es opcional, para darle bordes redondeados */
    font-weight: bold; /* Si deseas darle un poco más de énfasis */
}

/* Opcional: Puedes agregar efectos hover para los tabs no activos */
.tabs .nav-link:hover {
    background-color: #64b64e; /* Color más claro para el hover */
    color: white;
}
.nav-tabs .nav-link.active {
    border: none;  /* Elimina el borde */
    box-shadow: none;  /* Elimina cualquier sombra que pueda estar causando la raya */
}

.nav-tabs {
    border-bottom: none;
}
.nav-tabs {
    box-shadow: none;
}
.nav-tabs {
    margin-bottom: 0;
}

    
</style>

<body id="page-top">
<div class="modal fade" role="dialog" tabindex="-1" id="pedir">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--bs-blue);">
                    <h4 class="modal-title" style="color: rgb(255,255,255);font-size: 19px;"><i class="fa fa-plus"></i>&nbsp;Pedir Plato</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <form action="{{ route('realizarpedidopadre') }}" method="POST">
               		   @csrf
               		   <input type="hidden" name="idmenu" id="idmenu">
                    	<label class="form-label" style="color: rgb(0,0,0);">Nombre del Plato:</label>
                    	<input class="form-control form-control-sm" type="text" id="nombre_plato" name="nombre_plato" required="" readonly="">
                    	<label class="form-label" style="color: rgb(0,0,0);">Fecha:</label>
                    	<input class="form-control form-control-sm" type="date"  id="fecha_menu" required="" readonly="" name="fecha_pedido">
                        @if(Auth::user()->rol === 'Profesor')
                        <label class="form-label" style="color: rgb(0,0,0);">Confirme Sus datos:</label>    
                        @elseif(Auth::user()->rol === 'Padre')
                    	<label class="form-label" style="color: rgb(0,0,0);">Hijo:</label>
                        @endif
                    	<select class="form-select" name="idalumno" required> 
                            <option value="" selected="">Seleccione</option>
                            @foreach($padres as $padre)
                            @if($padre->dni_padre==Auth::user()->dni)
                            <option value="{{$padre->idalumno}}">{{$padre->nombre_alumno}} {{$padre->apellido_alumno}}</option>
                            
                            @endif
                            @endforeach
                        </select>
                        <label class="form-label" style="color: rgb(0,0,0);">Recreo:</label>
                        <select class="form-select" name="Recreo" required>
                        <option value="" selected="">Seleccione</option>
                        <option value="Primer Recreo">Primer Recreo</option>
						<option value="Segundo Recreo">Segundo Recreo</option>
                        <option value="Hora de Salida">Hora de Salida</option>
                    	</select>
                </div>
                <div class="modal-footer" style="margin-top: -1px;margin-bottom: -8px;"><button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-success btn-sm" type="submit">Realizar Pedido</button></div>
            </div>
        </div></form>
    </div>


<div class="info-box">
<span class="info-box-icon bg-primary"><i class="far fa-envelope"></i></span>
<div class="info-box-content">
<span class="info-box-text">Mensaje:</span>
<span class="info-box-number">Elija el plato de acuerdo al día en que piensa Comprarlo. Verifique la fecha.</span>
</div>
</div>
               <div class="card shadow" style="margin-left: 10px;margin-right: 10px;">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold"><i class="fa fa-book"></i>&nbsp;Menu Semanal</p>
                    </div>
                    <div class="card-body">
                        <div class="tabs"> <!-- Asegúrate de que la clase 'tabs' está en el contenedor -->
                            <ul class="nav nav-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1" style="color: rgb(0,32,255);">{{$lunes}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-2" style="color: rgb(0,32,255);">{{$martes}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-3" style="color: rgb(0,32,255);">{{$miercoles}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-4" style="color: rgb(0,32,255);">{{$jueves}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-5" style="color: rgb(0,32,255);">{{$viernes}}</a>
                                </li>
                            </ul>
                            
                            <div class="tab-content">
                                <div class="tab-pane active" role="tabpanel" id="tab-1">
                                    <br>
                                    <div class="table-responsive text-nowrap">
@php
function destacarPalabras($texto) {
    $palabras = ['sopa', 'arroz', 'pollo', 'ensalada', 'sándwich', 'jugos', 'papa', 'res', 'refresco'];

    // Resalta palabras clave
    foreach ($palabras as $palabra) {
        $texto = preg_replace("/\b($palabra)\b/i", '<strong>$1</strong>', $texto);
    }

    // Reemplaza ➼ y + por salto de línea con etiqueta <br>
    $texto = str_replace(['➼', '+'], ['<br>➼', '<br>+'], $texto);

    return $texto;
}
@endphp                                    
{{-- Loncheras --}}
<h1 class="mb-4" style="color:black;font-size: 28px;">
    <i class="fa fa-shopping-basket" aria-hidden="true"></i> Loncheras
</h1>
<div style="display: flex; align-items: center; justify-content: flex-end; margin-top: -50px;">
    <span style="font-size: 16px; background-color: #4CAF50; color: white; padding: 8px 16px; border-radius: 25px; display: flex; align-items: center;" class="responsive-button">
        <i class="fa fa-calendar" style="margin-right: 8px;"></i>
        {{$lunes}}
    </span>
</div>
<br>
<div class="row">
@foreach($lunesplatos as $plato)
    @if($plato->tipo_plato == "Lonchera")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-primary">{{ $plato->nombre_plato }}</h5>
                <p>{!! destacarPalabras($plato->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($plato->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $plato->stock_plato }}</span>
                <div class="text-end">
                    @if($plato->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $plato->idmenu }}', '{{ $plato->descripcion_plato }}', '{{ $plato->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>

{{-- Menú Prandium --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-cutlery" aria-hidden="true"></i> Menú Prandium
</h1>
<div class="row">
@foreach($lunesplatos as $menu)
    @if($menu->tipo_plato == "Menu")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-success">{{ $menu->nombre_plato }}</h5>
                <p>{!! destacarPalabras($menu->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($menu->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $menu->stock_plato }}</span>
                <div class="text-end">
                    @if($menu->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $menu->idmenu }}', '{{ $menu->descripcion_plato }}', '{{ $menu->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>

{{-- Extras y Snacks --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-star" aria-hidden="true"></i> Extras y Snacks
</h1>
<div class="row">
@foreach($lunesplatos as $extras)
    @if($extras->tipo_plato == "Individual")
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-warning">{{ $extras->nombre_plato }}</h5>
                <p>{!! destacarPalabras($extras->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($extras->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $extras->stock_plato }}</span>
                <div class="text-end">
                    @if($extras->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $extras->idmenu }}', '{{ $extras->descripcion_plato }}', '{{ $extras->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>

                                        
                                     
                                    </div>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="tab-2">
                                    
<br>                                    <div class="table-responsive text-nowrap">
{{-- Loncheras --}}
<h1 class="mb-4" style="color:black;font-size: 28px;">
    <i class="fa fa-shopping-basket" aria-hidden="true"></i> Loncheras
</h1>
<div style="display: flex; align-items: center; justify-content: flex-end; margin-top: -50px;">
    <span style="font-size: 16px; background-color: #4CAF50; color: white; padding: 8px 16px; border-radius: 25px; display: flex; align-items: center;" class="responsive-button">
        <i class="fa fa-calendar" style="margin-right: 8px;"></i>
        {{$martes}}
    </span>
</div>
<br>
<div class="row">
@foreach($martesplatos as $plato)
    @if($plato->tipo_plato == "Lonchera")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-primary">{{ $plato->nombre_plato }}</h5>
                <p>{!! destacarPalabras($plato->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($plato->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $plato->stock_plato }}</span>
                <div class="text-end">
                    @if($plato->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $plato->idmenu }}', '{{ $plato->descripcion_plato }}', '{{ $plato->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>
{{-- Menú Prandium --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-cutlery" aria-hidden="true"></i> Menú Prandium
</h1>
<div class="row">
@foreach($martesplatos as $menu)
    @if($menu->tipo_plato == "Menu")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-success">{{ $menu->nombre_plato }}</h5>
                <p>{!! destacarPalabras($menu->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($menu->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $menu->stock_plato }}</span>
                <div class="text-end">
                    @if($menu->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $menu->idmenu }}', '{{ $menu->descripcion_plato }}', '{{ $menu->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>                             
{{-- Extras y Snacks --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-star" aria-hidden="true"></i> Extras y Snacks
</h1>
<div class="row">
@foreach($martesplatos as $extras)
    @if($extras->tipo_plato == "Individual")
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-warning">{{ $extras->nombre_plato }}</h5>
                <p>{!! destacarPalabras($extras->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($extras->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $extras->stock_plato }}</span>
                <div class="text-end">
                    @if($extras->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $extras->idmenu }}', '{{ $extras->descripcion_plato }}', '{{ $extras->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>                             
                                        
                                     
                                    </div>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="tab-3">
                                    
                                    <div class="table-responsive text-nowrap">
<br>                                    <div class="table-responsive text-nowrap">
{{-- Loncheras --}}
<h1 class="mb-4" style="color:black;font-size: 28px;">
    <i class="fa fa-shopping-basket" aria-hidden="true"></i> Loncheras
</h1>
<div style="display: flex; align-items: center; justify-content: flex-end; margin-top: -50px;">
    <span style="font-size: 16px; background-color: #4CAF50; color: white; padding: 8px 16px; border-radius: 25px; display: flex; align-items: center;" class="responsive-button">
        <i class="fa fa-calendar" style="margin-right: 8px;"></i>
        {{$miercoles}}
    </span>
</div>
<br>
<div class="row">
@foreach($miercolesplatos as $plato)
    @if($plato->tipo_plato == "Lonchera")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-primary">{{ $plato->nombre_plato }}</h5>
                <p>{!! destacarPalabras($plato->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($plato->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $plato->stock_plato }}</span>
                <div class="text-end">
                    @if($plato->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $plato->idmenu }}', '{{ $plato->descripcion_plato }}', '{{ $plato->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>
{{-- Menú Prandium --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-cutlery" aria-hidden="true"></i> Menú Prandium
</h1>
<div class="row">
@foreach($miercolesplatos as $menu)
    @if($menu->tipo_plato == "Menu")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-success">{{ $menu->nombre_plato }}</h5>
                <p>{!! destacarPalabras($menu->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($menu->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $menu->stock_plato }}</span>
                <div class="text-end">
                    @if($menu->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $menu->idmenu }}', '{{ $menu->descripcion_plato }}', '{{ $menu->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>                             
{{-- Extras y Snacks --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-star" aria-hidden="true"></i> Extras y Snacks
</h1>
<div class="row">
@foreach($miercolesplatos as $extras)
    @if($extras->tipo_plato == "Individual")
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-warning">{{ $extras->nombre_plato }}</h5>
                <p>{!! destacarPalabras($extras->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($extras->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $extras->stock_plato }}</span>
                <div class="text-end">
                    @if($extras->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $extras->idmenu }}', '{{ $extras->descripcion_plato }}', '{{ $extras->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>                                        
</div>                           
</div>
</div>
                                <div class="tab-pane" role="tabpanel" id="tab-4">
                                 
                                    <div class="table-responsive text-nowrap">
<br>                                    <div class="table-responsive text-nowrap">
{{-- Loncheras --}}
<h1 class="mb-4" style="color:black;font-size: 28px;">
    <i class="fa fa-shopping-basket" aria-hidden="true"></i> Loncheras
</h1>
<div style="display: flex; align-items: center; justify-content: flex-end; margin-top: -50px;">
    <span style="font-size: 16px; background-color: #4CAF50; color: white; padding: 8px 16px; border-radius: 25px; display: flex; align-items: center;" class="responsive-button">
        <i class="fa fa-calendar" style="margin-right: 8px;"></i>
        {{$jueves}}
    </span>
</div>
<br>
<div class="row">
@foreach($juevesplatos as $plato)
    @if($plato->tipo_plato == "Lonchera")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-primary">{{ $plato->nombre_plato }}</h5>
                <p>{!! destacarPalabras($plato->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($plato->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $plato->stock_plato }}</span>
                <div class="text-end">
                    @if($plato->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $plato->idmenu }}', '{{ $plato->descripcion_plato }}', '{{ $plato->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>
{{-- Menú Prandium --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-cutlery" aria-hidden="true"></i> Menú Prandium
</h1>
<div class="row">
@foreach($juevesplatos as $menu)
    @if($menu->tipo_plato == "Menu")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-success">{{ $menu->nombre_plato }}</h5>
                <p>{!! destacarPalabras($menu->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($menu->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $menu->stock_plato }}</span>
                <div class="text-end">
                    @if($menu->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $menu->idmenu }}', '{{ $menu->descripcion_plato }}', '{{ $menu->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>                             
{{-- Extras y Snacks --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-star" aria-hidden="true"></i> Extras y Snacks
</h1>
<div class="row">
@foreach($juevesplatos as $extras)
    @if($extras->tipo_plato == "Individual")
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-warning">{{ $extras->nombre_plato }}</h5>
                <p>{!! destacarPalabras($extras->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($extras->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $extras->stock_plato }}</span>
                <div class="text-end">
                    @if($extras->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $extras->idmenu }}', '{{ $extras->descripcion_plato }}', '{{ $extras->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>                      
</div>                                    </div>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="tab-5">
                                    
                                    <div class="table-responsive text-nowrap">
<br>                                    <div class="table-responsive text-nowrap">
{{-- Loncheras --}}
<h1 class="mb-4" style="color:black;font-size: 28px;">
    <i class="fa fa-shopping-basket" aria-hidden="true"></i> Loncheras
</h1>
<div style="display: flex; align-items: center; justify-content: flex-end; margin-top: -50px;">
    <span style="font-size: 16px; background-color: #4CAF50; color: white; padding: 8px 16px; border-radius: 25px; display: flex; align-items: center;" class="responsive-button">
        <i class="fa fa-calendar" style="margin-right: 8px;"></i>
        {{$viernes}}
    </span>
</div>
<br>
<div class="row">
@foreach($viernesplatos as $plato)
    @if($plato->tipo_plato == "Lonchera")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-primary">{{ $plato->nombre_plato }}</h5>
                <p>{!! destacarPalabras($plato->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($plato->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $plato->stock_plato }}</span>
                <div class="text-end">
                    @if($plato->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $plato->idmenu }}', '{{ $plato->descripcion_plato }}', '{{ $plato->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>
{{-- Menú Prandium --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-cutlery" aria-hidden="true"></i> Menú Prandium
</h1>
<div class="row">
@foreach($viernesplatos as $menu)
    @if($menu->tipo_plato == "Menu")
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-success">{{ $menu->nombre_plato }}</h5>
                <p>{!! destacarPalabras($menu->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($menu->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $menu->stock_plato }}</span>
                <div class="text-end">
                    @if($menu->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $menu->idmenu }}', '{{ $menu->descripcion_plato }}', '{{ $menu->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>                             
{{-- Extras y Snacks --}}
<h1 class="mb-4" style="color:black;font-size: 28px">
    <i class="fa fa-star" aria-hidden="true"></i> Extras y Snacks
</h1>
<div class="row">
@foreach($viernesplatos as $extras)
    @if($extras->tipo_plato == "Individual")
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-warning">{{ $extras->nombre_plato }}</h5>
                <p>{!! destacarPalabras($extras->descripcion_plato) !!}</p>
                <p class="fw-bold">S/ {{ number_format($extras->precio_plato, 2) }}</p>
                <span class="badge bg-info text-white mb-2">Stock: {{ $extras->stock_plato }}</span>
                <div class="text-end">
                    @if($extras->stock_plato <= 0)
                        <span class="text-danger">Sin stock</span>
                    @else
                        <button class="btn btn-sm btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#pedir"
                            onclick="pedir('{{ $extras->idmenu }}', '{{ $extras->descripcion_plato }}', '{{ $extras->fecha_menu }}')">
                            <i class="fa fa-heart-o"></i> Pedir Plato
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                
<script>
    // Función para abrir el modal y mostrar los datos
    function pedir(idmenu,nombre_plato,fecha_menu) {
      // Asignamos los valores a los campos de texto
    	document.getElementById('idmenu').value = idmenu;
      document.getElementById('nombre_plato').value = nombre_plato;
      document.getElementById('fecha_menu').value = fecha_menu;
   
      

      // Mostramos el modal usando Bootstrap
      $('#miModal').modal('show');
    }

 </script> 
@endif 
@endsection