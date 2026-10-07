@extends('main')
@section('titulo', 'Formulário de Matricula')
@section('conteudo')
    <div class="row">
        @php
            if (!empty($data->id)) {
                $action = route('matricula.update', $data->id);
            } else {
                $action = route('matricula.store');
            }
        @endphp

        <h4>Formulário Aluno</h4>
        <form action="{{ $action }}" method="post" enctype="multipart/form-data">
            @csrf
            @if (!empty($data->id))
                @method('PUT')
            @endif

            <input type="hidden" name="id" value="{{ old('id', $data->id ?? '') }}">
            <div class="col-6">
                <label for="numero">Número</label>
                <input type="text" name="numero" class="form-control"
                    value="{{ old('numero', $data->numero ?? '') }}">
            </div>

            <div class="col-6">
                <label for="curso_id">Curso</label>
                <select name="curso_id" class="form-select">
                    @foreach ($cursos as $item)
                        <option value="{{ $item->id }}"
                            {{ old('curso_id', $data->curso_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->nome }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-6">
                <label for="turma_id">Turma</label>
                <select name="turma_id" class="form-select">
                    @foreach ($turmas as $item)
                        <option value="{{ $item->id }}"
                            {{ old('turma_id', $data->turma_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6">
                <label for="aluno_id">Aluno</label>
                <select name="aluno_id" class="form-select">
                    @foreach ($alunos as $item)
                        <option value="{{ $item->id }}"
                            {{ old('curso_id', $data->curso_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6">
                <label for="data_matricula">Data Matricula</label>
                <input type="date" name="data_matricula" class="form-control"
                    value="{{ old('data_matricula', $data->data_matricula ?? '') }}">
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ url('matricula') }}" class="btn btn-primary"> Voltar</a>
            </div>
        </form>
    </div>
@stop
