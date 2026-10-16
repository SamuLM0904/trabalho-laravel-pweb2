<!DOCTYPE html>
<html>

<head>
    <title>{{ $titulo }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <div class="row">
        <h3>{{ $titulo }}</h3>

    </div>

    <div class="row mt-4">
        @foreach ($dados as $item)
            <h4>Curso: {{ $item->nome }}</h4>

            @if ($item->alunos->isEmpty())
                <p>Nenhum aluno matriculado neste curso.</p>
            @else
                <p>Total de Alunos Matriculanos neste curso {{ $item->alunos->count() }}</p>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Requisito</th>
                            <th scope="col">Carga Horária</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item->alunos as $aluno)
                            <tr>
                                <th scope='row'>{{ $aluno->id }}</th>
                                <td>{{ $aluno->nome }}</td>
                                <td>{{ $aluno->cpf }}</td>
                                <td>{{ $aluno->telefone }}</td>
                                <td>{{ $aluno->categoria->nome ?? ' - ' }}</td>
                                <td>{{ $dataMatricula ?? ' - ' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    </div>
</body>

</html>
