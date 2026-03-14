<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            ->orderByDesc('id')
            ->paginate(10);

        return view('artista.index', compact('registros', 'texto'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('artista-create') || auth()->user()->can('producto-create'), 403);
        return view('artista.action');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('artista-create') || auth()->user()->can('producto-create'), 403);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'biografia' => ['nullable', 'string', 'max:5000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

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

        Artista::create([
            'nombre' => $datos['nombre'],
            'slug' => $slug,
            'biografia' => $datos['biografia'] ?? null,
            'foto' => $foto,
        ]);

        return redirect()->route('artistas.index')->with('mensaje', 'Artista creado correctamente.');
    }

    public function edit(string $id)
    {
        abort_unless(auth()->user()->can('artista-edit') || auth()->user()->can('producto-edit'), 403);

        $registro = Artista::findOrFail($id);
        return view('artista.action', compact('registro'));
    }

    public function update(Request $request, string $id)
    {
        abort_unless(auth()->user()->can('artista-edit') || auth()->user()->can('producto-edit'), 403);

        $registro = Artista::findOrFail($id);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'biografia' => ['nullable', 'string', 'max:5000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($registro->nombre !== $datos['nombre']) {
            $slugBase = Str::slug($datos['nombre']);
            $slug = $slugBase;
            $i = 2;
            while (Artista::where('slug', $slug)->where('id', '!=', $registro->id)->exists()) {
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
}
