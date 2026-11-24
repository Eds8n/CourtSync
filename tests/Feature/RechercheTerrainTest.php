<?php

namespace Tests\Feature;

use App\Models\Terrain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RechercheTerrainTest extends TestCase
{
    use RefreshDatabase;

    // Construit une URL de recherche avec un paramètre correctement encodé.
    private function urlRecherche(string $terme): string
    {
        return route('recherche.terrains', ['q' => $terme]);
    }

    public function test_un_visiteur_peut_consulter_la_liste_des_terrains(): void
    {
        // Préparer
        $terrain = Terrain::factory()->create([
            'nom' => 'Terrain Montmorency',
            'adresse' => '100 rue du Sport',
            'type' => 'Interieur',
        ]);

        // Agir
        $response = $this->get(route('terrains.index'));

        // Vérifier
        $response->assertOk();
        $response->assertViewIs('terrains.index');

        $response->assertViewHas(
            'terrains',
            fn ($terrains) => $terrains->contains('id', $terrain->id)
        );
    }

    public function test_la_liste_est_paginee_par_dix_terrains(): void
    {
        // Préparer
        Terrain::factory()->count(11)->create([
            'type' => 'Interieur',
        ]);

        // Agir
        $response = $this->get(route('terrains.index'));

        // Vérifier
        $response->assertOk();

        $response->assertViewHas('terrains', function ($terrains) {
            return $terrains->count() === 10
                && $terrains->total() === 11
                && $terrains->hasMorePages();
        });

        // Le dernier terrain doit être accessible à la deuxième page.
        $this->get(route('terrains.index', ['page' => 2]))
            ->assertOk()
            ->assertViewHas(
                'terrains',
                fn ($terrains) => $terrains->count() === 1
            );
    }

    public function test_la_recherche_trouve_un_terrain_par_son_nom(): void
    {
        // Préparer
        $terrain = Terrain::factory()->create([
            'nom' => 'Terrain Montmorency',
            'adresse' => '100 rue du Sport',
            'type' => 'Interieur',
        ]);

        Terrain::factory()->create([
            'nom' => 'Terrain Central',
            'adresse' => '200 rue Principale',
            'type' => 'Exterieur',
        ]);

        // Agir
        $response = $this->getJson($this->urlRecherche('Montmorency'));

        // Vérifier le résultat et sa structure exacte.
        $response->assertOk();
        $response->assertExactJson([
            'data' => [
                [
                    'id' => $terrain->id,
                    'label' => 'Terrain Montmorency (100 rue du Sport)',
                    'url' => route('terrains.show', $terrain),
                ],
            ],
        ]);
    }

    public function test_la_recherche_trouve_un_terrain_par_son_adresse(): void
    {
        // Préparer
        $terrain = Terrain::factory()->create([
            'nom' => 'Terrain Central',
            'adresse' => '100 boulevard Montmorency',
            'type' => 'Interieur',
        ]);

        // Agir
        $response = $this->getJson($this->urlRecherche('Montmorency'));

        // Vérifier
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.id', $terrain->id);
    }

    public function test_une_recherche_sans_resultat_retourne_une_liste_vide(): void
    {
        // Préparer
        Terrain::factory()->create([
            'nom' => 'Terrain Central',
            'adresse' => '100 rue du Sport',
            'type' => 'Interieur',
        ]);

        // Agir
        $response = $this->getJson($this->urlRecherche('Introuvable'));

        // Vérifier
        $response->assertOk();
        $response->assertExactJson(['data' => []]);
    }

    public function test_la_recherche_est_limitee_a_huit_resultats_tries_par_nom(): void
    {
        // Préparer : insertion dans l'ordre inverse.
        foreach (range(10, 1) as $numero) {
            Terrain::factory()->create([
                'nom' => sprintf('Terrain %02d', $numero),
                'adresse' => '100 rue du Sport',
                'type' => 'Interieur',
            ]);
        }

        // Agir
        $response = $this->getJson($this->urlRecherche('Terrain'));

        // Vérifier la limite et l'ordre de tous les résultats.
        $response->assertOk();
        $response->assertJsonCount(8, 'data');

        $nomsAttendus = array_map(
            fn ($numero) => sprintf(
                'Terrain %02d (100 rue du Sport)',
                $numero
            ),
            range(1, 8)
        );

        $this->assertSame(
            $nomsAttendus,
            array_column($response->json('data'), 'label')
        );
    }

    public function test_un_terme_absent_est_refuse(): void
    {
        $this->getJson(route('recherche.terrains'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('q');
    }

    public function test_un_terme_trop_court_est_refuse(): void
    {
        $this->getJson($this->urlRecherche('A'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('q');
    }

    public function test_un_terme_trop_long_est_refuse(): void
    {
        $this->getJson($this->urlRecherche(str_repeat('A', 51)))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('q');
    }

    public function test_un_terme_sous_forme_de_tableau_est_refuse(): void
    {
        $url = route('recherche.terrains', [
            'q' => ['Terrain'],
        ]);

        $this->getJson($url)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('q');
    }
}