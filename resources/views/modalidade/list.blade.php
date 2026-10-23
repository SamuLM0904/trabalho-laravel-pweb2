@extends('main')
@section('titulo', 'Listagem de Modalidades')
@section('conteudo')
    <div class="row">
        <h3>Listagem de Modalidades</h3>
        <form action="{{ route('modalidade.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-5">
                    <label for="valor">Nome da modalidade</label>
                    <input type="text" id="valor" name="valor" value="{{ old('valor', request('valor')) }}"
                        placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-7 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ route('modalidade.index') }}" class="btn btn-secondary">Limpar</a>
                    <a href="{{ route('modalidade.create') }}" class="btn btn-success">Nova modalidade</a>
                    <a href="{{ route('modalidade.report') }}" class="btn btn-danger">Relatório PDF</a>
                </div>
            </div>
        </form>
    </div>

    <div class="row mt-4">
        <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dados as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>
                            @if ($item->imagem)
                                <img src="{{ asset('storage/' . $item->imagem) }}" alt="Imagem de {{ $item->nome }}"
                                    width="80" height="60" style="object-fit: cover">
                            @else
                                Sem imagem
                            @endif
                        </td>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->descricao }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-warning" href="{{ route('modalidade.edit', $item->id) }}">Editar</a>
                            <form action="{{ route('modalidade.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Deseja excluir esta modalidade?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma modalidade encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
@stop
