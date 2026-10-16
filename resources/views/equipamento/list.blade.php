@extends('main')
@section('titulo', 'Listagem de Equipamentos')
@section('conteudo')
    <div class="row">
        <h3>Listagem de Equipamentos</h3>
        <form action="{{ route('equipamento.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-2">
                    <label for="tipo">Pesquisar por</label>
                    <select id="tipo" name="tipo" class="form-select">
                        <option value="nome" {{ old('tipo', request('tipo')) === 'nome' ? 'selected' : '' }}>Nome</option>
                        <option value="numero_serie" {{ old('tipo', request('tipo')) === 'numero_serie' ? 'selected' : '' }}>Número de série</option>
                        <option value="estado" {{ old('tipo', request('tipo')) === 'estado' ? 'selected' : '' }}>Estado</option>
                    </select>
                </div>
                <div class="col-4">
                    <label for="valor">Valor</label>
                    <input type="text" id="valor" name="valor" value="{{ old('valor', request('valor')) }}"
                        placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-6 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ route('equipamento.index') }}" class="btn btn-secondary">Limpar</a>
                    <a href="{{ route('equipamento.create') }}" class="btn btn-success">Novo equipamento</a>
                    <a href="{{ route('equipamento.report') }}" class="btn btn-danger">Relatório PDF</a>
                </div>
            </div>
        </form>
    </div>

    <div class="row mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Número de série</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dados as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>
                            @if ($item->imagem)
                                <img src="{{ asset('storage/' . $item->imagem) }}" alt="Foto de {{ $item->nome }}"
                                    width="80" height="60" style="object-fit: cover">
                            @else
                                Sem imagem
                            @endif
                        </td>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->numero_serie }}</td>
                        <td>{{ $item->estado }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-warning" href="{{ route('equipamento.edit', $item->id) }}">Editar</a>
                            <form action="{{ route('equipamento.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Deseja excluir este equipamento?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum equipamento encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop
