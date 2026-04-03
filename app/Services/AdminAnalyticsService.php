<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\Artista;
use App\Models\Formato;
use App\Models\Categoria;
use App\Models\InventarioMovimiento;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use App\Models\ProductoResena;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsService
{
    public function categories(): array
    {
        return [
            [
                'slug' => 'ventas',
                'titulo' => 'Estadistica General',
                'descripcion' => 'Conteo general del sistema usando la misma base de datos del dashboard.',
                'icono' => 'bi-graph-up-arrow',
            ],
            [
                'slug' => 'productos',
                'titulo' => 'Productos e Inventario',
                'descripcion' => 'Resumen de formatos, stock actual y datos del inventario.',
                'icono' => 'bi-vinyl-fill',
            ],
            [
                'slug' => 'stock',
                'titulo' => 'Stock de Productos',
                'descripcion' => 'Conteo de existencias, productos con pocas unidades y productos agotados.',
                'icono' => 'bi-box-seam-fill',
            ],
            [
                'slug' => 'proveedores',
                'titulo' => 'Proveedores',
                'descripcion' => 'Rendimiento de proveedores segun productos, ventas e ingresos generados.',
                'icono' => 'bi-truck-front-fill',
            ],
            [
                'slug' => 'clientes',
                'titulo' => 'Clientes',
                'descripcion' => 'Actividad de clientes y comportamiento de compra.',
                'icono' => 'bi-people-fill',
            ],
            [
                'slug' => 'usuarios',
                'titulo' => 'Usuarios',
                'descripcion' => 'Cuentas, roles y crecimiento reciente del sistema.',
                'icono' => 'bi-person-badge-fill',
            ],
            [
                'slug' => 'panel',
                'titulo' => 'Panel de Control',
                'descripcion' => 'Datos operativos de categorias, formatos, artistas, inventario y actividad.',
                'icono' => 'bi-kanban-fill',
            ],
        ];
    }

    public function dashboardData(): array
    {
        $stats = $this->dashboardStats();
        $proveedoresData = $this->proveedoresAnalytics();

        $ultimosPedidos = Pedido::with('user')->latest((new Pedido())->getKeyName())->limit(10)->get();

        $topProductos = PedidoDetalle::join('productos', 'productos.id', '=', 'pedido_detalles.producto_id')
            ->select(
                'productos.id',
                'productos.nombre',
                DB::raw('SUM(pedido_detalles.cantidad) as total_vendido'),
                DB::raw('SUM(pedido_detalles.precio * pedido_detalles.cantidad) as ingreso')
            )
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        // Usuarios are stored in `usuarios` table and pedidos reference `usuario_id`
        $topClientes = DB::table('pedidos')
            ->join('usuarios', 'usuarios.usuario_id', '=', 'pedidos.usuario_id')
            ->select(
                'usuarios.usuario_id',
                'usuarios.name',
                'usuarios.email',
                DB::raw('COUNT(pedidos.id) as total_pedidos'),
                DB::raw('SUM(pedidos.total) as total_gastado')
            )
            ->groupBy('usuarios.usuario_id', 'usuarios.name', 'usuarios.email')
            ->orderByDesc('total_gastado')
            ->limit(5)
            ->get();

        $ultimasResenas = ProductoResena::with(['user', 'producto'])->latest('resena_producto_id')->limit(8)->get();

        $pedidosPorEstado = Pedido::select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->get();

        $usuariosRecientes = User::latest('usuario_id')->limit(6)->get();

        $proveedoresTop = $proveedoresData['rows']->take(6)->values();
        $topProveedorVentas = $proveedoresData['rows']->sortByDesc('total_vendidos')->first();
        $topProveedorProductos = $proveedoresData['rows']->sortByDesc('total_productos')->first();

        $proveedoresResumen = [
            'total_proveedores' => (int) $proveedoresData['rows']->count(),
            'total_productos' => (int) $proveedoresData['rows']->sum('total_productos'),
            'total_vendidos' => (int) $proveedoresData['rows']->sum('total_vendidos'),
            'top_ventas_nombre' => $topProveedorVentas['proveedor'] ?? 'Sin datos',
            'top_productos_nombre' => $topProveedorProductos['proveedor'] ?? 'Sin datos',
        ];

        return compact(
            'stats',
            'ultimosPedidos',
            'topProductos',
            'topClientes',
            'ultimasResenas',
            'pedidosPorEstado',
            'usuariosRecientes',
            'proveedoresTop',
            'proveedoresResumen'
        );
    }

    private function dashboardStats(): array
    {
        return Cache::remember('analytics.dashboard.stats', now()->addMinutes(5), function (): array {
            $proveedoresData = $this->proveedoresAnalytics();
            $topProveedorVentas = $proveedoresData['rows']->sortByDesc('total_vendidos')->first();
            $topProveedorProductos = $proveedoresData['rows']->sortByDesc('total_productos')->first();

            return [
                'totalUsuarios' => User::count(),
                'usuariosActivos' => User::where('activo', 1)->count(),
                'totalPedidos' => Pedido::count(),
                'pedidosPendientes' => Pedido::where('estado', 'pendiente')->count(),
                'pedidosEnviados' => Pedido::where('estado', 'enviado')->count(),
                'pedidosCancelados' => Pedido::whereIn('estado', ['cancelado', 'anulado'])->count(),
                'pedidosEntregados' => Pedido::where('estado', 'entregado')->count(),
                'ingresoTotal' => (float) (Pedido::sum('total') ?? 0),
                'totalProductos' => Producto::count(),
                'stockTotalProductos' => (int) (Producto::sum('cantidad') ?? 0),
                'stockBajo' => Producto::where('cantidad', '<=', 5)->count(),
                'productosSinStock' => Producto::where('cantidad', '<=', 0)->count(),
                'totalCategorias' => Categoria::count(),
                'totalCatalogos' => Formato::count(),
                'totalArtistas' => Artista::count(),
                'totalMovimientosInventario' => InventarioMovimiento::count(),
                'totalActividadPanel' => AdminActivityLog::count(),
                'totalProveedores' => (int) $proveedoresData['rows']->count(),
                'totalProductosConProveedor' => (int) $proveedoresData['rows']->sum('total_productos'),
                'totalVendidosProveedores' => (int) $proveedoresData['rows']->sum('total_vendidos'),
                'topProveedorVentas' => $topProveedorVentas['proveedor'] ?? 'Sin datos',
                'topProveedorProductos' => $topProveedorProductos['proveedor'] ?? 'Sin datos',
            ];
        });
    }

    /**
     * Mini-KPIs para cada tarjeta del índice de estadísticas.
     * Se calculan en una sola llamada para no hacer consultas repetidas.
     */
    public function indexSummaryStats(): array
    {
        $stats = $this->dashboardStats();

        return [
            'ventas' => [
                ['label' => 'Usuarios',   'value' => $stats['totalUsuarios']],
                ['label' => 'Pedidos',    'value' => $stats['totalPedidos']],
                ['label' => 'Productos',  'value' => $stats['totalProductos']],
                ['label' => 'Ingreso',    'value' => '$' . number_format((float) $stats['ingresoTotal'], 2)],
            ],
            'productos' => [
                ['label' => 'Productos',   'value' => $stats['totalProductos']],
                ['label' => 'Pocas unidades',  'value' => $stats['stockBajo']],
            ],
            'stock' => [
                ['label' => 'Stock total', 'value' => $stats['stockTotalProductos']],
                ['label' => 'Pocas unidades',  'value' => $stats['stockBajo']],
                ['label' => 'Agotado',   'value' => $stats['productosSinStock']],
            ],
            'proveedores' => [
                ['label' => 'Proveedores', 'value' => $stats['totalProveedores']],
                ['label' => 'Productos asociados', 'value' => $stats['totalProductosConProveedor']],
                ['label' => 'Unidades vendidas', 'value' => $stats['totalVendidosProveedores']],
            ],
            'clientes' => [
                ['label' => 'Clientes',     'value' => User::role('cliente')->count()],
                ['label' => 'Con compras',  'value' => User::role('cliente')->whereHas('pedidos')->count()],
            ],
            'usuarios' => [
                ['label' => 'Total',    'value' => $stats['totalUsuarios'],
                ],
                ['label' => 'Activos',  'value' => $stats['usuariosActivos']],
            ],
            'panel' => [
                ['label' => 'Categorias', 'value' => $stats['totalCategorias']],
                ['label' => 'Formatos',   'value' => $stats['totalCatalogos']],
                ['label' => 'Artistas',   'value' => $stats['totalArtistas']],
            ],
        ];
    }

    /**
     * Genera dinámicamente una tarjeta por cada categoría musical registrada en la BD,
     * con métricas agregadas de ventas reales (misma fuente que el dashboard del cliente).
     */
    public function categoriasVentasCards(): Collection
    {
        $cards = Cache::remember('analytics.categorias_ventas.cards', now()->addMinutes(5), function () {
            return Categoria::leftJoin('productos', 'productos.categoria_id', '=', 'categorias.id')
            ->leftJoin('pedido_detalles', 'pedido_detalles.producto_id', '=', 'productos.id')
            ->leftJoin('pedidos', 'pedidos.id', '=', 'pedido_detalles.pedido_id')
            ->select(
                'categorias.id',
                'categorias.nombre',
                DB::raw('COUNT(DISTINCT productos.id) as total_productos'),
                DB::raw('COUNT(DISTINCT pedidos.id) as total_pedidos'),
                DB::raw('COALESCE(SUM(pedido_detalles.cantidad), 0) as total_unidades'),
                DB::raw('COALESCE(SUM(pedido_detalles.precio * pedido_detalles.cantidad), 0) as total_ventas')
            )
            ->groupBy('categorias.id', 'categorias.nombre')
            ->orderByDesc('total_ventas')
            ->get();
        });

        return collect($cards)
            ->map(function ($cat) {
                $slug        = 'cat-' . $cat->id;
                $ventas      = (float) $cat->total_ventas;
                $unidades    = (int) $cat->total_unidades;
                $pedidos     = (int) $cat->total_pedidos;
                $productos   = (int) $cat->total_productos;

                return [
                    'slug'           => $slug,
                    'titulo'         => $cat->nombre,
                    'descripcion'    => "{$productos} producto(s) · {$pedidos} pedido(s) · {$unidades} unidad(es) vendida(s)",
                    'icono'          => 'bi-music-note-beamed',
                    'total_productos' => $productos,
                    'total_pedidos'   => $pedidos,
                    'total_unidades'  => $unidades,
                    'total_ventas'    => $ventas,
                    'detalle_url'    => route('estadisticas.show',         ['categoria' => $slug]),
                    'pdf_url'        => route('estadisticas.export.pdf',   ['categoria' => $slug]),
                    'excel_url'      => route('estadisticas.export.excel', ['categoria' => $slug]),
                ];
            });
    }

    public function categoryData(string $categoria): array
    {
        // Categorías dinámicas generadas desde la tabla `categorias` (slug: cat-{id})
        if (preg_match('/^cat-(\d+)$/', $categoria, $m)) {
            return $this->categoriaEspecificaData((int) $m[1]);
        }

        if (!collect($this->categories())->pluck('slug')->contains($categoria)) {
            abort(404);
        }

        return match ($categoria) {
            'ventas'    => $this->ventasData(),
            'productos' => $this->productosData(),
            'stock'     => $this->stockData(),
            'proveedores' => $this->proveedoresData(),
            'clientes'  => $this->clientesData(),
            'usuarios'  => $this->usuariosData(),
            'panel'     => $this->panelData(),
        };
    }

    private function proveedoresData(): array
    {
        $proveedoresData = $this->proveedoresAnalytics();
        $rows = $proveedoresData['rows'];

        $topProveedorVentas = $rows->sortByDesc('total_vendidos')->first();
        $topProveedorProductos = $rows->sortByDesc('total_productos')->first();
        $maxVendidos = max(1, (int) $rows->max('total_vendidos'));

        $indicadores = $rows
            ->take(8)
            ->map(fn (array $row) => [
                'label' => $row['proveedor'],
                'ventas' => $row['total_vendidos'],
                'ingresos' => $row['ingresos'],
                'percent' => min(100, (int) round(($row['total_vendidos'] / $maxVendidos) * 100)),
            ])
            ->values();

        return [
            'categoria' => 'proveedores',
            'titulo' => 'Estadisticas de Proveedores',
            'descripcion' => 'Relacion entre proveedores, productos asociados, unidades vendidas e ingresos por ventas.',
            'summary' => [
                ['label' => 'Proveedores registrados', 'value' => (int) $rows->count()],
                ['label' => 'Productos asociados', 'value' => (int) $rows->sum('total_productos')],
                ['label' => 'Unidades vendidas', 'value' => (int) $rows->sum('total_vendidos')],
                ['label' => 'Ingresos por proveedores', 'value' => '$' . number_format((float) $rows->sum('ingresos'), 2)],
                ['label' => 'Top por ventas', 'value' => $topProveedorVentas['proveedor'] ?? 'Sin datos'],
                ['label' => 'Top por productos', 'value' => $topProveedorProductos['proveedor'] ?? 'Sin datos'],
            ],
            'headings' => [
                'Proveedor',
                'Productos asociados',
                'Unidades vendidas',
                'Ingresos',
                'Producto(s) mas vendido(s)',
            ],
            'rows' => $rows->map(fn (array $row) => [
                'proveedor' => $row['proveedor'],
                'total_productos' => $row['total_productos'],
                'total_vendidos' => $row['total_vendidos'],
                'ingresos' => number_format((float) $row['ingresos'], 2, '.', ''),
                'productos_top' => $row['productos_top'],
            ]),
            'indicadores' => $indicadores,
        ];
    }

    /**
     * Analitica agregada por proveedor usando proveedores -> productos -> pedido_detalles.
     */
    private function proveedoresAnalytics(): array
    {
        $rows = Cache::remember('analytics.proveedores.rows', now()->addMinutes(5), function () {
            // proveedores table uses `proveedor_id` as primary key; select and group by that column
            $proveedores = Proveedor::leftJoin('productos', 'productos.proveedor_id', '=', 'proveedores.proveedor_id')
            ->leftJoin('pedido_detalles', 'pedido_detalles.producto_id', '=', 'productos.id')
            ->select(
                'proveedores.proveedor_id as id',
                'proveedores.nombre',
                DB::raw('COUNT(DISTINCT productos.id) as total_productos'),
                DB::raw('COALESCE(SUM(pedido_detalles.cantidad), 0) as total_vendidos'),
                DB::raw('COALESCE(SUM(pedido_detalles.cantidad * pedido_detalles.precio), 0) as ingresos')
            )
            ->groupBy('proveedores.proveedor_id', 'proveedores.nombre')
            ->orderByDesc('total_vendidos')
            ->orderByDesc('ingresos')
            ->get();

            $productosTop = Producto::join('proveedores', 'proveedores.proveedor_id', '=', 'productos.proveedor_id')
            ->leftJoin('pedido_detalles', 'pedido_detalles.producto_id', '=', 'productos.id')
            ->select(
                'proveedores.proveedor_id as proveedor_id',
                'productos.nombre as producto_nombre',
                DB::raw('COALESCE(SUM(pedido_detalles.cantidad), 0) as total_vendido')
            )
            ->groupBy('proveedores.proveedor_id', 'productos.id', 'productos.nombre')
            ->orderBy('proveedores.proveedor_id')
            ->orderByDesc('total_vendido')
            ->get()
            ->groupBy('proveedor_id')
            ->map(function (Collection $items): string {
                $top = $items->take(3)->filter(fn ($item) => (int) $item->total_vendido > 0);

                if ($top->isEmpty()) {
                    return 'Sin ventas';
                }

                return $top
                    ->map(fn ($item) => $item->producto_nombre . ' (' . (int) $item->total_vendido . ')')
                    ->implode(', ');
            });

            return $proveedores->map(function ($p) use ($productosTop): array {
                return [
                    'proveedor' => $p->nombre,
                    'total_productos' => (int) $p->total_productos,
                    'total_vendidos' => (int) $p->total_vendidos,
                    'ingresos' => (float) $p->ingresos,
                    'productos_top' => $productosTop[$p->id] ?? 'Sin productos',
                ];
            })->values()->all();
        });

        return [
            'rows' => collect($rows),
        ];
    }

    private function ventasData(): array
    {
        $stats = $this->dashboardStats();

        $rows = Pedido::with('user')
            ->latest((new Pedido())->getKeyName())
            ->limit(30)
            ->get()
            ->map(fn (Pedido $pedido) => [
                'pedido' => '#' . $pedido->getKey(),
                'cliente' => $pedido->user->name ?? $pedido->nombre ?? 'Sin cliente',
                'estado' => ucfirst((string) $pedido->estado),
                'total' => number_format((float) $pedido->total, 2, '.', ''),
                'fecha' => optional($pedido->created_at)->format('Y-m-d H:i:s'),
            ]);

        return [
            'categoria' => 'ventas',
            'titulo' => 'Estadistica General',
            'descripcion' => 'Conteo general del sistema alimentado con la misma informacion del dashboard.',
            'summary' => [
                ['label' => 'Usuarios totales', 'value' => $stats['totalUsuarios']],
                ['label' => 'Usuarios activos', 'value' => $stats['usuariosActivos']],
                ['label' => 'Pedidos totales', 'value' => $stats['totalPedidos']],
                ['label' => 'Productos totales', 'value' => $stats['totalProductos']],
                ['label' => 'Categorias', 'value' => $stats['totalCategorias']],
                ['label' => 'Formatos', 'value' => $stats['totalCatalogos']],
                ['label' => 'Artistas', 'value' => $stats['totalArtistas']],
                ['label' => 'Ingreso total', 'value' => '$' . number_format((float) $stats['ingresoTotal'], 2)],
            ],
            'headings' => ['Pedido', 'Cliente', 'Estado', 'Total', 'Fecha'],
            'rows' => $rows,
        ];
    }

    private function productosData(): array
    {
        $rows = Producto::with(['categoria', 'catalogo', 'artista'])
            ->latest((new Producto())->getKeyName())
            ->limit(30)
            ->get()
            ->map(fn (Producto $producto) => [
                'producto' => $producto->nombre,
                'categoria' => $producto->categoria->nombre ?? 'Sin categoria',
                'formato' => $producto->catalogo->nombre ?? 'Sin formato',
                'artista' => $producto->artista->nombre ?? 'Sin artista',
                'stock' => (int) $producto->cantidad,
                'precio' => number_format((float) $producto->precio, 2, '.', ''),
                'descuento' => number_format((float) $producto->descuento, 2, '.', ''),
                'precio_final' => number_format((float) ($producto->precio - $producto->descuento), 2, '.', ''),
            ]);

        $totalDescuentos = Producto::where('descuento', '>', 0)->sum('descuento');
        $productosConDescuento = Producto::where('descuento', '>', 0)->count();
        return [
            'categoria' => 'productos',
            'titulo' => 'Estadisticas de Productos e Inventario',
            'descripcion' => 'Informacion del panel de productos, stock actual, cobertura del catalogo y descuentos aplicados.',
            'summary' => [
                ['label' => 'Total productos', 'value' => Producto::count()],
                ['label' => 'Categorias registradas', 'value' => Categoria::count()],
                ['label' => 'Formatos registrados', 'value' => Formato::count()],
                ['label' => 'Artistas registrados', 'value' => Artista::count()],
                ['label' => 'Pocas unidades (<=5)', 'value' => Producto::where('cantidad', '<=', 5)->count()],
                ['label' => 'Movimientos de inventario', 'value' => InventarioMovimiento::count()],
                ['label' => 'Productos con descuento', 'value' => $productosConDescuento],
                ['label' => 'Total descuentos aplicados', 'value' => '$' . number_format($totalDescuentos, 2)],
            ],
            'headings' => ['Producto', 'Categoria', 'Formato', 'Artista', 'Stock', 'Precio', 'Descuento', 'Precio final'],
            'rows' => $rows,
        ];
    }

    private function stockData(): array
    {
        $stats = $this->dashboardStats();

        $rows = Producto::with(['categoria', 'catalogo', 'artista'])
            ->orderBy('cantidad')
            ->orderBy('nombre')
            ->limit(50)
            ->get()
            ->map(fn (Producto $producto) => [
                'producto' => $producto->nombre,
                'categoria' => $producto->categoria->nombre ?? 'Sin categoria',
                'catalogo' => $producto->catalogo->nombre ?? 'Sin catalogo',
                'artista' => $producto->artista->nombre ?? 'Sin artista',
                'stock' => (int) $producto->cantidad,
                'estado_stock' => $producto->cantidad <= 0
                    ? 'Agotado'
                    : ($producto->cantidad <= 5 ? 'Pocas unidades' : 'Disponible'),
            ]);

        $promedioStock = (float) (Producto::avg('cantidad') ?? 0);

        return [
            'categoria' => 'stock',
            'titulo' => 'Estadisticas de Stock de Productos',
            'descripcion' => 'Control de existencias con enfoque en stock total, pocas unidades y productos agotados.',
            'summary' => [
                ['label' => 'Stock total unidades', 'value' => $stats['stockTotalProductos']],
                ['label' => 'Productos con pocas unidades', 'value' => $stats['stockBajo']],
                ['label' => 'Productos agotados', 'value' => $stats['productosSinStock']],
                ['label' => 'Promedio stock por producto', 'value' => number_format($promedioStock, 2)],
            ],
            'headings' => ['Producto', 'Categoria', 'Catalogo', 'Artista', 'Stock', 'Estado'],
            'rows' => $rows,
        ];
    }

    private function clientesData(): array
    {
        $clientes = User::role('cliente')
            ->withCount('pedidos')
            ->withSum('pedidos', 'total')
            ->latest((new User())->getKeyName())
            ->limit(30)
            ->get();

        $rows = $clientes->map(fn (User $user) => [
            'cliente' => $user->name,
            'correo' => $user->email,
            'estado' => $user->activo ? 'Activo' : 'Inactivo',
            'pedidos' => (int) $user->pedidos_count,
            'total_gastado' => number_format((float) ($user->pedidos_sum_total ?? 0), 2, '.', ''),
        ]);

        $clientesConCompras = User::role('cliente')->whereHas('pedidos')->count();
        $ticketPromedio = (float) (Pedido::avg('total') ?? 0);

        return [
            'categoria' => 'clientes',
            'titulo' => 'Estadisticas de Clientes',
            'descripcion' => 'Clientes del sistema con y sin compras, usando datos del panel y de pedidos.',
            'summary' => [
                ['label' => 'Clientes con rol cliente', 'value' => User::role('cliente')->count()],
                ['label' => 'Clientes activos', 'value' => User::role('cliente')->where('activo', 1)->count()],
                ['label' => 'Clientes con compras', 'value' => $clientesConCompras],
                ['label' => 'Ticket promedio', 'value' => '$' . number_format($ticketPromedio, 2)],
            ],
            'headings' => ['Cliente', 'Correo', 'Estado', 'Pedidos', 'Total gastado'],
            'rows' => $rows,
        ];
    }

    private function usuariosData(): array
    {
        $rows = User::with('roles:id,name')
            ->latest((new User())->getKeyName())
            ->limit(30)
            ->get()
            ->map(fn (User $user) => [
                'usuario' => $user->name,
                'correo' => $user->email,
                'estado' => $user->activo ? 'Activo' : 'Inactivo',
                'roles' => $user->roles->pluck('name')->implode(', '),
                'registro' => optional($user->created_at)->format('Y-m-d H:i:s'),
            ]);

        return [
            'categoria' => 'usuarios',
            'titulo' => 'Estadisticas de Usuarios del Sistema',
            'descripcion' => 'Usuarios recientes, estados de cuenta y roles cargados desde el panel.',
            'summary' => [
                ['label' => 'Total usuarios', 'value' => User::count()],
                ['label' => 'Usuarios activos', 'value' => User::where('activo', 1)->count()],
                ['label' => 'Usuarios inactivos', 'value' => User::where('activo', 0)->count()],
                ['label' => 'Nuevos ultimos 30 dias', 'value' => User::where('created_at', '>=', now()->subDays(30))->count()],
            ],
            'headings' => ['Usuario', 'Correo', 'Estado', 'Roles', 'Fecha registro'],
            'rows' => $rows,
        ];
    }

    public function panelData(): array
    {
        $rows = collect([
            $this->panelModuleRow('Productos', Producto::query()),
            $this->panelModuleRow('Categorias', Categoria::query()),
            $this->panelModuleRow('Formatos', Formato::query()),
            $this->panelModuleRow('Artistas', Artista::query()),
            $this->panelModuleRow('Movimientos de inventario', InventarioMovimiento::query()),
            $this->panelModuleRow('Resenas', ProductoResena::query()),
            $this->panelModuleRow('Actividad de panel', AdminActivityLog::query()),
        ]);

        return [
            'categoria' => 'panel',
            'titulo' => 'Estadisticas del Panel de Control',
            'descripcion' => 'Resumen operativo de los modulos administrativos y actividad registrada del panel.',
            'summary' => [
                ['label' => 'Categorias', 'value' => Categoria::count()],
                ['label' => 'Formatos', 'value' => Formato::count()],
                ['label' => 'Artistas', 'value' => Artista::count()],
                ['label' => 'Productos', 'value' => Producto::count()],
                ['label' => 'Movimientos inventario', 'value' => InventarioMovimiento::count()],
                ['label' => 'Actividad panel', 'value' => AdminActivityLog::count()],
            ],
            'headings' => ['Modulo', 'Registros', 'Ultima actualizacion', 'Estado'],
            'rows' => $rows,
        ];
    }

    /**
     * Detalle estadístico de una categoría musical específica.
     * Usa las mismas fuentes de datos (pedidos, pedido_detalles, productos)
     * que emplea el dashboard del cliente para $productosFrecuentes y $categoriasInteres.
     */
    private function categoriaEspecificaData(int $catId): array
    {
        $cat = Categoria::findOrFail($catId);

        // Productos de la categoría con métricas de venta agregadas
        $rows = Producto::where('productos.categoria_id', $catId)
            ->leftJoin('pedido_detalles', 'pedido_detalles.producto_id', '=', 'productos.id')
            ->select(
                'productos.id',
                'productos.nombre',
                'productos.precio',
                'productos.cantidad as stock',
                DB::raw('COUNT(pedido_detalles.id) as veces_pedido'),
                DB::raw('COALESCE(SUM(pedido_detalles.cantidad), 0) as unidades_vendidas'),
                DB::raw('COALESCE(SUM(pedido_detalles.precio * pedido_detalles.cantidad), 0) as ingreso')
            )
            ->groupBy('productos.id', 'productos.nombre', 'productos.precio', 'productos.cantidad')
            ->orderByDesc('unidades_vendidas')
            ->get()
            ->map(fn ($p) => [
                'producto'          => $p->nombre,
                'precio'            => '$' . number_format((float) $p->precio, 2),
                'stock'             => (int) $p->stock,
                'veces_pedido'      => (int) $p->veces_pedido,
                'unidades_vendidas' => (int) $p->unidades_vendidas,
                'ingreso'           => '$' . number_format((float) $p->ingreso, 2),
            ]);

        // KPIs de resumen (espejo de las variables del dashboard del cliente pero a nivel sistema)
        $totalProductos  = Producto::where('categoria_id', $catId)->count();
        $totalUnidades   = (int) PedidoDetalle::join('productos', 'productos.id', '=', 'pedido_detalles.producto_id')
            ->where('productos.categoria_id', $catId)
            ->sum('pedido_detalles.cantidad');
        $totalPedidos    = (int) PedidoDetalle::join('productos', 'productos.id', '=', 'pedido_detalles.producto_id')
            ->where('productos.categoria_id', $catId)
            ->distinct('pedido_detalles.pedido_id')
            ->count('pedido_detalles.pedido_id');
        $totalVentas     = (float) PedidoDetalle::join('productos', 'productos.id', '=', 'pedido_detalles.producto_id')
            ->where('productos.categoria_id', $catId)
            ->sum(DB::raw('pedido_detalles.precio * pedido_detalles.cantidad'));
        $stockBajo       = Producto::where('categoria_id', $catId)->where('cantidad', '<=', 5)->count();

        return [
            'categoria'   => 'cat-' . $catId,
            'titulo'      => 'Categoria: ' . $cat->nombre,
            'descripcion' => 'Ventas, pedidos y productos correspondientes a la categoria musical ' . $cat->nombre . '.',
            'summary'     => [
                ['label' => 'Productos en esta categoria', 'value' => $totalProductos],
                ['label' => 'Pedidos que la incluyen',     'value' => $totalPedidos],
                ['label' => 'Unidades vendidas',           'value' => $totalUnidades],
                ['label' => 'Ingreso total',               'value' => '$' . number_format($totalVentas, 2)],
                ['label' => 'Productos con pocas unidades',    'value' => $stockBajo],
            ],
            'headings' => ['Producto', 'Precio', 'Stock', 'Veces pedido', 'Unidades vendidas', 'Ingreso'],
            'rows'     => $rows,
        ];
    }

    private function panelModuleRow(string $moduleName, $query): array
    {
        $count = (clone $query)->count();
        $lastUpdatedAt = (clone $query)->max('updated_at') ?? (clone $query)->max('created_at');

        return [
            'modulo' => $moduleName,
            'registros' => $count,
            'ultima_actualizacion' => $lastUpdatedAt ? (string) $lastUpdatedAt : 'Sin movimientos',
            'estado' => $count > 0 ? 'Con datos' : 'Sin datos',
        ];
    }
}
