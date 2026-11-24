<?php

namespace Tests\Feature;

use App\Models\Terrain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultationTerrainTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_visiteur_peut_consulter_un_terrain(): void
    {
        // Préparer
        $terrain = Terrain::factory()->create([
            'nom' => 'Terrain Montmorency',
        ]);

        // Agir
        $response = $this->get(route('terrains.show', $terrain));

        // Vérifier
        $response->assertOk();
        $response->assertViewIs('terrains.show');
        $response->assertViewHas(
            'terrain',
            fn (Terrain $resultat) => $resultat->id === $terrain->id
        );
        $response->assertSee('Terrain Montmorency');
    }

    public function test_un_terrain_inexistant_retourne_404(): void
{
    // Préparer : aucun terrain dans la base de test

    // Agir
    $response = $this->get(route('terrains.show', [
        'terrain' => 999999,
    ]));

    // Vérifier
    $response->assertNotFound();
}
}