@extends('main')
@section('titulo', 'Listagem de Alunos')
@section('conteudo')
    <div class="row">

        <h3>Listagem de Alunos</h3>
        <form action="{{ route('aluno.search') }}" method="post">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-3 col-lg-2">
                    <label for="nome">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="nome" {{ old('tipo', request('tipo')) === 'nome' ? 'selected' : '' }}>Nome</option>
                        <option value="cpf" {{ old('tipo', request('tipo')) === 'cpf' ? 'selected' : '' }}>CPF</option>
                        <option value="telefone" {{ old('tipo', request('tipo')) === 'telefone' ? 'selected' : '' }}>Telefone</option>
                        <option value="email" {{ old('tipo', request('tipo')) === 'email' ? 'selected' : '' }}>E-mail</option>
                        <option value="plano" {{ old('tipo', request('tipo')) === 'plano' ? 'selected' : '' }}>Plano</option>
                        <option value="modalidade" {{ old('tipo', request('tipo')) === 'modalidade' ? 'selected' : '' }}>Modalidade</option>
                    </select>
                </div>
                <div class="col-12 col-md-5 col-lg-4">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" value="{{ old('valor', request('valor')) }}"
                        placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-12 col-lg-6 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ url('aluno/create') }}" class="btn btn-success">Novo</a>
                    <a href="{{ route('aluno.report') }}" class="btn btn-danger">Relatório PDF</a>
                    <a href="{{ route('avaliacao.index') }}" class="btn btn-warning">Avaliações</a>
                </div>
            </div>
        </form>

    </div>


    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover align-middle" style="min-width: 1200px">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Foto</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Nascimento</th>
                    <th scope="col">Plano</th>
                    <th scope="col">Modalidade</th>
                    <th scope="col">Situação</th>
                    <th scope="col">Avaliação</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dados as $item)
                    <tr>
                        <td class="text-nowrap">{{ $item->nome }}</td>
                        <td class="text-nowrap">
                            @if ($item->imagem)
                                <img src="{{ asset('storage/' . $item->imagem) }}" alt="Foto de {{ $item->nome }}"
                                    width="64" height="64" class="rounded-circle" style="object-fit: cover">
                            @else
                                Sem foto
                            @endif
                        </td>
                        <td class="text-nowrap">{{ $item->cpf }}</td>
                        <td class="text-nowrap">{{ $item->telefone }}</td>
                        <td class="text-nowrap">{{ $item->email }}</td>
                        <td style="min-width: 190px; max-width: 240px; white-space: normal; overflow-wrap: anywhere">
                            {{ $item->endereco }}
                        </td>
                        <td class="text-nowrap">{{ $item->data_nascimento?->format('d/m/Y') }}</td>
                        <td class="text-nowrap">{{ $item->plano->nome ?? 'Sem plano' }}</td>
                        <td class="text-nowrap">{{ $item->modalidade->nome ?? 'Sem modalidade' }}</td>
                        <td class="text-nowrap">{{ $item->ativo ? 'Ativo' : 'Inativo' }}</td>
                        <td class="text-nowrap">
                            @if ($item->avaliacaoFisica)
                                <a class="btn btn-info btn-sm" href="{{ route('avaliacao.edit', $item->avaliacaoFisica->id) }}">Ver ficha</a>
                            @else
                                <a class="btn btn-outline-primary btn-sm"
                                    href="{{ route('avaliacao.create', ['aluno_id' => $item->id]) }}">Nova ficha</a>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex gap-2">
                            <a class="btn btn-warning btn-sm" title="Editar" href="{{ route('aluno.edit', $item->id) }}">Editar</a>
                            <form action="{{ route('aluno.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Excluir"
                                    onclick="return confirm('Deseja excluir este aluno? A avaliação física associada também será removida.')">Deletar</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">Nenhum aluno encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop
