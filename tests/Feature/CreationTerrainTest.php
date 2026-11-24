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
}