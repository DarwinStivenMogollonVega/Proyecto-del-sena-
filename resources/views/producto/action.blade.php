@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-0" style="border-radius:1rem; background:#fff;">
                    <div class="card-header" style="background:transparent; border-bottom:1px solid #e5e7eb;">
                        <h3 class="card-title" style="color:#222;">Productos</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ isset($registro) ? route('productos.update', $registro->id) : route('productos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($registro))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Código -->
                                <div class="col-md-3 mb-3">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                        id="codigo" name="codigo"
                                        value="{{ old('codigo', $registro->codigo ?? '') }}" required>
                                    @error('codigo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-3 mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                        id="nombre" name="nombre"
                                        value="{{ old('nombre', $registro->nombre ?? '') }}" required>
                                    @error('nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Precio -->
                                <div class="col-md-3 mb-3">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="text" class="form-control @error('precio') is-invalid @enderror"
                                        id="precio" name="precio"
                                        value="{{ old('precio', $registro->precio ?? '') }}" required>
                                    @error('precio')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              <!--cantidad -->
                                <div class="col-md-3 mb-3">
                                    <label for="cantidad" class="form-label">Cantidad</label>
                                    <input type="text" class="form-control @error('cantidad') is-invalid @enderror"
                                        id="cantidad" name="cantidad"
                                        value="{{ old('cantidad', $registro->cantidad ?? '') }}" required>
                                    @error('cantidad')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Categoría -->
                                <div class="col-md-3 mb-3">
                                    <label for="categoria_id" class="form-label">Categoría</label>
                                    <select name="categoria_id" id="categoria_id" class="form-control" required>
                                        <option value="">Seleccione una categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}"
                                                {{ (string) old('categoria_id', $registro->categoria_id ?? '') === (string) $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Catálogo -->
                                <div class="col-md-3 mb-3">
                                    <label for="catalogo_id" class="form-label">Catálogo</label>
                                    <select name="catalogo_id" id="catalogo_id" class="form-control">
                                        <option value="">Seleccione un catálogo</option>
                                        @foreach($catalogos as $catalogo)
                                            <option value="{{ $catalogo->id }}"
                                                {{ (string) old('catalogo_id', $registro->catalogo_id ?? '') === (string) $catalogo->id ? 'selected' : '' }}>
                                                {{ $catalogo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('catalogo_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="proveedor_id" class="form-label">Proveedor</label>
                                    <select name="proveedor_id" id="proveedor_id" class="form-control">
                                        <option value="">Seleccione un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}"
                                                {{ (string) old('proveedor_id', $registro->proveedor_id ?? '') === (string) $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="artista_id" class="form-label">Artista</label>
                                    <select name="artista_id" id="artista_id" class="form-control">
                                        <option value="">Seleccione un artista</option>
                                        @foreach($artistas as $artista)
                                            <option value="{{ $artista->id }}"
                                                {{ (string) old('artista_id', $registro->artista_id ?? '') === (string) $artista->id ? 'selected' : '' }}>
                                                {{ $artista->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('artista_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="anio_lanzamiento" class="form-label">Año de lanzamiento</label>
                                    <input type="number" min="1900" max="2100" class="form-control @error('anio_lanzamiento') is-invalid @enderror"
                                        id="anio_lanzamiento" name="anio_lanzamiento"
                                        value="{{ old('anio_lanzamiento', $registro->anio_lanzamiento ?? '') }}">
                                    @error('anio_lanzamiento')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Descripción -->
                                <div class="col-md-6 mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea name="descripcion" class="form-control" id="descripcion" rows="4">{{ old('descripcion', $registro->descripcion ?? '') }}</textarea>
                                    @error('descripcion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="lista_canciones" class="form-label">Lista de canciones (una por linea)</label>
                                    <textarea name="lista_canciones" class="form-control" id="lista_canciones" rows="4">{{ old('lista_canciones', isset($registro) && is_array($registro->lista_canciones) ? implode(PHP_EOL, $registro->lista_canciones) : '') }}</textarea>
                                    @error('lista_canciones')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Imagen -->
                                <div class="col-md-3 mb-3">
                                    <label for="imagen" class="form-label">Imagen</label>
                                    <input type="file" class="form-control @error('imagen') is-invalid @enderror"
                                        id="imagen" name="imagen">
                                    @error('imagen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                    @if(isset($registro) && $registro->imagen)
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/productos/' . $registro->imagen) }}"
                                                alt="Imagen actual" style="max-width: 150px; height: auto; border-radius: 8px;">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2"
                                    onclick="window.location.href='{{ route('productos.index') }}'">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('itemProducto').classList.add('active');
    document.getElementById('mnuCatalogo')?.classList.add('menu-open');
    document.getElementById('mnuCatalogoLink')?.classList.add('active');
</script>
@endpush
