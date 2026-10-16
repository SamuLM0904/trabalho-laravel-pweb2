<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\ModalidadeController;
use App\Http\Controllers\AvaliacaoFisicaController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

###### Aluno ######
Route::get('/aluno/report', [AlunoController::class, 'report'])->name('aluno.report');
Route::get('/aluno', [AlunoController::class, 'index']);
Route::get('/aluno/create', [AlunoController::class, 'create']);
Route::post(
    '/aluno/store',
    [AlunoController::class, 'store']
)->name('aluno.store');

Route::get(
    '/aluno/edit/{id}',
    [AlunoController::class, 'edit']
)->name('aluno.edit');
Route::put(
    '/aluno/update/{id}',
    [AlunoController::class, 'update']
)->name('aluno.update');

Route::delete(
    '/aluno/{id}',
    [AlunoController::class, 'destroy']
)->name('aluno.destroy');

Route::post(
    '/aluno/search',
    [AlunoController::class, 'search']
)->name('aluno.search');

###### Fim Aluno ######

###### Plano ######

Route::get('/plano/report', [PlanoController::class, 'report'])->name('plano.report');
Route::resource('plano', PlanoController::class)->except(['show']);
Route::post(
    '/plano/search',
    [PlanoController::class, 'search']
)->name('plano.search');

###### Fim Plano ######

###### Modalidades ######

Route::get('/modalidade/report', [ModalidadeController::class, 'report'])->name('modalidade.report');
Route::resource('modalidade', ModalidadeController::class)->except(['show']);
Route::post('/modalidade/search', [ModalidadeController::class, 'search'])->name('modalidade.search');

###### Fim Modalidades ######

###### Avaliações Físicas ######

Route::get('/avaliacao/report', [AvaliacaoFisicaController::class, 'report'])->name('avaliacao.report');
Route::resource('avaliacao', AvaliacaoFisicaController::class)->except(['show']);
Route::post('/avaliacao/search', [AvaliacaoFisicaController::class, 'search'])->name('avaliacao.search');

###### Fim Avaliações Físicas ######

###### Equipamentos ######

Route::get('/equipamento/report', [EquipamentoController::class, 'report'])->name('equipamento.report');
Route::resource('equipamento', EquipamentoController::class)->except(['show']);
Route::post('/equipamento/search', [EquipamentoController::class, 'search'])->name('equipamento.search');

###### Fim Equipamentos ######

###### Curso ######

Route::get(
    '/curso/report',
    [\App\Http\Controllers\CursoController::class, 'report']
)->name('curso.report');

Route::get(
    '/curso/report-matriculados',
    [\App\Http\Controllers\CursoController::class, 'reportMatriculados']
)->name('curso.reportMatriculados');

Route::get(
    '/curso/chart',
    [\App\Http\Controllers\CursoController::class, 'chart']
)->name('curso.chart');

Route::get(
    '/curso/chart-qtd-aluno-curso-chart',
    [\App\Http\Controllers\CursoController::class, 'chartQtdAlunoCurso']
)->name('curso.qtdAlunoCursoChart');

Route::resource('curso', \App\Http\Controllers\CursoController::class);

Route::get(
    '/curso/{curso}/turmas',
    [\App\Http\Controllers\TurmaController::class, 'index']
)->name('curso.turmas');

Route::get(
    '/curso/{curso}/turmas/create',
    [\App\Http\Controllers\TurmaController::class, 'create']
)->name('curso.turmas.create');

Route::post(
    '/curso/search',
    [\App\Http\Controllers\CursoController::class, 'search']
)->name('curso.search');

###### Fim Curso ######

###### Turma ######

Route::resource('turma', \App\Http\Controllers\TurmaController::class);
Route::post(
    '/turma/search',
    [\App\Http\Controllers\TurmaController::class, 'search']
)->name('turma.search');

###### fim Turma ######

###### Matricula ######

Route::resource('matricula', \App\Http\Controllers\MatriculaController::class);
Route::post(
    '/matricula/search',
    [\App\Http\Controllers\MatriculaController::class, 'search']
)->name('matricula.search');

###### fim Matricula ######

/*
Route::get('/aluno', function () {
    return view('aluno.list');
    //return "<h3>Olá mundo Laravel!</h3>";
});
*/
