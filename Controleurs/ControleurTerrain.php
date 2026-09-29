<?php
declare(strict_types=1);
class ControleurTerrain {
    private $terrains; private $matchs; private $vue; private $erreurs;
    public function __construct(Terrain $t, MatchModele $m, Vue $v, ControleurErreur $e) { $this->terrains = $t; $this->matchs = $m; $this->vue = $v; $this->erreurs = $e; }
    
    public function index(): void { $this->vue->afficher('terrains/index', ['terrains' => $this->terrains->obtenirTous()], 'Terrains'); }
    
    public function afficher(int $id): void {
        $t = $this->terrains->obtenirParId($id);
        if (!$t) { $this->erreurs->afficher('Terrain introuvable', 404); return; }
        $this->vue->afficher('terrains/afficher', ['terrain' => $t, 'matchs' => $this->matchs->obtenirParTerrain($id)], $t['nom']);
    }
}