<?php
declare(strict_types=1);
class Routeur {
    private $cT; private $cM; private $cU; private $cE; private $cA; private $cR;
    
    public function __construct($cT, $cM, $cU, $cE, $cA, $cR) { 
        $this->cT = $cT; $this->cM = $cM; $this->cU = $cU; $this->cE = $cE; $this->cA = $cA; $this->cR = $cR; 
    }
    
    public function router(): void {
        // L'action par défaut devient l'accueil
        $action = $_GET['action'] ?? 'accueil';
        try {
            switch ($action) {
                case 'accueil': $this->cA->index(); break;
                case 'recits': $this->cR->index(); break;
                
                case 'terrains-liste': $this->cT->index(); break;
                case 'terrain-detail': $this->cT->afficher($this->lireIdGet()); break;
                
                case 'match-ajouter': $this->exigerPost(); $this->cM->ajouter($_POST); break;
                case 'match-supprimer': $this->exigerPost(); $this->cM->supprimer($_POST); break;
                case 'match-modifier-form': $this->cM->modifierFormulaire($this->lireIdGet()); break;
                case 'match-modifier': $this->exigerPost(); $this->cM->modifier($_POST); break;
                
                case 'connexion': $this->cU->connexion(); break;
                case 'authentifier': $this->exigerPost(); $this->cU->authentifier($_POST); break;
                case 'deconnexion': $this->exigerPost(); $this->cU->deconnecter(); break;
                case 'inscription': $this->cU->inscription(); break;
                case 'inscrire': $this->exigerPost(); $this->cU->inscrire($_POST); break;
                
                default: $this->cE->afficher('Page introuvable', 404);
            }
        } catch (Exception $e) { $this->cE->afficher($e->getMessage(), 500); }
    }
    private function lireIdGet(): int { return (int)filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); }
    private function exigerPost(): void { if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifierJetonCSRF($_POST['csrf_token']??'')) throw new Exception('Action interdite'); }
}