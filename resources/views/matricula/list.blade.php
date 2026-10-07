@extends('main')
@section('titulo', 'Listagem de Matriculas')
@section('conteudo')
    <div class="row">

        <h3>Listagem de Matriculas</h3>
        <form action="{{ route('matricula.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-2">
                    <label for="nome">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="curso">Curso</option>
                        <option value="turma">Turma</option>
                        <option value="aluno">Aluno</option>
                    </select>
                </div>
                <div class="col-5">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-5">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ url('matricula/create') }}" class="btn btn-success"> Novo</a>
                </div>
            </div>
        </form>

    </div>


    <div class="row mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Turma</th>
                    <th scope="col">Aluno</th>
                    <th scope="col">Data Matricula</th>
                    <th scope="col">Ação</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dados as $item)
                    <tr>
                        <th scope='row'>{{ $item->id }}</th>
                        <td>{{ $item->curso->nome }}</td>
                        <td>{{ $item->turma->nome }}</td>
                        <td>{{ $item->aluno->nome }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->data_matricula)) }}</td>
                        <td>
                            <a class='btn btn-warning' title='Editar'
                                href="{{ route('matricula.edit', $item->id) }}">Editar</a>
                        </td>
                        <td>
                            <form action="{{ route('matricula.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class='btn btn-danger' title='Exclur'
                                    onclick="return confirm('Deseja Excluir?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
