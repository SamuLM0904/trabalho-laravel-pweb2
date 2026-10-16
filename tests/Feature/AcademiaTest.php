<?php

namespace Tests\Feature;

use App\Models\Aluno;
use App\Models\AvaliacaoFisica;
use App\Models\CategoriaAluno;
use App\Models\Modalidade;
use App\Models\Plano;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AcademiaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_plan_and_prevent_deleting_a_plan_used_by_a_student(): void
    {
        $this->post(route('plano.store'), [
            'nome' => 'Mensal',
            'valor' => '120.00',
            'descricao' => 'Acesso mensal',
        ])->assertRedirect('plano');

        $plano = Plano::firstOrFail();
        $categoria = CategoriaAluno::create(['nome' => 'Aluno']);
        Aluno::create([
            'nome' => 'Ana Souza',
            'cpf' => '12345678901',
            'categoria_id' => $categoria->id,
            'plano_id' => $plano->id,
        ]);

        $this->delete(route('plano.destroy', $plano->id))
            ->assertRedirect('plano')
            ->assertSessionHas('error');

        $this->assertDatabaseHas('planos', ['id' => $plano->id]);
    }

    public function test_can_upload_and_remove_a_modality_image(): void
    {
        Storage::fake('public');

        $this->post(route('modalidade.store'), [
            'nome' => 'Pilates',
            'descricao' => 'Aulas de pilates',
            'imagem' => UploadedFile::fake()->create('pilates.jpg', 100, 'image/jpeg'),
        ])->assertRedirect('modalidade');

        $modalidade = Modalidade::firstOrFail();
        Storage::disk('public')->assertExists($modalidade->imagem);

        $this->delete(route('modalidade.destroy', $modalidade->id))
            ->assertRedirect('modalidade');

        Storage::disk('public')->assertMissing($modalidade->imagem);
    }

    public function test_physical_assessment_calculates_bmi_and_allows_one_per_student(): void
    {
        $plano = Plano::create(['nome' => 'Mensal', 'valor' => 120]);
        $categoria = CategoriaAluno::create(['nome' => 'Aluno']);
        $aluno = Aluno::create([
            'nome' => 'Ana Souza',
            'cpf' => '12345678901',
            'categoria_id' => $categoria->id,
            'plano_id' => $plano->id,
        ]);

        $dados = [
            'aluno_id' => $aluno->id,
            'peso' => 70,
            'altura' => 1.70,
            'data_avaliacao' => '2026-10-16',
        ];

        $this->post(route('avaliacao.store'), $dados)->assertRedirect('avaliacao');
        $this->assertSame('24.22', AvaliacaoFisica::firstOrFail()->imc);

        $this->post(route('avaliacao.store'), $dados)
            ->assertSessionHasErrors('aluno_id');
    }

    public function test_equipment_serial_number_must_be_unique(): void
    {
        $dados = [
            'nome' => 'Esteira',
            'numero_serie' => 'EST-001',
            'estado' => 'Bom',
        ];

        $this->post(route('equipamento.store'), $dados)->assertRedirect('equipamento');
        $this->post(route('equipamento.store'), $dados)->assertSessionHasErrors('numero_serie');

        $this->assertDatabaseHas('equipamentos', [
            'numero_serie' => 'EST-001',
            'estado' => 'Bom',
        ]);
        $this->assertDatabaseCount('equipamentos', 1);
    }
}
