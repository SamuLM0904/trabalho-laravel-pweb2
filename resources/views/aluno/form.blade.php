@extends('main')
@section('titulo', 'Formulário de Alunos')
@section('conteudo')
    @php
        $editando = !empty($data->id);
        $action = $editando ? route('aluno.update', $data->id) : route('aluno.store');
    @endphp

    <section class="form-page">
        <div class="mb-3">
            <h2 class="h3 mb-1">{{ $editando ? 'Editar aluno' : 'Novo aluno' }}</h2>
            <p class="text-body-secondary mb-0">Preencha os dados para manter o cadastro atualizado.</p>
        </div>

        @if ($planos->isEmpty() || $modalidades->isEmpty())
            <div class="alert alert-warning">
                Cadastre pelo menos um plano e uma modalidade antes de salvar um aluno.
                @if ($planos->isEmpty())
                    <a href="{{ route('plano.create') }}">Cadastrar plano</a>
                @endif
                @if ($modalidades->isEmpty())
                    <a href="{{ route('modalidade.create') }}">Cadastrar modalidade</a>
                @endif
            </div>
        @endif

        <div class="form-card">
            <form action="{{ $action }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($editando)
                    @method('PUT')
                @endif

                <div class="form-card-header">
                    <h3 class="h6 mb-0">Dados pessoais e plano</h3>
                </div>
                <div class="form-card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="nome" class="form-label">Nome completo</label>
                            <input type="text" id="nome" name="nome" maxlength="150" required class="form-control"
                                value="{{ old('nome', $data->nome ?? '') }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" id="cpf" name="cpf" maxlength="14" inputmode="numeric"
                                data-mask="cpf" placeholder="000.000.000-00" required class="form-control"
                                value="{{ old('cpf', $data->cpf ?? '') }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" id="telefone" name="telefone" maxlength="15" inputmode="numeric"
                                data-mask="telefone" placeholder="(00) 00000-0000" class="form-control"
                                value="{{ old('telefone', $data->telefone ?? '') }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" id="email" name="email" maxlength="255" required class="form-control"
                                value="{{ old('email', $data->email ?? '') }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="data_nascimento" class="form-label">Data de nascimento</label>
                            <input type="date" id="data_nascimento" name="data_nascimento" required class="form-control"
                                max="{{ date('Y-m-d') }}"
                                value="{{ old('data_nascimento', isset($data->data_nascimento) ? $data->data_nascimento->format('Y-m-d') : '') }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="ativo" class="form-label">Situação</label>
                            <select name="ativo" id="ativo" class="form-select" required>
                                <option value="1" {{ old('ativo', $data->ativo ?? 1) == 1 ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ old('ativo', $data->ativo ?? 1) == 0 ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="endereco" class="form-label">Endereço completo</label>
                            <input type="text" id="endereco" name="endereco" maxlength="255" required class="form-control"
                                value="{{ old('endereco', $data->endereco ?? '') }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="modalidade_id" class="form-label">Modalidade</label>
                            <select name="modalidade_id" id="modalidade_id" class="form-select" required>
                                <option value="">Selecione uma modalidade</option>
                                @foreach ($modalidades as $modalidade)
                                    <option value="{{ $modalidade->id }}"
                                        {{ old('modalidade_id', $data->modalidade_id ?? '') == $modalidade->id ? 'selected' : '' }}>
                                        {{ $modalidade->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="plano_id" class="form-label">Plano</label>
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
                        <div class="col-12">
                            <label for="imagem" class="form-label">Foto do aluno</label>
                            @if (!empty($data->imagem))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $data->imagem) }}" class="rounded-circle" width="96"
                                        height="96" style="object-fit: cover" alt="Foto atual de {{ $data->nome }}">
                                </div>
                            @endif
                            <input type="file" id="imagem" name="imagem" accept=".jpg,.jpeg,.png" class="form-control">
                            <div class="form-text">JPG ou PNG, até 5 MB. Ao editar, deixe vazio para manter a foto atual.</div>
                        </div>
                    </div>

                    <div class="form-card-actions">
                        <button type="submit" class="btn btn-primary"
                            {{ $planos->isEmpty() || $modalidades->isEmpty() ? 'disabled' : '' }}>Salvar cadastro</button>
                        <a href="{{ url('aluno') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
@stop
