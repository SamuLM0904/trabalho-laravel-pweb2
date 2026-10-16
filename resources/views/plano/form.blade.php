@extends('main')
@section('titulo', 'Formulário de Planos')
@section('conteudo')
    <div class="row">
        @php
            $editando = !empty($data->id);
            $action = $editando ? route('plano.update', $data->id) : route('plano.store');
        @endphp

        <h4>{{ $editando ? 'Editar plano' : 'Novo plano' }}</h4>
        <form action="{{ $action }}" method="post">
            @csrf
            @if ($editando)
                @method('PUT')
            @endif

            <div class="col-6 mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" maxlength="100" required class="form-control"
                    value="{{ old('nome', $data->nome ?? '') }}">
            </div>
            <div class="col-6 mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" id="valor" name="valor" min="0" step="0.01" required class="form-control"
                    value="{{ old('valor', $data->valor ?? '') }}">
            </div>
            <div class="col-6 mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" rows="4" class="form-control">{{ old('descricao', $data->descricao ?? '') }}</textarea>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('plano.index') }}" class="btn btn-primary">Voltar</a>
            </div>
        </form>
    </div>
@stop
