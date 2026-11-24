<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class InscriptionTest extends TestCase
{
    use RefreshDatabase;

    private const CAPTCHA_URL =
        'https://www.google.com/recaptcha/api/siteverify';

    protected function setUp(): void
    {
        parent::setUp();

        // Une clé fictive suffit : Google ne sera pas contacté
        config(['services.recaptcha.secret_key' => 'secret-test']);
    }

    private function donneesValides(): array
    {
        return [
            'name' => 'Edson Test',
            'email' => 'edson@example.test',
            'email_confirmation' => 'edson@example.test',
            'password' => 'MotDePasse-Test123!',
            'password_confirmation' => 'MotDePasse-Test123!',
            'g-recaptcha-response' => 'jeton-test',
        ];
    }

    private function simulerCaptcha(bool $accepte): void
    {
        Http::fake([
            self::CAPTCHA_URL => Http::response([
                'success' => $accepte,
            ], 200),
        ]);
    }

    public function test_une_inscription_valide_cree_et_connecte_un_joueur(): void
    {
        // Préparer
        $this->simulerCaptcha(true);
        $donnees = $this->donneesValides();

        // Agir
        $response = $this->post(route('register.store'), $donnees);

        // Vérifier
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('terrains.index'));

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'name' => $donnees['name'],
            'email' => $donnees['email'],
            'role' => User::ROLE_JOUEUR,
        ]);

        $user = User::firstOrFail();

        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($donnees['password'], $user->password);
        $this->assertTrue(
            Hash::check($donnees['password'], $user->password)
        );

        Http::assertSent(function ($request) {
            return $request->url() === self::CAPTCHA_URL
                && $request['secret'] === 'secret-test'
                && $request['response'] === 'jeton-test';
        });
    }

    public function test_un_role_admin_envoye_par_le_formulaire_est_ignore(): void
    {
        $this->simulerCaptcha(true);

        $this->post(route('register.store'), [
            ...$this->donneesValides(),
            'role' => User::ROLE_ADMIN,
        ])->assertRedirect(route('terrains.index'));

        $this->assertDatabaseCount('users', 1);
        $this->assertSame(
            User::ROLE_JOUEUR,
            User::firstOrFail()->role
        );
    }

    public function test_un_captcha_refuse_empeche_la_creation_du_compte(): void
    {
        $this->simulerCaptcha(false);

        $this->post(
            route('register.store'),
            $this->donneesValides()
        )->assertSessionHasErrors('g-recaptcha-response');

        Http::assertSentCount(1);
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_un_captcha_absent_empeche_la_creation_du_compte(): void
    {
        $donnees = $this->donneesValides();
        unset($donnees['g-recaptcha-response']);

        $this->post(route('register.store'), $donnees)
            ->assertSessionHasErrors('g-recaptcha-response');

        Http::assertNothingSent();
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_une_erreur_http_de_google_empeche_l_inscription(): void
    {
        Http::fake([
            self::CAPTCHA_URL => Http::response([], 500),
        ]);

        $this->post(
            route('register.store'),
            $this->donneesValides()
        )->assertSessionHasErrors('g-recaptcha-response');

        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_google_injoignable_empeche_l_inscription(): void
    {
        Http::fake([
            self::CAPTCHA_URL => function () {
                throw new ConnectionException('Connexion de test impossible');
            },
        ]);

        $this->post(
            route('register.store'),
            $this->donneesValides()
        )->assertSessionHasErrors('g-recaptcha-response');

        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    #[DataProvider('champsInvalides')]
    public function test_des_champs_invalides_empechent_l_inscription(
        array $changements,
        string $champEnErreur
    ): void {
        $donnees = array_replace(
            $this->donneesValides(),
            $changements
        );

        $this->post(route('register.store'), $donnees)
            ->assertSessionHasErrors($champEnErreur);

        // La validation doit arrêter le traitement avant Google
        Http::assertNothingSent();
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public static function champsInvalides(): array
    {
        return [
            'nom absent' => [
                ['name' => ''],
                'name',
            ],
            'nom trop long' => [
                ['name' => str_repeat('A', 101)],
                'name',
            ],
            'courriel invalide' => [
                [
                    'email' => 'pas-un-courriel',
                    'email_confirmation' => 'pas-un-courriel',
                ],
                'email',
            ],
            'confirmation courriel differente' => [
                ['email_confirmation' => 'autre@example.test'],
                'email',
            ],
            'mot de passe trop court' => [
                [
                    'password' => 'court',
                    'password_confirmation' => 'court',
                ],
                'password',
            ],
            'confirmation mot de passe differente' => [
                ['password_confirmation' => 'AutreMotDePasse123!'],
                'password',
            ],
        ];
    }

    public function test_un_courriel_deja_utilise_est_refuse(): void
    {
        $existant = User::factory()->create([
            'email' => 'edson@example.test',
        ]);

        $ancienHash = $existant->password;

        $this->post(
            route('register.store'),
            $this->donneesValides()
        )->assertSessionHasErrors('email');

        Http::assertNothingSent();
        $this->assertDatabaseCount('users', 1);

        // Le compte existant n'est pas remplacé
        $this->assertDatabaseHas('users', [
            'id' => $existant->id,
            'name' => $existant->name,
            'email' => $existant->email,
            'password' => $ancienHash,
        ]);

        $this->assertGuest();
    }
}