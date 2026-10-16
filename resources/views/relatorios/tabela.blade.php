<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-bottom: 4px; }
        p { color: #555; margin-top: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>

<body>
    <h2>{{ $titulo }}</h2>
    <p>Gerado em {{ $data }}</p>
    <table>
        <thead>
            <tr>
                @foreach ($colunas as $tituloColuna)
                    <th>{{ $tituloColuna }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($dados as $linha)
                <tr>
                    @foreach ($colunas as $campo => $tituloColuna)
                        <td>{{ $linha[$campo] ?? '' }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($colunas) }}">Nenhum registro cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
