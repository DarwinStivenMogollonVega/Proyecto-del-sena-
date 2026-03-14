<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h1 { margin: 0 0 8px 0; font-size: 20px; }
        .meta { margin-bottom: 16px; color: #4b5563; }
        .summary { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .summary td { border: 1px solid #e5e7eb; padding: 8px; }
        .summary .label { background: #f8fafc; font-weight: bold; width: 35%; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 7px; text-align: left; }
        th { background: #f1f5f9; }
    </style>
</head>
<body>
    <h1>{{ $titulo }}</h1>
    <div class="meta">
        {{ $descripcion }}<br>
        Generado: {{ now()->format('d/m/Y H:i:s') }}
    </div>

    <table class="summary">
        @foreach($summary as $item)
        <tr>
            <td class="label">{{ $item['label'] }}</td>
            <td>{{ $item['value'] }}</td>
        </tr>
        @endforeach
    </table>

    <table>
        <thead>
            <tr>
                @foreach($headings as $heading)
                <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
            <tr>
                @foreach($row as $value)
                <td>{{ $value }}</td>
                @endforeach
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($headings) }}">Sin datos disponibles.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
