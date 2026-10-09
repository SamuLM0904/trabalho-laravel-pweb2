@extends('main')
@section('titulo', 'Listagem de Modalidades')
@section('conteudo')
    <div class="row">
        <h3>Listagem de Modalidades</h3>
        <form action="{{ route('modalidade.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="nome_modalidade">Nome da Modalidade</option>
                        <option value="descricao">Descrição</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end mt-2 mt-md-0">
                    <button type="submit" class="btn btn-primary me-2">Buscar</button>
                    <a href="{{ url('modalidade/create') }}" class="btn btn-success">Novo</a>
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
                        <th scope="col">Nome da Modalidade</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Valor Mensal (R$)</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados as $item)
                        <tr>
                            <th scope='row'>{{ $item->id }}</th>
                            <td>{{ $item->nome_modalidade }}</td>
                            <td>{{ $item->descricao }}</td>
                            <td>{{ $item->data_fim}}
                            <td>R$ {{ number_format($item->valor_mensal, 2, ',', '.') }}</td>
                            <td>
                                <a class='btn btn-warning btn-sm' title='Editar' href="{{ route('modalidade.edit', $item->id) }}">Editar</a>
                            </td>
                            <td>
                                <form action="{{ route('modalidade.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class='btn btn-danger btn-sm' title='Excluir'
                                        onclick="return confirm('Deseja Excluir?')">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
