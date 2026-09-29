<?php
declare(strict_types=1);
class ControleurUtilisateur {
    private $utilisateurs; private $auth; private $vue;
    public function __construct(Utilisateur $u, Authentification $a, Vue $v) { $this->utilisateurs = $u; $this->auth = $a; $this->vue = $v; }
    
    public function connexion(?string $erreur = null): void { $this->vue->afficher('utilisateurs/connexion', ['erreur' => $erreur], 'Connexion'); }
    
    public function authentifier(array $post): void {
        $u = $this->utilisateurs->trouverParCourriel($post['courriel'] ?? '');
        if (!$u || !password_verify($post['mot_de_passe'] ?? '', $u['mot_de_passe'])) { $this->connexion('Courriel ou mot de passe invalide.'); return; }
        $this->auth->connecter($u); header('Location: terrains-liste'); exit;
    }
    
    public function deconnecter(): void { $this->auth->deconnecter(); header('Location: terrains-liste'); exit; }
    public function inscription(): void { $this->vue->afficher('utilisateurs/inscription', [], 'Inscription'); }
    
    public function inscrire(array $post): void {
        $this->utilisateurs->ajouter($post['nom'], $post['courriel'], password_hash($post['mot_de_passe'], PASSWORD_DEFAULT));
        header('Location: connexion'); exit;
    }
}