@props([
    'title' => '',
    'actions' => null,
    'search' => false,
    'searchPlaceholder' => 'Ingrese texto a buscar',
    'tableHead' => [],
    'tableBody' => null
])
<div class="card" style="border-radius:1.1rem; background:#181f2a; border:1px solid #232a3b; box-shadow:0 8px 32px rgba(0,0,0,.18);">
    <div class="card-header pb-0" style="background:transparent; border-bottom:none; padding:1.3rem 1.7rem 0.7rem 1.7rem; display:flex; align-items:center; justify-content:space-between;">
        <div style="font-size:1.2rem; font-weight:700; color:#fff; display:flex; align-items:center; gap:.5rem;">
            <i class="fas fa-clock"></i> {{ $title }}
        </div>
        @if($actions)
            <div>{{ $actions }}</div>
        @endif
    </div>
    <div class="card-body p-0" style="padding:0 1.7rem 1.7rem 1.7rem;">
        @if($search)
        <form method="get" class="mb-3">
            <input type="text" name="buscar" class="form-control" style="background:#232a3b;color:#fff;border:1px solid #313a4d;min-width:260px;border-radius:.7rem;padding:1rem 1.2rem;box-shadow:none;" placeholder="{{ $searchPlaceholder }}">
            <button type="submit" class="btn btn-secondary">Buscar</button>
        </form>
        @endif
        <div class="table-responsive">
            <table class="table table-hover mb-0" style="font-size:1rem; background:transparent; color:#fff;">
                <thead>
                    <tr>
                        @foreach($tableHead as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{ $tableBody }}
                </tbody>
            </table>
        </div>
    </div>
</div>
