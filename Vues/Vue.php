<?php
declare(strict_types=1);
class Vue {
    private $authentification;
    public function __construct(Authentification $authentification) { 
        $this->authentification = $authentification; 
    }
    public function afficher(string $fichier, array $donnees = [], string $titrePage = ''): void {
        $chemin = __DIR__ . '/' . $fichier . '.php';
        extract($donnees, EXTR_SKIP);
        $utilisateurCourant = $this->authentification->utilisateur();
        
        ob_start(); 
        require $chemin; 
        $contenu = ob_get_clean();
        
        require __DIR__ . '/gabarit.php';
    }
}