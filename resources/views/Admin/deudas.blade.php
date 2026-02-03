<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Reporte Deudas
	</title>
	<!-- Incluir el archivo CSS de Bootstrap directamente en el HTML para el PDF -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<style>
		/* Estilo personalizado para centrar las tablas */
		.table-responsive {
			margin: 0 auto;
		}
		/* Agregar espacio alrededor de la página */
		body {
			padding: 20px;
		}
		/* Asegurarse de que las tablas no se salgan de la página */
		table {
			width: 100%;
		}
	</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12" style="text-align: center;"><label class="col-form-label" style="color: rgb(0,0,0);font-weight: bold;">Historial de Consumo</label></div>
    </div>
    @foreach($padres as $padre)
    <div class="row">
        <div class="col-md-6"><label class="col-form-label" style="color: rgb(0,0,0);"><strong>Cliente:</strong> {{$padre->nombre_padre}} {{$padre->apellido_padre}}</label></div>
        <div class="col-md-6"><label class="col-form-label">Fecha:  {{$fecha_inicio}} al {{$fecha_fin}}</label></div>
    </div>
    @endforeach
</div>
<br>
<div class="container">
    <div class="table-responsive">
        <table class="table" border="1">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Estudiante</th>
                    <th>Plato</th>
                    <th>Precio</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
            	@foreach($pedidos as $pedido)
                <tr>
                    <td>{{$pedido->fecha_pedido}}</td>
                    <td>{{$pedido->nombre_alumno}} {{$pedido->apellido_alumno}}</td>
                    <td>{{$pedido->nombre_plato}}</td>
                    <td>S/{{number_format($pedido->precio_plato, 2) }}</td>
                    <td>{{$pedido->estado_pago}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
<div>
	<p>Deuda total : S/{{ number_format($deudas, 2) }}</p>
</div>
</body>
</html>