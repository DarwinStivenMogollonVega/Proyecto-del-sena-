<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PerfilController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteGestionController;
use App\Http\Controllers\SeguridadController;
use App\Http\Controllers\EstadisticaController;
use App\Services\AdminAnalyticsService;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use App\Models\ProductoResena;

// 🔹 Rutas públicas del sitio web
Route::get('/', [WebController::class, 'index'])->name('web.index');
Route::view('/acerca', 'web.acerca')->name('web.acerca');
Route::get('/producto/{id}', [WebController::class, 'show'])->name('web.show');
// Página pública de listado de productos (ruta pública única para tienda)
Route::get('/tienda', [WebController::class, 'productos'])->name('web.productos');
Route::post('/producto/{id}/resena', [WebController::class, 'guardarResena'])
    ->middleware('auth')
    ->name('web.resena.guardar');

// Ruta de soporte (guía de uso)
Route::view('/soporte', 'web.soporte')->name('web.soporte');

// 🔹 Nueva ruta para mostrar productos por categoría
Route::get('/categoria-web/{id}', [CategoriaController::class, 'show'])->name('web.categoria.show');
Route::get('/formato-web/{id}', [CatalogoController::class, 'show'])->name('web.formato.show');
// Ruta pública para ver productos por artista
Route::get('/artista-web/{id}', [WebController::class, 'artistaShow'])->name('web.artista.show');

Route::get('/carrito', [CarritoController::class, 'mostrar'])->name('carrito.mostrar');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito/sumar', [CarritoController::class, 'sumar'])->name('carrito.sumar');
Route::get('/carrito/restar', [CarritoController::class, 'restar'])->name('carrito.restar');
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

Route::get('/deseados', function() {
    return view('web.wishlist');
})->name('web.wishlist');

Route::post('/deseados/agregar/{id}', function($id) {
    $producto = App\Models\Producto::find($id);
    if (!$producto) {
        return redirect()->back()->with('error', 'Producto no encontrado');
    }
    $wishlist = session('wishlist', []);
    $wishlist[$id] = [
        'id' => $producto->id,
        'nombre' => $producto->nombre,
        'artista' => $producto->artista?->nombre,
        'precio' => $producto->precio,
        'imagen' => $producto->imagen,
    ];
    session(['wishlist' => $wishlist]);
    return redirect()->back()->with('success', 'Producto agregado a la lista de deseados');
})->name('web.wishlist.add');

Route::post('/deseados/toggle/{id}', function($id) {
    $producto = App\Models\Producto::find($id);
    if (!$producto) {
        return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
    }
    // If user is authenticated, persist in DB; otherwise keep using session
    if (auth()->check()) {
        $userId = auth()->id();
        $exists = App\Models\Wishlist::where('user_id', $userId)->where('producto_id', $id)->exists();
        if ($exists) {
            App\Models\Wishlist::where('user_id', $userId)->where('producto_id', $id)->delete();
            $action = 'removed';
            $inWishlist = false;
        } else {
            App\Models\Wishlist::create(['user_id' => $userId, 'producto_id' => $id]);
            $action = 'added';
            $inWishlist = true;
        }
        $count = App\Models\Wishlist::where('user_id', $userId)->count();
        return response()->json([ 'success' => true, 'action' => $action, 'inWishlist' => $inWishlist, 'count' => $count ]);
    }

    // Guest: session-based fallback
    $wishlist = session('wishlist', []);
    $action = 'added';
    if (isset($wishlist[$id])) {
        unset($wishlist[$id]);
        $action = 'removed';
    } else {
        $wishlist[$id] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'artista' => $producto->artista?->nombre,
            'precio' => $producto->precio,
            'imagen' => $producto->imagen,
        ];
    }
    session(['wishlist' => $wishlist]);
    return response()->json([
        'success' => true,
        'action' => $action,
        'inWishlist' => $action === 'added',
        'count' => count($wishlist)
    ]);
})->name('web.wishlist.toggle');

Route::post('/deseados/quitar/{id}', function($id) {
    $wishlist = session('wishlist', []);
    if (isset($wishlist[$id])) {
        unset($wishlist[$id]);
        session(['wishlist' => $wishlist]);
    }
    return redirect()->back()->with('success', 'Producto eliminado de la lista de deseados');
})->name('web.wishlist.remove');

