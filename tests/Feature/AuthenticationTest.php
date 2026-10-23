<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_requires_authentication(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@academia.com',
            'password' => 'password',
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        User::factory()->create(['email' => 'admin@academia.com']);

        $this->post(route('login.store'), [
            'email' => 'admin@academia.com',
            'password' => 'senha-incorreta',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_database_seeder_creates_demo_account_and_academy_data(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', ['email' => 'admin@academia.com']);
        $this->assertDatabaseHas('planos', ['nome' => 'Mensal']);
        $this->assertDatabaseHas('modalidades', ['nome' => 'Musculação']);
        $this->assertDatabaseCount('alunos', 5);

        $this->post(route('login.store'), [
            'email' => 'admin@academia.com',
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }
}
