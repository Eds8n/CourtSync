<?php
declare(strict_types=1);
class Authentification {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
            session_start();
        }
    }
    public function connecter(array $utilisateur): void {
        session_regenerate_id(true);
        $_SESSION['utilisateur'] = ['id' => (int)$utilisateur['id'], 'nom' => $utilisateur['nom'], 'courriel' => $utilisateur['courriel']];
    }
    public function utilisateur(): ?array { return $_SESSION['utilisateur'] ?? null; }
    public function deconnecter(): void {
        $_SESSION = [];
        session_destroy();
    }
}