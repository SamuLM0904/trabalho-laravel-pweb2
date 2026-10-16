@extends('main')
@section('titulo', 'Formulário de Avaliação Física')
@section('conteudo')
    <div class="row">
        @php
            $editando = !empty($data->id);
            $action = $editando ? route('avaliacao.update', $data->id) : route('avaliacao.store');
        @endphp

        <h4>{{ $editando ? 'Editar avaliação física' : 'Nova avaliação física' }}</h4>
        @if ($alunos->isEmpty() && !$editando)
            <div class="alert alert-warning">
                Cadastre um aluno antes de criar uma avaliação.
                <a href="{{ route('aluno.create') }}">Cadastrar aluno</a>
            </div>
        @endif
        <form action="{{ $action }}" method="post">
            @csrf
            @if ($editando)
                @method('PUT')
            @endif

            <div class="col-6 mb-3">
                <label for="aluno_id" class="form-label">Aluno</label>
                <select id="aluno_id" name="aluno_id" class="form-select" required>
                    <option value="">Selecione um aluno</option>
                    @foreach ($alunos as $aluno)
                        <option value="{{ $aluno->id }}"
                            {{ old('aluno_id', $data->aluno_id ?? request('aluno_id', '')) == $aluno->id ? 'selected' : '' }}>
                            {{ $aluno->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 mb-3">
                <label for="data_avaliacao" class="form-label">Data da avaliação</label>
                <input type="date" id="data_avaliacao" name="data_avaliacao" required class="form-control"
                    value="{{ old('data_avaliacao', isset($data) ? $data->data_avaliacao->format('Y-m-d') : date('Y-m-d')) }}">
            </div>
            <div class="col-6 mb-3">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" id="peso" name="peso" min="0.01" max="500" step="0.01" required
                    class="form-control" value="{{ old('peso', $data->peso ?? '') }}">
            </div>
            <div class="col-6 mb-3">
                <label for="altura" class="form-label">Altura (m)</label>
                <input type="number" id="altura" name="altura" min="0.5" max="3" step="0.01" required
                    class="form-control" value="{{ old('altura', $data->altura ?? '') }}">
            </div>
            <div class="col-6 mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea id="observacoes" name="observacoes" rows="4" class="form-control">{{ old('observacoes', $data->observacoes ?? '') }}</textarea>
            </div>
            <p>O IMC será calculado automaticamente ao salvar.</p>

            <div class="mt-2">
                <button type="submit" class="btn btn-success" {{ $alunos->isEmpty() && !$editando ? 'disabled' : '' }}>Salvar</button>
                <a href="{{ route('avaliacao.index') }}" class="btn btn-primary">Voltar</a>
            </div>
        </form>
    </div>
@stop