// 🔹 Rutas protegidas (solo usuarios autenticados)
Route::middleware(['auth', 'admin.activity'])->group(function(){
    Route::resource('usuarios', UserController::class);
    Route::patch('usuarios/{usuario}/toggle', [UserController::class, 'toggleStatus'])->name('usuarios.toggle');
    Route::resource('roles', RoleController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('proveedores', ProveedorController::class)->except(['show']);
    Route::resource('categoria', CategoriaController::class);
    Route::resource('formato', CatalogoController::class); // ✅ Rutas del formato (antes catálogo)
    Route::resource('albums', App\Http\Controllers\AlbumController::class)->except(['show']);
    Route::post('/albums/{album}/vincular-productos', [App\Http\Controllers\AlbumController::class, 'vincularProductos'])->name('albums.vincular_productos');
    Route::post('/formato/{formato}/vincular-productos', [CatalogoController::class, 'vincularProductos'])->name('formato.vincular_productos');
    Route::post('/categoria/{categoria}/vincular-productos', [CategoriaController::class, 'vincularProductos'])->name('categoria.vincular_productos');
    // AJAX endpoints para vinculación en tiempo real
    Route::post('/categoria/{categoria}/vincular-producto', [CategoriaController::class, 'attachProducto'])->name('categoria.attach_product');
    Route::delete('/categoria/{categoria}/vincular-producto/{producto}', [CategoriaController::class, 'detachProducto'])->name('categoria.detach_product');
    Route::get('/productos/search', [ProductoController::class, 'search'])->name('productos.search');
    Route::post('/artistas/{artista}/vincular-productos', [ArtistaController::class, 'vincularProductos'])->name('artista.vincular_productos');
    Route::resource('artistas', ArtistaController::class)->except(['show']);
    Route::post('/artistas/check-identifier', [ArtistaController::class, 'checkIdentifier'])->name('artistas.checkIdentifier');
    // Ruta explícita para ver detalles de un artista (la resource excluye 'show')
    Route::get('/artistas/{id}', [ArtistaController::class, 'show'])->name('artistas.show');


    // Flujo multi-paso del pedido
    Route::get('/pedido/datos', [PedidoController::class, 'datosForm'])->name('pedido.datos');
    Route::post('/pedido/datos', [PedidoController::class, 'datosGuardar'])->name('pedido.datos.guardar');
    Route::get('/pedido/entrega', [PedidoController::class, 'entregaForm'])->name('pedido.entrega');
    Route::post('/pedido/entrega', [PedidoController::class, 'entregaGuardar'])->name('pedido.entrega.guardar');
    Route::get('/pedido/pago', [PedidoController::class, 'pagoForm'])->name('pedido.pago');
    Route::post('/pedido/pago', [PedidoController::class, 'pagoGuardar'])->name('pedido.pago.guardar');
    // (opcional: puedes dejar la ruta original para compatibilidad)
    Route::post('/pedido/realizar', [PedidoController::class, 'realizar'])->name('pedido.realizar');
    Route::get('/perfil/pedidos', [PedidoController::class, 'misPedidos'])->name('perfil.pedidos');
    Route::get('/perfil/recibos-factura', [FacturaController::class, 'index'])->name('perfil.recibos');
    Route::get('/perfil/recibos-factura/{id}', [FacturaController::class, 'generarDesdePedido'])->name('perfil.recibos.show');
    Route::get('/perfil/facturas/{id}', [FacturaController::class, 'show'])->name('perfil.facturas.show');
    Route::get('/perfil/facturas/{id}/pdf', [FacturaController::class, 'pdf'])->name('perfil.facturas.pdf');
    Route::get('/admin/pedidos', [PedidoController::class, 'adminIndex'])->name('admin.pedidos');
    Route::get('/admin/facturas', [FacturaController::class, 'adminFacturasIndex'])->name('admin.facturas.index');
    Route::get('/admin/facturas/crear', [FacturaController::class, 'adminCreate'])->name('admin.facturas.create');
    Route::post('/admin/facturas', [FacturaController::class, 'adminStore'])->name('admin.facturas.store');
    Route::get('/admin/facturas/{id}/editar', [FacturaController::class, 'adminEdit'])->name('admin.facturas.edit');
    Route::put('/admin/facturas/{id}', [FacturaController::class, 'adminUpdate'])->name('admin.facturas.update');
    Route::delete('/admin/facturas/{id}', [FacturaController::class, 'adminDestroy'])->name('admin.facturas.destroy');
    Route::post('/admin/facturas/{id}/reload', [FacturaController::class, 'adminReload'])->name('admin.facturas.reload');

    Route::get('/admin/clientes', [ClienteGestionController::class, 'index'])->name('admin.clientes.index');
    Route::get('/admin/clientes/{id}', [ClienteGestionController::class, 'show'])->name('admin.clientes.show');

    Route::get('/admin/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::post('/admin/inventario/{id}/movimiento', [InventarioController::class, 'moverStock'])->name('inventario.movimiento');

    Route::get('/admin/seguridad', [SeguridadController::class, 'index'])->name('admin.seguridad.index');
    Route::get('/admin/seguridad/crear', [SeguridadController::class, 'create'])->name('admin.seguridad.create');
    Route::get('/admin/guia-soporte', function () {
        return view('plantilla.guia');
    })->name('admin.guia');

    Route::patch('/pedidos/{id}/estado', [PedidoController::class, 'cambiarEstado'])->name('pedidos.cambiar.estado');    

    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');
    Route::get('/estadisticas/{categoria}', [EstadisticaController::class, 'show'])->name('estadisticas.show');
    Route::get('/estadisticas/{categoria}/export/pdf', [EstadisticaController::class, 'exportPdf'])->name('estadisticas.export.pdf');
    Route::get('/estadisticas/{categoria}/export/excel', [EstadisticaController::class, 'exportExcel'])->name('estadisticas.export.excel');

    Route::get('dashboard', function(){
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('cliente.dashboard');
        }

        $data = app(AdminAnalyticsService::class)->dashboardData();

        // Cargar una vista reducida del gestor de clientes para el dashboard
        $textoClientes = '';
        $clientesQuery = User::query()
            ->whereHas('roles', fn ($q) => $q->where('name', 'cliente'))
            ->withCount('pedidos')
            ->orderByDesc((new User())->getKeyName());

        $registrosClientes = $clientesQuery->limit(10)->get();

        $data['registrosClientes'] = $registrosClientes;
        $data['textoClientes'] = $textoClientes;

        return view('dashboard', $data);
    })->name('dashboard');

    Route::get('/dashboard-cliente', function () {
        $userId = auth()->id();

        $pedidosBase = Pedido::where('usuario_id', $userId);
        $detallesBase = PedidoDetalle::query()
            ->join('pedidos', 'pedidos.id', '=', 'pedido_detalles.pedido_id')
            ->where('pedidos.usuario_id', $userId);

        $totalPedidos = (clone $pedidosBase)->count();
        $gastoTotal = (float) ((clone $pedidosBase)->sum('total') ?? 0);
        $pedidosPendientes = (clone $pedidosBase)->where('estado', 'pendiente')->count();
        $pedidosEnviados = (clone $pedidosBase)->where('estado', 'enviado')->count();
        $pedidosCancelados = (clone $pedidosBase)->whereIn('estado', ['cancelado', 'anulado'])->count();
        $recibosFactura = (clone $pedidosBase)->where('requiere_factura_electronica', true)->count();

        $totalUnidadesCompradas = (int) ((clone $detallesBase)->sum('pedido_detalles.cantidad') ?? 0);

        $ultimosPedidos = Pedido::where('usuario_id', $userId)
            ->latest('id')
            ->limit(5)
            ->get();

        $productosFrecuentes = (clone $detallesBase)
            ->join('productos', 'productos.id', '=', 'pedido_detalles.producto_id')
            ->select(
                'productos.id',
                'productos.nombre',
                DB::raw('SUM(pedido_detalles.cantidad) as total_cantidad')
            )
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('total_cantidad')
            ->limit(5)
            ->get();

        $categoriasInteres = (clone $detallesBase)
            ->join('productos', 'productos.id', '=', 'pedido_detalles.producto_id')
            ->leftJoin('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->select(
                DB::raw("COALESCE(categorias.nombre, 'Sin categoria') as categoria"),
                DB::raw('SUM(pedido_detalles.cantidad) as total_cantidad')
            )
            ->groupBy('categoria')
            ->orderByDesc('total_cantidad')
            ->limit(5)
            ->get();

        $carrito = session('carrito', []);
        $itemsCarrito = collect($carrito)->sum(fn ($item) => (int) ($item['cantidad'] ?? 0));
        $totalCarrito = collect($carrito)->sum(fn ($item) => ((float) ($item['precio'] ?? 0)) * ((int) ($item['cantidad'] ?? 0)));

        $resumen = [
            'totalPedidos' => $totalPedidos,
            'gastoTotal' => $gastoTotal,
            'pedidosPendientes' => $pedidosPendientes,
            'pedidosEnviados' => $pedidosEnviados,
            'pedidosCancelados' => $pedidosCancelados,
            'recibosFactura' => $recibosFactura,
            'totalUnidadesCompradas' => $totalUnidadesCompradas,
            'itemsCarrito' => $itemsCarrito,
            'totalCarrito' => $totalCarrito,
        ];

        return view('web.dashboard_cliente', compact(
            'resumen',
            'ultimosPedidos',
            'productosFrecuentes',
            'categoriasInteres'
        ));
    })->name('cliente.dashboard');

    Route::post('logout', function(){
        Auth::logout();
        return redirect('/login');
    })->name('logout');

    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
});

    // Telemetry endpoint (authenticated users)
    use App\Http\Controllers\TelemetryController;
    Route::post('/telemetry', [TelemetryController::class, 'store'])->name('telemetry.store')->middleware('auth');

// 🔹 Rutas de autenticación (solo para invitados)
Route::middleware('guest')->group(function(){
    Route::get('login', function(){
        return view('autenticacion.login');
    })->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/registro', [RegisterController::class, 'showRegistroForm'])->name('registro');
    Route::post('/registro', [RegisterController::class, 'registrar'])->name('registro.store');

    Route::get('password/reset', [ResetPasswordController::class, 'showRequestForm'])->name('password.request');
    Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.send-link');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});
