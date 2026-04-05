<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Producto;

class AlbumController extends Controller
{
    public function index()
    {
        // Ordenar álbumes por id descendente (mayor a menor)
        $albums = Album::orderByDesc('album_id')->get();
        $productos = Producto::orderBy('nombre')->get();
        return view('albums.index', compact('albums', 'productos'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['nombre' => ['required','string','max:150','not_regex:/\\d/'], 'descripcion' => 'nullable|string']);
        Album::create($data);
        return redirect()->route('albums.index')->with('success', 'Álbum creado');
    }

    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate(['nombre' => ['required','string','max:150','not_regex:/\\d/'], 'descripcion' => 'nullable|string']);
        $album->update($data);
        return redirect()->route('albums.index')->with('success', 'Álbum actualizado');
    }

    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Álbum eliminado');
    }

    /**
     * Vincular productos a un álbum (recibe array de product_ids)
     */
    public function vincularProductos(Request $request, Album $album)
    {
        $data = $request->validate([
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer', 'exists:productos,id'],
        ]);

        $selected = $data['product_ids'] ?? [];

        // Asignar album_id a los productos seleccionados
        if (!empty($selected)) {
            Producto::whereIn('id', $selected)->update(['album_id' => $album->album_id]);
        }

        // Quitar album_id de productos que antes pertenecían y ya no están seleccionados
        Producto::where('album_id', $album->album_id)
            ->whereNotIn('id', $selected ?: [0])
            ->update(['album_id' => null]);

        return redirect()->route('albums.index')->with('success', 'Productos vinculados al álbum');
    }
}
