<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->rol=='Administrador'){
            
        $padres=DB::table('padre')
        ->count();
        
        $alumnos=DB::table('alumno')
        ->count();
        
        $pedidos=DB::table('pedido')
        ->count();
        
        $pagados=DB::table('pedido')
        ->where('estado_pago','=','Pagado')
        ->count();
        
        return view('Admin.home', compact('padres','alumnos','pedidos','pagados'));
        }
        elseif(Auth::user()->rol=='Padre' ||  Auth::user()->rol=='Profesor')
        {
            if(Auth::user()->estado=='Activo')
            {
                $dni = auth()->user()->dni;

            $idpadre = DB::table('padre')
                ->where('dni_padre', $dni)
                ->value('idpadre');

            if (!$idpadre) {
                // En caso no se encuentre el padre asociado
                return redirect()->back()->with('alert1', 'No se encontró al padre asociado al usuario actual.');
            }

            $hijosRegistrados = DB::table('alumno')
                ->where('padre_idpadre', $idpadre)
                ->count();
        
            $totalPlatosPedidos = DB::table('pedido')
                ->join('alumno', 'pedido.alumno_idalumno', '=', 'alumno.idalumno')
                ->where('alumno.padre_idpadre', $idpadre)
                ->count();
        
            $platosHoy = DB::table('pedido')
                ->join('alumno', 'pedido.alumno_idalumno', '=', 'alumno.idalumno')
                ->where('alumno.padre_idpadre', $idpadre)
                ->whereDate('pedido.fecha_pedido', now()->toDateString())
                ->count(); 
            // Obtener deuda total
            $deudaTotal = DB::table('padre')
                ->join('alumno', 'padre.idpadre', '=', 'alumno.padre_idpadre')
                ->join('pedido', 'alumno.idalumno', '=', 'pedido.alumno_idalumno')
                ->join('menu', 'pedido.menu_idmenu', '=', 'menu.idmenu')
                ->join('plato', 'menu.plato_idplato', '=', 'plato.idplato')
                ->where('padre.dni_padre', $dni)
                ->where('pedido.estado_pago', 'Pendiente')
                ->sum('plato.precio_plato');
            return view('Padre.home',compact('hijosRegistrados', 'totalPlatosPedidos', 'platosHoy','deudaTotal'));
            
            
            }
            
            else{
               return view('Padre.mensaje');
                
            }
        }    
    }
}
