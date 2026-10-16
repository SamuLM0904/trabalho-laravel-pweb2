@extends('main')
@section('titulo', 'Avaliações Físicas')
@section('conteudo')
    <div class="row">
        <h3>Avaliações Físicas</h3>
        <form action="{{ route('avaliacao.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-5">
                    <label for="valor">Nome do aluno</label>
                    <input type="text" id="valor" name="valor" value="{{ old('valor', request('valor')) }}"
                        placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-7 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ route('avaliacao.index') }}" class="btn btn-secondary">Limpar</a>
                    <a href="{{ route('avaliacao.create') }}" class="btn btn-success">Nova avaliação</a>
                    <a href="{{ route('avaliacao.report') }}" class="btn btn-danger">Relatório PDF</a>
                </div>
            </div>
        </form>
    </div>

    <div class="row mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Aluno</th>
                    <th>Data</th>
                    <th>Peso (kg)</th>
                    <th>Altura (m)</th>
                    <th>IMC</th>
                    <th>Observações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dados as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->aluno->nome }}</td>
                        <td>{{ $item->data_avaliacao->format('d/m/Y') }}</td>
                        <td>{{ $item->peso }}</td>
                        <td>{{ $item->altura }}</td>
                        <td>{{ $item->imc }}</td>
                        <td>{{ $item->observacoes }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-warning" href="{{ route('avaliacao.edit', $item->id) }}">Editar</a>
                            <form action="{{ route('avaliacao.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Deseja excluir esta avaliação?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Nenhuma avaliação encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop
