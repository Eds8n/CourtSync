<?php
declare(strict_types=1);
class ControleurAccueil {
    private $vue;
    public function __construct(Vue $v) { $this->vue = $v; }
    public function index(): void { 
        $this->vue->afficher('accueil', [], 'Accueil - CourtSync'); 
    }
}