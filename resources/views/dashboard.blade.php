@extends('main')
@section('titulo', 'Painel da Academia')
@section('conteudo')
    <h3 class="mb-4">Painel da Academia</h3>

    <div class="row g-3 mb-4">
        @foreach ([
            'Alunos' => $totais['alunos'],
            'Planos' => $totais['planos'],
            'Modalidades' => $totais['modalidades'],
            'Avaliações físicas' => $totais['avaliacoes'],
            'Equipamentos' => $totais['equipamentos'],
        ] as $titulo => $total)
            <div class="col-6 col-md">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title">{{ $titulo }}</h6>
                        <p class="display-6 mb-0">{{ $total }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    {!! $alunosPorPlano->container() !!}
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    {!! $equipamentosPorEstado->container() !!}
                </div>
            </div>
        </div>
    </div>

    <script src="{{ $alunosPorPlano->cdn() }}"></script>
    {{ $alunosPorPlano->script() }}
    {{ $equipamentosPorEstado->script() }}
@stop
