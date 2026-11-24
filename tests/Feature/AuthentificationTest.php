<?php

namespace Tests\Feature;

use App\Models\Terrain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthentificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_utilisateur_peut_se_connecter(): void
    {
        // Préparer
        $user = User::factory()->create([
            'password' => Hash::make('MotDePasse-Test123!'),
        ]);

        // Agir
        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'MotDePasse-Test123!',
        ]);

        // Vérifier
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('terrains.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_un_mauvais_mot_de_passe_est_refuse(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('MotDePasse-Test123!'),
        ]);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => $user->email,
                'password' => 'MauvaisMotDePasse',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'password' => $user->password,
        ]);
    }

    public function test_un_compte_inexistant_ne_peut_pas_se_connecter(): void
    {
        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'inconnu@example.test',
                'password' => 'MotDePasse-Test123!',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_un_mot_de_passe_absent_est_refuse(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => '',
        ])->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_un_utilisateur_peut_se_deconnecter(): void
    {
        $user = User::factory()->create();

        // Une donnée permet de vérifier l'invalidation de la session
        $this->actingAs($user)
            ->withSession(['donnee_privee' => 'test'])
            ->post(route('logout'))
            ->assertRedirect(route('terrains.index'))
            ->assertSessionMissing('donnee_privee');

        $this->assertGuest();
    }

    public function test_un_visiteur_ne_peut_pas_consulter_mon_compte(): void
    {
        $this->get(route('account.show'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_mon_compte_affiche_uniquement_mes_terrains(): void
    {
        // Préparer
        $user = User::factory()->create();
        $autreUser = User::factory()->create();

        $monTerrain = Terrain::factory()->create([
            'nom' => 'Mon terrain',
            'adresse' => '10 rue du Sport',
            'type' => 'Interieur',
            'user_id' => $user->id,
        ]);

        $autreTerrain = Terrain::factory()->create([
            'nom' => 'Terrain autre compte',
            'adresse' => '20 rue du Sport',
            'type' => 'Exterieur',
            'user_id' => $autreUser->id,
        ]);

        // Agir
        $response = $this->actingAs($user)->get(
            route('account.show')
        );

        // Vérifier
        $response->assertOk();
        $response->assertViewIs('account.show');

        $response->assertViewHas(
            'user',
            fn (User $resultat) => $resultat->id === $user->id
        );

        $response->assertViewHas('terrains', function ($terrains) use (
            $monTerrain,
            $autreTerrain
        ) {
            return $terrains->count() === 1
                && $terrains->contains('id', $monTerrain->id)
                && ! $terrains->contains('id', $autreTerrain->id);
        });
    }
}