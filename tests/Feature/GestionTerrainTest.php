<?php

namespace Tests\Feature;

use App\Models\Terrain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GestionTerrainTest extends TestCase
{
    use RefreshDatabase;

    private function donneesValides(): array
    {
        return [
            'nom' => 'Terrain modifié',
            'adresse' => '100 rue du Sport, Laval',
            'type' => 'Exterieur',
        ];
    }

    // Relire les données en base et trier les clés pour une comparaison stricte
    private function etatTerrain(Terrain $terrain): array
    {
        $etat = $terrain->fresh()->getAttributes();
        ksort($etat);

        return $etat;
    }

    public function test_un_admin_peut_modifier_un_terrain(): void
    {
        // Préparer
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $terrain = Terrain::factory()->create([
            'type' => 'Interieur',
        ]);

        // Agir
        $response = $this->actingAs($admin)->put(
            route('terrains.update', $terrain),
            $this->donneesValides()
        );

        // Vérifier
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('terrains.show', $terrain));

        $this->assertDatabaseHas('terrains', [
            'id' => $terrain->id,
            ...$this->donneesValides(),
            'user_id' => $terrain->user_id,
        ]);
    }

    public function test_une_modification_invalide_laisse_le_terrain_intact(): void
    {
        // Préparer
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $terrain = Terrain::factory()->create([
            'type' => 'Interieur',
        ]);

        $avant = $this->etatTerrain($terrain);

        // Agir
        $response = $this->actingAs($admin)->put(
            route('terrains.update', $terrain),
            [...$this->donneesValides(), 'nom' => '']
        );

        // Vérifier
        $response->assertSessionHasErrors('nom');

        $this->assertSame($avant, $this->etatTerrain($terrain));
    }

    public function test_un_joueur_ne_peut_pas_modifier_meme_son_terrain(): void
    {
        // Préparer
        $joueur = User::factory()->create([
            'role' => User::ROLE_JOUEUR,
        ]);

        $terrain = Terrain::factory()->create([
            'type' => 'Interieur',
            'user_id' => $joueur->id,
        ]);

        $avant = $this->etatTerrain($terrain);

        // Agir
        $response = $this->actingAs($joueur)->put(
            route('terrains.update', $terrain),
            $this->donneesValides()
        );

        // Vérifier
        $response->assertForbidden();

        $this->assertSame($avant, $this->etatTerrain($terrain));
    }

    public function test_un_visiteur_ne_peut_pas_modifier_un_terrain(): void
    {
        // Préparer
        $terrain = Terrain::factory()->create([
            'type' => 'Interieur',
        ]);

        $avant = $this->etatTerrain($terrain);

        // Agir
        $response = $this->put(
            route('terrains.update', $terrain),
            $this->donneesValides()
        );

        // Vérifier
        $response->assertRedirect(route('login'));

        $this->assertSame($avant, $this->etatTerrain($terrain));
    }

    public function test_un_admin_peut_supprimer_un_terrain(): void
    {
        // Préparer
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $terrain = Terrain::factory()->create([
            'type' => 'Interieur',
        ]);

        // Agir
        $response = $this->actingAs($admin)->delete(
            route('terrains.destroy', $terrain)
        );

        // Vérifier
        $response->assertRedirect(route('terrains.index'));

        $this->assertDatabaseMissing('terrains', [
            'id' => $terrain->id,
        ]);
    }

    public function test_un_joueur_ne_peut_pas_supprimer_meme_son_terrain(): void
    {
        // Préparer
        $joueur = User::factory()->create([
            'role' => User::ROLE_JOUEUR,
        ]);

        $terrain = Terrain::factory()->create([
            'type' => 'Interieur',
            'user_id' => $joueur->id,
        ]);

        $avant = $this->etatTerrain($terrain);

        // Agir
        $response = $this->actingAs($joueur)->delete(
            route('terrains.destroy', $terrain)
        );

        // Vérifier
        $response->assertForbidden();

        $this->assertSame($avant, $this->etatTerrain($terrain));
    }

    public function test_un_visiteur_ne_peut_pas_supprimer_un_terrain(): void
    {
        // Préparer
        $terrain = Terrain::factory()->create([
            'type' => 'Interieur',
        ]);

        $avant = $this->etatTerrain($terrain);

        // Agir
        $response = $this->delete(
            route('terrains.destroy', $terrain)
        );

        // Vérifier
        $response->assertRedirect(route('login'));

        $this->assertSame($avant, $this->etatTerrain($terrain));
    }

    public function test_modifier_un_terrain_inexistant_retourne_404(): void
    {
        // Préparer
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        // Agir
        $response = $this->actingAs($admin)->put(
            route('terrains.update', ['terrain' => 999999]),
            $this->donneesValides()
        );

        // Vérifier
        $response->assertNotFound();
    }

    public function test_supprimer_un_terrain_inexistant_retourne_404(): void
    {
        // Préparer
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        // Agir
        $response = $this->actingAs($admin)->delete(
            route('terrains.destroy', ['terrain' => 999999])
        );

        // Vérifier
        $response->assertNotFound();
    }
}