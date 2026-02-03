

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PadreController;

// Rutas de autenticación
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/', [LoginController::class, 'showLoginForm'])->name('/');
Auth::routes();

// Rutas públicas
Route::post('/recuperar-clave', [AdminController::class, 'recuperar_clave'])->name('recuperar.clave');
 Route::get('/registrar', [PadreController::class, 'registrar'])->name('registrar');
Route::post('/registrarpadre', [PadreController::class, 'registrarpadre'])->name('registrarpadre');
Route::post('/realizarpedidopadre', [PadreController::class, 'realizarpedidopadre'])->name('realizarpedidopadre');

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rutas de administración
    Route::get('/crear', [AdminController::class, 'crear'])->name('crear');
    Route::get('/platos', [AdminController::class, 'platos'])->name('platos');
    Route::post('/crearplato', [AdminController::class, 'crearplato'])->name('crearplato');
    Route::post('/editarplato', [AdminController::class, 'editarplato'])->name('editarplato');
    Route::post('/eliminarplato', [AdminController::class, 'eliminarplato'])->name('eliminarplato');
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('pedidos');
    Route::get('/pedidosadmin', [AdminController::class, 'pedidosadmin'])->name('pedidosadmin');
    Route::post('/realizarpedido', [AdminController::class, 'realizarpedido'])->name('realizarpedido');
    Route::get('/padre_hijo', [AdminController::class, 'padre_hijo'])->name('padre_hijo');
    Route::post('/editarpadre', [AdminController::class, 'editarpadre'])->name('editarpadre');
    Route::post('/editarhijo', [AdminController::class, 'editarhijo'])->name('editarhijo');
    Route::get('/menu', [AdminController::class, 'menu'])->name('menu');
    Route::post('/agregarmenu', [AdminController::class, 'agregarmenu'])->name('agregarmenu');
    Route::get('/perfil', [AdminController::class, 'perfil'])->name('perfil');
    Route::post('/editarperfil', [AdminController::class, 'editarperfil'])->name('editarperfil');
    Route::post('/pedidosupdate', [AdminController::class, 'pedidosupdate'])->name('pedidosupdate');
    Route::post('/recreo', [AdminController::class, 'recreo'])->name('recreo');
    Route::post('/generar', [AdminController::class, 'generar'])->name('generar');
    Route::get('/pdf', [AdminController::class, 'pdf'])->name('pdf');
    Route::get('/ticket', [AdminController::class, 'ticket'])->name('ticket');
    Route::get('/Reportes', [AdminController::class, 'reportes'])->name('reportes');
    Route::get('/buscar-cliente', [AdminController::class, 'buscar_cliente'])->name('buscar.cliente');
    Route::get('/pedidosprofesor', [AdminController::class, 'pedidosprofesor'])->name('pedidosprofesor');
    Route::post('/editarstock', [AdminController::class, 'editarstock'])->name('editarstock');
    Route::get('/recarga', [AdminController::class, 'recarga'])->name('recarga');
    Route::post('/recargar', [AdminController::class, 'recargar'])->name('recargar');
    Route::post('/agregarlonchera', [AdminController::class, 'agregarlonchera'])->name('agregarlonchera');
    Route::post('/agregarpra', [AdminController::class, 'agregarpra'])->name('agregarpra');
    Route::post('/eliminarmenu', [AdminController::class, 'eliminarmenu'])->name('eliminarmenu');
    Route::post('/editar-menu-prandium', [AdminController::class, 'editarPrandium'])->name('editarpra');
    Route::post('/editar-menu-lonchera', [AdminController::class, 'editarLonchera'])->name('editarlonchera');
    Route::get('/ticket-grupo', [AdminController::class, 'ticket_grupo'])->name('pedido.ticket.grupo');
    Route::get('/deudaspendientes', [AdminController::class, 'deudaspendientes'])->name('deudaspendientes');
    Route::post('/pagar-deuda-total', [AdminController::class, 'pagarDeudaTotal'])->name('pagar.deuda.total');

    // Rutas de padre
    Route::get('/perfilpadre', [PadreController::class, 'perfilpadre'])->name('perfilpadre');
    Route::post('/editarperfilP', [PadreController::class, 'editarperfilpadre'])->name('editarperfilpadre');
    Route::get('/PedidosPadre', [PadreController::class, 'pedidospadre'])->name('pedidospadre');
    Route::get('/MenuPadre', [PadreController::class, 'menupadre'])->name('menupadre');
   
    Route::get('/hijos', [PadreController::class, 'hijos'])->name('hijos');
    Route::post('/agregarhijo', [PadreController::class, 'agregarhijo'])->name('agregarhijo');
    Route::post('/editarhijoP', [PadreController::class, 'editarhijop'])->name('editarhijop');
    Route::post('/eliminarhijoP', [PadreController::class, 'eliminarhijop'])->name('eliminarhijop');
    Route::post('/editarrecreop', [PadreController::class, 'editarrecreop'])->name('editarrecreop');
    Route::post('/mantenimiento', [AdminController::class, 'cambiarestado'])->name('mantenimiento');
});

    