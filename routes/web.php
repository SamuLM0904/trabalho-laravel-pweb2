<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AvaliacaoFisicaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\ModalidadeController;
use App\Http\Controllers\PlanoController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ##### Aluno ######
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

    // ##### Fim Aluno ######

    // ##### Plano ######

    Route::get('/plano/report', [PlanoController::class, 'report'])->name('plano.report');
    Route::resource('plano', PlanoController::class)->except(['show']);
    Route::post(
        '/plano/search',
        [PlanoController::class, 'search']
    )->name('plano.search');

    // ##### Fim Plano ######

    // ##### Modalidades ######

    Route::get('/modalidade/report', [ModalidadeController::class, 'report'])->name('modalidade.report');
    Route::resource('modalidade', ModalidadeController::class)->except(['show']);
    Route::post('/modalidade/search', [ModalidadeController::class, 'search'])->name('modalidade.search');

    // ##### Fim Modalidades ######

    // ##### Avaliações Físicas ######

    Route::get('/avaliacao/report', [AvaliacaoFisicaController::class, 'report'])->name('avaliacao.report');
    Route::resource('avaliacao', AvaliacaoFisicaController::class)->except(['show']);
    Route::post('/avaliacao/search', [AvaliacaoFisicaController::class, 'search'])->name('avaliacao.search');

    // ##### Fim Avaliações Físicas ######

    // ##### Equipamentos ######

    Route::get('/equipamento/report', [EquipamentoController::class, 'report'])->name('equipamento.report');
    Route::resource('equipamento', EquipamentoController::class)->except(['show']);
    Route::post('/equipamento/search', [EquipamentoController::class, 'search'])->name('equipamento.search');

    // ##### Fim Equipamentos ######

    /*
    Route::get('/aluno', function () {
        return view('aluno.list');
        //return "<h3>Olá mundo Laravel!</h3>";
    });
    */
});
