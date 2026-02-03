<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ticket</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<style>
		@page {
			size: 74mm 105mm;
			margin: 5mm;
		}
		body {
			font-family: Arial, sans-serif;
			font-size: 10px;
			padding: 0;
			margin: 0;
			color: #0000FF !important; /* Todo el texto azul */
		}
		table {
			width: 100%;
			border-collapse: collapse;
			font-size: 10px;
			color: #0000FF !important;
		}
		th, td {
			border: 1px solid #0000FF !important; /* Bordes azules */
			padding: 5px;
			text-align: left;
			color: #0000FF !important;
		}
		th {
			background-color: #d2e3ff !important; /* Azul clarito */
			font-weight: bold;
			color: #0000FF !important;
		}
		.container {
			width: 100%;
			text-align: center;
			color: #0000FF !important;
		}
		.label {
			font-weight: bold;
			font-size: 14px;
			color: #0000FF !important;
			margin-top: 10px;
		}
		.table-responsive {
			margin-top: 5mm;
		}
		.total-resaltado {
			background-color: #d2e3ff !important;
			font-weight: bold;
			color: #0000FF !important;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="label">Prandium</div>

		@php
			$first = $pedidos->first();
		@endphp

		<!-- Datos del estudiante -->
		<div class="table-responsive" style="margin-top: 10px;">
			<table class="table">
				<thead>
					<tr>
						<th colspan="2">Datos del Estudiante</th>
					</tr>
				</thead>
				<tbody>
					
					<tr>
						@if($first->tipo_usuario==='profesor' || $first->tipo_usuario==='Profesor')
						<td class="text-end">Profesor:</td>
						@else
						<td class="text-end">Estudiante:</td>
						@endif
						<td>{{ $first->nombre_alumno }} {{ $first->apellido_alumno }}</td>
					</tr>
					
					<tr>
						<td class="text-end">Nivel:</td>
						<td>{{ $first->nivel_alumno }}</td>
					</tr>
					<tr>
						<td class="text-end">Grado:</td>
						<td>{{ $first->grado_alumno }}</td>
					</tr>
					<tr>
						<td class="text-end">Sección:</td>
						<td>{{ $first->seccion_alumno }}</td>
					</tr>
					<tr>
						<td class="text-end">Recreo:</td>
						<td>{{ $first->Recreo }}</td>
					</tr>
					<tr>
						<td class="text-end">Fecha:</td>
						<td>{{ \Carbon\Carbon::parse($first->fecha_pedido)->format('d/m/Y') }}</td>
					</tr>
				</tbody>
			</table>
		</div>
       
		<!-- Detalle de pedidos -->
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Pedidos</th>
                        <th style="text-align: right;">
                            <strong>Total: S/ {{ number_format($precio_total, 2) }}</strong>
                        </th>
					</tr>
				</thead>
				<tbody>
				
					@foreach($pedidos as $pedido)
						<tr>
							<td class="text-end">Producto:</td>
							<td>{{ $pedido->nombre_plato }}</td>
						</tr>
        
						@if(!empty(trim($pedido->descripcion_plato)))
						<tr>
							<td class="text-end">Descripción:</td>
							<td>{{ str_replace(['➼', '?'], ['-', '-'], $pedido->descripcion_plato) }}</td>
						</tr>
						@endif
						
					@endforeach
					
				</tbody>
			</table>
	
		</div>
	</div>
</body>
</html>
