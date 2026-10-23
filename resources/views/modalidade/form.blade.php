@extends('main')
@section('titulo', 'Formulário de Modalidades')
@section('conteudo')
    <div class="row">
        @php
            $editando = !empty($data->id);
            $action = $editando ? route('modalidade.update', $data->id) : route('modalidade.store');
        @endphp

        <h4>{{ $editando ? 'Editar modalidade' : 'Nova modalidade' }}</h4>
        <form action="{{ $action }}" method="post" enctype="multipart/form-data">
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
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" rows="4" class="form-control">{{ old('descricao', $data->descricao ?? '') }}</textarea>
            </div>
            <div class="col-6 mb-3">
                <label for="imagem" class="form-label">Foto ilustrativa (JPG/PNG, até 5 MB)</label>
                @if (!empty($data->imagem))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $data->imagem) }}" alt="Imagem atual de {{ $data->nome }}"
                            width="140">
                    </div>
                @endif
                <input type="file" id="imagem" name="imagem" accept=".jpg,.jpeg,.png" class="form-control">
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('modalidade.index') }}" class="btn btn-primary">Voltar</a>
            </div>
        </form>
    </div>
@stop
