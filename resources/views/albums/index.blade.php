@extends('plantilla.app')

@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">formato</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">formato</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('albums.index') }}" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="formato" placeholder="formato">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <a href="{{ route('albums.create') }}" class="btn btn-sm btn-primary">formato</a>
            </div>
        </div>

        @if(Session::has('mensaje'))
            <div class="alert alert-info alert-dismissible fade show mt-2">
            formato
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="formato"></button>
        </div>
        @endif

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="min-width:700px">
                        <thead>
                            <tr>
                                <th style="width: 20px">formato</th>
                                <th>formato</th>
                                <th>formato</th>
                                <th style="width: 150px">formato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($albums as $album)
                                <tr>
                                    <td>formato</td>
                                    <td>formato</td>
                                    <td>formato</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('albums.edit', $album->getKey()) }}" class="btn btn-sm btn-outline-info" title="formato"><i class="bi bi-pencil"></i></a>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal-vincular-{{ $album->getKey() }}" title="formato"><i class="bi bi-link-45deg"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar-album-{{ $album->getKey() }}" title="formato"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox me-2"></i>formato
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @foreach($albums as $album)
            @include('albums.delete', ['reg' => $album])
            <!-- Modal vincular productos -->
            <div class="modal fade" id="modal-vincular-{{ $album->getKey() }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">formato</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="formato"></button>
                        </div>
                        <form action="{{ route('albums.vincular_productos', $album->getKey()) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <p class="small text-muted">formato</p>
                                <div class="mb-2">
                                    <select name="product_ids[]" id="product_ids_{{ $album->getKey() }}" class="form-control" multiple size="10">
                                        @foreach($productos as $p)
                                            <option value="{{ $p->getKey() }}" {{ $p->album_id == $album->album_id ? 'selected' : '' }}>formato</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">formato</button>
                                <button type="submit" class="btn btn-primary">formato</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('mnuFormato')?.classList.add('menu-open');
    document.getElementById('mnuFormatoLink')?.classList.add('active');
    document.getElementById('itemAlbum')?.classList.add('active');
</script>
<script>
    // Permite togglear opciones en <select multiple> sin necesidad de Ctrl
    document.addEventListener('mousedown', function(e){
        const el = e.target;
        if (el.tagName === 'OPTION' && el.parentElement && el.parentElement.multiple) {
            e.preventDefault();
            el.selected = !el.selected;
            el.parentElement.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });
</script>
@endpush
