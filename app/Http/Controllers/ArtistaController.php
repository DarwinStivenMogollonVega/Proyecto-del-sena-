<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use App\Http\Requests\ArtistaRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ArtistaController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('artista-list') || auth()->user()->can('producto-list'), 403);

        $texto = trim((string) $request->input('texto'));

        $registros = Artista::query()
            ->when($texto !== '', function ($q) use ($texto) {
                $q->where('nombre', 'like', "%{$texto}%");
            })
            ->orderByDesc('artista_id')
            ->paginate(10);

        return view('artista.index', compact('registros', 'texto'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('artista-create') || auth()->user()->can('producto-create'), 403);
        return view('artista.action');
    }

    public function store(ArtistaRequest $request)
    {
        abort_unless(auth()->user()->can('artista-create') || auth()->user()->can('producto-create'), 403);

        $datos = $request->validated();

        $slugBase = Str::slug($datos['nombre']);
        $slug = $slugBase;
        $i = 2;
        while (Artista::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $i;
            $i++;
        }

        $foto = null;
        if ($request->hasFile('foto')) {
            $filename = strtolower(Str::random(3)) . '-' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('uploads/artistas', $filename);
            $foto = $filename;
        }

        // ensure unique identifier column is set (DB requires it)
        // Allow client-provided identificador_unico (validated) or generate one
        $identificador = $request->input('identificador_unico') ?? (string) Str::uuid();

        $registro = Artista::create([
            'nombre' => $datos['nombre'],
            'slug' => $slug,
            'biografia' => $datos['biografia'] ?? null,
            'foto' => $foto,
            'identificador_unico' => $identificador,
        ]);

        // If request was AJAX, return JSON with the created model for client-side use
        if (request()->ajax()) {
            return response()->json(['success' => true, 'artista' => $registro], 201);
        }

        return redirect()->route('artistas.index')->with('mensaje', 'Artista creado correctamente.');
    }

    public function edit(string $id)
    {
        abort_unless(auth()->user()->can('artista-edit') || auth()->user()->can('producto-edit'), 403);

        $registro = Artista::findOrFail($id);
        return view('artista.action', compact('registro'));
    }

    public function show(string $id)
    {
        abort_unless(auth()->user()->can('artista-list') || auth()->user()->can('producto-list'), 403);

        $registro = Artista::findOrFail($id);
        return view('artista.show', compact('registro'));
    }

    public function update(ArtistaRequest $request, string $id)
    {
        abort_unless(auth()->user()->can('artista-edit') || auth()->user()->can('producto-edit'), 403);

        $registro = Artista::findOrFail($id);

        $datos = $request->validated();

        if ($registro->nombre !== $datos['nombre']) {
            $slugBase = Str::slug($datos['nombre']);
            $slug = $slugBase;
            $i = 2;
            while (Artista::where('slug', $slug)->where('artista_id', '!=', $registro->getKey())->exists()) {
                $slug = $slugBase . '-' . $i;
                $i++;
            }
            $registro->slug = $slug;
        }

        if ($request->hasFile('foto')) {
            $filename = strtolower(Str::random(3)) . '-' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('uploads/artistas', $filename);
            if (!empty($registro->foto) && file_exists('uploads/artistas/' . $registro->foto)) {
                @unlink('uploads/artistas/' . $registro->foto);
            }
            $registro->foto = $filename;
        }

        $registro->nombre = $datos['nombre'];
        $registro->biografia = $datos['biografia'] ?? null;
        $registro->save();

        return redirect()->route('artistas.index')->with('mensaje', 'Artista actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        abort_unless(auth()->user()->can('artista-delete') || auth()->user()->can('producto-delete'), 403);

        $registro = Artista::findOrFail($id);

        if (!empty($registro->foto) && file_exists('uploads/artistas/' . $registro->foto)) {
            @unlink('uploads/artistas/' . $registro->foto);
        }

        $registro->delete();

        return redirect()->route('artistas.index')->with('mensaje', 'Artista eliminado correctamente.');
    }

    /**
     * AJAX: check identificador_unico uniqueness
     */
    public function checkIdentifier(Request $request)
    {
        $key = $request->input('identificador_unico');
        $ignoreId = $request->input('ignore_id');

        if (empty($key)) {
            return response()->json(['unique' => false, 'message' => 'Identificador vacío'], 200);
        }

        $query = Artista::where('identificador_unico', $key);
        if ($ignoreId) {
            $query->where('artista_id', '!=', $ignoreId);
        }

        $exists = $query->exists();

        return response()->json(['unique' => !$exists]);
    }
}
