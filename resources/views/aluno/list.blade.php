@extends('main')
@section('titulo', 'Listagem de Alunos')
@section('conteudo')
    <div class="row">

        <h3>Listagem de Alunos</h3>
        <form action="{{ route('aluno.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-2">
                    <label for="nome">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="nome" {{ old('tipo', request('tipo')) === 'nome' ? 'selected' : '' }}>Nome</option>
                        <option value="cpf" {{ old('tipo', request('tipo')) === 'cpf' ? 'selected' : '' }}>CPF</option>
                        <option value="telefone" {{ old('tipo', request('tipo')) === 'telefone' ? 'selected' : '' }}>Telefone</option>
                        <option value="plano" {{ old('tipo', request('tipo')) === 'plano' ? 'selected' : '' }}>Plano</option>
                    </select>
                </div>
                <div class="col-5">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" value="{{ old('valor', request('valor')) }}"
                        placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-5">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ url('aluno/create') }}" class="btn btn-success"> Novo</a>
                    <a href="{{ route('aluno.report') }}" class="btn btn-danger">Relatório PDF</a>
                    <a href="{{ route('avaliacao.index') }}" class="btn btn-warning">Avaliações</a>
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
                    <th scope="col">CPF</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Plano</th>
                    <th scope="col">Avaliação</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dados as $item)
                    <tr>
                        <th scope='row'>{{ $item->id }}</th>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->cpf }}</td>
                        <td>{{ $item->telefone }}</td>
                        <td>{{ $item->categoria->nome ?? 'Sem categoria' }}</td>
                        <td>{{ $item->plano->nome ?? 'Sem plano' }}</td>
                        <td>
                            @if ($item->avaliacaoFisica)
                                <a class="btn btn-info" href="{{ route('avaliacao.edit', $item->avaliacaoFisica->id) }}">Ver ficha</a>
                            @else
                                <a class="btn btn-outline-primary"
                                    href="{{ route('avaliacao.create', ['aluno_id' => $item->id]) }}">Nova ficha</a>
                            @endif
                        </td>
                        <td>
                            <a class='btn btn-warning' title='Editar' href="{{ route('aluno.edit', $item->id) }}">Editar</a>
                            <form action="{{ route('aluno.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class='btn btn-danger' title='Exclur'
                                    onclick="return confirm('Deseja excluir este aluno?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Nenhum aluno encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop
