@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-0" style="border-radius:1rem;">
                    <div class="card-header" style="background:transparent; border-bottom:1px ">
                        <h3 class="card-title">Productos</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ isset($registro) ? route('productos.update', $registro->getKey()) : route('productos.store') }}" method="POST" enctype="multipart/form-data" id="formProducto" novalidate>
                            @csrf
                            @if(isset($registro))
                                @method('PUT')
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <strong>Corrige los siguientes errores:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <!-- Código -->
                                <div class="col-md-3 mb-3">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                        id="codigo" name="codigo"
                                        value="{{ old('codigo', $registro->codigo ?? '') }}" maxlength="16" required pattern="[A-Za-z0-9_-]+" oninput="this.value = this.value.replace(/[^A-Za-z0-9_-]/g, '')" title="El código solo puede contener letras, números, guiones y guiones bajos">
                                    @error('codigo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-3 mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                        id="nombre" name="nombre"
                                        value="{{ old('nombre', $registro->nombre ?? '') }}" minlength="3" maxlength="100" required pattern="^[^0-9]+$" oninput="this.value = this.value.replace(/[0-9]/g, '')" title="El nombre no puede contener números">
                                    @error('nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Precio -->
                                <div class="col-md-3 mb-3">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" step="0.01" min="0" inputmode="decimal" class="form-control @error('precio') is-invalid @enderror"
                                        id="precio" name="precio"
                                        value="{{ old('precio', $registro->precio ?? '') }}" required>
                                    @error('precio')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Descuento (porcentaje) -->
                                <div class="col-md-3 mb-3">
                                    <label for="descuento" class="form-label">Descuento (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" inputmode="decimal" class="form-control @error('descuento') is-invalid @enderror"
                                        id="descuento" name="descuento"
                                        value="{{ old('descuento', $registro->descuento ?? 0) }}" placeholder="0 - 100">
                                    @error('descuento')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              <!--cantidad -->
                                <div class="col-md-3 mb-3">
                                    <label for="cantidad" class="form-label">Cantidad</label>
                                    <input type="number" min="0" step="1" inputmode="numeric" class="form-control @error('cantidad') is-invalid @enderror"
                                        id="cantidad" name="cantidad"
                                        value="{{ old('cantidad', $registro->cantidad ?? '') }}" required>
                                    @error('cantidad')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Categoría -->
                                <div class="col-md-3 mb-3">
                                    <label for="categoria_id" class="form-label">Categoría</label>
                                    <select name="categoria_id" id="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                                        <option value="">Seleccione una categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->getKey() }}"
                                                {{ (string) old('categoria_id', $registro->categoria_id ?? '') === (string) $categoria->getKey() ? 'selected' : '' }}>
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
                                <!-- Formato (antes Catálogo) -->
                                <div class="col-md-3 mb-3">
                                    <label for="formato_id" class="form-label">Formato</label>
                                    <select name="formato_id" id="formato_id" class="form-control @error('formato_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un formato</option>
                                        @foreach($formatos as $formato)
                                            <option value="{{ $formato->getKey() }}"
                                                {{ (string) old('formato_id', $registro->formato_id ?? '') === (string) $formato->getKey() ? 'selected' : '' }}>
                                                {{ $formato->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('formato_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="proveedor_id" class="form-label">Proveedor</label>
                                    <select name="proveedor_id" id="proveedor_id" class="form-control @error('proveedor_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->getKey() }}"
                                                {{ (string) old('proveedor_id', $registro->proveedor_id ?? '') === (string) $proveedor->getKey() ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="album_id" class="form-label">Álbum</label>
                                    <select name="album_id" id="album_id" class="form-control @error('album_id') is-invalid @enderror">
                                        <option value="">Sin álbum</option>
                                        @foreach($albums as $album)
                                            <option value="{{ $album->getKey() }}"
                                                {{ (string) old('album_id', $registro->album_id ?? '') === (string) $album->getKey() ? 'selected' : '' }}>
                                                {{ $album->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('album_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="artista_id" class="form-label">Artista</label>
                                    <select name="artista_id" id="artista_id" class="form-control @error('artista_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un artista</option>
                                        @foreach($artistas as $artista)
                                            <option value="{{ $artista->getKey() }}"
                                                {{ (string) old('artista_id', $registro->artista_id ?? '') === (string) $artista->getKey() ? 'selected' : '' }}>
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
                                    <input type="number" min="1900" max="2100" step="1" inputmode="numeric" class="form-control @error('anio_lanzamiento') is-invalid @enderror"
                                        id="anio_lanzamiento" name="anio_lanzamiento"
                                        value="{{ old('anio_lanzamiento', $registro->anio_lanzamiento ?? '') }}">
                                    @error('anio_lanzamiento')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Descripción -->
                                <div class="col-md-6 mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" rows="4" maxlength="1000">{{ old('descripcion', $registro->descripcion ?? '') }}</textarea>
                                    @error('descripcion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="lista_canciones" class="form-label">Lista de canciones (una por linea)</label>
                                    <textarea name="lista_canciones" class="form-control @error('lista_canciones') is-invalid @enderror" id="lista_canciones" rows="4" maxlength="5000">{{ old('lista_canciones', isset($registro) && is_array($registro->lista_canciones) ? implode(PHP_EOL, $registro->lista_canciones) : '') }}</textarea>
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
    
    // Inline modal for creating an artista from product form
    (function(){
        const formProducto = document.getElementById('formProducto');
        if (formProducto) {
            const precioInput = document.getElementById('precio');
            const cantidadInput = document.getElementById('cantidad');
            const anioInput = document.getElementById('anio_lanzamiento');

            // Evita letras y símbolos no permitidos en campos numéricos.
            const normalizeNumberInput = (input, allowDecimal = false) => {
                if (!input) return;
                input.addEventListener('input', () => {
                    const regex = allowDecimal ? /[^0-9.]/g : /[^0-9]/g;
                    let value = input.value.replace(regex, '');
                    if (allowDecimal) {
                        const parts = value.split('.');
                        if (parts.length > 2) {
                            value = parts.shift() + '.' + parts.join('');
                        }
                    }
                    input.value = value;
                });
                input.addEventListener('keydown', (event) => {
                    if (['e', 'E', '+', '-'].includes(event.key)) {
                        event.preventDefault();
                    }
                });
            };

            normalizeNumberInput(precioInput, true);
            normalizeNumberInput(cantidadInput, false);
            normalizeNumberInput(anioInput, false);

            formProducto.addEventListener('submit', function (event) {
                if (!formProducto.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    formProducto.querySelectorAll('input, select, textarea').forEach((field) => {
                        if (!field.checkValidity()) field.classList.add('is-invalid');
                    });
                }
            });

            formProducto.querySelectorAll('input, select, textarea').forEach((field) => {
                field.addEventListener('input', () => {
                    if (field.checkValidity()) {
                        field.classList.remove('is-invalid');
                    }
                });
                field.addEventListener('change', () => {
                    if (field.checkValidity()) {
                        field.classList.remove('is-invalid');
                    }
                });
            });
        }

        const btn = document.getElementById('btnNuevoArtista');
        if(!btn) return;

        // Create modal HTML
                const modalHtml = `
                <div class="modal" id="modalNuevoArtista" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Nuevo artista</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                            <div class="modal-body">
                                <div class="mb-2"><label class="form-label">Nombre</label><input id="modal_artista_nombre" class="form-control" name="nombre" oninput="this.value = this.value.replace(/[0-9]/g, '')"></div>
                                <div class="mb-2"><label class="form-label">Identificador único (opcional)</label><input id="modal_artista_identificador" class="form-control" name="identificador_unico"></div>
                                <div class="mb-2"><label class="form-label">Fotografía (opcional)</label><input id="modal_artista_foto" type="file" accept="image/*" class="form-control" name="foto"></div>
                                <div id="modal_artista_preview" class="mt-2"></div>
                                <div id="modal_artista_feedback" class="mt-1"></div>
                            </div>
                            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button id="modal_artista_guardar" type="button" class="btn btn-primary">Guardar</button></div>
                        </div>
                    </div>
                </div>`;

        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const modalEl = document.getElementById('modalNuevoArtista');
        const bsModal = new bootstrap.Modal(modalEl);
        const inputNombre = document.getElementById('modal_artista_nombre');
        const inputIdent = document.getElementById('modal_artista_identificador');
        const inputFoto = document.getElementById('modal_artista_foto');
        const preview = document.getElementById('modal_artista_preview');
        const feedback = document.getElementById('modal_artista_feedback');
        const btnGuardar = document.getElementById('modal_artista_guardar');

        btn.addEventListener('click', ()=>{
            inputNombre.value = '';
            inputIdent.value = '';
            feedback.innerHTML = '';
            bsModal.show();
        });

        // Check identifier uniqueness on blur
        inputIdent?.addEventListener('blur', function(){
            const v = inputIdent.value.trim();
            if(!v) return;
            fetch('{{ route('artistas.checkIdentifier') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ identificador_unico: v })
            }).then(r=>r.json()).then(data=>{
                if(data.unique) feedback.innerHTML = '<small class="text-success">Identificador disponible</small>';
                else feedback.innerHTML = '<small class="text-danger">Identificador ya existe</small>';
            }).catch(()=>{ feedback.innerHTML = '<small class="text-warning">No se pudo comprobar existencia</small>'; });
        });

        // Foto preview
        inputFoto?.addEventListener('change', function(){
            preview.innerHTML = '';
            const f = inputFoto.files && inputFoto.files[0];
            if(!f) return;
            if(!f.type.startsWith('image/')){ preview.innerHTML = '<small class="text-danger">Archivo no válido</small>'; return; }
            const img = document.createElement('img');
            img.style.maxWidth = '120px';
            img.style.borderRadius = '8px';
            img.style.display = 'block';
            img.style.marginTop = '6px';
            img.src = URL.createObjectURL(f);
            preview.appendChild(img);
        });

        btnGuardar.addEventListener('click', function(){
            const nombre = inputNombre.value.trim();
            const ident = inputIdent.value.trim();
            if(!nombre){ feedback.innerHTML = '<small class="text-danger">El nombre es obligatorio</small>'; return; }

            const formData = new FormData();
            formData.append('nombre', nombre);
            if(ident) formData.append('identificador_unico', ident);
            // append foto if selected
            if(inputFoto && inputFoto.files && inputFoto.files[0]){
                formData.append('foto', inputFoto.files[0]);
            }
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}');

            fetch('{{ route('artistas.store') }}', {
                method: 'POST',
                body: formData,
            }).then(async r=>{
                if(r.status === 201){
                    const data = await r.json();
                    if(data.success && data.artista){
                        // append to select
                        const sel = document.getElementById('artista_id');
                        const opt = document.createElement('option');
                        opt.value = data.artista.id;
                        opt.text = data.artista.nombre;
                        sel.appendChild(opt);
                        sel.value = data.artista.id;
                        bsModal.hide();
                    }
                } else if(r.status === 422){
                    const err = await r.json();
                    feedback.innerHTML = '<small class="text-danger">'+(err.message || 'Error de validación')+'</small>';
                } else {
                    feedback.innerHTML = '<small class="text-danger">Error al crear artista</small>';
                }
            }).catch(()=>{ feedback.innerHTML = '<small class="text-danger">Error de red</small>'; });
        });
    })();
</script>
@endpush
