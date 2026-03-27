@extends('plantilla.app')

@push('estilos')
<!-- Badge styles moved to public/css/admin.css -->
@endpush

@section('contenido')
<div class="app-content py-3">
<div class="container-fluid">
	<div class="d-flex align-items-center justify-content-between mb-4">
		<h4 class="fw-bold mb-1" style="color:var(--adm-heading)">
			<i class="bi bi-list-check me-2" style="color:var(--adm-accent)"></i>Pedidos de usuarios
		</h4>
	</div>
	<div class="card dz-admin-table-card">
		<div class="card-header" style="background:transparent; border-bottom:1px solid #232a3b; padding:1.2rem 1.5rem 1rem 1.5rem;">
			<div class="fw-bold mb-2" style="color:#fff; font-size:1.1rem; letter-spacing:.01em;">
				<i class="bi bi-clock-history me-2" style="color:var(--adm-accent)"></i>Todos los Pedidos
			</div>
			<form method="get" class="d-flex align-items-center" style="gap:.5rem;">
				<input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control form-control-sm" style="max-width:220px; background:#232a3b;color:#fff;border:1px solid #3b4253;border-radius:.5rem;padding:.7rem 1rem;box-shadow:none;" placeholder="Ingrese texto a buscar">
				<button class="btn btn-sm btn-secondary" type="submit" style="border-radius:.4rem;padding:.5rem 1.1rem;"><i class="bi bi-search"></i></button>
				@can('pedido-create')
				<a href="{{ route('admin.pedidos') }}" class="btn btn-sm btn-primary" style="border-radius:.4rem;padding:.5rem 1.1rem;">Nuevo</a>
				@endcan
			</form>
		</div>
		<div class="card-body p-0" style="padding:0 1.5rem 1.5rem 1.5rem;">
			<div class="table-responsive">
				<table class="table table-hover mb-0" style="font-size:.95rem; background:transparent; color:#fff;">
					<thead>
						<tr>
							<th class="px-3">#</th>
							<th>Cliente</th>
							<th>Email</th>
							<th>Teléfono</th>
							<th>Dirección</th>
							<th>Total</th>
							<th>Estado</th>
							<th>Fecha</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						@forelse($pedidos as $pedido)
						<tr>
							<td class="px-3 fw-semibold">{{ $pedido->getKey() }}</td>
							<td>
								<div class="fw-semibold">{{ $pedido->user->name ?? $pedido->nombre ?? 'N/A' }}</div>
							</td>
							<td>{{ $pedido->email }}</td>
							<td>{{ $pedido->telefono }}</td>
							<td>{{ $pedido->direccion }}</td>
							<td class="fw-bold">${{ number_format($pedido->total, 2) }}</td>
							<td>
								<span class="badge badge-{{ $pedido->estado }} rounded-pill px-2 py-1" style="font-size:.85rem">
									{{ ucfirst($pedido->estado) }}
								</span>
							</td>
							<td style="color:var(--adm-muted)">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
							<td>
								<a href="#" class="btn btn-sm btn-outline-primary">Ver detalles</a>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="9" class="text-center py-4" style="color:var(--adm-muted)">
								<i class="bi bi-inbox me-2"></i>Sin pedidos registrados
							</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer bg-white border-0 py-3">
			<div class="d-flex justify-content-center">
				{{ $pedidos->links() }}
			</div>
		</div>
	</div>
</div>
</div>
@endsection