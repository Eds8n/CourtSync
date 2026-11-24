<?php

namespace Tests\Feature;

use App\Models\Terrain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreationTerrainTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_admin_peut_creer_un_terrain(): void
    {
        // Préparer
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        // Agir
        $response = $this->actingAs($admin)->post(
            route('terrains.store'),
            [
                'nom' => 'Terrain Montmorency',
                'adresse' => '475 boulevard de l’Avenir, Laval',
                'type' => 'Interieur',
            ]
        );

        // Vérifier
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount('terrains', 1);

        $this->assertDatabaseHas('terrains', [
            'nom' => 'Terrain Montmorency',
            'adresse' => '475 boulevard de l’Avenir, Laval',
            'type' => 'Interieur',
            'user_id' => $admin->id,
        ]);

        $terrain = Terrain::firstOrFail();

        $response->assertRedirect(
            route('terrains.show', $terrain)
        );
    }

    public function test_un_nom_vide_empeche_la_creation(): void
    {

    // preparer 
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
    ]);

    //Agir
    $response = $this->actingAs($admin)->post(
        route('terrains.store'),
        [
            'nom' => '',
            'adresse' => '475 boulevard de l’Avenir, Laval',
            'type' => 'Interieur',
        ]
    );

    // Verifier 
    $response->assertSessionHasErrors('nom');
    $this->assertDatabaseCount('terrains', 0);
    }

    public function test_un_joueur_ne_peut_pas_creer_un_terrain(): void
{
    // Préparer
    $joueur = User::factory()->create([
        'role' => User::ROLE_JOUEUR,
    ]);

    // Agir
    $response = $this->actingAs($joueur)->post(
        route('terrains.store'),
        [
            'nom' => 'Terrain interdit',
            'adresse' => '475 boulevard de l’Avenir, Laval',
            'type' => 'Interieur',
        ]
    );

    // Vérifier
    $response->assertForbidden();
    $this->assertDatabaseCount('terrains', 0);
}

public function test_un_visiteur_ne_peut_pas_creer_un_terrain(): void
{
    // Préparer
    $donnees = [
        'nom' => 'Terrain visiteur',
        'adresse' => '475 boulevard de l’Avenir, Laval',
        'type' => 'Interieur',
    ];

    // Agir
    $response = $this->post(route('terrains.store'), $donnees);

    // Vérifier
    $response->assertRedirect(route('login'));
    $this->assertDatabaseCount('terrains', 0);
}


public function test_un_nom_de_plus_de_40_caracteres_est_refuse(): void
{
    // Préparer
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
    ]);

    // Agir
    $response = $this->actingAs($admin)->post(
        route('terrains.store'),
        [
            'nom' => str_repeat('A', 41),
            'adresse' => '475 boulevard de l’Avenir, Laval',
            'type' => 'Interieur',
        ]
    );

    // Vérifier
    $response->assertSessionHasErrors('nom');
    $this->assertDatabaseCount('terrains', 0);
}
}