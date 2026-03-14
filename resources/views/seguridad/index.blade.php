@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Roles y permisos</h3></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Rol</th>
                                        <th>Permisos</th>
                                        <th>Usuarios</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $rol)
                                        <tr>
                                            <td>{{ $rol->name }}</td>
                                            <td>{{ $rol->permissions_count }}</td>
                                            <td>{{ $rol->users_count }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3">Sin roles registrados.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h3 class="card-title">Administradores</h3></div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse($usuariosAdmin as $admin)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $admin->name }} ({{ $admin->email }})</span>
                                    <span class="badge {{ $admin->activo ? 'bg-success' : 'bg-secondary' }}">{{ $admin->activo ? 'Activo' : 'Inactivo' }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">No hay administradores.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Registro de actividad admin</h3></div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Metodo</th>
                                        <th>Ruta</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $log->user->name ?? 'N/A' }}</td>
                                            <td>{{ $log->method }}</td>
                                            <td>{{ $log->route_name ?? '-' }}</td>
                                            <td>{{ $log->ip_address }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5">Sin actividad registrada.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('mnuSeguridadPanel')?.classList.add('active');
    document.getElementById('mnuSeguridad')?.classList.add('menu-open');
    document.getElementById('mnuSeguridadLink')?.classList.add('active');
</script>
@endpush
