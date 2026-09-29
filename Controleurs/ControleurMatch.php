<?php
declare(strict_types=1);
class ControleurMatch {
    private $matchs; private $vue; private $erreurs;
    public function __construct(MatchModele $m, Vue $v, ControleurErreur $e) { $this->matchs = $m; $this->vue = $v; $this->erreurs = $e; }
    
    public function ajouter(array $post): void {
        $this->matchs->ajouter($post['date_heure'], (int)$post['terrain_id'], (int)$post['utilisateur_id']);
        header('Location: terrain-detail/' . $post['terrain_id']); exit;
    }
    public function supprimer(array $post): void {
        $this->matchs->supprimer((int)$post['id']);
        header('Location: terrain-detail/' . $post['terrain_id']); exit;
    }
    public function modifierFormulaire(int $id): void {
        $m = $this->matchs->obtenirParId($id);
        if (!$m) { $this->erreurs->afficher('Match introuvable', 404); return; }
        $this->vue->afficher('matchs/modifier', ['match' => $m], 'Modifier');
    }
    public function modifier(array $post): void {
        $this->matchs->modifier((int)$post['id'], $post['date_heure']);
        header('Location: terrain-detail/' . $post['terrain_id']); exit;
    }
}