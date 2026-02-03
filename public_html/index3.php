<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio Suspendido</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            font-family: "Nunito", sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            padding: 40px;
            max-width: 500px;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .icon {
            font-size: 70px;
            color: #dc3545;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="icon mb-3">⚠️</div>

        <h2 class="text-danger fw-bold mb-3">Servicio Suspendido</h2>

        <p class="mb-3">
            El servicio de <b>Web Hosting</b> ha sido <b>suspendido</b> debido a la falta de pago de la renovación.
        </p>

        <p class="mb-3">
            Monto pendiente:<br>
            <b>€120 euros</b><br>
            <b>≈ S/ 498 soles</b>
        </p>

        <p class="fw-bold text-secondary">
            Para reactivar la plataforma, por favor<br>
            <span class="text-dark">contacte con su proveedor lo antes posible.</span>
        </p>

        <hr>

        <p class="text-muted small">
            Esta página permanecerá inaccesible hasta regularizar el pago.
        </p>
    </div>

</body>

</html>
