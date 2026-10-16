@extends('main')
@section('titulo', 'Formulário de Alunos')
@section('conteudo')
    <div class="row">
        @php
            if (!empty($data->id)) {
                $action = route('aluno.update', $data->id);
            } else {
                $action = route('aluno.store');
            }
        @endphp

        <h4>{{ !empty($data->id) ? 'Editar aluno' : 'Novo aluno' }}</h4>
        @if ($planos->isEmpty())
            <div class="alert alert-warning">
                Cadastre um plano antes de salvar um aluno.
                <a href="{{ route('plano.create') }}">Cadastrar plano</a>
            </div>
        @endif
        <form action="{{ $action }}" method="post" enctype="multipart/form-data">
            @csrf
            @if (!empty($data->id))
                @method('PUT')
            @endif

            <input type="hidden" name="id" value="{{ old('id', $data->id ?? '') }}">
            <div class="col-6">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" maxlength="150" required class="form-control"
                    value="{{ old('nome', $data->nome ?? '') }}">
            </div>
            <div class="col-6">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" maxlength="16" required class="form-control"
                    value="{{ old('cpf', $data->cpf ?? '') }}">
            </div>
            <div class="col-6">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" maxlength="20" class="form-control"
                    value="{{ old('telefone', $data->telefone ?? '') }}">
            </div>
            <div class="col-6">
                <label for="categoria_id">Categoria</label>
                <select name="categoria_id" id="categoria_id" class="form-select" required>
                    <option value="">Selecione uma categoria</option>
                    @foreach ($categorias as $item)
                        <option value="{{ $item->id }}"
                            {{ old('categoria_id', $data->categoria_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->nome }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="col-6">
                <label for="plano_id">Plano</label>
                <select name="plano_id" id="plano_id" class="form-select" required>
                    <option value="">Selecione um plano</option>
                    @foreach ($planos as $plano)
                        <option value="{{ $plano->id }}"
                            {{ old('plano_id', $data->plano_id ?? '') == $plano->id ? 'selected' : '' }}>
                            {{ $plano->nome }} - R$ {{ number_format((float) $plano->valor, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label for="imagem">Imagem</label>
                @if (!empty($data->imagem))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $data->imagem) }}" class="rounded-circle" width="160"
                            height="160" style="object-fit: cover" alt="Foto atual de {{ $data->nome }}">
                    </div>
                @endif
                <input type="file" id="imagem" name="imagem" accept=".jpg,.jpeg,.png" class="form-control">
                <small>JPG/PNG, até 2 MB. Deixe vazio para manter a foto atual.</small>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-success" {{ $planos->isEmpty() ? 'disabled' : '' }}>Salvar</button>
                <a href="{{ url('aluno') }}" class="btn btn-primary"> Voltar</a>
            </div>
        </form>
    </div>
@stop
