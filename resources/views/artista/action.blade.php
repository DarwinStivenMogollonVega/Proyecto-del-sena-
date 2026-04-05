@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-0" style="border-radius:1rem;">
                    <div class="card-header" style="background:transparent; border-bottom:1px">
                        <h3 class="card-title">{{ isset($registro) ? 'Editar artista' : 'Crear artista' }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($registro) ? route('artistas.update', $registro->getKey()) : route('artistas.store') }}" method="POST" enctype="multipart/form-data" id="formArtista" novalidate>
                            @csrf
                            @if(isset($registro))
                                @method('PUT')
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <strong>Corrige los siguientes errores:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $registro->nombre ?? '') }}" minlength="3" maxlength="120" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s\-\.]+$" required oninput="this.value = this.value.replace(/[0-9]/g, '')" title="El nombre no puede contener números">
                                    @error('nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fotografía</label>
                                    <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,.webp,image/*" class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @if(isset($registro) && $registro->foto)
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/artistas/' . $registro->foto) }}" alt="{{ $registro->nombre }}" style="max-width:120px;border-radius:8px;">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Biografía</label>
                                <textarea id="biografia" name="biografia" rows="6" maxlength="5000" class="form-control @error('biografia') is-invalid @enderror">{{ old('biografia', $registro->biografia ?? '') }}</textarea>
                                @error('biografia')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Identificador único (opcional)</label>
                                <input type="text" id="identificador_unico" name="identificador_unico" maxlength="140" pattern="^[a-zA-Z0-9\-_]+$" class="form-control @error('identificador_unico') is-invalid @enderror" value="{{ old('identificador_unico', $registro->identificador_unico ?? '') }}" placeholder="ej: abc123-xyz">
                                <small id="identificadorHelp" class="form-text text-muted">Si no lo rellena se generará automáticamente.</small>
                                <div id="identificadorFeedback" class="mt-1"></div>
                                @error('identificador_unico')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('artistas.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('itemArtista')?.classList.add('active');
    document.getElementById('mnuFormato')?.classList.add('menu-open');
    document.getElementById('mnuFormatoLink')?.classList.add('active');
    
    // Client-side validation for identificador_unico
    (function(){
        const input = document.getElementById('identificador_unico');
        const nombreInput = document.getElementById('nombre');
        const fotoInput = document.getElementById('foto');
        const form = document.getElementById('formArtista');
        const feedback = document.getElementById('identificadorFeedback');
        const submitBtn = form ? form.querySelector('button[type="submit"]') : null;

        function setInvalid(msg){
            feedback.innerHTML = '<small class="text-danger">'+msg+'</small>';
            if(submitBtn) submitBtn.disabled = true;
        }
        function setValid(msg){
            feedback.innerHTML = '<small class="text-success">'+msg+'</small>';
            if(submitBtn) submitBtn.disabled = false;
        }

        if(!input) return;

        if (form) {
            form.addEventListener('submit', function(event){
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.querySelectorAll('input, textarea').forEach((field) => {
                        if (!field.checkValidity()) field.classList.add('is-invalid');
                    });
                }
            });
        }

        nombreInput?.addEventListener('input', function(){
            this.classList.toggle('is-invalid', !this.checkValidity());
        });

        fotoInput?.addEventListener('change', function(){
            const file = this.files && this.files[0];
            if (!file) {
                this.classList.remove('is-invalid');
                return;
            }
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowed.includes(file.type) || file.size > 2 * 1024 * 1024) {
                this.classList.add('is-invalid');
                return;
            }
            this.classList.remove('is-invalid');
        });

        // basic format check
        input.addEventListener('input', function(){
            const v = input.value.trim();
            input.classList.remove('is-invalid');
            if(v === ''){ setValid('Se generará automáticamente si se deja vacío.'); return; }
            // allow letters, numbers, hyphens and underscores
            if(!/^[a-zA-Z0-9-_]+$/.test(v)){
                input.classList.add('is-invalid');
                setInvalid('Sólo se permiten letras, números, guiones y guiones bajos.');
                return;
            }
            if(v.length > 140){
                input.classList.add('is-invalid');
                setInvalid('Máximo 140 caracteres.');
                return;
            }
            // tentative valid until server confirms uniqueness
            setValid('Formato correcto — comprobando disponibilidad...');
        });

        // on blur: check uniqueness via AJAX
        input.addEventListener('blur', function(){
            const v = input.value.trim();
            if(v === ''){ setValid('Se generará automáticamente si se deja vacío.'); return; }
            if(!/^[a-zA-Z0-9-_]+$/.test(v)) return; // already handled

            const payload = new URLSearchParams();
            payload.append('identificador_unico', v);
            // include current id to ignore when editing
            const urlParts = location.pathname.split('/');
            const possibleId = urlParts[urlParts.length-1];
            if(!isNaN(parseInt(possibleId))){ payload.append('ignore_id', possibleId); }

            fetch('{{ route('artistas.checkIdentifier') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: payload.toString()
            }).then(r=>r.json()).then(data=>{
                if(data && data.unique){
                    setValid('Identificador disponible.');
                } else {
                    setInvalid('Identificador ya existe. Elija otro.');
                }
            }).catch(err=>{
                // do not block submit on network errors, just warn
                feedback.innerHTML = '<small class="text-warning">No se pudo comprobar disponibilidad (error de red).</small>';
            });
        });
    })();
</script>
@endpush
