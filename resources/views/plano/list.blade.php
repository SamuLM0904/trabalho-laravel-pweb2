@extends('main')
@section('titulo', 'Listagem de Planos')
@section('conteudo')
    <div class="row">
        <h3>Listagem de Planos</h3>
        <form action="{{ route('plano.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-5">
                    <label for="valor">Nome do plano</label>
                    <input type="text" id="valor" name="valor" value="{{ old('valor', request('valor')) }}"
                        placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-7 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ route('plano.index') }}" class="btn btn-secondary">Limpar</a>
                    <a href="{{ route('plano.create') }}" class="btn btn-success">Novo plano</a>
                    <a href="{{ route('plano.report') }}" class="btn btn-danger">Relatório PDF</a>
                </div>
            </div>
        </form>
    </div>

    <div class="row mt-4">
        <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dados as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->nome }}</td>
                        <td>R$ {{ number_format((float) $item->valor, 2, ',', '.') }}</td>
                        <td>{{ $item->descricao }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-warning" href="{{ route('plano.edit', $item->id) }}">Editar</a>
                            <form action="{{ route('plano.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Deseja excluir este plano?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhum plano encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
@stop
