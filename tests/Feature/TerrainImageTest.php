<?php

namespace Tests\Feature;

use App\Models\Terrain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TerrainImageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Isoler les fichiers : aucune vraie image ne sera touchée
        Storage::fake('public');
    }

    private function donneesValides(): array
    {
        return [
            'nom' => 'Terrain illustré',
            'adresse' => '100 rue du Sport, Laval',
            'type' => 'Interieur',
        ];
    }

    private function creerTerrainAvecImage(): Terrain
    {
        $chemin = UploadedFile::fake()
            ->image('ancienne.png')
            ->store('terrains', 'public');

        return Terrain::factory()->create([
            'type' => 'Interieur',
            'image_path' => $chemin,
        ]);
    }

    public function test_un_admin_peut_creer_un_terrain_avec_image(): void
    {
        // Préparer
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        // Agir
        $response = $this->actingAs($admin)->post(
            route('terrains.store'),
            [
                ...$this->donneesValides(),
                'image' => UploadedFile::fake()->image('terrain.png'),
            ]
        );

        // Vérifier
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('terrains', 1);

        $terrain = Terrain::firstOrFail();

        $response->assertRedirect(route('terrains.show', $terrain));
        $this->assertSame($admin->id, $terrain->user_id);
        $this->assertNotEmpty($terrain->image_path);
        Storage::disk('public')->assertExists($terrain->image_path);
    }

    public function test_un_fichier_texte_est_refuse(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)->post(
            route('terrains.store'),
            [
                ...$this->donneesValides(),
                'image' => UploadedFile::fake()->create(
                    'document.txt',
                    10,
                    'text/plain'
                ),
            ]
        )->assertSessionHasErrors('image');

        $this->assertDatabaseCount('terrains', 0);
        $this->assertCount(0, Storage::disk('public')->allFiles());
    }

    public function test_une_image_trop_lourde_est_refusee(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)->post(
            route('terrains.store'),
            [
                ...$this->donneesValides(),
                'image' => UploadedFile::fake()
                    ->image('terrain.png')
                    ->size(2049),
            ]
        )->assertSessionHasErrors('image');

        $this->assertDatabaseCount('terrains', 0);
        $this->assertCount(0, Storage::disk('public')->allFiles());
    }

    public function test_remplacer_une_image_supprime_l_ancienne(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $terrain = $this->creerTerrainAvecImage();
        $ancienChemin = $terrain->image_path;

        $response = $this->actingAs($admin)->put(
            route('terrains.update', $terrain),
            [
                ...$this->donneesValides(),
                'image' => UploadedFile::fake()->image('nouvelle.png'),
            ]
        );

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('terrains.show', $terrain));

        $nouveauChemin = $terrain->fresh()->image_path;

        $this->assertNotEmpty($nouveauChemin);
        $this->assertNotSame($ancienChemin, $nouveauChemin);
        Storage::disk('public')->assertMissing($ancienChemin);
        Storage::disk('public')->assertExists($nouveauChemin);
    }

    public function test_un_admin_peut_supprimer_uniquement_l_image(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $terrain = $this->creerTerrainAvecImage();
        $chemin = $terrain->image_path;

        $this->actingAs($admin)
            ->from(route('terrains.edit', $terrain))
            ->delete(route('terrains.image.destroy', $terrain))
            ->assertRedirect(route('terrains.edit', $terrain));

        $this->assertDatabaseHas('terrains', [
            'id' => $terrain->id,
            'image_path' => null,
        ]);

        Storage::disk('public')->assertMissing($chemin);
    }

    public function test_supprimer_un_terrain_supprime_son_image(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $terrain = $this->creerTerrainAvecImage();
        $chemin = $terrain->image_path;

        $this->actingAs($admin)
            ->delete(route('terrains.destroy', $terrain))
            ->assertRedirect(route('terrains.index'));

        $this->assertDatabaseMissing('terrains', [
            'id' => $terrain->id,
        ]);

        Storage::disk('public')->assertMissing($chemin);
    }

    public function test_un_joueur_ne_peut_pas_supprimer_l_image(): void
    {
        $joueur = User::factory()->create(['role' => User::ROLE_JOUEUR]);
        $terrain = $this->creerTerrainAvecImage();
        $chemin = $terrain->image_path;

        $this->actingAs($joueur)
            ->delete(route('terrains.image.destroy', $terrain))
            ->assertForbidden();

        $this->assertDatabaseHas('terrains', [
            'id' => $terrain->id,
            'image_path' => $chemin,
        ]);

        Storage::disk('public')->assertExists($chemin);
    }

    public function test_un_visiteur_ne_peut_pas_supprimer_l_image(): void
    {
        $terrain = $this->creerTerrainAvecImage();
        $chemin = $terrain->image_path;

        $this->delete(route('terrains.image.destroy', $terrain))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('terrains', [
            'id' => $terrain->id,
            'image_path' => $chemin,
        ]);

        Storage::disk('public')->assertExists($chemin);
    }
}