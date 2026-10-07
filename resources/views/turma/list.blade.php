@extends('main')
@section('titulo', 'Listagem de Cursos')
@section('conteudo')
    <div class="row">

        <h3>Listagem de Turmas</h3>
        <h5>Curso: {{ $curso->nome }}</h5>
        <form action="{{ route('turma.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-2">
                    <label for="nome">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="nome">Nome</option>
                        <option value="cpf">CPF</option>
                        <option value="telefone">Telefone</option>
                    </select>
                </div>
                <div class="col-5">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-5">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ route('curso.turmas.create',$curso) }}" class="btn btn-success"> Novo</a>
                    <a href="{{ url('curso') }}" class="btn btn-secondary"> Voltar</a>
                </div>
            </div>
        </form>

    </div>


    <div class="row mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Código</th>
                    <th scope="col">Data Início</th>
                    <th scope="col">Data Fim</th>
                    <th scope="col">Ação</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dados as $item)
                    <tr>
                        <th scope='row'>{{ $item->id }}</th>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->data_inicio)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->data_fim)) }}</td>
                        <td>
                            <a class='btn btn-warning' title='Editar' href="{{ route('turma.edit', $item->id) }}">Editar</a>
                        </td>
                        <td>
                            <form action="{{ route('turma.destroy', $item->id) }}" method="post">
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
