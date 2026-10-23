@extends('main')
@section('titulo', 'Formulário de Equipamentos')
@section('conteudo')
    <div class="row">
        @php
            $editando = !empty($data->id);
            $action = $editando ? route('equipamento.update', $data->id) : route('equipamento.store');
        @endphp

        <h4>{{ $editando ? 'Editar equipamento' : 'Novo equipamento' }}</h4>
        <form action="{{ $action }}" method="post" enctype="multipart/form-data">
            @csrf
            @if ($editando)
                @method('PUT')
            @endif

            <div class="col-6 mb-3">
                <label for="nome" class="form-label">Nome do aparelho</label>
                <input type="text" id="nome" name="nome" maxlength="120" required class="form-control"
                    value="{{ old('nome', $data->nome ?? '') }}">
            </div>
            <div class="col-6 mb-3">
                <label for="numero_serie" class="form-label">Número de série</label>
                <input type="text" id="numero_serie" name="numero_serie" maxlength="100" required class="form-control"
                    value="{{ old('numero_serie', $data->numero_serie ?? '') }}">
            </div>
            <div class="col-6 mb-3">
                <label for="estado" class="form-label">Estado de conservação</label>
                <select id="estado" name="estado" class="form-select" required>
                    <option value="">Selecione</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado }}"
                            {{ old('estado', $data->estado ?? '') === $estado ? 'selected' : '' }}>{{ $estado }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 mb-3">
                <label for="imagem" class="form-label">Foto do equipamento (JPG/PNG, até 5 MB)</label>
                @if (!empty($data->imagem))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $data->imagem) }}" alt="Foto atual de {{ $data->nome }}"
                            width="140">
                    </div>
                @endif
                <input type="file" id="imagem" name="imagem" accept=".jpg,.jpeg,.png" class="form-control">
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('equipamento.index') }}" class="btn btn-primary">Voltar</a>
            </div>
        </form>
    </div>
@stop
