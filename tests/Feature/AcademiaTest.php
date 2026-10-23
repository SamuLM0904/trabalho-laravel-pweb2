<?php

namespace Tests\Feature;

use App\Charts\AlunosPorModalidadeChart;
use App\Charts\NovosAlunosPorMesChart;
use App\Models\Aluno;
use App\Models\AvaliacaoFisica;
use App\Models\Modalidade;
use App\Models\Plano;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LineChart;
use ArielMejiaDev\LarapexCharts\PieChart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AcademiaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_can_create_plan_and_prevent_deleting_a_plan_used_by_a_student(): void
    {
        $this->post(route('plano.store'), [
            'nome' => 'Mensal',
            'valor' => '120.00',
            'descricao' => 'Acesso mensal',
        ])->assertRedirect('plano');

        $plano = Plano::firstOrFail();
        Aluno::create([
            'nome' => 'Ana Souza',
            'cpf' => '12345678901',
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

    public function test_student_can_upload_an_image_larger_than_the_previous_limit(): void
    {
        Storage::fake('public');

        $plano = Plano::create(['nome' => 'Mensal', 'valor' => 120]);
        $modalidade = Modalidade::create(['nome' => 'Musculação']);
        $aluno = Aluno::factory()->create([
            'plano_id' => $plano->id,
            'modalidade_id' => $modalidade->id,
        ]);

        $this->put(route('aluno.update', $aluno->id), [
            'nome' => $aluno->nome,
            'cpf' => $aluno->getRawOriginal('cpf'),
            'telefone' => $aluno->getRawOriginal('telefone'),
            'email' => $aluno->email,
            'endereco' => $aluno->endereco,
            'data_nascimento' => $aluno->data_nascimento->format('Y-m-d'),
            'ativo' => true,
            'plano_id' => $plano->id,
            'modalidade_id' => $modalidade->id,
            'imagem' => UploadedFile::fake()->image('foto-aluno.jpg')->size(3000),
        ])->assertRedirect('aluno');

        $aluno->refresh();
        $this->assertNotNull($aluno->imagem);
        Storage::disk('public')->assertExists($aluno->imagem);
    }

    public function test_physical_assessment_calculates_bmi_and_allows_one_per_student(): void
    {
        $plano = Plano::create(['nome' => 'Mensal', 'valor' => 120]);
        $aluno = Aluno::create([
            'nome' => 'Ana Souza',
            'cpf' => '12345678901',
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
        $this->get(route('avaliacao.report'))->assertDownload('relatorio_avaliacoes_fisicas.pdf');

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

    public function test_student_can_be_deleted_with_related_assessment(): void
    {
        $aluno = Aluno::create([
            'nome' => 'Ana Souza',
            'cpf' => '12345678901',
        ]);
        $avaliacao = AvaliacaoFisica::create([
            'aluno_id' => $aluno->id,
            'peso' => 70,
            'altura' => 1.70,
            'imc' => 24.22,
            'data_avaliacao' => '2026-10-23',
        ]);

        $this->delete(route('aluno.destroy', $aluno->id))
            ->assertRedirect('aluno')
            ->assertSessionHas('success', 'Aluno removido com sucesso, junto com a avaliação física associada.');

        $this->assertDatabaseMissing('alunos', ['id' => $aluno->id]);
        $this->assertDatabaseMissing('avaliacoes_fisicas', ['id' => $avaliacao->id]);
    }

    public function test_student_requires_academy_details_and_shows_related_records(): void
    {
        $plano = Plano::create(['nome' => 'Mensal', 'valor' => 120]);
        $modalidade = Modalidade::create(['nome' => 'Musculação']);
        $this->post(route('aluno.store'), [
            'nome' => 'Ana Souza',
            'cpf' => '12345678901',
            'telefone' => '48999990000',
            'email' => 'ana@example.com',
            'endereco' => 'Rua das Flores, 100, Florianópolis',
            'data_nascimento' => '2000-01-01',
            'ativo' => '1',
            'plano_id' => $plano->id,
            'modalidade_id' => $modalidade->id,
        ])->assertRedirect('aluno');

        $this->assertDatabaseHas('alunos', [
            'email' => 'ana@example.com',
            'endereco' => 'Rua das Flores, 100, Florianópolis',
            'modalidade_id' => $modalidade->id,
            'ativo' => true,
        ]);

        $this->get('/aluno')
            ->assertOk()
            ->assertSee('Mensal')
            ->assertSee('Musculação')
            ->assertSee('aria-current="page"', false)
            ->assertSee('ana@example.com')
            ->assertDontSee('<th scope="col">#</th>', false)
            ->assertDontSee('Categoria')
            ->assertSee('table-responsive')
            ->assertSee('min-width: 1200px')
            ->assertSee('overflow-wrap: anywhere');

        $this->get('/aluno/create')
            ->assertOk()
            ->assertSee('form-page')
            ->assertSee('form-card')
            ->assertSee('Dados pessoais e plano')
            ->assertSee('data-mask="cpf"', false)
            ->assertSee('data-mask="telefone"', false)
            ->assertDontSee('Categoria')
            ->assertSee('Modalidade');
    }

    public function test_student_cpf_and_phone_are_formatted_when_displayed(): void
    {
        $aluno = Aluno::create([
            'nome' => 'Ana Souza',
            'cpf' => '12345678901',
            'telefone' => '48999991234',
        ]);

        $this->assertSame('123.456.789-01', $aluno->cpf);
        $this->assertSame('(48) 99999-1234', $aluno->telefone);
    }

    public function test_dashboard_charts_use_different_chart_types(): void
    {
        $this->assertInstanceOf(
            PieChart::class,
            app(AlunosPorModalidadeChart::class)->build()
        );
        $this->assertInstanceOf(
            LineChart::class,
            app(NovosAlunosPorMesChart::class)->build()
        );

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Alunos por modalidade')
            ->assertSee('Novos alunos por mês')
            ->assertDontSee('Cursos')
            ->assertDontSee('Matrículas');

        $this->get('/curso')->assertNotFound();
        $this->get('/matricula')->assertNotFound();
        $this->get('/turma')->assertNotFound();
    }

    public function test_active_students_report_is_downloaded_as_pdf(): void
    {
        $plano = Plano::create(['nome' => 'Mensal', 'valor' => 120]);
        $modalidade = Modalidade::create(['nome' => 'Musculação']);

        Aluno::factory()->create([
            'plano_id' => $plano->id,
            'modalidade_id' => $modalidade->id,
            'ativo' => true,
        ]);
        Aluno::factory()->create([
            'plano_id' => $plano->id,
            'modalidade_id' => $modalidade->id,
            'ativo' => false,
        ]);

        $this->get(route('aluno.report'))
            ->assertDownload('relatorio_alunos.pdf');
    }
}
