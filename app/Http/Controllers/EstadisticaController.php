<?php

namespace App\Http\Controllers;

use App\Exports\CategoryStatsExport;
use App\Services\AdminAnalyticsService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EstadisticaController extends Controller
{
    public function __construct(private readonly AdminAnalyticsService $analytics)
    {
    }

    private function categoriasConRutas(): array
    {
        return array_map(function (array $categoria): array {
            $slug = $categoria['slug'];

            return $categoria + [
                'detalle_url' => route('estadisticas.show', ['categoria' => $slug]),
                'pdf_url' => route('estadisticas.export.pdf', ['categoria' => $slug]),
                'excel_url' => route('estadisticas.export.excel', ['categoria' => $slug]),
            ];
        }, $this->analytics->categories());
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $summaryStats     = $this->analytics->indexSummaryStats();
        $categorias       = array_map(function (array $categoria) use ($summaryStats): array {
            $slug = $categoria['slug'];
            return $categoria + [
                'detalle_url' => route('estadisticas.show',         ['categoria' => $slug]),
                'pdf_url'     => route('estadisticas.export.pdf',   ['categoria' => $slug]),
                'excel_url'   => route('estadisticas.export.excel', ['categoria' => $slug]),
                'stats'       => $summaryStats[$slug] ?? [],
            ];
        }, $this->analytics->categories());

        $estadisticaGeneral = collect($categorias)->firstWhere('slug', 'ventas');
        $stockCategoria = collect($categorias)->firstWhere('slug', 'stock');
        $stockDetalle = $stockCategoria ? $this->analytics->categoryData('stock') : null;
        $proveedoresCategoria = collect($categorias)->firstWhere('slug', 'proveedores');
        $proveedoresDetalle = $proveedoresCategoria ? $this->analytics->categoryData('proveedores') : null;

        $categorias = array_values(array_filter(
            $categorias,
            fn (array $categoria): bool => !in_array($categoria['slug'], ['ventas', 'stock', 'proveedores'], true)
        ));

        $categoriasVentas = $this->analytics->categoriasVentasCards();

        return view('estadisticas.index', compact(
            'estadisticaGeneral',
            'stockCategoria',
            'stockDetalle',
            'proveedoresCategoria',
            'proveedoresDetalle',
            'categoriasVentas'
        ));
    }

    public function show(Request $request, string $categoria)
    {
        $this->authorizeAdmin($request);
        $data = $this->buildCategoryData($categoria);

        return view('estadisticas.show', $data);
    }

    public function exportPdf(Request $request, string $categoria)
    {
        $this->authorizeAdmin($request);
        $data = $this->buildCategoryData($categoria);

        $pdf = Pdf::loadView('estadisticas.pdf', $data)->setPaper('a4', 'landscape');

        return $pdf->download('estadisticas-' . $categoria . '-' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportExcel(Request $request, string $categoria)
    {
        $this->authorizeAdmin($request);
        $data = $this->buildCategoryData($categoria);

        return Excel::download(
            new CategoryStatsExport($data['headings'], $data['rows']->toArray()),
            'estadisticas-' . $categoria . '-' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user() && $request->user()->hasRole('admin'), 403);
    }

    private function buildCategoryData(string $categoria): array
    {
        $data = $this->analytics->categoryData($categoria);

        $categorias = $this->categoriasConRutas();

        // Para categorías dinámicas (cat-{id}) construimos categoriaActual desde los datos devueltos
        if (preg_match('/^cat-(\d+)$/', $categoria)) {
            $categoriaActual = [
                'slug'        => $categoria,
                'titulo'      => $data['titulo'],
                'descripcion' => $data['descripcion'],
                'icono'       => 'bi-music-note-beamed',
            ];
        } else {
            $categoriaActual = collect($categorias)->firstWhere('slug', $categoria);
        }

        return $data + [
            'categorias'      => $categorias,
            'categoriaActual' => $categoriaActual,
        ];
    }
}
