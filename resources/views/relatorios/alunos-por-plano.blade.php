<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Relatório de alunos ativos por plano</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        p { color: #555; margin-top: 0; }
        h2 { font-size: 14px; margin: 18px 0 6px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Alunos ativos por plano</h1>
    <p>Emitido em {{ $data }}</p>

    @forelse ($dados->groupBy('plano') as $plano => $alunos)
        <h2>{{ $plano }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Modalidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alunos as $aluno)
                    <tr>
                        <td>{{ $aluno['nome'] }}</td>
                        <td>{{ $aluno['cpf'] }}</td>
                        <td>{{ $aluno['telefone'] }}</td>
                        <td>{{ $aluno['modalidade'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p>Nenhum aluno ativo cadastrado.</p>
    @endforelse
</body>
</html>
